<?php

use App\Http\Controllers\RegistrationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Petugas Pendaftaran Routes (Admisi & Registrasi Pasien)
|--------------------------------------------------------------------------
| Routes untuk Petugas Pendaftaran, Admin & Super Admin:
| Registrasi pasien baru/lama, pencarian data pasien, pembatalan registrasi.
*/

Route::middleware(['auth', 'role:Super Admin,Admin,Petugas Pendaftaran'])->group(function () {
    Route::get('/api/search-patients', [RegistrationController::class, 'searchPatients'])->name('registrations.search-patients');
    Route::post('/registrations/{registration}/cancel', [RegistrationController::class, 'cancel'])->name('registrations.cancel');
    Route::resource('registrations', RegistrationController::class);
});
