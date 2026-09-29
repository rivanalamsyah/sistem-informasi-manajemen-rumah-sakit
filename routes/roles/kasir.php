<?php

use App\Http\Controllers\BillingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Kasir Routes (Billing & Pembayaran Kasir)
|--------------------------------------------------------------------------
| Routes untuk Kasir, Admin & Super Admin:
| Tagihan pasien, pembukuan kasir, pencetakan kuitansi, proses transaksi pembayaran.
*/

Route::middleware(['auth', 'role:Super Admin,Admin,Kasir'])->group(function () {
    Route::get('/billing/reports', [BillingController::class, 'reports'])->name('billing.reports');
    Route::get('/billing/{invoice}/print', [BillingController::class, 'print'])->name('billing.print');
    Route::post('/billing/{invoice}/pay', [BillingController::class, 'pay'])->name('billing.pay');
    Route::resource('billing', BillingController::class)->parameters(['billing' => 'invoice']);
});
