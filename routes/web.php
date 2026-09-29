<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BillingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InpatientController;
use App\Http\Controllers\LaboratoryController;
use App\Http\Controllers\Master\BedController;
use App\Http\Controllers\Master\DepartmentController;
use App\Http\Controllers\Master\DoctorController;
use App\Http\Controllers\Master\LaboratoryTestController;
use App\Http\Controllers\Master\MedicineCategoryController;
use App\Http\Controllers\Master\MedicineController;
use App\Http\Controllers\Master\RoomController;
use App\Http\Controllers\Master\ServiceController;
use App\Http\Controllers\Master\SupplierController;
use App\Http\Controllers\Master\TariffController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\OutpatientController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\User\ActivityLogController;
use App\Http\Controllers\User\RolePermissionController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Warehouse\StockOpnameController;
use App\Http\Controllers\Warehouse\WarehouseController;
use App\Http\Controllers\Warehouse\WarehouseDispatchController;
use App\Http\Controllers\Warehouse\WarehouseItemController;
use App\Http\Controllers\Warehouse\WarehouseMasterController;
use App\Http\Controllers\Warehouse\WarehouseMutationController;
use App\Http\Controllers\Warehouse\WarehouseReceiptController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — SIMRS RSU Rajawali Citra
|--------------------------------------------------------------------------
*/

// ── PUBLIC WEBSITE & INFORMASI UMUM ──────────────────────────────────────────
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/tentang-kami', [PublicController::class, 'about'])->name('about');
Route::get('/layanan', [PublicController::class, 'services'])->name('services');
Route::get('/layanan/{slug}', [PublicController::class, 'serviceDetail'])->name('services.detail');
Route::get('/dokter', [PublicController::class, 'doctors'])->name('doctors');
Route::get('/dokter/{slug}', [PublicController::class, 'doctorDetail'])->name('doctors.detail');
Route::get('/informasi', [PublicController::class, 'information'])->name('information');
Route::get('/informasi/berita', [PublicController::class, 'news'])->name('news');
Route::get('/informasi/berita/{slug}', [PublicController::class, 'newsDetail'])->name('news.detail');
Route::get('/informasi/artikel', [PublicController::class, 'articles'])->name('articles');
Route::get('/informasi/artikel/{slug}', [PublicController::class, 'articleDetail'])->name('articles.detail');
Route::get('/informasi/faq', [PublicController::class, 'faq'])->name('faq');
Route::get('/kontak', [PublicController::class, 'contact'])->name('contact');

// Redirect legacy route
Route::get('/landing', fn () => redirect()->route('home'))->name('welcome');

// ── AUTENTIKASI GUEST (LOGIN, REGISTER, LUPA PASSWORD) ────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
});

