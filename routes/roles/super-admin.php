<?php

use App\Http\Controllers\SettingController;
use App\Http\Controllers\User\ActivityLogController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Super Admin Routes
|--------------------------------------------------------------------------
| Routes khusus untuk Super Admin: Audit trail, activity logs, dan
| konfigurasi tingkat lanjut sistem.
*/

Route::middleware(['auth', 'role:Super Admin'])->group(function () {
    // Audit Trail & Log Aktivitas Sistem
    Route::get('/audit-trail', [ActivityLogController::class, 'auditTrail'])->name('activities.audit-trail');
    Route::get('/login-history', [ActivityLogController::class, 'loginHistory'])->name('activities.login-history');

    // Modul Pengaturan Sistem (System Settings)
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
