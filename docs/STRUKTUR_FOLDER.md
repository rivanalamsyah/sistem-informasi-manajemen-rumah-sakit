# Struktur Direktori & Konvensi Kode SIMRS Enterprise

Dokumen ini menjelaskan tata letak direktori proyek **SIMRS Enterprise** yang mematuhi konvensi standar Laravel 12.

---

## 📂 Pohon Direktori Utama Project

```text
simrs/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/LoginController.php
│   │   │   ├── Master/ (DepartmentController, DoctorController, dll)
│   │   │   ├── User/ (UserController, RolePermissionController, ActivityLogController)
│   │   │   ├── Warehouse/ (WarehouseController, Item, Receipt, Dispatch, Mutation, Opname)
│   │   │   ├── BillingController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── InpatientController.php
│   │   │   ├── LaboratoryController.php
│   │   │   ├── MedicalRecordController.php
│   │   │   ├── OutpatientController.php
│   │   │   ├── PharmacyController.php
│   │   │   ├── RegistrationController.php
│   │   │   ├── ReportController.php
│   │   │   └── SettingController.php
│   │   ├── Middleware/ (Authenticate, Spatie RBAC)
│   │   └── Requests/ (Form Request Validations)
│   ├── Models/ (32 Eloquent Models)
│   └── Services/ (WarehouseService, UserService, SettingService, BillingService, dll)
├── bootstrap/
├── config/ (app.php, database.php, simrs.php)
├── database/
│   ├── migrations/ (File skema DDL MySQL)
│   └── seeders/ (DatabaseSeeder & Data Historis)
├── docs/ (21 File Dokumentasi Enterprise)
├── public/ (Favicon, build assets, index.php)
├── resources/
│   ├── css/ (app.css Tailwind CSS 4)
│   ├── js/ (app.js Vite Javascript)
│   └── views/
│       ├── components/ (x-card, x-table, x-page-header, x-badge, x-action-bar, dll)
│       ├── layouts/ (admin.blade.php Sidebar Drawer Layout)
│       ├── modules/ (Tampilan Blade 13 Modul SIMRS)
│       └── landing.blade.php (15-Section Enterprise Landing Page)
├── routes/
│   └── web.php (219 Registered Routes)
├── storage/
│   ├── app/ (backups, uploads)
│   └── logs/ (laravel.log)
├── composer.json
├── package.json
└── vite.config.js
```
