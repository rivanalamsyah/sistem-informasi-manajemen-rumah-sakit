#!/bin/bash
##############################################################################
#  SIMRS — Production Deployment Script
#  Usage: bash deploy/scripts/deploy.sh [--first-time]
#
#  Jalankan sebagai: sudo -u www-data bash deploy/scripts/deploy.sh
#  Atau dengan flag pertama kali: bash deploy/scripts/deploy.sh --first-time
##############################################################################

set -euo pipefail
IFS=$'\n\t'

# ── Konfigurasi ───────────────────────────────────────────────────────────
APP_DIR="/var/www/simrs"
RELEASES_DIR="${APP_DIR}/releases"
CURRENT_LINK="${APP_DIR}/current"
SHARED_DIR="${APP_DIR}/shared"
REPO_URL="https://github.com/YOUR_ORG/simrs.git"   # Ganti sesuai repo
BRANCH="main"
PHP_BIN="/usr/bin/php"
COMPOSER_BIN="/usr/local/bin/composer"
NODE_BIN="/usr/bin/node"
NPM_BIN="/usr/bin/npm"
MAX_RELEASES=5                                       # Simpan 5 release terakhir
RELEASE_NAME=$(date +%Y%m%d_%H%M%S)
NEW_RELEASE="${RELEASES_DIR}/${RELEASE_NAME}"
FIRST_TIME=${1:-""}

# ── Warna Output ──────────────────────────────────────────────────────────
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m'

log_info()    { echo -e "${BLUE}[INFO]${NC}  $1"; }
log_success() { echo -e "${GREEN}[OK]${NC}    $1"; }
log_warn()    { echo -e "${YELLOW}[WARN]${NC}  $1"; }
log_error()   { echo -e "${RED}[ERROR]${NC} $1"; exit 1; }

# ── Pre-flight Checks ─────────────────────────────────────────────────────
log_info "=== SIMRS Deployment: ${RELEASE_NAME} ==="
log_info "Checking dependencies..."

command -v git  >/dev/null 2>&1 || log_error "git tidak ditemukan"
command -v php  >/dev/null 2>&1 || log_error "php tidak ditemukan"
command -v node >/dev/null 2>&1 || log_error "node tidak ditemukan"
command -v npm  >/dev/null 2>&1 || log_error "npm tidak ditemukan"

$PHP_BIN --version | head -1
log_success "Dependencies OK"

# ── First-time Setup ──────────────────────────────────────────────────────
if [[ "${FIRST_TIME}" == "--first-time" ]]; then
    log_info "Mode: First-time setup"
    mkdir -p "${RELEASES_DIR}"
    mkdir -p "${SHARED_DIR}/storage/app/public"
    mkdir -p "${SHARED_DIR}/storage/framework/cache"
    mkdir -p "${SHARED_DIR}/storage/framework/sessions"
    mkdir -p "${SHARED_DIR}/storage/framework/views"
    mkdir -p "${SHARED_DIR}/storage/logs"
    mkdir -p "${SHARED_DIR}/bootstrap/cache"

    if [[ ! -f "${SHARED_DIR}/.env" ]]; then
        log_warn ".env tidak ditemukan di shared directory!"
        log_warn "Salin file .env ke ${SHARED_DIR}/.env sebelum melanjutkan."
        log_warn "Contoh: cp deploy/.env.production ${SHARED_DIR}/.env"
        log_warn "Lalu isi semua nilai yang diperlukan."
        exit 1
    fi
    log_success "Direktori shared dibuat"
fi

# ── Clone Repository ──────────────────────────────────────────────────────
log_info "Cloning repository branch=${BRANCH}..."
git clone --depth=1 --branch "${BRANCH}" "${REPO_URL}" "${NEW_RELEASE}"
cd "${NEW_RELEASE}"
GIT_HASH=$(git rev-parse --short HEAD)
log_success "Cloned: ${GIT_HASH}"

