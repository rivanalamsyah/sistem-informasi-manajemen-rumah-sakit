<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes — Entry Point Utama SIMRS RSU Rajawali Citra
|--------------------------------------------------------------------------
| File ini bertindak sebagai entry point utama untuk memuat public routes,
| guest authentication, shared authenticated routes, dan pendaftaran
| modul route terpisah secara modular per role.
*/

// ── 1. PUBLIC WEBSITE & INFORMASI UMUM ──────────────────────────────────────────
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

// Legacy Redirect
Route::get('/landing', fn () => redirect()->route('home'))->name('welcome');

// ── 2. AUTENTIKASI GUEST (LOGIN, REGISTER, LUPA PASSWORD) ────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
});

// ── 3. AUTHENTICATED COMMON & SHARED ROUTES ──────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/user/profile', [UserController::class, 'profile'])->name('users.profile');
    Route::post('/user/profile', [UserController::class, 'updateProfile'])->name('users.update-profile');
});

// ── 4. PEMUATAN MODULAR ROUTE PER ROLE ───────────────────────────────────────
require __DIR__ . '/roles/super-admin.php';
require __DIR__ . '/roles/admin.php';
require __DIR__ . '/roles/petugas-pendaftaran.php';
require __DIR__ . '/roles/dokter.php';
require __DIR__ . '/roles/perawat.php';
require __DIR__ . '/roles/apoteker.php';
require __DIR__ . '/roles/petugas-laboratorium.php';
require __DIR__ . '/roles/kasir.php';
require __DIR__ . '/roles/pasien.php';
