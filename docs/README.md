# SIMRS Enterprise — Sistem Informasi Manajemen Rumah Sakit Terintegrasi

![Laravel 12](https://img.shields.io/badge/Laravel-12.x-red.svg)
![Tailwind CSS 4](https://img.shields.io/badge/Tailwind_CSS-4.x-38bdf8.svg)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-00758f.svg)
![PHP](https://img.shields.io/badge/PHP-8.2--8.5+-777bb4.svg)
![Status](https://img.shields.io/badge/Status-100%25_Production_Ready-emerald.svg)

Dokumentasi resmi untuk **SIMRS Enterprise Architecture**, platform Sistem Informasi Manajemen Rumah Sakit serba digital yang mengintegrasikan seluruh alur operasional medis, penunjang, logistik, keuangan, dan analitik eksekutif **RSU Rajawali Citra**.

---

## 👨‍💻 Informasi Pengembang (Developer)

- **Lead Developer**: **Rivan Alamsyah**
- **Email**: `alamsyahrivan14@gmail.com`
- **Situs Portofolio**: [https://rivanalamsyah.netlify.app](https://rivanalamsyah.netlify.app)

---

## 🏥 Profil & Identitas Rumah Sakit

- **Nama Rumah Sakit**: RSU Rajawali Citra
- **Alamat Lengkap**: Jl. Pleret No.KM 2.5, Banjardadap, Potorono, Kec. Banguntapan, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55196
- **Telepon Call Center**: 0821-3431-3535
- **Jam Operasional**: Open 24 hours (Buka 24 Jam Non-Stop)
- **Provinsi / Wilayah**: Daerah Istimewa Yogyakarta (DIY)
- **Email Support**: `info@rsurajawalicitra.co.id`
- **Situs Web Resmi**: `https://rsurajawalicitra.co.id`

---

## 📌 Daftar Isi Dokumentasi Enterprise

1. [Panduan Instalasi Lokal](INSTALASI.md)
2. [Panduan Deployment Production (Ubuntu & Nginx)](DEPLOYMENT.md)
3. [Arsitektur Sistem & Service-Repository Pattern](ARSITEKTUR.md)
4. [Skema Database & Spesifikasi Tabel](DATABASE.md)
5. [Diagram Entity-Relationship (ERD)](ERD.md)
6. [Struktur Folder & Konvensi Kode](STRUKTUR_FOLDER.md)
7. [Spesifikasi 13 Modul Core SIMRS](MODUL.md)
8. [Panduan Pengguna (User Guide)](USER_GUIDE.md)
9. [Panduan Administrator (Admin Guide)](ADMIN_GUIDE.md)
10. [Matriks Peran & Hak Akses (Role & Permission)](ROLE_PERMISSION.md)
11. [Alur Pelayanan Pasien (Workflow End-to-End)](WORKFLOW.md)
12. [Dokumentasi API Internal & SATUSEHAT Integration](API_INTERNAL.md)
13. [Aturan Validasi Form Request](VALIDASI.md)
14. [Prosedur Backup & Restore Data](BACKUP_RESTORE.md)
15. [Panduan Troubleshooting & Solusi Galat](TROUBLESHOOTING.md)
16. [Fitur Keamanan & Security Standards](SECURITY.md)
17. [Panduan Optimasi Performa & Query](PERFORMANCE.md)
18. [Catatan Rilis (Changelog)](CHANGELOG.md)
19. [Pertanyaan Sering Diajukan (FAQ)](FAQ.md)
20. [Lisensi Penggunaan](LICENSE.md)

---

## 🏥 Ringkasan 13 Modul SIMRS Enterprise

| No | Modul | Deskripsi Fungsional | Status |
|---|---|---|---|
| 1 | **Pendaftaran & Antrean** | Registrasi pasien baru/lama, cetak tiket antrean, pencarian RM | ✅ 100% Ready |
| 2 | **Poliklinik / Rawat Jalan** | Assessment TTV perawat, pemanggilan suara antrean, SOAP dokter | ✅ 100% Ready |
| 3 | **Rawat Inap & Bed** | Admisi ranap, alokasi bed, transfer ruangan, & discharge pasien | ✅ 100% Ready |
| 4 | **Rekam Medis (EMR)** | EMR longitudinal, kodifikasi ICD-10 & ICD-9-CM, SOAP dokter | ✅ 100% Ready |
| 5 | **Farmasi & E-Resep** | Validasi apoteker, E-Resep, penyerahan obat (dispensing), stok FIFO | ✅ 100% Ready |
| 6 | **Laboratorium (LIS)** | Penerimaan sampel darah/urin, entry hasil lab, nilai rujukan | ✅ 100% Ready |
| 7 | **Kasir & Billing** | Invoice konsolidasi, pelunasan kasir, kuitansi, void invoice | ✅ 100% Ready |
| 8 | **Gudang Logistik** | Penerimaan barang (Inbound), pengeluaran unit (Outbound), opname | ✅ 100% Ready |
| 9 | **User & Audit Trail** | Spatie RBAC matrix, log aktivitas pengguna, & riwayat login | ✅ 100% Ready |
| 10 | **Laporan & Analitik BI** | Dashboard statistik, grafik bulanan, & ekspor CSV server-side | ✅ 100% Ready |
| 11 | **Pengaturan System** | Profil RS, penomoran dokumen otomatis, SMTP email, & backup | ✅ 100% Ready |
| 12 | **Master Data RS** | Master Dokter, Poli, Ruangan, Bed, Layanan, Obat, Supplier, Lab | ✅ 100% Ready |
| 13 | **Landing Page (`/`)** | Landing page 15-section modern dengan ROI calculator interaktif | ✅ 100% Ready |

---

## 🔑 Akun Demo Kredensial Pengujian

Seluruh akun demo telah dibuat pada seeder database dengan password default: `password`

| Role Peran | Email Login | Password | Modul Utama |
|---|---|---|---|
| **Super Administrator** | `admin@rsurajawalicitra.co.id` | `password` | Seluruh Akses & Pengaturan |
| **Petugas Pendaftaran** | `pendaftaran@rsurajawalicitra.co.id` | `password` | Pendaftaran & Antrean |
| **Dokter DPJP** | `dokter@rsurajawalicitra.co.id` | `password` | Poliklinik & EMR SOAP |
| **Perawat Poli / Ranap** | `perawat@rsurajawalicitra.co.id` | `password` | TTV & Bed Management |
| **Apoteker Farmasi** | `farmasi@rsurajawalicitra.co.id` | `password` | E-Resep & Dispensing |
| **Analis Laboratorium** | `laboratorium@rsurajawalicitra.co.id` | `password` | Sampel & Hasil Lab |
| **Petugas Kasir** | `kasir@rsurajawalicitra.co.id` | `password` | Invoice & Pelunasan Kasir |
| **Kepala Gudang** | `gudang@rsurajawalicitra.co.id` | `password` | Logistik & Stock Opname |
| **Direktur RS** | `direktur@rsurajawalicitra.co.id` | `password` | Dashboard Eksekutif & BI |

---

## 🚀 Quick Start (Menjalankan Aplikasi Lokal)

```bash
# 1. Clone repository
git clone https://github.com/simrs-rajawalicitra/simrs-laravel.git
cd simrs-laravel

# 2. Install dependency PHP & Node
composer install
npm install

# 3. Environment configuration
cp .env.example .env
php artisan key:generate

# 4. Migration & Seeder Data
php artisan migrate:fresh --seed

# 5. Build assets & Jalankan dev server
npm run build
php artisan serve
```

Aplikasi SIMRS siap diakses melalui browser pada `http://127.0.0.1:8000` atau `http://simrs.test`.

---

## 📧 Kontak Developer & Support Teknis

- **Pengembang**: Rivan Alamsyah (`alamsyahrivan14@gmail.com`)
- **Portofolio**: [https://rivanalamsyah.netlify.app](https://rivanalamsyah.netlify.app)
- **Instansi**: RSU Rajawali Citra
- **Alamat**: Jl. Pleret No.KM 2.5, Banjardadap, Potorono, Kec. Banguntapan, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55196
- **Telepon Support**: 0821-3431-3535
- **Email Support**: `info@rsurajawalicitra.co.id`
- **Situs Web**: `https://rsurajawalicitra.co.id`
