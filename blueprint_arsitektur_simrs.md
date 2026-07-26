# BLUEPRINT ARSITEKTUR SIMRS (SISTEM INFORMASI MANAJEMEN RUMAH SAKIT)
**Dokumen Spesifikasi Teknis, Desain Arsitektur, & Standar Pengembangan**

---

## DAFTAR ISI
1. [A. Analisis Kebutuhan](#a-analisis-kebutuhan)
2. [B. Analisis Aktor & Hak Akses](#b-analisis-aktor--hak-akses)
3. [C. Analisis Modul System (15 Modul)](#c-analisis-modul-system-15-modul)
4. [D. Analisis Alur Bisnis (End-to-End Flow)](#d-analisis-alur-bisnis-end-to-end-flow)
5. [E. Arsitektur Sistem & Struktur Framework](#e-arsitektur-sistem--struktur-framework)
6. [F. Standar Pengembangan & Code Pattern](#f-standar-pengembangan--code-pattern)
7. [G. Standar Desain UI/UX & Design System](#g-standar-desain-uiux--design-system)
8. [H. Arsitektur & Strategi Keamanan](#h-arsitektur--strategi-keamanan)
9. [I. Roadmap Pengembangan Sistem](#i-roadmap-pengembangan-sistem)
10. [J. Analisis Risiko & Mitigasi Teknis](#j-analisis-risiko--mitigasi-teknis)
11. [K. Self-Review & Verifikasi Arsitektur](#k-self-review--verifikasi-arsitektur)

---

## A. ANALISIS KEBUTUHAN

### 1. Tujuan Sistem
Sistem Informasi Manajemen Rumah Sakit (SIMRS) ini dirancang sebagai platform enterprise modern berbasis web yang ringan, cepat, aman, dan modular. Tujuan utamanya adalah:
- Digitalisasi dan otomatisasi operasional rumah sakit kelas C/D dan klinik utama menengah secara terpadu.
- Meminimalkan potensi *human error* pada pencatatan medis, penyampaian resep obat, transaksional laboratorium, dan perhitungan kasir/billing.
- Memastikan kemudahan pemeliharaan (*maintainability*) dan keterbacaan kode (*code readability*) untuk tim pengembang jangka panjang.
- Menyediakan arsitektur monolithic yang solid dan siap dikembangkan tanpa memerlukan refactoring besar jika di kemudian hari ditambahkan integrasi eksternal.

### 2. Ruang Lingkup Sistem
Ruang lingkup mencakup operasional internal rumah sakit secara menyeluruh, terdiri dari 15 modul inti:
1. Dashboard Analitik
2. Master Data Rumah Sakit
3. Pendaftaran & Admisi Pasien
4. Pelayanan Rawat Jalan (Poliklinik)
5. Pelayanan Rawat Inap
6. Rekam Medis Elektronik (EMR)
7. Pelayanan Farmasi & Manajemen Obat
8. Pelayanan Laboratorium
9. Kasir, Kas, & Billing Terpadu
10. Pelaporan Ekskutif & Operasional
11. Manajemen User, Peran, & Otentikasi
12. Pengaturan Sistem & Profil RS
13. Managemen Jadwal Dokter & Kuota
14. Logistik & Gudang Non-Obat / Obat
15. Portal Pasien Mandiri (Reservasi & Informasi)

### 3. Batasan Sistem (Constraints)
- **Arsitektur**: Monolith murni berbasis pola MVC Laravel.
- **Frontend Stack**: Laravel Blade Template Engine + Tailwind CSS + Vanilla JavaScript (Strict No React, Vue, Livewire, Inertia, Alpine, atau SPA framework lainnya).
- **Integrasi Eksternal**: Pada versi rilis dasar (Phase 1), **TIDAK** mencakup integrasi BPJS Bridging (V-Claim/P-Care), SATUSEHAT Kemenkes, PACS (Picture Archiving and Communication System), maupun fitur AI/Machine Learning.
- **Teknologi Backend**: PHP 8.5, Laravel 12, MySQL Database Server, Apache/Nginx Web Server.
- **Lokalisasi**: Bahasa Indonesia sebagai bahasa tunggal antarmuka, Timezone `Asia/Jakarta`, Charset `UTF-8`.

### 4. Asumsi Pengembangan
- Server deployment menggunakan lingkungan Linux (Ubuntu LTS) atau Windows Server dengan Nginx/Apache, PHP 8.5 FPM, MySQL 8.0+.
- Perangkat jaringan lokal (LAN) rumah sakit stabil dengan bandwidth memadai untuk transfer data antar workstation.
- Client browser pada stasiun kerja (Desktop/Tablet) mendukung fitur HTML5, ES6 Vanilla JS, dan CSS Grid/Flexbox modern (Chrome, Edge, Firefox, Safari).

### 5. Target Pengguna
1. **Manajemen / Eksekutif**: Direktur RS, Kepala Bagian Keuangan, Kepala Pelayanan Medis.
2. **Tenaga Medis**: Dokter Spesialis, Dokter Umum, Perawat, Bidan.
3. **Tenaga Penunjang Medis**: Apoteker, Asisten Apoteker, Analis Laboratorium.
4. **Staff Operasional & Administrasi**: Petugas Pendaftaran, Kasir/Billing, Staff Logistik/Gudang, Administrator Sistem (IT).
5. **Pasien / Masyarakat**: Pasien umum atau keluarga pasien yang mengakses Portal Pasien.

---

## B. ANALISIS AKTOR & HAK AKSES

| No | Aktor / Peran | Hak Akses Utama | Tanggung Jawab Operasional |
|:---|:---|:---|:---|
| 1 | **Super Admin** | Access All (Full Access tanpa batasan) | Pemeliharaan sistem, konfigurasi global, manajemen database, pemantauan audit log, recovery data. |
| 2 | **Admin / Management** | Pengaturan Master Data, Manajemen User (terbatas), Laporan Eksekutif, Pengaturan RS | Pengelolaan data referensi rumah sakit, penentuan tarif, pengelolaan akun pegawai, analisis laporan operasional. |
| 3 | **Dokter** | Jadwal Pribadi, Antrean Rawat Jalan/Inap, Rekam Medis (EMR), Input Resep, Order Lab | Pemeriksaan klinis pasien, pengisian Anamnesis, Diagnosis (ICD-10/ICD-9 CM), pemberian resep obat, permintaan penunjang medis. |
| 4 | **Perawat** | Antrean Poliklinik, Pengisian Tanda Vital (TTV), Asuhan Keperawatan, Manajemen Bed Rawat Inap | Anamnesis awal, pengukuran Tanda-tanda Vital (Suhu, TD, Nadi, RR), pendampingan dokter, manajemen tempat tidur pasien rawat inap. |
| 5 | **Apoteker / Staff Farmasi** | Antrean Resep, Verifikasi & Dispensing Obat, Stok Obat, Pengeluaran Obat | Verifikasi dosis resep, penyiapan obat (*dispensing*), penyerahan obat ke pasien, mutasi stok depo farmasi. |
| 6 | **Petugas Laboratorium** | Order Penunjang Lab, Input Hasil Pemeriksaan Lab, Verifikasi Hasil | Menerima sampel, melakukan verifikasi order lab, memasukkan hasil pemeriksaan fisik/kimia/darah, mencetak lembar hasil lab. |
| 7 | **Petugas Pendaftaran** | Master Data Pasien, Registrasi Pasien (Baru/Lama), Booking Antrean Poliklinik/Rawat Inap | Pendaftaran akun pasien, pembuatan No. RM, pencetakan kartu pasien & slip antrean, admisi rawat inap. |
| 8 | **Kasir / Billing** | Modul Billing, Pembayaran & Kas, Cetak Kuitansi, Rekap Pembayaran Harian | Verifikasi seluruh tagihan (tindakan, obat, lab, kamar), memproses transaksi pembayaran (Tunai/Non-Tunai), mencetak rincian tagihan. |
| 9 | **Pasien** | Portal Pasien (Profile, Riwayat Pemeriksaan, Jadwal Dokter, Booking Online Mandiri) | Melihat riwayat kunjungan medis pribadi, melakukan reservasi janji temu dokter, melihat estimasi antrean. |

---

## C. ANALISIS MODUL SYSTEM (15 MODUL)

### Modul 1: Dashboard
- **Tujuan**: Menyajikan ringkasan informasi operasional rumah sakit secara visual dan *real-time*.
- **Fungsi Utama**:
  - Widget KPI: Jumlah Pasien Hari Ini (Rawat Jalan, Rawat Inap, IGD), Bed Occupancy Rate (BOR), Total Revenue Hari Ini.
  - Grafik Kunjungan Pasien mingguan/bulanan.
  - Quick Shortcut ke menu favorit berdasarkan peran pengguna.
- **Hubungan Modul**: Terhubung dengan Pendaftaran, Rawat Jalan, Rawat Inap, Kasir, dan Farmasi.
- **Data Dikelola**: Metadata agregat kunjungan, indikator kinerja rumah sakit.

### Modul 2: Master Data
- **Tujuan**: Mengelola data referensi dasar yang digunakan di seluruh modul aplikasi.
- **Fungsi Utama**:
  - Data Wilayah (Provinsi, Kota/Kab, Kecamatan, Kelurahan).
  - Data Poliklinik / Spesialisasi.
  - Data Ruangan & Tempat Tidur (Bed Management: Kamar, Kelas, Tarif, Status Bed).
  - Master Diagnosa (ICD-10) & Master Tindakan Medis (ICD-9 CM / Tarif RS).
  - Master Satuan, Kategori, & Jenis Obat.
- **Hubungan Modul**: Menjadi fondasi dasar bagi Pendaftaran, Rawat Jalan, Rawat Inap, Farmasi, dan Billing.
- **Data Dikelola**: Data Kamar, Bed, Poliklinik, ICD-10, ICD-9 CM, Tarif Tindakan.

### Modul 3: Pendaftaran (Admisi Pasien)
- **Tujuan**: Memproses data identitas pasien dan pendaftaran kunjungan medis.
- **Fungsi Utama**:
  - Pencarian Pasien berdasarkan NIK, No. RM, Nama, atau Tanggal Lahir.
  - Registrasi Pasien Baru (Auto-generate Nomor Rekam Medis unik).
  - Pendaftaran Rawat Jalan (Pilih Poliklinik, Dokter, dan Tanggal Kunjungan).
  - Admisi Rawat Inap (Pilih Ruangan, Kelas, dan Bed yang tersedia).
  - Cetak Kartu Pasien & Slip Antrean Pendaftaran.
- **Hubungan Modul**: Master Data, Rawat Jalan, Rawat Inap, Jadwal Dokter, Rekam Medis.
- **Data Dikelola**: Pasien, Kunjungan Pasien (Registrasi), Nomor Antrean.

### Modul 4: Rawat Jalan (Poliklinik)
- **Tujuan**: Memfasilitasi proses pelayanan medis pasien di poliklinik rawat jalan.
- **Fungsi Utama**:
  - Pemanggilan antrean poliklinik secara berurutan.
  - Input Tanda-Tanda Vital (TTV) oleh Perawat (Tekanan Darah, Suhu, Nadi, Berat/Tinggi Badan).
  - Input Anamnesis, Keluhan Utama, Pemeriksaan Fisik oleh Dokter.
  - Pemilihan Diagnosa (ICD-10) & Input Tindakan Medis (ICD-9 CM).
  - E-Resep Obat langsung ke Farmasi & E-Order Pemeriksaan ke Laboratorium.
- **Hubungan Modul**: Pendaftaran, Rekam Medis, Farmasi, Laboratorium, Billing.
- **Data Dikelola**: Asuhan Keperawatan, Pemeriksaan Dokter, Order Resep, Order Lab.

### Modul 5: Rawat Inap
- **Tujuan**: Mengelola perawatan pasien yang membutuhkan rawat inap/opname.
- **Fungsi Utama**:
  - Denah & Monitoring Bed Real-time (Terisi, Kosong, Dibersihkan, Perbaikan).
  - Pencatatan Perkembangan Pasien Harian (CPPT - Catatan Perkembangan Pasien Terintegrasi).
  - Input Tindakan Harian, Visite Dokter, & Pemakaian Alkes/Obat Harian.
  - Transfer Pasien antar Ruangan/Kelas.
  - Proses Pasien Pulang (Checkout Medis & Admin).
- **Hubungan Modul**: Master Data, Rawat Jalan, Rekam Medis, Farmasi, Kasir/Billing.
- **Data Dikelola**: Admisi Rawat Inap, CPPT, Penggunaan Bed, Tindakan Rawat Inap.

### Modul 6: Rekam Medis (EMR - Electronic Medical Record)
- **Tujuan**: Menyimpan dan menampilkan riwayat medis pasien secara terpusat, komprehensif, dan terlindungi.
- **Fungsi Utama**:
  - Timeline Riwayat Kesehatan Pasien (Rawat Jalan, Rawat Inap, Lab, Resep Obat).
  - Pencarian Rekam Medis Pasien berdasarkan NIK / No. RM.
  - Ringkasan Medis Pasien Pulang (Discharge Summary).
  - Pencetakan Lembar Rekam Medis Terintegrasi.
- **Hubungan Modul**: Pendaftaran, Rawat Jalan, Rawat Inap, Laboratorium, Farmasi.
- **Data Dikelola**: Encrypted Health Records, History Log Pemeriksaan Medis.

### Modul 7: Farmasi (Apotek)
- **Tujuan**: Mengelola verifikasi resep, dispensing obat ke pasien, dan manajemen stok obat di depo.
- **Fungsi Utama**:
  - Antrean E-Resep dari Rawat Jalan dan Rawat Inap.
  - Verifikasi Dosis & Interaksi Obat oleh Apoteker.
  - Screen Penyiapan & Racikan Obat (Obat Jadi vs Obat Racikan).
  - Penyerahan Obat & ETIKET (Aturan Pakai Obat) otomatis tercetak.
  - Penjualan Obat Bebas (Penjualan Direct Tanpa Resep).
- **Hubungan Modul**: Rawat Jalan, Rawat Inap, Gudang Obat, Billing.
- **Data Dikelola**: Master Obat, Stok Depo Farmasi, Detail Transaksi Resep, Etiket.

### Modul 8: Laboratorium
- **Tujuan**: Mengolah permintaan order pemeriksaan sampel laboratorium medis.
- **Fungsi Utama**:
  - Daftar Order Masuk Laboratorium (dari Poliklinik / Rawat Inap).
  - Sampling Data (Waktu Ambil Sampel, Jenis Sampel).
  - Input Hasil Pemeriksaan Laboratorium (Nilai Parameter, Nilai Rujukan/Normal, Satuan, Flag Abnormal).
  - Validasi & Otorisasi Hasil oleh Penanggung Jawab Lab.
  - Cetak Lembar Hasil Laboratorium.
- **Hubungan Modul**: Rawat Jalan, Rawat Inap, Rekam Medis, Billing.
- **Data Dikelola**: Parameter Lab, Order Lab, Hasil Lab.

### Modul 9: Kasir & Billing
- **Tujuan**: Menghitung total konsolidasi tagihan pelayanan pasien dan memproses pembayaran.
- **Fungsi Utama**:
  - Konsolidasi Otomatis Seluruh Biaya (Biaya Admisi, Tindakan Medis, Obat Farmasi, Pemeriksaan Lab, Sewa Kamar Rawat Inap).
  - Pembuatan Rincian Tagihan (Invoice / Billing Sheet).
  - Pemrosesan Pembayaran (Tunai, Transfer Bank, Debit/Kredit).
  - Penerbitan Kuitansi Pembayaran Sah.
  - Rekapitulasi Pembayaran Kasir Per Shift / Per Hari.
- **Hubungan Modul**: Pendaftaran, Rawat Jalan, Rawat Inap, Farmasi, Laboratorium, Laporan.
- **Data Dikelola**: Invoice, Detail Item Billing, Transaksi Pembayaran, Rekap Kas.

### Modul 10: Laporan
- **Tujuan**: Menyediakan laporan operasional dan keuangan bagi pihak manajemen rumah sakit.
- **Fungsi Utama**:
  - Laporan Kunjungan Pasien (Per Poli, Per Dokter, Per Penjamin).
  - Laporan Keuangan & Pendapatan Kasir (Harian, Bulanan, Tahunan).
  - Laporan Morbiditas & 10 Besar Penyakit (Berdasarkan ICD-10).
  - Laporan Pengeluaran & Pemakaian Obat (Fast/Slow Moving).
  - Export Laporan ke format PDF dan Excel (.xlsx).
- **Hubungan Modul**: Seluruh modul transaksi operasional.
- **Data Dikelola**: Datamart agregat & query view pelaporan.

### Modul 11: Manajemen User (User & Access Management)
- **Tujuan**: Pengelolaan akun pengguna, peran (*roles*), dan izin akses (*permissions*).
- **Fungsi Utama**:
  - CRUD Akun Pengguna (Pegawai & Dokter).
  - Manajemen Role (Super Admin, Dokter, Perawat, Kasir, Apoteker, dll.).
  - Assignment Permission per Role.
  - Reset Password, Lock Account, & Log Activity User.
- **Hubungan Modul**: Seluruh Modul Aplikasi (Security Layer).
- **Data Dikelola**: Users, Roles, Permissions, ModelHasRoles.

### Modul 12: Pengaturan (System Settings)
- **Tujuan**: Mengatur konfigurasi variabel global sistem dan identitas instansi.
- **Fungsi Utama**:
  - Profil Rumah Sakit (Nama RS, Alamat, Logo, No. Telp, Email, Footer Kuitansi).
  - Konfigurasi Format Auto-Numbering (Format No. RM, No. Registrasi, No. Invoice, No. Resep).
  - Setting Running Text & Informasi Antrean Public Display.
- **Hubungan Modul**: Seluruh modul aplikasi (Global Config).
- **Data Dikelola**: System Settings Key-Value Pair.

### Modul 13: Jadwal Dokter
- **Tujuan**: Mengatur alokasi waktu praktik dan kuota pasien dokter spesialis/umum.
- **Fungsi Utama**:
  - Pengaturan Hari Praktik, Jam Mulai, & Jam Selesai Dokter per Poliklinik.
  - Pengaturan Max Kuota Pasien (Offline & Online).
  - Pengaturan Cuti Dokter / Dokter Pengganti.
- **Hubungan Modul**: Pendaftaran, Rawat Jalan, Portal Pasien.
- **Data Dikelola**: Doctor Schedules, Schedule Exceptions.

### Modul 14: Gudang (Inventory Non-Obat & Obat Central)
- **Tujuan**: Mengelola rantai pasok logistik obat, alkes, dan barang operasional rumah sakit.
- **Fungsi Utama**:
  - Penerimaan Barang dari Supplier / Vendor (PBM).
  - Stok Gudang Utama (FIFO / LIFO / Expired Date Tracking).
  - Permintaan Barang / Mutasi Stok dari Depo Farmasi & Unit ke Gudang Utama.
  - Pencatatan Stock Opname Periodik & Penyesuaian Stok.
- **Hubungan Modul**: Farmasi, Master Data, Billing.
- **Data Dikelola**: Inventori Barang, Transaksi Masuk/Keluar, Mutasi Stok, Batch & Expiry Date.

### Modul 15: Portal Pasien
- **Tujuan**: Antarmuka mandiri berbasis web responsif untuk pasien umum/keluarga pasien.
- **Fungsi Utama**:
  - Login / Registrasi Akun Pasien Mandiri (verifikasi NIK & No. HP).
  - Reservasi Online Kunjungan Poliklinik (Pilih Poli, Dokter, Tanggal).
  - Informasi Status Antrean Real-time Poliklinik.
  - Riwayat Kunjungan & Resume Medis Pribadi.
- **Hubungan Modul**: Pendaftaran, Jadwal Dokter, Rekam Medis.
- **Data Dikelola**: User Pasien, Online Booking Request.

---

## D. ANALISIS ALUR BISNIS (END-TO-END FLOW)

```
[ PASIEN DATANG ]
       │
       ├─► (Portal Pasien / Mandiri) ──► Booking Online ──┐
       │                                                 │
       └─► (Petugas Pendaftaran) ◄───────────────────────┘
                 │
                 ├──► Pasien Baru  ──► Input Data Pasien ──► Generate No. RM
                 │
                 └──► Pasien Lama  ──► Cari Data NIK/RM
                           │
                           ▼
                 Pilih Jenis Pelayanan
                           │
             ┌─────────────┴─────────────┐
             ▼                           ▼
     [ RAWAT JALAN ]             [ RAWAT INAP ]
             │                           │
             ▼                           ▼
    Antrean Poliklinik           Admisi Rawat Inap
             │                    (Alokasi Kamar/Bed)
             ▼                           │
   Pemeriksaan Perawat                   │
      (Input TTV)                        │
             │                           │
             ▼                           │
   Pemeriksaan Dokter ◄──────────────────┤
   - Anamnesis & Diagnosa (ICD-10)       │
   - Tindakan Medis (ICD-9 CM)           │
   - CPPT (Catatan Terintegrasi) ────────┘
             │
             ├──► Butuh Pemeriksaan Penunjang?
             │            │
             │            ▼
             │   [ LABORATORIUM ]
             │   - Terima Sampel
             │   - Input & Validasi Hasil
             │            │
             │            └───────────────────┐
             │                                │
             ├──► Butuh Obat / Resep?         │
             │            │                   │
             │            ▼                   │
             │   [ FARMASI ]                  │
             │   - Skrining & Dispensing Obat │
             │   - Mutasi Stok Depo Obat      │
             │   - Cetak Etiket               │
             │            │                   │
             │            └───────────────────┤
             │                                │
             ▼                                ▼
   [ PELAYANAN SELESAI ] ──────────► [ KASIR & BILLING ]
                                           │
                                           ├──► Rekap Tagihan Terkonsolidasi
                                           ├──► Memproses Pembayaran (Tunai/Non-Tunai)
                                           └──► Cetak Kuitansi Sah
                                                   │
                                                   ▼
                                           [ PASIEN PULANG ]
                                                   │
                                                   ▼
                                           [ MODUL LAPORAN ]
                                           (Sinkronisasi Otomatis)
```

---

## E. ARSITEKTUR SISTEM & STRUKTUR FRAMEWORK

### 1. Pola Monolith Layered MVC + Service Layer
Aplikasi menggunakan arsitektur **Monolith MVC (Model-View-Controller)** bawaan Laravel 12 yang diperkaya dengan **Service Layer**. Pola ini menjamin pemisahan tanggung jawab (*Separation of Concerns*) yang bersih tanpa kompleksitas berlebihan.

```
       [ Client Browser (Vanilla JS + Tailwind UI) ]
                           │
                           ▼ (HTTP Request / HTTPS)
                    [ Web Server ]
                           │
                           ▼
                   [ Routes (web.php) ]
                           │
                           ▼
                  [ HTTP Middleware ]
         (Auth, RBAC, CSRF, Secure Headers, Sanitize)
                           │
                           ▼
              [ Form Request Validation ]
          (Validasi input & aturan bisnis awal)
                           │
                           ▼
                    [ Controller ]
       (Proses HTTP Request, panggil Service, & kembalikan View)
                           │
                           ▼
                   [ Service Layer ]
        (Eksekusi Logika Bisnis, DB Transaction, Workflow)
                           │
                           ▼
                [ Eloquent Domain Model ]
            (Entitas Data, Relasi, & Query Scopes)
                           │
                           ▼
                  [ MySQL Database ]
```

### 2. Keputusan Arsitektur: Service Layer vs Repository Pattern
- **Service Layer (DIGUNAKAN)**:
  *Alasan*: Mengisolasi logika bisnis yang kompleks (seperti kalkulasi komprehensif billing kasir, alokasi pengurangan stok depo obat, dan pendaftaran transaksi bertahap) keluar dari Controller. Controller tetap *thin* (ramping) dan fokus mengatur HTTP Request/Response.
- **Repository Pattern (TIDAK DIGUNAKAN)**:
  *Alasan*: Eloquent ORM Laravel pada dasarnya sudah merupakan implementasi Active Record dan Query Builder yang sangat fleksibel dan kaya fitur. Mengatur *Repository Interface & Implementation* di atas Eloquent untuk aplikasi monolith berpotensi menciptakan lapisan abstraksi redundan (*over-engineering*) yang memperlambat proses pengkodean tanpa memberikan manfaat nyata.

### 3. Organisasi Folder Proyek Laravel 12

```
simrs/
├── app/
│   ├── Enums/                     # Enum PHP 8.5 (StatusPasien, StatusBed, StatusBilling, dll.)
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/             # Controller Master Data & Pengaturan
│   │   │   ├── Pendaftaran/       # Controller Admisi & Pendaftaran
│   │   │   ├── Poliklinik/        # Controller Pelayanan Rawat Jalan
│   │   │   ├── RawatInap/         # Controller Pelayanan Rawat Inap
│   │   │   ├── Farmasi/           # Controller Apotek & Obat
│   │   │   ├── Laboratorium/      # Controller Laboratorium
│   │   │   ├── Kasir/             # Controller Billing & Kuitansi
│   │   │   ├── Gudang/            # Controller Logistik
│   │   │   ├── Laporan/           # Controller Analytics & Reports
│   │   │   └── Portal/            # Controller Portal Pasien Mandiri
│   │   ├── Middleware/            # Custom Middleware Keamanan & RBAC
│   │   └── Requests/              # Form Request Classes per Modul
│   ├── Models/                    # Eloquent Models & Traits
│   ├── Services/                  # Business Logic Services per Domain
│   │   ├── PendaftaranService.php
│   │   ├── RekamMedisService.php
│   │   ├── FarmasiService.php
│   │   ├── BillingService.php
│   │   └── InventoryService.php
│   └── Traits/                    # Reusable Traits (Auditable, HasAutoNumber, dll.)
├── bootstrap/
│   └── app.php                    # Laravel 12 Configuration & Middleware Binding
├── config/                        # File Konfigurasi Laravel
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── public/                        # Asset Publik (Images, Compiled CSS/JS)
├── resources/
│   ├── css/                       # Tailwind CSS Entry File
│   ├── js/                        # Vanilla JS Modules & Helpers
│   └── views/
│       ├── components/            # Blade Components UI Reusable
│       │   ├── alert.blade.php
│       │   ├── badge.blade.php
│       │   ├── button.blade.php
│       │   ├── card.blade.php
│       │   ├── modal.blade.php
│       │   ├── table.blade.php
│       │   └── form/
│       ├── layouts/               # Master Layouts (Admin, Portal, Print)
│       │   ├── admin.blade.php
│       │   ├── auth.blade.php
│       │   └── print.blade.php
│       ├── modules/               # View Templates per Modul Aplikasi
│       │   ├── dashboard/
│       │   ├── pendaftaran/
│       │   ├── poliklinik/
│       │   ├── farmasi/
│       │   ├── kasir/
│       │   └── ...
│       └── partials/              # Sidebar, Topbar, Footer, Breadcrumbs
├── routes/
│   ├── web.php                    # General & Authenticated Routes
│   └── auth.php                   # Laravel Breeze Authentication Routes
└── storage/                       # App Storage, Logs, & Uploads
```

### 4. Konvensi Penamaan (Naming Conventions)
- **Database Table**: `snake_case` jamak (contoh: `pasiens`, `rekam_medis`, `detail_penjualan_obats`).
- **Eloquent Model**: `PascalCase` tunggal (contoh: `Pasien`, `RekamMedis`, `DetailPenjualanObat`).
- **Controller**: `PascalCase` dengan akhiran Controller (contoh: `PendaftaranController`, `FarmasiResepController`).
- **Service Class**: `PascalCase` dengan akhiran Service (contoh: `BillingService`).
- **Form Request**: `PascalCase` (contoh: `StorePasienRequest`, `UpdateResepRequest`).
- **Blade Views**: `kebab-case` (contoh: `resources/views/modules/rawat-jalan/index.blade.php`).
- **Blade Components**: `kebab-case` (contoh: `<x-card-header>`, `<x-form-input>`).
- **PHP Enums**: `PascalCase` (contoh: `StatusPendaftaranEnum`, `JenisKelaminEnum`).

### 5. Strategi Reusable Component Blade
Blade Component dikelompokkan menjadi 3 kategori:
1. **Layout Components**: `<x-layouts.admin>`, `<x-layouts.print>`.
2. **UI Primitive Components**: `<x-button>`, `<x-badge>`, `<x-card>`, `<x-modal>`, `<x-table>`, `<x-alert>`.
3. **Form Elements**: `<x-form-input>`, `<x-form-select>`, `<x-form-textarea>`, `<x-form-checkbox>`.

---

## F. STANDAR PENGEMBANGAN & CODE PATTERN

### 1. Kepatuhan PSR-12 & Tooling Code Quality
- Mengikuti standar **PSR-12** (PHP Coding Style Standard).
- Format otomatis menggunakan **Laravel Pint** sebelum penggabungan kode.

### 2. Struktur Controller (Thin Controller)
Controller dilarang keras menampung query SQL langsung, kalkulasi matematika rumit, atau transaksi multi-tabel. Controller hanya bertugas:
1. Menerima request yang sudah tervalidasi via `FormRequest`.
2. Memanggil metode pada `Service Layer`.
3. Mengembalikan respons HTTP (Redirect dengan flash message atau Blade View render).

### 3. Form Request Validation
Setiap manipulasi data (`POST`, `PUT`, `PATCH`) wajib menggunakan kelas `FormRequest` tersendiri.
- Mengisolasi aturan validasi dari Controller.
- Membantu auto-sanitasi data input sebelum masuk ke Service Layer.

### 4. Service Layer Pattern
Seluruh proses bisnis antar modul (contoh: Pembayaran Billing yang memunculkan transaksi kas, mengubah status registrasi pasien, serta merilis kunci kamar) dibungkus di dalam **Database Transaction** (`DB::transaction()`) di tingkat Service Layer untuk menjamin atomisitas (ACID).

### 5. Eloquent Relationship & Optimasi Database
- Menggunakan relasi resmi Eloquent (`hasOne`, `hasMany`, `belongsTo`, `belongsToMany`, `morphTo`).
- Wajib mengatasi N+1 Query Problem dengan secara konsisten menerapkan **Eager Loading** (`with(['poliklinik', 'dokter'])`).
- Menggunakan `select()` terbatas pada kolom yang dibutuhkan pada tabel berukuran besar (seperti rekam medis).

### 6. Pagination Standar
Seluruh daftar data tabel wajib menggunakan Pagination bawaan Eloquent (`paginate(15)`) untuk menjaga beban render memori server tetap efisien.

### 7. Logging & Error Handling Terstruktur
- Log aplikasi dipisah per hari (`daily` log channel) pada `storage/logs/laravel.log`.
- Log transaksi krusial (seperti error pembayaran kasir, kesalahan mutasi stok) dicatat menggunakan `Log::error()` beserta context array (User ID, IP Address, Payload).
- Exception khusus (*Custom Exceptions*) digunakan untuk menangani kegagalan bisnis (contoh: `StokObatHabisException`, `BedNotAvailableException`).

### 8. Session Management & Flash Message
- Session menggunakan driver `database` atau `redis` untuk ketahanan data session pengguna.
- Pemberitahuan sukses/gagal di antarmuka menggunakan flash session key konsisten (`success`, `error`, `warning`, `info`) yang ditangkap otomatis oleh komponen toast Blade.

### 9. System Audit Log (Audit Trail)
- Setiap aktivitas `CREATE`, `UPDATE`, `DELETE` pada tabel kritis (Rekam Medis, Resep, Billing, User Access) mencatat jejak audit:
  - `created_by`, `updated_by`, `deleted_by` (User ID).
  - Snapshot data sebelum dan sesudah perubahan (*old values* vs *new values*).

---

## G. STANDAR DESAIN UI/UX & DESIGN SYSTEM

### 1. Layout Admin Utama
Layout dasboard admin berbasis rupa *Modern Clean Clinical Interface*:
- **Sidebar Navigation**:
  - Terbagi menjadi grup menu logis (Operasional Medis, Penunjang, Keuangan, Master Data).
  - Dapat diciutkan (*collapsible*) untuk memberikan ruang kerja luas pada tampilan tablet.
- **Topbar**:
  - Menampilkan nama rumah sakit, running info jam WIB, pencarian cepat global (No. RM/Pasien), notifikasi antrean, dan menu profil user.
- **Breadcrumb**:
  - Navigasi bertingkat interaktif di bagian atas halaman (contoh: `Home / Poliklinik / Pemeriksaan Dokter`).

### 2. UI Component Blueprint

```
+-----------------------------------------------------------------------+
|  [Logo RS] SIMRS KENCANA       [Search RM...]    (Notif) (User Profile)|
+--------------+--------------------------------------------------------+
|  SIDEBAR     | Breadcrumb: Home / Rawat Jalan / Antrean Poliklinik   |
|              +--------------------------------------------------------+
|  Dashboard   |  +--[ Card Widget ]----------------------------------+ |
|  Master Data |  | Pasien Poli Hari Ini: 42 Pasien                   | |
| >Rawat Jalan |  +---------------------------------------------------+ |
|  Rawat Inap  |                                                        |
|  Farmasi     |  +--[ Table Container ]------------------------------+ |
|  Laboratorium|  | No | No. RM | Nama Pasien | Dokter | Status| Aksi  | |
|  Billing     |  +----+--------+-------------+--------+-------+-------+ |
|  Laporan     |  | 01 | RM-001 | Ahmad Yani  | Dr. B  | [Poli]| [Pilih| |
|  Pengaturan  |  +---------------------------------------------------+ |
+--------------+--------------------------------------------------------+
```

- **Cards**: Kontainer latar putih (*white background*) dengan sudut tumpul halus (`rounded-lg`), bayangan lembut (`shadow-sm`), dan border Slate tipis.
- **Tables**:
  - Header tabel berwarna kontras lembut dengan teks uppercase rata kiri.
  - Alternating row background (zebra striping lembut) untuk mempermudah pembacaan data padat.
  - Status ditampilkan dalam bentuk **Badge** berwarna (Teal: Selesai, Amber: Dalam Antrean, Rose: Batal, Indigo: Diproses).
- **Forms**:
  - Input label berada di atas bidang ketik dengan tanda bintang merah untuk kolom wajib.
  - Validasi error menampilkan garis tepi merah pada input dan teks penjelasan merah di bawahnya.
- **Modals**:
  - Memiliki latar belakang gelap transparan (*backdrop blur/dimmed*).
  - Posisi sentral secara vertikal dan horizontal, dapat ditutup dengan tombol ESC atau klik luar.
- **Empty State**:
  - Jika tabel atau data kosong, tampilkan ilustrasi SVG sederhana, pesan komunikatif, dan tombol aksi utama (contoh: "Belum Ada Data Pasien. [Tambah Pasien Baru]").
- **Loading State**:
  - Tombol yang sedang memproses tindakan akan menonaktifkan klik (*disabled*) dan menampilkan ikon spinner animasi Vanilla JS.

### 3. Palette Warna Medis Modern (Tailwind CSS Base)
- **Primary Color (Medical Trust)**: Teal / Deep Slate (`teal-600` / `teal-700`) - Memberikan kesan bersih, higienis, dan profesional.
- **Secondary Accent**: Indigo (`indigo-600`) - Digunakan untuk elemen penunjang medis dan statistik.
- **Neutral Background**: Slate (`slate-50`, `slate-100` untuk body, `white` untuk card).
- **State Colors**:
  - Success: Emerald (`emerald-600`)
  - Warning: Amber (`amber-500`)
  - Danger/Alert: Rose (`rose-600`)
  - Info: Sky (`sky-500`)

### 4. Tipografi & Ikon
- **Font Family**: *Inter* atau *Plus Jakarta Sans* (diimpor lokal/Google Fonts) untuk pembacaan teks angka dan medis yang legibel.
- **Icon Set**: SVG Inline berbasis Lucide Icons atau Heroicons yang di-render via Blade Component (`<x-icon.stethoscope />`).

### 5. Responsivitas Layar (Responsive Grid)
- **Desktop (>= 1024px)**: Sidebar permanen terbuka, tampilan tabel penuh multi-kolom.
- **Tablet (768px - 1023px)**: Sidebar otomatis ciut (*collapsed icon-only*), tabel dapat di-scroll horizontal secara halus.
- **Mobile (< 768px)**: Sidebar tersembunyi (*off-canvas drawer* dengan tombol hamburger), kartu data menggantikan tabel kompleks jika diperlukan.

---

## H. ARSITEKTUR & STRATEGI KEAMANAN

### 1. Otentikasi & Guard (Laravel Breeze)
- Otentikasi berbasis Laravel Breeze Blade (Session Guard).
- **Login Protection**: Throttle Rate Limiting (Maksimal 5 percobaan gagal per menit per IP untuk mencegah *brute-force attack*).
- Auto Logout jika terjadi inaktivitas selama durasi tertentu (misal: 30 menit).

### 2. Otorisasi & Control Akses (RBAC)
- Menggunakan Role-Based Access Control (RBAC) berbasis Spatie Permission atau Gate/Policy bawaan Laravel.
- Pengecekan izin dilakukan di 3 baris pertahanan:
  1. Middleware Route (`middleware('can:rekam-medis.view')`).
  2. Controller Method Authorization (`$this->authorize('update', $rekamMedis)`).
  3. Blade Directive View (`@can('farmasi.dispensing') ... @endcan`).

### 3. CSRF & XSS Prevention
- **CSRF Protection**: Seluruh Form HTML wajib menyertakan directive `@csrf`. Permintaan Fetch/AJAX Vanilla JS wajib mengirimkan header `X-CSRF-TOKEN`.
- **XSS Prevention**: Memanfaatkan pengescapan otomatis Blade `{{ $variable }}`. Untuk input riwayat medis kaya teks, dilakukan pembersihan (*sanitization*) ketat menggunakan HTMLPurifier.

### 4. SQL Injection & Mass Assignment Protection
- **SQL Injection**: Seluruh query database wajib menggunakan Eloquent ORM atau Query Builder berparameter. Dilarang keras menggunakan *raw SQL string concatenation*.
- **Mass Assignment**: Seluruh Model Eloquent mengaktifkan `protected $fillable` secara eksplisit untuk mencegah penyuntikan kolom tak terdaftar.

### 5. Keamanan Unggah Berkas (File Upload Security)
- Berkas pendukung (seperti hasil scan lab/rujukan) divalidasi MIME Type secara ketat (PDF, JPG, PNG) dan ukuran maksimal (maks 2MB).
- Berkas disimpan di direktori privat `storage/app/private` (bukan publik) dan hanya dapat diakses melalui *Signed Stream Controller* yang membutuhkan otorisasi hak akses.
- Nama file diubah secara acak (*UUID/Hashed Filename*) untuk mencegah eksekusi file berbahaya.

### 6. Hashing Password & Headers Keamanan
- Hashing password menggunakan algoritma **Bcrypt** atau **Argon2id**.
- Menambahkan Secure HTTP Headers via Middleware: `X-Frame-Options: SAMEORIGIN`, `X-Content-Type-Options: nosniff`, `X-XSS-Protection: 1; mode=block`, dan `Referrer-Policy`.

---

## I. ROADMAP PENGEMBANGAN SISTEM

Pengembangan dilakukan secara bertahap dan terukur dalam **6 Fase Utama** untuk meminimalkan risiko ketergantungan antar komponen:

```
[ FASE 1: FONDASI ] ──► [ FASE 2: POLIKLINIK ] ──► [ FASE 3: PENUNJANG ]
- Base Framework        - Jadwal Dokter           - Farmasi & Stok Obat
- System Config         - Admisi & Pendaftaran    - Gudang Inventory
- Design System UI      - Rawat Jalan (Poli)      - Laboratorium
- RBAC & User Auth      - EMR Rekam Medis
- Master Data Basic
         │
         ▼
[ FASE 6: HARDENING ] ◄── [ FASE 5: ANALITIK ] ◄── [ FASE 4: BILLING ]
- Audit Trail Security    - Dashboard Analitik      - Admisi Rawat Inap
- Performance Tuning      - Laporan Ekskutif        - Integrasi Kasir/Billing
- User Acceptance Test    - Portal Pasien           - Cetak Kuitansi & Kas
- UAT & Go-Live
```

### Rincian Pengerjaan:

1. **FASE 1: Fondasi Sistem & Master Data**
   - Inisialisasi struktur Laravel 12, Tailwind CSS, & Blade Component Library.
   - Setup Otentikasi (Breeze) & Spatie RBAC (Peran & Izin).
   - Implemetasi Master Data (Wilayah, Kamar/Bed, Poliklinik, ICD-10, ICD-9 CM, Tarif).

2. **FASE 2: Core Pelayanan Rawat Jalan & EMR**
   - Modul Jadwal Dokter & Manajemen Kuota.
   - Modul Pendaftaran Pasien (Baru/Lama, Rawat Jalan).
   - Modul Rawat Jalan (Anamnesis Perawat & Pemeriksaan Dokter).
   - Modul Rekam Medis Elektronik (EMR Timeline).

3. **FASE 3: Pelayanan Penunjang Medis & Logistik**
   - Modul Farmasi (E-Resep, Dispensing, Cetak Etiket).
   - Modul Gudang Inventory (Penerimaan Obat/Alkes, Stok Opname, Mutasi Depo).
   - Modul Laboratorium (Order Lab, Input Hasil, Validasi).

4. **FASE 4: Pelayanan Rawat Inap & Billing Terpadu**
   - Modul Admisi Rawat Inap & Bed Management.
   - Modul Pelayanan Rawat Inap (CPPT & Visite Dokter).
   - Modul Kasir & Billing Terpadu (Konsolidasi Otomatis Biaya & Kuitansi).

5. **FASE 5: Portal Pasien & Pelaporan Eksekutif**
   - Modul Dashboard Analitik KPI.
   - Modul Laporan (Kunjungan, Keuangan, 10 Besar Penyakit, Rekap Kasir).
   - Modul Portal Pasien Mandiri (Reservasi Online & Cek Antrean).

6. **FASE 6: Hardening, Pemeliharaan, & Deployment**
   - Pengujian keamanan (Security Hardening, XSS/CSRF Audit).
   - Profiling performa query SQL & indexing tuning.
   - User Acceptance Testing (UAT), Penyusunan Dokumentasi Pengguna, & Go-Live.

---

## J. ANALISIS RISIKO & MITIGASI TEKNIS

| No | Potensi Risiko Teknis / Fungsional | Dampak | Strategi Mitigasi Arsitektural |
|:---|:---|:---|:---|
| 1 | **Race Condition pada Pengurangan Stok Obat & Alokasi Bed** | Stok obat menjadi minus atau 1 bed ditempati 2 pasien akibat transaksi simultan. | Menggunakan **Database Transaction** dengan **Pessimistic Locking** (`lockForUpdate()`) pada Eloquent Service saat memproses pengurangan stok dan alokasi bed. |
| 2 | **Duplikasi Nomor Antrean & Nomor Rekam Medis** | Ketiadaan sinkronisasi nomor urut saat pendaftaran bersamaan. | Implementasi Atomic Sequence Trait berbasis transaksi database, dan penambahan indeks `UNIQUE` pada tingkat kolom tabel MySQL. |
| 3 | **Penurunan Performa Query pada Tabel Rekam Medis & Billing Besar** | Loading halaman poliklinik atau laporan bulanan lambat. | Pemasangan **Composite Indexing** pada kolom pencarian utama (seperti `pasien_id`, `created_at`, `deleted_at`), penarikan data berpaginasi, dan isolasi query laporan ke Service khusus. |
| 4 | **Ketidaksengajaan Penghapusan Data Medis Pasien** | Data riwayat kesehatan pasien hilang dari sistem. | Penerapan **Soft Delete** (`softDeletes()`) pada seluruh tabel master dan transaksi. Data dihapus secara kontekstual tanpa menghilangkan record fisik database. |
| 5 | **Kesalahan Manusia (Human Error) Input Dosis & Tarif Billing** | Dosis obat salah atau tagihan billing tidak akurat. | Pembuatan aturan validasi `FormRequest` yang presisi, penguncian tarif otomatis dari Master Data, serta modal konfirmasi ganda pada UI sebelum transaksi diselesaikan. |
| 6 | **Ukuran Berkas Asset & CSS Terlalu Besar** | Loading antarmuka di jaringan LAN rumah sakit terasa lambat. | Menggunakan Vite bundler untuk memadatkan Tailwind CSS dan Vanilla JS, serta memanfaatkan browser caching untuk static asset. |

---

## K. SELF-REVIEW & VERIFIKASI ARSITEKTUR

Sebagai Senior Software Architect, dilakukan evaluasi mandiri terhadap seluruh cetak biru arsitektur ini:

1. **Konsistensi Arsitektur**:
   - Pola Monolith MVC + Service Layer sangat konsisten diterapkan di seluruh 15 modul. Tidak ada modul yang melanggar batas tanggung jawab layer.
2. **Kepatuhan Terhadap Batasan User**:
   - Seluruh batasan (Tanpa AI, Tanpa BPJS, Tanpa SATUSEHAT, Tanpa PACS, Tanpa JS Framework heavy) terpenuhi 100%.
   - Menggunakan teknologi persis sesuai permintaan: Laravel 12, PHP 8.5, MySQL, Blade, Tailwind CSS, Vanilla JS, Laravel Breeze.
3. **Ketersediaan Jalur Pengembangan Masa Depan (Scalability & Extensibility)**:
   - Penggunaan Service Layer dan pengorganisasian modul yang rapi memastikan bahwa jika di masa mendatang manajemen memutuskan untuk menambahkan integrasi BPJS/SATUSEHAT/PACS, pengembang cukup menambahkan Service/Job khusus tanpa perlu merombak Controller atau Struktur Database inti.
4. **Kemudahan Pemeliharaan (Maintainability)**:
   - Pemisahan UI ke dalam Reusable Blade Components dan isolasi logika ke Service Layer mencegah munculnya *spaghetti code*.
   - Konvensi penamaan standar dan kepatuhan PSR-12 memudahkan *onboarding* developer baru dalam tim.

---
**Kesimpulan**: Blueprint Arsitektur SIMRS ini sah, solid, konsisten, dan siap dijadikan acuan utama untuk tahap perancangan database (skema ERD, migration, model, dan seeder) pada langkah selanjutnya.