// ── UTAMA & AUTHENTICATED COMMON ROUTES ──────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/user/profile', [UserController::class, 'profile'])->name('users.profile');
    Route::post('/user/profile', [UserController::class, 'updateProfile'])->name('users.update-profile');

    // ── ROLE GROUP 1: SUPER ADMIN & MANAGEMENT SECURITY ────────────────────
    Route::middleware('role:Super Admin')->group(function () {
        // Audit Trail & Activity Logs
        Route::get('/audit-trail', [ActivityLogController::class, 'auditTrail'])->name('activities.audit-trail');
        Route::get('/login-history', [ActivityLogController::class, 'loginHistory'])->name('activities.login-history');

        // Modul Pengaturan Sistem
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('index');
            Route::get('/hospital', [SettingController::class, 'hospitalProfile'])->name('hospital');
            Route::post('/hospital', [SettingController::class, 'updateHospitalProfile']);
            Route::get('/numbering', [SettingController::class, 'numbering'])->name('numbering');
            Route::post('/numbering', [SettingController::class, 'updateNumbering']);
            Route::get('/email', [SettingController::class, 'email'])->name('email');
            Route::post('/email', [SettingController::class, 'updateEmail']);
            Route::post('/email/test', [SettingController::class, 'testEmail'])->name('email.test');
            Route::get('/notifications', [SettingController::class, 'notifications'])->name('notifications');
            Route::post('/notifications', [SettingController::class, 'updateNotifications']);
            Route::get('/backup', [SettingController::class, 'backup'])->name('backup');
            Route::post('/backup/run', [SettingController::class, 'runBackup'])->name('backup.run');
            Route::get('/backup/download/{backup}', [SettingController::class, 'downloadBackup'])->name('backup.download');
            Route::get('/security', [SettingController::class, 'security'])->name('security');
            Route::post('/security', [SettingController::class, 'updateSecurity']);
        });
    });

    // ── ROLE GROUP 2: ADMIN & MASTER DATA ──────────────────────────────────
    Route::middleware('role:Super Admin,Admin')->group(function () {
        Route::post('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');
        Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
        Route::resource('users', UserController::class);

        // Roles & Permission Matrix
        Route::get('/roles-matrix', [RolePermissionController::class, 'matrix'])->name('roles.matrix');
        Route::post('/roles-matrix', [RolePermissionController::class, 'updateMatrix'])->name('roles.update-matrix');
        Route::get('/roles', [RolePermissionController::class, 'indexRoles'])->name('roles.index');
        Route::post('/roles', [RolePermissionController::class, 'storeRole'])->name('roles.store');
        Route::put('/roles/{role}', [RolePermissionController::class, 'updateRole'])->name('roles.update');
        Route::delete('/roles/{role}', [RolePermissionController::class, 'destroyRole'])->name('roles.destroy');

        // Master Data Utama
        Route::get('/master', fn () => view('modules.master.index'))->name('master.index');
        Route::prefix('master')->name('master.')->group(function () {
            Route::resource('departments', DepartmentController::class);
            Route::resource('doctors', DoctorController::class);
            Route::resource('rooms', RoomController::class);
            Route::resource('beds', BedController::class);
            Route::resource('services', ServiceController::class);
            Route::resource('tariffs', TariffController::class);
            Route::resource('medicine-categories', MedicineCategoryController::class);
            Route::resource('medicines', MedicineController::class);
            Route::resource('suppliers', SupplierController::class);
            Route::resource('laboratory-tests', LaboratoryTestController::class);
        });

        // Modul Manajemen Gudang (Warehouse Management)
        Route::prefix('warehouse')->name('warehouse.')->group(function () {
            Route::get('/', [WarehouseController::class, 'index'])->name('index');
            Route::get('/stock-card', [WarehouseController::class, 'stockCard'])->name('stock-card');
            Route::get('/reports', [WarehouseController::class, 'reports'])->name('reports');
            Route::get('/export-csv', [WarehouseController::class, 'exportCsv'])->name('export-csv');
            Route::resource('items', WarehouseItemController::class);
            Route::get('/masters', [WarehouseMasterController::class, 'index'])->name('masters.index');
            Route::post('/masters/warehouses', [WarehouseMasterController::class, 'storeWarehouse'])->name('masters.store-warehouse');
            Route::post('/masters/locations', [WarehouseMasterController::class, 'storeLocation'])->name('masters.store-location');
            Route::resource('receipts', WarehouseReceiptController::class)->only(['index', 'create', 'store', 'show']);
            Route::resource('dispatches', WarehouseDispatchController::class)->only(['index', 'create', 'store', 'show']);
            Route::resource('mutations', WarehouseMutationController::class)->only(['index', 'create', 'store', 'show']);
            Route::resource('opnames', StockOpnameController::class)->only(['index', 'create', 'store', 'show']);
        });

        // Reports & Analitik
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('/reports/registrations', [ReportController::class, 'registrations'])->name('reports.registrations');
        Route::get('/reports/outpatients', [ReportController::class, 'outpatients'])->name('reports.outpatients');
        Route::get('/reports/inpatients', [ReportController::class, 'inpatients'])->name('reports.inpatients');
        Route::get('/reports/emr', [ReportController::class, 'emr'])->name('reports.emr');
        Route::get('/reports/pharmacy', [ReportController::class, 'pharmacy'])->name('reports.pharmacy');
        Route::get('/reports/laboratory', [ReportController::class, 'laboratory'])->name('reports.laboratory');
        Route::get('/reports/financial', [ReportController::class, 'financial'])->name('reports.financial');
        Route::get('/reports/export-csv/{type}', [ReportController::class, 'exportCsv'])->name('reports.export-csv');
    });

    // ── ROLE GROUP 3: PETUGAS PENDAFTARAN (ADMISI) ────────────────────────────
    Route::middleware('role:Super Admin,Admin,Petugas Pendaftaran')->group(function () {
        Route::get('/api/search-patients', [RegistrationController::class, 'searchPatients'])->name('registrations.search-patients');
        Route::post('/registrations/{registration}/cancel', [RegistrationController::class, 'cancel'])->name('registrations.cancel');
        Route::resource('registrations', RegistrationController::class);
    });

    // ── ROLE GROUP 4: DOKTER (PELAYANAN MEDIS & EMR) ─────────────────────────
    Route::middleware('role:Super Admin,Admin,Dokter')->group(function () {
        Route::resource('medical-records', MedicalRecordController::class);
        Route::post('/outpatients/{outpatient_visit}/complete', [OutpatientController::class, 'complete'])->name('outpatients.complete');
    });

    // ── ROLE GROUP 5: PERAWAT (RAWAT JALAN & RAWAT INAP) ─────────────────────
    Route::middleware('role:Super Admin,Admin,Dokter,Perawat')->group(function () {
        Route::post('/outpatients/{outpatient_visit}/call-queue', [OutpatientController::class, 'callQueue'])->name('outpatients.call-queue');
        Route::put('/outpatients/{outpatient_visit}/vital-signs', [OutpatientController::class, 'updateVitalSigns'])->name('outpatients.update-vital-signs');
        Route::resource('outpatients', OutpatientController::class)->parameters(['outpatients' => 'outpatient_visit']);

        Route::get('/inpatients/monitoring', [InpatientController::class, 'bedMonitoring'])->name('inpatients.monitoring');
        Route::post('/inpatients/{inpatient_visit}/transfer', [InpatientController::class, 'transfer'])->name('inpatients.transfer');
        Route::post('/inpatients/{inpatient_visit}/discharge', [InpatientController::class, 'discharge'])->name('inpatients.discharge');
        Route::resource('inpatients', InpatientController::class)->parameters(['inpatients' => 'inpatient_visit']);
    });

    // ── ROLE GROUP 6: APOTEKER (FARMASI & OBAT) ──────────────────────────────
    Route::middleware('role:Super Admin,Admin,Apoteker')->group(function () {
        Route::get('/pharmacy/inventory', [PharmacyController::class, 'inventory'])->name('pharmacy.inventory');
        Route::get('/pharmacy/movements', [PharmacyController::class, 'movements'])->name('pharmacy.movements');
        Route::post('/pharmacy/{prescription}/validate', [PharmacyController::class, 'validatePrescription'])->name('pharmacy.validate');
        Route::post('/pharmacy/{prescription}/dispense', [PharmacyController::class, 'dispense'])->name('pharmacy.dispense');
        Route::post('/pharmacy/adjust-stock/{medicine_stock}', [PharmacyController::class, 'adjustStock'])->name('pharmacy.adjust-stock');
        Route::resource('pharmacy', PharmacyController::class)->parameters(['pharmacy' => 'prescription']);
    });

    // ── ROLE GROUP 7: PETUGAS LABORATORIUM (LIS) ────────────────────────────
    Route::middleware('role:Super Admin,Admin,Petugas Laboratorium')->group(function () {
        Route::post('/laboratory/{laboratory_order}/collect-sample', [LaboratoryController::class, 'collectSample'])->name('laboratory.collect-sample');
        Route::post('/laboratory/{laboratory_order}/store-results', [LaboratoryController::class, 'storeResults'])->name('laboratory.store-results');
        Route::resource('laboratory', LaboratoryController::class)->parameters(['laboratory' => 'laboratory_order']);
    });

    // ── ROLE GROUP 8: KASIR (BILLING & PEMBAYARAN) ───────────────────────────
    Route::middleware('role:Super Admin,Admin,Kasir')->group(function () {
        Route::get('/billing/reports', [BillingController::class, 'reports'])->name('billing.reports');
        Route::get('/billing/{invoice}/print', [BillingController::class, 'print'])->name('billing.print');
        Route::post('/billing/{invoice}/pay', [BillingController::class, 'pay'])->name('billing.pay');
        Route::resource('billing', BillingController::class)->parameters(['billing' => 'invoice']);
    });

    // ── ROLE GROUP 9: PASIEN (PORTAL PASIEN MANDIRI) ─────────────────────────
    Route::middleware('role:Super Admin,Pasien')->prefix('pasien-portal')->name('pasien.')->group(function () {
        Route::get('/', fn () => view('public.home'))->name('index');
    });
});
