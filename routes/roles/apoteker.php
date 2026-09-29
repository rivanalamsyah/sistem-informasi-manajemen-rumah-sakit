<?php

use App\Http\Controllers\PharmacyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Apoteker Routes (Farmasi & Dispensing Obat)
|--------------------------------------------------------------------------
| Routes untuk Apoteker, Admin & Super Admin:
| Inventaris obat farmasi, mutasi stok obat, verifikasi resep, dispensing obat.
*/

Route::middleware(['auth', 'role:Super Admin,Admin,Apoteker'])->group(function () {
    Route::get('/pharmacy/inventory', [PharmacyController::class, 'inventory'])->name('pharmacy.inventory');
    Route::get('/pharmacy/movements', [PharmacyController::class, 'movements'])->name('pharmacy.movements');
    Route::post('/pharmacy/{prescription}/validate', [PharmacyController::class, 'validatePrescription'])->name('pharmacy.validate');
    Route::post('/pharmacy/{prescription}/dispense', [PharmacyController::class, 'dispense'])->name('pharmacy.dispense');
    Route::post('/pharmacy/adjust-stock/{medicine_stock}', [PharmacyController::class, 'adjustStock'])->name('pharmacy.adjust-stock');
    Route::resource('pharmacy', PharmacyController::class)->parameters(['pharmacy' => 'prescription']);
});
