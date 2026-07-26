# Panduan Deployment Production (Ubuntu Server & Nginx)

Dokumen ini berisi petunjuk operasional standar (SOP) deployment **SIMRS Enterprise** pada server produksi berbasikan **Ubuntu Server 24.04 LTS**, **Nginx**, **PHP 8.5 FPM**, dan **MySQL 8.0**.

---

## 🏗️ Spesifikasi Server Produksi Recomended

- **OS**: Ubuntu Server 24.04 LTS / 22.04 LTS
- **CPU**: 4 vCPU atau lebih
- **RAM**: 8 GB RAM (16 GB disarankan untuk rumah sakit dengan > 500 kunjungan/hari)
- **Disk**: 100 GB SSD NVMe
- **SSL**: Let's Encrypt SSL / Certbot HTTPS

---

## 🔧 1. Konfigurasi Server & Install Paket Utama

```bash
# Update sistem Ubuntu
sudo apt update && sudo apt upgrade -y

# Instalasi Nginx, MySQL 8, PHP 8.5 FPM & Ekstensi
sudo apt install nginx mysql-server php8.5-fpm php8.5-mysql php8.5-cli php8.5-common php8.5-mbstring php8.5-xml php8.5-gd php8.5-curl php8.5-zip unzip git supervisor -y
```

---

## 🌐 2. Konfigurasi Nginx Virtual Host (`/etc/nginx/sites-available/simrs`)

Buat file konfigurasi Nginx untuk SIMRS:
```nginx
server {
    listen 80;
    server_name simrs.kencanamedika.co.id;
    root /var/www/simrs/public;

    index index.php index.html;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.5-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Aktifkan virtual host dan reload Nginx:
```bash
sudo ln -s /etc/nginx/sites-available/simrs /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

---

## 🔒 3. Pemasangan Sertifikat SSL HTTPS (Certbot)

```bash
sudo apt install certbot python3-certbot-nginx -y
sudo certbot --nginx -d simrs.kencanamedika.co.id
```

---

## 🚀 4. Deployment Application Steps

```bash
# Clone repository ke server
cd /var/www
sudo git clone https://github.com/simrs-kencanamedika/simrs-laravel.git simrs
cd /var/www/simrs

# Instalasi dependency produksi
sudo composer install --no-dev --optimize-autoloader
sudo npm install && sudo npm run build

# Set permission folder storage & bootstrap/cache
sudo chown -R www-data:www-data /var/www/simrs
sudo chmod -R 775 /var/www/simrs/storage /var/www/simrs/bootstrap/cache

# Environment & Migration Production
sudo cp .env.example .env
sudo php artisan key:generate
sudo php artisan migrate --force
sudo php artisan storage:link

# Cache Laravel Optimizations
sudo php artisan config:cache
sudo php artisan route:cache
sudo php artisan view:cache
```

---

## 📋 5. Checklist Go-Live Produksi

- [x] APP_ENV diatur ke `production` dan APP_DEBUG diatur ke `false` pada file `.env`.
- [x] HTTPS SSL aktif dan terverifikasi.
- [x] Backup otomatis terjadwal via Crontab / SystemD timer.
- [x] File permission `www-data` aman (775 untuk storage/cache, 755 untuk folder lainnya).
- [x] Seluruh cache Laravel (`config`, `route`, `view`) aktif.
