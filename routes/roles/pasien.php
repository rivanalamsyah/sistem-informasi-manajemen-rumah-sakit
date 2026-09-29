<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Pasien Routes (Portal Pasien Mandiri)
|--------------------------------------------------------------------------
| Routes untuk Pasien & Super Admin:
| Dashboard mandiri pasien, booking antrean online, riwayat rekam medis pribadi.
*/

Route::middleware(['auth', 'role:Super Admin,Pasien'])->prefix('pasien-portal')->name('pasien.')->group(function () {
    Route::get('/', fn () => view('public.home'))->name('index');
});
