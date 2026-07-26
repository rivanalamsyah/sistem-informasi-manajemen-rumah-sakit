# Panduan Troubleshooting & Solusi Galat Teknis

Dokumen ini berisi daftar masalah umum yang mungkin terjadi pada SIMRS Enterprise dan solusi perbaikannya.

---

## 🛠️ Daftar Masalah Umum & Perbaikan

### 1. `SQLSTATE[42000]: 1140 In aggregated query without GROUP BY`
- **Penyebab**: Penggunaan query `SUM`/`COUNT` tanpa pembungkusan `DB::raw()` pada MySQL Strict Mode `ONLY_FULL_GROUP_BY`.
- **Solusi**: Pastikan kolom agregat di dalam `groupBy(...)` dibungkus dengan `DB::raw("DATE_FORMAT(...)")` atau gunakan collection filtering.

### 2. `ErrorException: Attempt to read property on null`
- **Penyebab**: Mengakses relasi yang bersifat opsional (misal: Pasien belum terhubung ke dokter).
- **Solusi**: Gunakan operator null-safe `?->` pada Blade (contoh: `$visit->registration?->doctor?->name`).

### 3. Halaman Tampilan Tidak Berubah Setelah Edit Blade
- **Penyebab**: Template Blade tersimpan di dalam view cache Laravel.
- **Solusi**: Jalankan `php artisan view:clear` atau `php artisan optimize:clear`.

### 4. `The stream or file "/var/www/simrs/storage/logs/laravel.log" could not be opened: failed to open stream: Permission denied`
- **Penyebab**: Hak akses folder `storage` atau `bootstrap/cache` tidak dimiliki oleh user `www-data`.
- **Solusi**: Jalankan `sudo chown -R www-data:www-data storage bootstrap/cache` dan `sudo chmod -R 775 storage bootstrap/cache`.
