# Arsitektur Sistem & Pattern SIMRS Enterprise

Dokumen ini menjelaskan rancangan arsitektur perangkat lunak **SIMRS Enterprise**, yang dibangun dengan prinsip **Clean Code**, **Model-View-Controller (MVC)**, dan **Service Layer Pattern**.

---

## 🏛️ Diagram Arsitektur Aplikasi (Mermaid)

```mermaid
graph TD
    Client[Browser Client / User] -->|HTTP Request| Router[Laravel Router (routes/web.php)]
    Router -->|Middleware Auth & RBAC| Controller[HTTP Controllers (app/Http/Controllers)]
    Controller -->|Validasi Input| FormRequest[Form Request Validation (app/Http/Requests)]
    Controller -->|Delegasi Logika Bisnis| ServiceLayer[Services Layer (app/Services)]
    ServiceLayer -->|Query & Transaksi DB| EloquentModel[Eloquent Models (app/Models)]
    EloquentModel -->|MySQL 8 / MariaDB| Database[(MySQL Database)]
    ServiceLayer -->|Return Data Payload| Controller
    Controller -->|Render UI / Data| BladeView[Blade Views & Tailwind CSS 4]
    BladeView -->|HTML Response| Client
```

---

## 🧱 Layer Komponen Utama

### 1. Controllers (`app/Http/Controllers/`)
Menangani HTTP Request, menerima parameter, mengarahkan ke Service Layer, dan mengembalikan tampilan View Blade atau Response JSON.
- **Prinsip**: Controller harus *thin* (tipis) dan tidak boleh berisi query SQL kompleks secara langsung.

### 2. Service Layer (`app/Services/`)
Mengisolasi logika bisnis rumah sakit (Business Logic Engine) agar dapat digunakan kembali secara konsisten:
- `WarehouseService.php`: Logika stok FIFO, Goods Receipt, Outbound, Mutasi, dan Opname.
- `OutpatientService.php`: Logika TTV perawat, pemanggilan antrean, dan penyelesaian kunjungan poli.
- `InpatientService.php`: Logika admisi rawat inap, alokasi bed, transfer kamar, dan discharge.
- `PharmacyService.php`: Logika validasi E-Resep, pengurangan stok obat otomatis, dan dispensing.
- `LaboratoryService.php`: Logika penerimaan sampel lab dan publikasi hasil pengujian ke EMR.
- `BillingService.php`: Logika konsolidasi invoice tagihan dan pelunasan kasir.
- `UserService.php`: Logika statistik pengguna, RBAC matrix, dan audit log.
- `SettingService.php`: Logika konfigurasi global RS, SMTP, dan CLI database backup.

### 3. Form Requests (`app/Http/Requests/`)
Melakukan enkapsulasi aturan validasi parameter input sebelum mencapai Controller.
- Contoh: `StoreInpatientAdmissionRequest.php`, `StoreLabOrderRequest.php`, `ProcessPaymentRequest.php`.

### 4. Eloquent Models (`app/Models/`)
Mewakili entitas tabel database dan mendefinisikan relasi antar-tabel (`belongsTo`, `hasMany`, `belongsToMany`).
