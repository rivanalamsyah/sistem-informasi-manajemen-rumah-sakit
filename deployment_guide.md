# 🏥 SIMRS — Panduan Deployment Production

> **Stack**: Laravel 13 · PHP 8.5 · MySQL 8+ · Nginx · Ubuntu Server 24.04 LTS · Tailwind CSS 4 · Vite

---

## 📋 Daftar Isi

1. [Persyaratan Server](#1-persyaratan-server)
2. [Instalasi Server](#2-instalasi-server)
3. [Setup MySQL Database](#3-setup-mysql-database)
4. [Setup Direktori Aplikasi](#4-setup-direktori-aplikasi)
5. [Konfigurasi Environment (.env)](#5-konfigurasi-environment-env)
6. [Deployment Pertama (First Deploy)](#6-deployment-pertama-first-deploy)
7. [Update Aplikasi](#7-update-aplikasi)
8. [Rollback](#8-rollback)
9. [Backup & Restore](#9-backup--restore)
10. [Keamanan Server](#10-keamanan-server)
11. [Monitoring & Logging](#11-monitoring--logging)
12. [Troubleshooting](#12-troubleshooting)
13. [Perintah Artisan Penting](#13-perintah-artisan-penting)

---

## 1. Persyaratan Server

| Komponen | Minimum | Rekomendasi |
|---|---|---|
| CPU | 2 vCPU | 4 vCPU |
| RAM | 2 GB | 4–8 GB |
| Storage | 20 GB SSD | 100 GB SSD |
| OS | Ubuntu 24.04 LTS | Ubuntu 24.04 LTS |
| PHP | 8.3+ | 8.5 |
| MySQL | 8.0 | 8.0+ |
| Nginx | 1.24 | 1.26+ |
| Node.js | 20 LTS | 22 LTS |

---

## 2. Instalasi Server

### 2.1 Update Sistem

```bash
sudo apt update && sudo apt upgrade -y
sudo apt install -y curl wget git unzip zip software-properties-common
```

### 2.2 Instalasi PHP 8.5 + Ekstensi

```bash
sudo add-apt-repository ppa:ondrej/php -y
sudo apt update
sudo apt install -y php8.5 php8.5-fpm php8.5-mysql php8.5-mbstring \
    php8.5-xml php8.5-bcmath php8.5-curl php8.5-tokenizer \
    php8.5-fileinfo php8.5-gd php8.5-zip php8.5-intl php8.5-opcache

# Verifikasi
php8.5 --version
```

### 2.3 Konfigurasi PHP Production

```bash
# Edit php.ini untuk production
sudo nano /etc/php/8.5/fpm/php.ini
```

Ubah nilai berikut:
```ini
memory_limit = 256M
upload_max_filesize = 20M
post_max_size = 22M
max_execution_time = 120
expose_php = Off
display_errors = Off
log_errors = On
error_log = /var/log/php/php8.5_errors.log

; OPcache (wajib production)
opcache.enable = 1
opcache.memory_consumption = 128
opcache.interned_strings_buffer = 8
opcache.max_accelerated_files = 10000
opcache.revalidate_freq = 2
opcache.validate_timestamps = 0
```

```bash
# Salin pool config SIMRS
sudo cp /var/www/simrs/deploy/php/simrs-fpm.conf /etc/php/8.5/fpm/pool.d/simrs.conf
sudo mkdir -p /var/log/php
sudo systemctl restart php8.5-fpm
```

### 2.4 Instalasi Nginx

```bash
sudo apt install -y nginx
sudo systemctl enable nginx

# Salin konfigurasi
sudo cp /var/www/simrs/deploy/nginx/simrs.conf /etc/nginx/sites-available/simrs
sudo ln -s /etc/nginx/sites-available/simrs /etc/nginx/sites-enabled/
sudo rm -f /etc/nginx/sites-enabled/default

# Test & reload
sudo nginx -t && sudo systemctl reload nginx
```

### 2.5 Instalasi Node.js (untuk build assets)

```bash
curl -fsSL https://deb.nodesource.com/setup_22.x | sudo -E bash -
sudo apt install -y nodejs
node --version && npm --version
```

### 2.6 Instalasi Composer

```bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
composer --version
```

### 2.7 Instalasi Supervisor (Queue Worker)

```bash
sudo apt install -y supervisor
sudo systemctl enable supervisor

# Salin konfigurasi worker
sudo cp /var/www/simrs/deploy/supervisor/simrs-worker.conf /etc/supervisor/conf.d/
```

### 2.8 SSL/TLS dengan Let's Encrypt

```bash
sudo apt install -y certbot python3-certbot-nginx
sudo certbot --nginx -d simrs.rumahsakit.co.id -d www.simrs.rumahsakit.co.id
# Certbot akan auto-renew melalui cron
```

---

## 3. Setup MySQL Database

```bash
sudo apt install -y mysql-server
sudo mysql_secure_installation   # Ikuti prompt, set root password

# Buat database & user khusus SIMRS
sudo mysql -u root -p
```

```sql
-- Buat database
CREATE DATABASE simrs_production CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Buat user khusus (JANGAN gunakan root di production!)
CREATE USER 'simrs_user'@'localhost' IDENTIFIED BY 'PASSWORD_KUAT_DISINI';

-- Grant permissions
GRANT ALL PRIVILEGES ON simrs_production.* TO 'simrs_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

> [!CAUTION]
> Gunakan password yang kuat (min. 24 karakter, mix huruf/angka/simbol). Simpan di password manager.

---

## 4. Setup Direktori Aplikasi

```bash
# Buat struktur direktori
sudo mkdir -p /var/www/simrs/{releases,shared,backup}
sudo mkdir -p /var/www/simrs/shared/storage/{app/public,framework/{cache,sessions,views},logs}
sudo mkdir -p /var/www/simrs/shared/bootstrap/cache
sudo mkdir -p /var/backups/simrs/database

# Set ownership
sudo chown -R www-data:www-data /var/www/simrs
sudo chown -R www-data:www-data /var/backups/simrs

# Set permissions
sudo chmod -R 755 /var/www/simrs
sudo chmod -R 775 /var/www/simrs/shared/storage
sudo chmod -R 775 /var/www/simrs/shared/bootstrap/cache
```

---

## 5. Konfigurasi Environment (.env)

```bash
# Salin template
sudo cp /var/www/simrs/deploy/.env.production /var/www/simrs/shared/.env

# Edit dengan nilai production yang benar
sudo nano /var/www/simrs/shared/.env
```

> [!IMPORTANT]
> Wajib diisi sebelum deployment:
> - `APP_KEY` → Generate: `php artisan key:generate --show`
> - `APP_URL` → URL production Anda
> - `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` → Sesuai step 3
> - `MAIL_*` → Konfigurasi SMTP email

---

## 6. Deployment Pertama (First Deploy)

```bash
# Clone repository ke release pertama
bash /path/to/deploy/scripts/deploy.sh --first-time

# Setelah clone berhasil, jalankan seeder (hanya sekali!)
cd /var/www/simrs/current
sudo -u www-data php artisan db:seed --force

# Jalankan migration production index
sudo -u www-data php artisan migrate --force

# Buat storage link
sudo -u www-data php artisan storage:link

# Setup Supervisor
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start simrs-worker:*

# Setup Cron Scheduler
echo "* * * * * www-data /usr/bin/php /var/www/simrs/current/artisan schedule:run >> /dev/null 2>&1" \
    | sudo tee /etc/cron.d/simrs-scheduler

# Setup Backup Database Harian (02:00)
echo "0 2 * * * www-data bash /var/www/simrs/deploy/scripts/backup-db.sh" \
    | sudo tee -a /etc/cron.d/simrs-scheduler
```

### 6.1 Verifikasi Deployment

```bash
# Test PHP-FPM
sudo systemctl status php8.5-fpm

# Test Nginx
sudo nginx -t && sudo systemctl status nginx

# Test aplikasi
curl -I https://simrs.rumahsakit.co.id

# Test queue worker
sudo supervisorctl status simrs-worker:*

# Test scheduler
sudo -u www-data php /var/www/simrs/current/artisan schedule:list
```

---

## 7. Update Aplikasi

```bash
# Jalankan deployment script (tidak perlu --first-time)
bash /var/www/simrs/deploy/scripts/deploy.sh
```

Script otomatis:
1. Clone release baru dari Git
2. Install dependencies (no-dev)
3. Build Vite assets
4. Jalankan migration
5. Enable maintenance mode
6. Rebuild semua Laravel cache
7. Activate release baru
8. Restart PHP-FPM, Nginx, Queue
9. Disable maintenance mode
10. Hapus release lama (simpan 5 terakhir)

---

## 8. Rollback

```bash
bash /var/www/simrs/deploy/scripts/rollback.sh
```

> [!WARNING]
> Jika ada database migration di release baru, rollback schema **tidak otomatis**. Jalankan secara manual:
> ```bash
> cd /var/www/simrs/current
> php artisan migrate:rollback --step=1
> ```

---

## 9. Backup & Restore

### 9.1 Backup Manual

```bash
bash /var/www/simrs/deploy/scripts/backup-db.sh
```

### 9.2 Restore Database

```bash
# Daftar backup tersedia
ls -lh /var/backups/simrs/database/

# Restore
gunzip -c /var/backups/simrs/database/simrs_db_YYYYMMDD_HHMMSS.sql.gz \
    | mysql -u simrs_user -p simrs_production

# Verifikasi
mysql -u simrs_user -p simrs_production -e "SHOW TABLES;" | head -20
```

### 9.3 Backup File Upload

```bash
tar -czf /var/backups/simrs/storage_$(date +%Y%m%d).tar.gz \
    /var/www/simrs/shared/storage/app/
```

---

## 10. Keamanan Server

### 10.1 Firewall (UFW)

```bash
sudo ufw default deny incoming
sudo ufw default allow outgoing
sudo ufw allow ssh
sudo ufw allow 80/tcp
sudo ufw allow 443/tcp
sudo ufw enable
sudo ufw status
```

### 10.2 SSH Hardening

```bash
sudo nano /etc/ssh/sshd_config
```
```
PermitRootLogin no
PasswordAuthentication no
PubkeyAuthentication yes
MaxAuthTries 3
```
```bash
sudo systemctl restart sshd
```

### 10.3 Fail2ban (Brute Force Protection)

```bash
sudo apt install -y fail2ban
sudo systemctl enable --now fail2ban
```

### 10.4 Checklist Keamanan Laravel

| Item | Status |
|---|---|
| `APP_DEBUG=false` | Wajib |
| `APP_ENV=production` | Wajib |
| `SESSION_SECURE_COOKIE=true` | Wajib (HTTPS) |
| `SESSION_ENCRYPT=true` | Disarankan |
| `.env` tidak di Git (`.gitignore`) | Sudah ada |
| `BCRYPT_ROUNDS=14` | Production |
| Direktori `storage/` & `vendor/` tidak dapat diakses web | Sudah di Nginx |
| File upload hanya ekstensi yang diizinkan | Validasi di Request |
| CSRF aktif (semua form POST) | Laravel default |

---

## 11. Monitoring & Logging

### 11.1 Log Laravel (daily rotation, 14 hari)

```bash
# Lihat log hari ini
tail -f /var/www/simrs/shared/storage/logs/laravel-$(date +%Y-%m-%d).log

# Error saja
grep "ERROR" /var/www/simrs/shared/storage/logs/laravel-$(date +%Y-%m-%d).log
```

### 11.2 Log Nginx

```bash
tail -f /var/log/nginx/simrs_access.log
tail -f /var/log/nginx/simrs_error.log
```

### 11.3 Monitoring Queue Worker

```bash
sudo supervisorctl status
sudo supervisorctl tail simrs-worker:simrs-worker_00
```

### 11.4 Monitoring Resource

```bash
# CPU & RAM
htop

# Disk
df -h

# MySQL connections
mysql -u simrs_user -p -e "SHOW STATUS LIKE 'Threads_connected';"

# PHP-FPM status
sudo curl --unix-socket /run/php/php8.5-fpm.sock http://localhost/status
```

---

## 12. Troubleshooting

### Error: 500 Internal Server Error
```bash
tail -50 /var/www/simrs/shared/storage/logs/laravel-$(date +%Y-%m-%d).log
tail -20 /var/log/nginx/simrs_error.log
```

### Error: Permissions Denied
```bash
sudo chown -R www-data:www-data /var/www/simrs/shared/storage
sudo chmod -R 775 /var/www/simrs/shared/storage
sudo chmod -R 775 /var/www/simrs/shared/bootstrap/cache
```

### Error: Database Connection
```bash
# Test koneksi
mysql -u simrs_user -p -h 127.0.0.1 simrs_production -e "SELECT 1;"

# Cek .env
grep "DB_" /var/www/simrs/shared/.env
```

### Error: Assets Tidak Muncul (404)
```bash
# Pastikan build sudah dijalankan
ls -la /var/www/simrs/current/public/build/

# Pastikan storage:link ada
ls -la /var/www/simrs/current/public/storage
```

### Error: Queue Worker Mati
```bash
sudo supervisorctl restart simrs-worker:*
sudo supervisorctl status
```

### Aplikasi Lambat
```bash
# Pastikan semua cache aktif
cd /var/www/simrs/current
sudo -u www-data php artisan config:cache
sudo -u www-data php artisan route:cache
sudo -u www-data php artisan view:cache
sudo -u www-data php artisan event:cache

# Cek OPcache
sudo -u www-data php -r "print_r(opcache_get_status());" | head -20
```

---

## 13. Perintah Artisan Penting

```bash
# Berpindah ke direktori aplikasi
cd /var/www/simrs/current

# ── Maintenance ────────────────────────────────────────────────────────
php artisan down                          # Aktifkan maintenance mode
php artisan up                            # Matikan maintenance mode

# ── Cache ──────────────────────────────────────────────────────────────
php artisan optimize                      # Build semua cache sekaligus
php artisan optimize:clear                # Hapus semua cache
php artisan config:cache                  # Cache konfigurasi
php artisan route:cache                   # Cache routes
php artisan view:cache                    # Cache Blade templates
php artisan event:cache                   # Cache event listeners

# ── Database ───────────────────────────────────────────────────────────
php artisan migrate --force               # Jalankan migration
php artisan migrate:status                # Status migration
php artisan migrate:rollback --step=1     # Rollback 1 migration
php artisan db:seed --force               # Jalankan seeder

# ── Queue ──────────────────────────────────────────────────────────────
php artisan queue:work                    # Jalankan worker (foreground)
php artisan queue:restart                 # Restart worker secara graceful
php artisan queue:monitor                 # Monitor queue
php artisan queue:failed                  # Lihat failed jobs
php artisan queue:retry all               # Retry semua failed jobs
php artisan queue:flush                   # Hapus semua failed jobs

# ── Storage ────────────────────────────────────────────────────────────
php artisan storage:link                  # Buat symlink storage → public/storage

# ── Debugging (DEVELOPMENT ONLY) ───────────────────────────────────────
php artisan tinker                        # REPL interaktif
php artisan route:list                    # Daftar semua route
php artisan model:show Patient            # Info model & relasi
```

---

## 📞 Kontak & Support

| Item | Informasi |
|---|---|
| Tim Pengembang | Dev Team SIMRS |
| Repository | `git@github.com:YOUR_ORG/simrs.git` |
| Versi Dokumen | 1.0.0 (2026-07-26) |
| PHP | 8.5 |
| Laravel | 13.x |
| Tailwind | CSS 4 |

> [!NOTE]
> Dokumen ini harus diperbarui setiap kali ada perubahan signifikan pada arsitektur sistem atau proses deployment.
