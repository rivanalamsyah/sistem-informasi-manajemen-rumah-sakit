#!/bin/bash
##############################################################################
#  SIMRS — Rollback Script
#  Usage: bash deploy/scripts/rollback.sh
#  Rollback ke release sebelumnya secara otomatis
##############################################################################

set -euo pipefail

APP_DIR="/var/www/simrs"
RELEASES_DIR="${APP_DIR}/releases"
CURRENT_LINK="${APP_DIR}/current"
PHP_BIN="/usr/bin/php"

RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m'

log_info()    { echo -e "\033[0;34m[INFO]\033[0m  $1"; }
log_success() { echo -e "${GREEN}[OK]\033[0m    $1"; }
log_error()   { echo -e "${RED}[ERROR]\033[0m $1"; exit 1; }

log_info "=== SIMRS Rollback ==="

# Dapatkan release saat ini
CURRENT_RELEASE=$(readlink -f "${CURRENT_LINK}")
log_info "Release saat ini : ${CURRENT_RELEASE}"

# Dapatkan semua release yang tersedia, urutkan descending
RELEASES=($(ls -dt "${RELEASES_DIR}"/*/))

if [[ ${#RELEASES[@]} -lt 2 ]]; then
    log_error "Tidak ada release sebelumnya untuk rollback!"
fi

# Release sebelumnya adalah index [1]
PREVIOUS_RELEASE="${RELEASES[1]}"
# Hapus trailing slash
PREVIOUS_RELEASE="${PREVIOUS_RELEASE%/}"

echo -e "${YELLOW}Rollback ke:${NC} ${PREVIOUS_RELEASE}"
read -rp "Konfirmasi? (y/N): " CONFIRM
[[ "${CONFIRM}" =~ ^[Yy]$ ]] || { log_info "Dibatalkan."; exit 0; }

# Enable maintenance
log_info "Maintenance mode ON..."
cd "${CURRENT_LINK}" && $PHP_BIN artisan down --retry=30 2>/dev/null || true

# Aktifkan release sebelumnya
log_info "Mengaktifkan release sebelumnya..."
ln -sfn "${PREVIOUS_RELEASE}" "${CURRENT_LINK}"

# Rebuild cache dari release lama
cd "${CURRENT_LINK}"
log_info "Rebuilding caches..."
$PHP_BIN artisan config:cache
$PHP_BIN artisan route:cache
$PHP_BIN artisan view:cache

# Matikan maintenance
$PHP_BIN artisan up

# Restart services
sudo systemctl reload php8.5-fpm
sudo systemctl reload nginx
sudo supervisorctl restart simrs-worker:* 2>/dev/null || true
$PHP_BIN artisan queue:restart

log_success "Rollback selesai → ${PREVIOUS_RELEASE}"
