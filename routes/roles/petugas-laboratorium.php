<?php

use App\Http\Controllers\LaboratoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Petugas Laboratorium Routes (LIS & Hasil Lab)
|--------------------------------------------------------------------------
| Routes untuk Petugas Laboratorium, Admin & Super Admin:
| Penerimaan sampel lab, pengisian hasil tes laboratorium, pencetakan hasil lab.
*/

Route::middleware(['auth', 'role:Super Admin,Admin,Petugas Laboratorium'])->group(function () {
    Route::post('/laboratory/{laboratory_order}/collect-sample', [LaboratoryController::class, 'collectSample'])->name('laboratory.collect-sample');
    Route::post('/laboratory/{laboratory_order}/store-results', [LaboratoryController::class, 'storeResults'])->name('laboratory.store-results');
    Route::resource('laboratory', LaboratoryController::class)->parameters(['laboratory' => 'laboratory_order']);
});
