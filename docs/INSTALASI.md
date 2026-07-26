# Panduan Instalasi Lokal SIMRS Enterprise

Dokumen ini berisi petunjuk komprehensif langkah demi langkah untuk menginstal dan menjalankan proyek **SIMRS Enterprise** di lingkungan pengembangan lokal (Windows, Linux, macOS).

---

## 💻 Prasyarat Perangkat Lunak (System Requirements)

Pastikan komputer/server Anda telah terpasang:
- **PHP**: Versi 8.2 atau 8.5+ (Ekstensi: `pdo`, `pdo_mysql`, `mbstring`, `openssl`, `curl`, `json`, `gd`, `zip`)
- **Composer**: Versi 2.5+
- **Node.js**: Versi 18+ LTS atau 20+
- **MySQL / MariaDB**: MySQL 8.0+ atau MariaDB 10.6+
- **Web Server**: Nginx, Apache, atau Laragon

---

## 🛠️ Langkah Demi Langkah Instalasi

### Langkah 1: Kloning Repository Project
Buka terminal/command prompt dan jalankan perintah:
```bash
git clone https://github.com/simrs-kencanamedika/simrs-laravel.git
cd simrs-laravel
```

### Langkah 2: Instalasi Dependency Backend (Composer)
Jalankan composer install untuk memasukkan seluruh pustaka Laravel 12:
```bash
composer install
```

### Langkah 3: Instalasi Dependency Frontend (Node.js)
Jalankan npm install untuk menyiapkan Tailwind CSS 4 dan Vite:
```bash
npm install
```

### Langkah 4: Konfigurasi File Lingkungan (`.env`)
Salin file konfigurasi sampel `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Buka file `.env` dan sesuaikan kredensial koneksi database MySQL:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=simrs_db
DB_USERNAME=root
DB_PASSWORD=
```

### Langkah 5: Generasi Application Encryption Key
Jalankan generasi Kunci Aplikasi Laravel:
```bash
php artisan key:generate
```

### Langkah 6: Pembuatan Symbolic Link Storage
Jalankan pertautan folder penyimpanan file publik:
```bash
php artisan storage:link
```

### Langkah 7: Eksekusi Migration & Database Seeding
Pastikan database `simrs_db` sudah dibuat di MySQL, lalu jalankan perancangan tabel dan pengisian data awal:
```bash
php artisan migrate:fresh --seed
```

### Langkah 8: Kompilasi Aset Frontend (Vite)
Kompilasi aset CSS dan JavaScript untuk performa maksimal:
```bash
npm run build
```

### Langkah 9: Menjalankan Server Pengembangan (Dev Server)
Jalankan server aplikasi Laravel:
```bash
php artisan serve
```
Aplikasi SIMRS Enterprise sekarang dapat diakses melalui browser pada `http://127.0.0.1:8000`.

---

## 🔑 Login Pertama
Gunakan salah satu akun demo terdaftar:
- **Email**: `admin@kencanamedika.co.id`
- **Password**: `password`
