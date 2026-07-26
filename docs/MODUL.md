# Rincian 13 Modul Core SIMRS Enterprise

Dokumen ini berisi spesifikasi teknis dan fungsional dari seluruh **13 Modul Core SIMRS Enterprise**.

---

## 📌 Deskripsi Spesifikasi Modul

### 1. Modul Pendaftaran Pasien & Antrean
- **Route Namespace**: `registrations.*`
- **Fitur Utama**: Registrasi pasien baru/lama, pencarian No. RM / NIK, penerbitan tiket antrean poli, pencetakan kartu pasien.
- **Controller**: `RegistrationController.php`

### 2. Modul Poliklinik & Rawat Jalan (Outpatient)
- **Route Namespace**: `outpatients.*`
- **Fitur Utama**: Antrean poli per dokter, assessment TTV perawat (vital signs), pemanggilan antrean suara, pemeriksaan DPJP dokter, & penyelesaian kunjungan.
- **Controller**: `OutpatientController.php`

### 3. Modul Rawat Inap & Bed Management (Inpatient)
- **Route Namespace**: `inpatients.*`
- **Fitur Utama**: Admisi masuk ranap, alokasi bed fisik, monitoring ketersediaan bed, transfer ruangan, & proses kepulangan (discharge).
- **Controller**: `InpatientController.php`

### 4. Modul Rekam Medis Elektronik (EMR SOAP)
- **Route Namespace**: `medical-records.*`
- **Fitur Utama**: Pengisian SOAP (Subjective, Objective, Assessment, Plan), kodifikasi penyakit ICD-10 & ICD-9-CM, histori longitudinal pasien.
- **Controller**: `MedicalRecordController.php`

### 5. Modul Farmasi & E-Resep
- **Route Namespace**: `pharmacy.*`
- **Fitur Utama**: Penerimaan E-Resep otomatis dari EMR, validasi dosis & stok apoteker, penyerahan obat (dispensing), auto-deduct stok obat FIFO.
- **Controller**: `PharmacyController.php`

### 6. Modul Laboratorium (LIS)
- **Route Namespace**: `laboratory.*`
- **Fitur Utama**: Order sampel lab, konfirmasi sampel darah/urin, entry hasil pengujian & nilai rujukan, validasi analis lab.
- **Controller**: `LaboratoryController.php`

### 7. Modul Kasir & Billing Pelayanan
- **Route Namespace**: `billing.*`
- **Fitur Utama**: Generasi invoice konsolidasi otomatis, pelunasan kasir (tunai/non-tunai), cetak kuitansi resmi A4, void/batal invoice.
- **Controller**: `BillingController.php`

### 8. Modul Gudang & Logistik Medis
- **Route Namespace**: `warehouse.*`
- **Fitur Utama**: Inbound penerimaan barang dari supplier (`GRN-`), Outbound distribusi ke unit/farmasi (`OUT-`), Mutasi antar gudang (`MUT-`), Stock Opname (`SOP-`), Kartu stok ledger.
- **Controller**: `WarehouseController.php`, `WarehouseItemController.php`, `WarehouseReceiptController.php`, dll.

### 9. Modul User Management & Security
- **Route Namespace**: `users.*`, `roles.*`, `activities.*`
- **Fitur Utama**: Management akun user, Spatie RBAC matrix grid, audit trail log aktivitas, riwayat login sesi.
- **Controller**: `UserController.php`, `RolePermissionController.php`, `ActivityLogController.php`

### 10. Modul Laporan & Dashboard Analitik BI
- **Route Namespace**: `reports.*`
- **Fitur Utama**: Dashboard KPI, grafik bulanan kunjungan/pendapatan, 10 penyakit terbanyak, ekspor CSV server-side (UTF-8 BOM).
- **Controller**: `ReportController.php`

### 11. Modul Pengaturan System
- **Route Namespace**: `settings.*`
- **Fitur Utama**: Profil RS & branding, format penomoran otomatis, SMTP email & test mail, notifikasi alert stok, backup database CLI.
- **Controller**: `SettingController.php`

### 12. Modul Master Data Utama
- **Route Namespace**: `master.*`
- **Fitur Utama**: CRUD Master Poli, Dokter, Ruangan, Bed, Layanan, Tarif, Obat, Supplier, Lab Tests.
- **Controller**: `DepartmentController.php`, `DoctorController.php`, dll.

### 13. Modul Landing Page Enterprise (`/`)
- **Route Name**: `landing`
- **Fitur Utama**: 15 Section landing page modern, ROI efficiency calculator, preview chart interaktif.
- **View**: `landing.blade.php`
