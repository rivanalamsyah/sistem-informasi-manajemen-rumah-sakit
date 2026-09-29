<?php

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
use App\Http\Controllers\ReportController;
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
| Admin Routes
|--------------------------------------------------------------------------
| Routes untuk Admin & Super Admin: Manajemen pengguna, RBAC matrix,
| Master Data Rumah Sakit, Manajemen Logistik/Gudang, serta Laporan Eksekutif.
*/

Route::middleware(['auth', 'role:Super Admin,Admin'])->group(function () {

    // ── User Management & Status ──────────────────────────────────────────────
    Route::post('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');
    Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])->name('users.reset-password');
    Route::resource('users', UserController::class);

    // ── Roles & Permission Matrix ─────────────────────────────────────────────
    Route::get('/roles-matrix', [RolePermissionController::class, 'matrix'])->name('roles.matrix');
    Route::post('/roles-matrix', [RolePermissionController::class, 'updateMatrix'])->name('roles.update-matrix');
    Route::get('/roles', [RolePermissionController::class, 'indexRoles'])->name('roles.index');
    Route::post('/roles', [RolePermissionController::class, 'storeRole'])->name('roles.store');
    Route::put('/roles/{role}', [RolePermissionController::class, 'updateRole'])->name('roles.update');
    Route::delete('/roles/{role}', [RolePermissionController::class, 'destroyRole'])->name('roles.destroy');

    // ── Master Data Utama Rumah Sakit ─────────────────────────────────────────
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

    // ── Modul Manajemen Logistik & Gudang (Warehouse) ─────────────────────────
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

    // ── Reports & Analitik Rumah Sakit ────────────────────────────────────────
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/registrations', [ReportController::class, 'registrations'])->name('registrations');
        Route::get('/outpatients', [ReportController::class, 'outpatients'])->name('outpatients');
        Route::get('/inpatients', [ReportController::class, 'inpatients'])->name('inpatients');
        Route::get('/emr', [ReportController::class, 'emr'])->name('emr');
        Route::get('/pharmacy', [ReportController::class, 'pharmacy'])->name('pharmacy');
        Route::get('/laboratory', [ReportController::class, 'laboratory'])->name('laboratory');
        Route::get('/financial', [ReportController::class, 'financial'])->name('financial');
        Route::get('/export-csv/{type}', [ReportController::class, 'exportCsv'])->name('export-csv');
    });
});