# ── Symlink Shared Files ──────────────────────────────────────────────────
log_info "Linking shared files..."
rm -rf "${NEW_RELEASE}/storage"
ln -nfs "${SHARED_DIR}/storage" "${NEW_RELEASE}/storage"
ln -nfs "${SHARED_DIR}/.env" "${NEW_RELEASE}/.env"
ln -nfs "${SHARED_DIR}/bootstrap/cache" "${NEW_RELEASE}/bootstrap/cache"
log_success "Shared links OK"

# ── Install PHP Dependencies ──────────────────────────────────────────────
log_info "Installing Composer dependencies (production)..."
$COMPOSER_BIN install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist \
    --quiet
log_success "Composer OK"

# ── Build Frontend Assets ─────────────────────────────────────────────────
log_info "Building frontend assets (Vite/Tailwind)..."
$NPM_BIN ci --silent
$NPM_BIN run build
log_success "Assets built OK"

# ── Artisan: Key Check ────────────────────────────────────────────────────
log_info "Verifying application key..."
$PHP_BIN artisan key:generate --force --no-interaction 2>/dev/null || true

# ── Database Migration ────────────────────────────────────────────────────
log_info "Running database migrations..."
$PHP_BIN artisan migrate --force --no-interaction
log_success "Migrations OK"

# ── Storage Link ──────────────────────────────────────────────────────────
log_info "Creating storage symlink..."
$PHP_BIN artisan storage:link --force
log_success "Storage link OK"

# ── Maintenance Mode ON ───────────────────────────────────────────────────
log_info "Enabling maintenance mode..."
if [[ -L "${CURRENT_LINK}" ]]; then
    cd "${CURRENT_LINK}" && $PHP_BIN artisan down --retry=60 --refresh=30 2>/dev/null || true
fi

# ── Laravel Production Caches ─────────────────────────────────────────────
log_info "Building Laravel production caches..."
cd "${NEW_RELEASE}"
$PHP_BIN artisan config:cache
$PHP_BIN artisan route:cache
$PHP_BIN artisan view:cache
$PHP_BIN artisan event:cache
log_success "Caches built OK"

# ── Activate New Release ──────────────────────────────────────────────────
log_info "Activating release ${RELEASE_NAME}..."
ln -sfn "${NEW_RELEASE}" "${CURRENT_LINK}"
log_success "Release activated"

# ── Maintenance Mode OFF ──────────────────────────────────────────────────
log_info "Taking application live..."
$PHP_BIN artisan up
log_success "Application is LIVE"

# ── Restart Services ──────────────────────────────────────────────────────
log_info "Restarting services..."
sudo systemctl reload php8.5-fpm
sudo systemctl reload nginx
sudo supervisorctl restart simrs-worker:* 2>/dev/null || true
log_success "Services restarted"

# ── Queue Restart (graceful) ──────────────────────────────────────────────
log_info "Signaling queue workers to restart gracefully..."
$PHP_BIN artisan queue:restart
log_success "Queue restart signaled"

# ── Cleanup Old Releases ──────────────────────────────────────────────────
log_info "Cleaning up old releases (keeping last ${MAX_RELEASES})..."
cd "${RELEASES_DIR}"
ls -dt */ | tail -n +$((MAX_RELEASES + 1)) | xargs -r rm -rf
KEPT=$(ls -dt */ | wc -l)
log_success "Kept ${KEPT} release(s)"

# ── Summary ───────────────────────────────────────────────────────────────
echo ""
echo -e "${GREEN}╔══════════════════════════════════════════════╗${NC}"
echo -e "${GREEN}║   DEPLOYMENT BERHASIL ✓                      ║${NC}"
echo -e "${GREEN}╠══════════════════════════════════════════════╣${NC}"
echo -e "${GREEN}║  Release  : ${RELEASE_NAME}           ║${NC}"
echo -e "${GREEN}║  Git Hash : ${GIT_HASH}                          ║${NC}"
echo -e "${GREEN}║  Path     : ${NEW_RELEASE}   ║${NC}"
echo -e "${GREEN}╚══════════════════════════════════════════════╝${NC}"
echo ""
