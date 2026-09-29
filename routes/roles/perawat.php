<?php

use App\Http\Controllers\InpatientController;
use App\Http\Controllers\OutpatientController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Perawat Routes (Rawat Jalan & Rawat Inap)
|--------------------------------------------------------------------------
| Routes untuk Perawat, Dokter, Admin & Super Admin:
| Antrean poli, triase TTV, pemantauan tempat tidur ranap, transfer bed, discharge.
*/

Route::middleware(['auth', 'role:Super Admin,Admin,Dokter,Perawat'])->group(function () {
    // Rawat Jalan
    Route::post('/outpatients/{outpatient_visit}/call-queue', [OutpatientController::class, 'callQueue'])->name('outpatients.call-queue');
    Route::put('/outpatients/{outpatient_visit}/vital-signs', [OutpatientController::class, 'updateVitalSigns'])->name('outpatients.update-vital-signs');
    Route::resource('outpatients', OutpatientController::class)->parameters(['outpatients' => 'outpatient_visit']);

    // Rawat Inap
    Route::get('/inpatients/monitoring', [InpatientController::class, 'bedMonitoring'])->name('inpatients.monitoring');
    Route::post('/inpatients/{inpatient_visit}/transfer', [InpatientController::class, 'transfer'])->name('inpatients.transfer');
    Route::post('/inpatients/{inpatient_visit}/discharge', [InpatientController::class, 'discharge'])->name('inpatients.discharge');
    Route::resource('inpatients', InpatientController::class)->parameters(['inpatients' => 'inpatient_visit']);
});
