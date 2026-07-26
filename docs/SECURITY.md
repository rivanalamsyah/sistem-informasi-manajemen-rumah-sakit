# Fitur Keamanan & Security Standards SIMRS Enterprise

Dokumen ini menjelaskan implementasi fitur keamanan pada **SIMRS Enterprise**.

---

## 🛡️ Standar Keamanan Utama

1. **Authentication & Password Hashing**: Menggunakan algoritma **Bcrypt** dengan work factor default Laravel 12.
2. **CSRF Protection**: Seluruh formulir POST, PUT, DELETE dilindungi token `@csrf` dan header `X-CSRF-TOKEN`.
3. **XSS Prevention**: Rendering tampilan Blade menggunakan sintaks `{{ $variable }}` yang secara otomatis meloloskan (escape) karakter HTML berbahaya.
4. **SQL Injection Prevention**: Seluruh query database menggunakan Eloquent ORM atau PDO Prepared Statements dengan parameter binding.
5. **Role-Based Access Control (RBAC)**: Menggunakan `spatie/laravel-permission` untuk membatasi eksekusi aksi berdasarkan wewenang pengguna.
6. **Audit Trail Log**: Setiap transaksi pembuatan, pengubahan, dan penghapusan data medis/keuangan dicatat pada tabel `activity_logs`.
7. **Session Management & Login History**: Setiap login mencatat IP address, User Agent browser, dan timestamp pada tabel `user_logins`.
