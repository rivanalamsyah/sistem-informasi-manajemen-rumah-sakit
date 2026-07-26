# 🏥 SISTEM INFORMASI MANAJEMEN RUMAH SAKIT (SIMRS) ENTERPRISE

[![Laravel Version](https://img.shields.io/badge/Laravel-13.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.3%2B%20%2F%208.5-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL Version](https://img.shields.io/badge/MySQL-8.0%2B-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-v4.0-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge)](LICENSE)

**SIMRS Enterprise** adalah sistem informasi manajemen rumah sakit modern berbasis web yang dirancang untuk mengintegrasikan seluruh operasional pelayanan medis, administrasi, farmasi, laboratorium, keuangan, hingga manajemen logistik gudang dalam satu platform monolithic yang cepat, aman, dan modular.

Dokumen ini berisi panduan lengkap penggunaan, instalasi, arsitektur teknis, serta kontak tim pengembang.

---

## 📋 DAFTAR ISI

1. [Tentang Sistem & Tujuan](#-tentang-sistem--tujuan)
2. [Ringkasan Modul & Fitur Utama](#-ringkasan-modul--fitur-utama)
3. [Arsitektur & Teknologi Stack](#-arsitektur--teknologi-stack)
4. [Persyaratan Sistem (Prerequisites)](#-persyaratan-sistem-prerequisites)
5. [Panduan Instalasi & Memulai](#-panduan-instalasi--memulai)
6. [Struktur Direktori Proyek](#-struktur-direktori-proyek)
7. [Perintah Artisan & Helper Scripts](#-perintah-artisan--helper-scripts)
8. [Standar Keamanan & Audit Trail](#-standar-keamanan--audit-trail)
9. [Dokumentasi Teknis Terkait](#-dokumentasi-teknis-terkait)
10. [Kontak Developer & Dukungan Teknis](#-kontak-developer--dukungan-teknis)

---

## 🚀 TENTANG SISTEM & TUJUAN

Aplikasi SIMRS ini dibangun khusus untuk memenuhi kebutuhan rumah sakit kelas C/D serta klinik utama menengah dengan tujuan utama:

* **Digitalisasi Pelayanan Medis**: Menggantikan pencatatan manual dengan Rekam Medis Elektronik (EMR) yang terintegrasi.
* **Otomatisasi Operasional**: Mengintegrasikan alur pasien mulai dari pendaftaran/admisi, penanganan poliklinik/rawat inap, penunjang laboratorium, dispensing farmasi, hingga pembayaran kasir/billing.
* **Akurasi Keuangan & Logistik**: Meminimalisir kesalahan perhitungan biaya pelayanan, memantau pengeluaran/masuk obat serta mutasi stok barang gudang secara real-time.
* **Kemudahan Pemeliharaan (*Maintainability*)**: Menggunakan arsitektur monolithic Laravel MVC murni dengan Blade & Vanilla JavaScript yang bersih, tanpa kompleksitas dependensi framework SPA yang berlebihan.

---

## 🧩 RINGKASAN MODUL & FITUR UTAMA

Sistem terbagi ke dalam 15 modul inti yang saling terhubung:

| No | Modul | Deskripsi Fitur Utama |
| :--- | :--- | :--- |
| 1 | **Dashboard Analitik** | Overview KPI operasional real-time (Kunjungan Pasien, *Bed Occupancy Rate* / BOR, Total Revenue), grafik tren, & shortcut menu. |
| 2 | **Pendaftaran & Admisi** | Registrasi pasien baru/lama, pencarian pasien cerdas, penomoran RM otomatis, serta registrasi antrean poliklinik & rawat inap. |
| 3 | **Pelayanan Rawat Jalan** | Pemanggilan antrean poliklinik, pencatatan Tanda-Tanda Vital (TTV), integrasi input EMR, dan order resep/lab. |
| 4 | **Pelayanan Rawat Inap** | Monitoring ketersediaan tempat tidur (Bed Management), alokasi kelas/kamar, transfer antar bangsal, hingga proses pemulangan (*discharge*). |
| 5 | **Rekam Medis (EMR)** | Catatan Anamnesis, Diagnosis (standar ICD-10 & ICD-9 CM), Catatan Perkembangan Pasien Terintegrasi (CPPT), serta riwayat tindakan medis. |
| 6 | **Farmasi & Depo Obat** | Verifikasi & dispensing resep medis, manajemen stok depo, penyesuaian stok (*adjust stock*), serta riwayat pergerakan obat. |
| 7 | **Laboratorium (LIS)** | Penerimaan & *sample collection*, order tes laboratorium, input hasil pemeriksaan fisik/darah/kimia, serta cetak lembar hasil. |
| 8 | **Kasir & Billing Terpadu** | Generasi invoice otomatis dari tindakan medis, kamar, obat, & lab; pemrosesan pembayaran (Tunai/Non-Tunai); serta cetak kuitansi resmi. |
| 9 | **Gudang (Warehouse)** | Pengelolaan barang non-obat/obat, penerimaan (*receipts*), pengeluaran (*dispatches*), mutasi barang antar gudang, & *stock opname*. |
| 10 | **Master Data Utama** | Manajemen data referensi: Dokter, Spesialis/Poli, Bangsal/Kamar/Bed, Layanan & Tarif, Kategori Obat, Obat, Supplier, & Paket Lab. |
| 11 | **User & Keamanan** | Pengelolaan pengguna, autentikasi, pengaturan Matriks *Role & Permission* (RBAC), serta pencatatan *Audit Trail Log* & *Login History*. |
| 12 | **Pengaturan Sistem** | Konfigurasi profil Rumah Sakit, format penomoran dokumen otomatis (RM, Invoice, Preskripsi), SMTP Email, Notifikasi, & Backup DB. |
| 13 | **Laporan & BI** | Laporan eksekutif harian/bulanan (Registrasi, Rawat Jalan/Inap, EMR, Farmasi, Lab, Keuangan) dilengkapi fitur Export CSV/Excel. |
| 14 | **Portal Pasien (Landing)** | Antarmuka publik untuk informasi jadwal praktik dokter, profil rumah sakit, dan layanan unggulan. |
| 15 | **Log & Audit Trail** | Pencatatan setiap aktivitas *Create, Read, Update, Delete* (CRUD) pengguna dan riwayat sesi login untuk memenuhi standar kepatuhan regulasi medis. |

---

## 🛠 ARSITEKTUR & TEKNOLOGI STACK

### Backend Stack
* **Framework**: [Laravel 13.x](https://laravel.com) (PHP 8.3+ / 8.5)
* **Architecture Pattern**: Monolithic Architecture (Model-View-Controller / MVC)
* **Authentication**: Native Laravel Authentication Middleware + RBAC Matrix
* **Database Layer**: MySQL 8.0+ / MariaDB 10.4+ (ORM Eloquent)

### Frontend Stack
* **Templating Engine**: Laravel Blade
* **Styling & UI**: Tailwind CSS v4.0 (Modern Design System with Dark/Light Support)
* **JavaScript**: Vanilla ES6 JavaScript (No heavy SPA Framework to ensure maximum performance and low memory consumption)
* **Asset Bundler**: Vite 6.x

---

## ⚡ PERSYARATAN SISTEM (PREREQUISITES)

Sebelum menginstal aplikasi, pastikan lingkungan server/komputer lokal Anda memenuhi spesifikasi berikut:

| Komponen | Persyaratan Minimum | Rekomendasi Production |
| :--- | :--- | :--- |
| **PHP** | `^8.3` | `8.5` (dengan ekstensi `pdo_mysql`, `mbstring`, `bcmath`, `xml`, `curl`, `gd`, `zip`, `intl`, `tokenizer`, `fileinfo`) |
| **Database** | MySQL 8.0 / MariaDB 10.4 | MySQL 8.0+ |
| **Composer** | Composer v2.5+ | Composer v2.7+ |
| **Node.js** | Node.js v20 LTS | Node.js v22 LTS & NPM v10+ |
| **Web Server** | Nginx 1.24+ / Apache 2.4+ | Nginx 1.26+ (PHP-FPM) |

---

## ⚙️ PANDUAN INSTALASI & MEMULAI

### 1. Clone Repository & Setup Environment
```bash
# Clone repository ke server / web root lokal Anda
git clone https://github.com/rivanalamsyah/sistem-informasi-manajemen-rumah-sakit.git
cd sistem-informasi-manajemen-rumah-sakit

# Salin file konfigurasi environment
cp .env.example .env
```

### 2. Install Dependensi PHP & Node.js
```bash
# Install paket PHP via Composer
composer install

# Install paket Frontend via NPM
npm install
```

### 3. Konfigurasi Database & Application Key
Buka file `.env` dan atur kredensial koneksi database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=simrs_db
DB_USERNAME=root
DB_PASSWORD=
```

Jalankan generasi kunci enkripsi aplikasi:
```bash
php artisan key:generate
```

### 4. Jalankan Migrasi Database & Seeder
```bash
# Membuat struktur tabel database dan mengisi data awal (Master Data & User Default)
php artisan migrate --seed
```

### 5. Jalankan Environment Development
Proyek ini dilengkapi dengan skrip pengembang otomatis yang menjalankan server aplikasi, penanganan queue, log viewer, dan asset bundler sekaligus:
```bash
composer run dev
```
*Atau secara terpisah:*
```bash
# Terminal 1 - Backend Server
php artisan serve

# Terminal 2 - Asset Hot Reloading
npm run dev
```

Akses aplikasi melalui peramban web di: `http://127.0.0.1:8000` atau `http://localhost:8000`.

---

## 📁 STRUKTUR DIREKTORI PROYEK

```
simrs/
├── app/
│   ├── Http/
│   │   ├── Controllers/       # Controller per Modul (Master, Billing, EMR, Farmasi, dll.)
│   │   └── Middleware/        # Middleware Keamanan & Hak Akses User
│   ├── Models/                # Eloquent Models (Pasien, Registrasi, EMR, Dokter, dll.)
│   └── Services/              # Business Logic & Service Layers
├── bootstrap/                 # Inisialisasi Aplikasi Laravel
├── config/                    # File Konfigurasi Sistem (Database, Auth, App)
├── database/
│   ├── factories/             # Data Testing Factories
│   ├── migrations/            # Migrasi Skema Tabel Database
│   └── seeders/               # Data awal (Default Admin, Master Poliklinik, Tarif)
├── docs/                      # Dokumentasi Tambahan Proyek
├── public/                    # Web Root (Index.php, Static Assets, Uploaded Files)
├── resources/
│   ├── css/                   # Stylesheet Tailwind CSS
│   ├── js/                    # JavaScript Module & Helper
│   └── views/                 # Blade Views per Modul & Layout Admin
├── routes/
│   └── web.php                # Definisi Seluruh Route Modul Aplikasi
├── storage/                   # Storage Log Aplikasi & Backup File
├── tests/                     # Automated Test Suites (Feature & Unit Test)
├── blueprint_arsitektur_simrs.md # Spesifikasi & Blueprint Arsitektur Lengkap
├── deployment_guide.md        # Panduan Deployment Server Production
└── desain_database_simrs.md   # Dokumentasi Skema & Relasi Database
```

---

## 💻 PERINTAH ARTISAN & HELPER SCRIPTS

Aplikasi menyediakan beberapa perintah bawaan (*custom scripts*) untuk mempermudah operasional pengembang:

* **Menjalankan Dev Environment**:
  ```bash
  composer run dev
  ```
* **Menjalankan Automated Unit/Feature Tests**:
  ```bash
  composer run test
  ```
* **Format Kode Berdasarkan Standar PSR-12 (Laravel Pint)**:
  ```bash
  vendor/bin/pint
  ```
* **Membersihkan Cache Aplikasi**:
  ```bash
  php artisan config:clear
  php artisan route:clear
  php artisan view:clear
  php artisan cache:clear
  ```

---

## 🔒 STANDAR KEAMANAN & AUDIT TRAIL

1. **Role-Based Access Control (RBAC)**: Setiap grup pengguna (Super Admin, Dokter, Perawat, Apoteker, Analis Lab, Kasir, Pendaftaran) dibatasi oleh *Permission Matrix* ketat.
2. **Audit Logging**: Modul `ActivityLogController` mencatat seluruh perubahan data kritis (seperti perubahan rekam medis, pembuatan transaksi kasir, dan penyesuaian stok obat) lengkap dengan IP Address dan timestamp.
3. **Proteksi Serangan Web**:
   * Proteksi CSRF (*Cross-Site Request Forgery*) pada seluruh formulir.
   * Parameterized Queries untuk mencegah *SQL Injection*.
   * Sanitasi output XSS pada template Blade.
   * Hashing Password tingkat tinggi menggunakan `Bcrypt` / `Argon2id`.

---

## 📑 DOKUMENTASI TEKNIS TERKAIT

Untuk mempelajari arsitektur teknis dan detail perancangan secara lebih mendalam, silakan merujuk pada dokumen ekosistem berikut:

* 📐 [Blueprint Arsitektur SIMRS](file:///c:/laragon/www/simrs/blueprint_arsitektur_simrs.md) — Dokumen spesifikasi teknis, alur proses bisnis 15 modul, dan arsitektur sistem.
* 🗄️ [Desain Database SIMRS](file:///c:/laragon/www/simrs/desain_database_simrs.md) — Kamus data, struktur tabel, dan ERD (Entity Relationship Diagram).
* 🚀 [Panduan Deployment Production](file:///c:/laragon/www/simrs/deployment_guide.md) — Panduan konfigurasi Ubuntu Server, Nginx, PHP-FPM, SSL, dan strategi backup.

---

## 📞 KONTAK DEVELOPER & DUKUNGAN TEKNIS

Jika Anda membutuhkan bantuan teknis, pelaporan bug, kustomisasi modul, atau diskusi integrasi lanjutan, silakan hubungi tim pengembang melalui saluran resmi berikut:

### 👤 Tim Utama Tim Pengembang (Development Team)

* **Lead System Architect & Core Developer**
  * **Nama**: Tim Developer SIMRS Enterprise
  * **Email Utama**: `dev@simrs.local` / `support@simrs-enterprise.com`
  * **Kontak WhatsApp / HP**: `+62 812-3456-7890` (Jam Kerja 08:00 - 17:00 WIB)
  * **GitHub Repository**: `https://github.com/rivanalamsyah/sistem-informasi-manajemen-rumah-sakit`

* **Tim Support & Operations**
  * **Helpdesk SIMRS**: `helpdesk@simrs-enterprise.com`
  * **Layanan Darurat Technical Support (24/7)**: `+62 811-9876-5432`

---

### 📩 Prosedur Pelaporan Masalah (Issue Escalation)

Bila Anda menemukan kendala teknis atau celah keamanan (*security vulnerability*):
1. **Bug Biasa / Feature Request**: Buat *Issue* baru pada repository GitHub proyek ini dengan melampirkan *screenshot* serta langkah reproduksi masalah.
2. **Security Vulnerability**: Kirimkan deskripsi detail masalah secara tertutup ke email `security@simrs-enterprise.com` agar dapat ditangani secara prioritas sebelum dipublikasikan.

---

<p center="align">
  <b>SIMRS Enterprise Application</b> &copy; 2026 Tim Pengembang SIMRS. Hak Cipta Dilindungi Undang-Undang.
</p>
