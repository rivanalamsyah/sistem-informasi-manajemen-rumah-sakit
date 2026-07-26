# Panduan Administrator (Admin Guide) SIMRS Enterprise

Dokumen ini diperuntukkan bagi Administrator Sistem TI Rumah Sakit yang mengelola pengguna, hak akses, master data, dan pemeliharaan server.

---

## 🔐 1. Pengelolaan Akun Pengguna & Hak Akses (RBAC)

### Menambahkan User Baru
1. Buka menu **Pengaturan & Reference ➔ Manajemen User**.
2. Klik tombol **Tambah User Baru**.
3. Masukkan Nama Lengkap, Username, Email, Password, NIK, Nomor Telepon, dan centang satu/beberapa **Role Hak Akses**.
4. Klik **Simpan User Baru**.

### Mengatur Matriks Permission (Permission Matrix Grid)
1. Buka menu **Manajemen User ➔ Role & Hak Akses**.
2. Klik **Buka Permission Matrix**.
3. Centang modul mana saja yang berhak diakses oleh masing-masing Role (Misal: Kasir hanya bisa akses Billing).
4. Klik **Simpan Seluruh Matriks Permission**.

---

## 🛠️ 2. Management Master Data Rumah Sakit

Administrator bertanggung jawab mengelola Master Data pada menu **Master Data**:
- **Master Dokter & Jadwal**: Mengatur spesialisasi, SIP, dan kuota harian.
- **Master Ruangan & Tempat Tidur (Bed)**: Mengatur status Bed (Kosong, Terisi, Perawatan/Rusak).
- **Master Layanan & Tarif**: Mengatur harga nominal tindakan medis.
- **Master Obat & BMHP**: Mengatur HPP, harga jual, dan kategori obat.

---

## 💾 3. Backup & Restore Database CLI

1. Buka menu **Pengaturan RS ➔ Backup & Restore**.
2. Klik **Buat Backup Database Sekarang**.
3. File `.sql.gz` terkompresi akan dibuat di folder `storage/app/backups/`.
4. Klik **Unduh File** untuk mengunduh arsip cadangan ke komputer lokal.
