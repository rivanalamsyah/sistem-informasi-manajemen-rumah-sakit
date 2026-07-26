#!/bin/bash
##############################################################################
#  SIMRS — Database Backup Script
#  Tambahkan ke crontab: 0 2 * * * /var/www/simrs/deploy/scripts/backup-db.sh
#  Backup harian jam 02:00, simpan 30 hari
##############################################################################

set -euo pipefail

# ── Konfigurasi ───────────────────────────────────────────────────────────
BACKUP_DIR="/var/backups/simrs/database"
APP_DIR="/var/www/simrs/current"
KEEP_DAYS=30
TIMESTAMP=$(date +%Y%m%d_%H%M%S)
BACKUP_FILE="${BACKUP_DIR}/simrs_db_${TIMESTAMP}.sql.gz"
LOG_FILE="/var/log/simrs_backup.log"

# Baca dari .env
ENV_FILE="${APP_DIR}/.env"
DB_HOST=$(grep "^DB_HOST=" "${ENV_FILE}" | cut -d '=' -f2 | tr -d '"' | tr -d "'")
DB_PORT=$(grep "^DB_PORT=" "${ENV_FILE}" | cut -d '=' -f2 | tr -d '"' | tr -d "'")
DB_DATABASE=$(grep "^DB_DATABASE=" "${ENV_FILE}" | cut -d '=' -f2 | tr -d '"' | tr -d "'")
DB_USERNAME=$(grep "^DB_USERNAME=" "${ENV_FILE}" | cut -d '=' -f2 | tr -d '"' | tr -d "'")
DB_PASSWORD=$(grep "^DB_PASSWORD=" "${ENV_FILE}" | cut -d '=' -f2 | tr -d '"' | tr -d "'")

# ── Eksekusi ──────────────────────────────────────────────────────────────
mkdir -p "${BACKUP_DIR}"

echo "[$(date '+%Y-%m-%d %H:%M:%S')] Memulai backup database: ${DB_DATABASE}" >> "${LOG_FILE}"

MYSQL_PWD="${DB_PASSWORD}" mysqldump \
    --host="${DB_HOST}" \
    --port="${DB_PORT}" \
    --user="${DB_USERNAME}" \
    --single-transaction \
    --routines \
    --triggers \
    --add-drop-table \
    --complete-insert \
    "${DB_DATABASE}" \
    | gzip -9 > "${BACKUP_FILE}"

BACKUP_SIZE=$(du -sh "${BACKUP_FILE}" | cut -f1)
echo "[$(date '+%Y-%m-%d %H:%M:%S')] Backup selesai: ${BACKUP_FILE} (${BACKUP_SIZE})" >> "${LOG_FILE}"

# ── Hapus backup lama ──────────────────────────────────────────────────────
DELETED=$(find "${BACKUP_DIR}" -name "simrs_db_*.sql.gz" -mtime +${KEEP_DAYS} -delete -print | wc -l)
echo "[$(date '+%Y-%m-%d %H:%M:%S')] Dihapus ${DELETED} backup lama (>${KEEP_DAYS} hari)" >> "${LOG_FILE}"

echo "[$(date '+%Y-%m-%d %H:%M:%S')] Backup sukses. File tersimpan: ${BACKUP_FILE}" >> "${LOG_FILE}"
