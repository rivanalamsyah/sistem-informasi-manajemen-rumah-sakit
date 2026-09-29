<?php

use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\OutpatientController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Dokter Routes (Pelayanan Medis & EMR)
|--------------------------------------------------------------------------
| Routes untuk Dokter, Admin & Super Admin:
| Input Rekam Medis (EMR), diagnosa ICD-10, anamnesis, penyelesaian layanan poliklinik.
*/

Route::middleware(['auth', 'role:Super Admin,Admin,Dokter'])->group(function () {
    Route::resource('medical-records', MedicalRecordController::class);
    Route::post('/outpatients/{outpatient_visit}/complete', [OutpatientController::class, 'complete'])->name('outpatients.complete');
});
