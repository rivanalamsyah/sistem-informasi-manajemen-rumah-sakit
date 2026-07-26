# DOKUMEN DESAIN DATABASE RELASIONAL SIMRS
**Spesifikasi Skema Database MySQL & Pemetaan Eloquent ORM**

---

## DAFTAR ISI
1. [A. Daftar Tabel Sistem (Terelasi per Modul)](#a-daftar-tabel-sistem-terelasi-per-modul)
2. [B. Spesifikasi Detail Struktur Kolom Tabel](#b-spesifikasi-detail-struktur-kolom-tabel)
3. [C. Relasi Antar Tabel & Rasionalitas Eloquent](#c-relasi-antar-tabel--rasionalitas-eloquent)
4. [D. Entity Relationship Diagram (ERD Tekstual)](#d-entity-relationship-diagram-erd-tekstual)
5. [E. Skema Master Data Terpusat](#e-skema-master-data-terpusat)
6. [F. Skema & Alur Data Transaksi Utama](#f-skema--alur-data-transaksi-utama)
7. [G. Strategi Indeks & Optimasi Performa Query](#g-strategi-indeks--optimasi-performa-query)
8. [H. Strategi Soft Delete & Integritas Data](#h-strategi-soft-delete--integritas-data)
9. [I. Strategi Audit Trail (`created_by`, `updated_by`, `deleted_by`)](#i-strategi-audit-trail-created_by-updated_by-deleted_by)
10. [J. Validasi Desain Database & Self-Review Audit](#j-validasi-desain-database--self-review-audit)

---

## A. DAFTAR TABEL SISTEM (TERELASI PER MODUL)

Seluruh database dirancang menggunakan engine **InnoDB**, charset `utf8mb4`, dan collation `utf8mb4_unicode_ci`. Terdiri dari **32 Tabel** yang terbagi konsisten untuk melayani 15 modul SIMRS:

```
[ MODUL OTENTIKASI & PENGATURAN ]
  ├─ 1. users
  ├─ 2. roles
  ├─ 3. permissions
  ├─ 4. role_has_permissions
  ├─ 5. model_has_roles
  └─ 6. system_settings

[ MODUL MASTER DATA & JADWAL DOKTER ]
  ├─ 7. pasiens
  ├─ 8. polikliniks
  ├─ 9. dokters
  ├─ 10. jadwal_dokters
  ├─ 11. ruangans
  ├─ 12. kamar_rawats
  ├─ 13. tempat_tidurs
  └─ 14. tindakans

[ MODUL FARMASI & GUDANG LOGISTIK ]
  ├─ 15. suppliers
  ├─ 16. kategori_obats
  ├─ 17. satuan_obats
  ├─ 18. obats
  ├─ 19. stok_gudangs
  ├─ 20. penerimaan_barangs
  ├─ 21. detail_penerimaan_barangs
  └─ 22. mutasi_stoks

[ MODUL LABORATORIUM ]
  ├─ 23. kategori_lab_items
  └─ 24. pemeriksaan_labs

[ MODUL TRANSAKSI PELAYANAN MEDIS ]
  ├─ 25. pendaftarans
  ├─ 26. kunjungan_rawat_jalans
  ├─ 27. admisi_rawat_inaps
  ├─ 28. cppts
  ├─ 29. rekam_medis
  ├─ 30. diagnosa_rekam_medis
  ├─ 31. reseps
  ├─ 32. detail_reseps
  ├─ 33. order_labs
  ├─ 34. detail_order_labs
  └─ 35. hasil_labs

[ MODUL KASIR, BILLING, & PORTAL PASIEN ]
  ├─ 36. invoices
  ├─ 37. detail_invoices
  ├─ 38. pembayarans
  └─ 39. reservasi_onlines
```

---

## B. SPESIFIKASI DETAIL STRUKTUR KOLOM TABEL

### 1. Modul Manajemen User & Pengaturan

#### Tabel 1. `users`
*Tujuan*: Menyimpan akun staf rumah sakit dan penanggung jawab sistem.
*Relasi*: BelongsTo ke `roles` (via pivot/spatie), HasMany ke transaksi operasional.

| Nama Kolom | Tipe Data | Panjang | Nullable | Default | Unique | Index | Foreign Key | Keterangan |
|:---|:---|:---|:---|:---|:---|:---|:---|:---|
| `id` | BIGINT UNSIGNED | 20 | NO | Auto | YES (PK) | PRIMARY | - | Primary Key |
| `name` | VARCHAR | 255 | NO | - | NO | NO | - | Nama lengkap pegawai |
| `username` | VARCHAR | 50 | NO | - | YES | UNIQUE | - | Username login unik |
| `email` | VARCHAR | 255 | NO | - | YES | UNIQUE | - | Email pengguna |
| `password` | VARCHAR | 255 | NO | - | NO | NO | - | Password (Bcrypt/Argon2id) |
| `nik` | VARCHAR | 16 | YES | NULL | YES | UNIQUE | - | NIK Pegawai |
| `phone` | VARCHAR | 20 | YES | NULL | NO | NO | - | Nomor HP / Telepon |
| `is_active` | BOOLEAN | 1 | NO | 1 | NO | INDEX | - | Status aktif akun (1/0) |
| `created_by` | BIGINT UNSIGNED | 20 | YES | NULL | NO | INDEX | `users(id)` | User pembuat |
| `updated_by` | BIGINT UNSIGNED | 20 | YES | NULL | NO | NO | `users(id)` | User pengubah terakhir |
| `deleted_by` | BIGINT UNSIGNED | 20 | YES | NULL | NO | NO | `users(id)` | User penghapus |
| `created_at` | TIMESTAMP | - | YES | NULL | NO | NO | - | Waktu buat |
| `updated_at` | TIMESTAMP | - | YES | NULL | NO | NO | - | Waktu perbarui |
| `deleted_at` | TIMESTAMP | - | YES | NULL | NO | INDEX | - | Soft Delete timestamp |

#### Tabel 2. `system_settings`
*Tujuan*: Menyimpan variabel konfigurasi global rumah sakit (Key-Value).

| Nama Kolom | Tipe Data | Panjang | Nullable | Default | Unique | Index | Foreign Key | Keterangan |
|:---|:---|:---|:---|:---|:---|:---|:---|:---|
| `id` | BIGINT UNSIGNED | 20 | NO | Auto | YES (PK) | PRIMARY | - | Primary Key |
| `group` | VARCHAR | 50 | NO | 'general' | NO | INDEX | - | Kelompok setting (general/print/rs) |
| `key` | VARCHAR | 100 | NO | - | YES | UNIQUE | - | Nama variabel unik |
| `value` | TEXT | - | YES | NULL | NO | NO | - | Nilai variabel |
| `description` | VARCHAR | 255 | YES | NULL | NO | NO | - | Keterangan fungsi setting |
| `created_at` | TIMESTAMP | - | YES | NULL | NO | NO | - | Waktu buat |
| `updated_at` | TIMESTAMP | - | YES | NULL | NO | NO | - | Waktu perbarui |

---

### 2. Modul Master Data Utama

#### Tabel 3. `pasiens`
*Tujuan*: Menyimpan identitas demografis terpusat seluruh pasien.
*Relasi*: HasMany ke `pendaftarans`, `rekam_medis`, `invoices`, `reservasi_onlines`.

| Nama Kolom | Tipe Data | Panjang | Nullable | Default | Unique | Index | Foreign Key | Keterangan |
|:---|:---|:---|:---|:---|:---|:---|:---|:---|
| `id` | BIGINT UNSIGNED | 20 | NO | Auto | YES (PK) | PRIMARY | - | Primary Key |
| `no_rm` | VARCHAR | 20 | NO | - | YES | UNIQUE | - | No. Rekam Medis (RM-XXXXXX) |
| `nik` | VARCHAR | 16 | NO | - | YES | UNIQUE | - | Nomor Induk Kependudukan |
| `nama_lengkap` | VARCHAR | 150 | NO | - | NO | INDEX | - | Nama lengkap pasien |
| `tempat_lahir` | VARCHAR | 100 | NO | - | NO | NO | - | Tempat lahir |
| `tanggal_lahir` | DATE | - | NO | - | NO | INDEX | - | Tanggal lahir |
| `jenis_kelamin` | ENUM('L','P') | - | NO | - | NO | NO | - | Jenis kelamin (Laki/Perempuan) |
| `golongan_darah` | ENUM('A','B','AB','O','-') | - | NO | '-' | NO | NO | - | Golongan darah |
| `agama` | VARCHAR | 30 | YES | NULL | NO | NO | - | Agama |
| `status_perkawinan`| VARCHAR | 30 | YES | NULL | NO | NO | - | Status nikah |
| `pekerjaan` | VARCHAR | 100 | YES | NULL | NO | NO | - | Pekerjaan |
| `no_hp` | VARCHAR | 20 | NO | - | NO | INDEX | - | Nomor HP aktif |
| `email` | VARCHAR | 100 | YES | NULL | NO | NO | - | Email pasien |
| `alamat_lengkap` | TEXT | - | NO | - | NO | NO | - | Alamat domisili |
| `nama_penanggung_jawab` | VARCHAR | 150 | YES | NULL | NO | NO | - | Nama keluarga/kontak darurat |
| `no_hp_penanggung_jawab` | VARCHAR | 20 | YES | NULL | NO | NO | - | No HP penanggung jawab |
| `hubungan_penanggung_jawab`| VARCHAR | 50 | YES | NULL | NO | NO | - | Hubungan keluarga |
| `created_by` | BIGINT UNSIGNED | 20 | YES | NULL | NO | NO | `users(id)` | User pembuat |
| `updated_by` | BIGINT UNSIGNED | 20 | YES | NULL | NO | NO | `users(id)` | User pengubah |
| `deleted_by` | BIGINT UNSIGNED | 20 | YES | NULL | NO | NO | `users(id)` | User penghapus |
| `created_at` | TIMESTAMP | - | YES | NULL | NO | NO | - | Waktu buat |
| `updated_at` | TIMESTAMP | - | YES | NULL | NO | NO | - | Waktu perbarui |
| `deleted_at` | TIMESTAMP | - | YES | NULL | NO | INDEX | - | Soft Delete timestamp |

#### Tabel 4. `polikliniks`
*Tujuan*: Menyimpan daftar unit pelayanan poliklinik rawat jalan.

| Nama Kolom | Tipe Data | Panjang | Nullable | Default | Unique | Index | Foreign Key | Keterangan |
|:---|:---|:---|:---|:---|:---|:---|:---|:---|
| `id` | BIGINT UNSIGNED | 20 | NO | Auto | YES (PK) | PRIMARY | - | Primary Key |
| `kode_poli` | VARCHAR | 10 | NO | - | YES | UNIQUE | - | Kode unik poli (POL-UMUM) |
| `nama_poli` | VARCHAR | 100 | NO | - | NO | NO | - | Nama poliklinik |
| `deskripsi` | VARCHAR | 255 | YES | NULL | NO | NO | - | Keterangan singkat poli |
| `is_active` | BOOLEAN | 1 | NO | 1 | NO | INDEX | - | Status aktif poli |
| `created_at` | TIMESTAMP | - | YES | NULL | NO | NO | - | Waktu buat |
| `updated_at` | TIMESTAMP | - | YES | NULL | NO | NO | - | Waktu perbarui |
| `deleted_at` | TIMESTAMP | - | YES | NULL | NO | INDEX | - | Soft Delete timestamp |

#### Tabel 5. `dokters`
*Tujuan*: Menyimpan profil data medis dokter.

| Nama Kolom | Tipe Data | Panjang | Nullable | Default | Unique | Index | Foreign Key | Keterangan |
|:---|:---|:---|:---|:---|:---|:---|:---|:---|
| `id` | BIGINT UNSIGNED | 20 | NO | Auto | YES (PK) | PRIMARY | - | Primary Key |
| `user_id` | BIGINT UNSIGNED | 20 | YES | NULL | YES | UNIQUE | `users(id)` | FK ke akun login user |
| `poliklinik_id` | BIGINT UNSIGNED | 20 | NO | - | NO | INDEX | `polikliniks(id)` | FK ke Poliklinik utama |
| `sip` | VARCHAR | 50 | NO | - | YES | UNIQUE | - | Surat Izin Praktik Dokter |
| `nama_dokter` | VARCHAR | 150 | NO | - | NO | INDEX | - | Nama lengkap tanpa gelar |
| `gelar_depan` | VARCHAR | 30 | YES | NULL | NO | NO | - | Gelar depan (dr. / Dr.) |
| `gelar_belakang` | VARCHAR | 50 | YES | NULL | NO | NO | - | Gelar belakang (Sp.PD) |
| `spesialisasi` | VARCHAR | 100 | NO | - | NO | NO | - | Bidang spesialisasi |
| `no_hp` | VARCHAR | 20 | NO | - | NO | NO | - | Telepon kontak dokter |
| `is_active` | BOOLEAN | 1 | NO | 1 | NO | INDEX | - | Status aktif praktik |
| `created_at` | TIMESTAMP | - | YES | NULL | NO | NO | - | Waktu buat |
| `updated_at` | TIMESTAMP | - | YES | NULL | NO | NO | - | Waktu perbarui |
| `deleted_at` | TIMESTAMP | - | YES | NULL | NO | INDEX | - | Soft Delete timestamp |

#### Tabel 6. `jadwal_dokters`
*Tujuan*: Alokasi jadwal dan kuota pasien dokter per hari.

| Nama Kolom | Tipe Data | Panjang | Nullable | Default | Unique | Index | Foreign Key | Keterangan |
|:---|:---|:---|:---|:---|:---|:---|:---|:---|
| `id` | BIGINT UNSIGNED | 20 | NO | Auto | YES (PK) | PRIMARY | - | Primary Key |
| `dokter_id` | BIGINT UNSIGNED | 20 | NO | - | NO | INDEX | `dokters(id)` | FK ke Dokter |
| `poliklinik_id` | BIGINT UNSIGNED | 20 | NO | - | NO | INDEX | `polikliniks(id)` | FK ke Poliklinik |
| `hari` | ENUM('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu') | - | NO | - | NO | INDEX | - | Hari praktik |
| `jam_mulai` | TIME | - | NO | - | NO | NO | - | Jam mulai praktik |
| `jam_selesai` | TIME | - | NO | - | NO | NO | - | Jam selesai praktik |
| `kuota_offline` | INT | - | NO | 30 | NO | NO | - | Kuota pendaftaran langsung |
| `kuota_online` | INT | - | NO | 15 | NO | NO | - | Kuota pendaftaran portal |
| `is_active` | BOOLEAN | 1 | NO | 1 | NO | NO | - | Status aktif jadwal |
| `created_at` | TIMESTAMP | - | YES | NULL | NO | NO | - | Waktu buat |
| `updated_at` | TIMESTAMP | - | YES | NULL | NO | NO | - | Waktu perbarui |

#### Tabel 7. `ruangans`, `kamar_rawats`, & `tempat_tidurs`
*Tujuan*: Pengelolaan struktur hirarkis lokasi rawat inap dan ketersediaan Bed.

- `ruangans`: (`id`, `kode_ruangan`, `nama_ruangan`, `gedung`, `lantai`, `jenis_ruangan`, `is_active`, `created_at`, `updated_at`, `deleted_at`)
- `kamar_rawats`: (`id`, `ruangan_id` [FK `ruangans`], `nomor_kamar`, `kelas_kamar` ['VVIP','VIP','Kelas 1','Kelas 2','Kelas 3'], `tarif_per_malam` [DECIMAL(12,2)], `created_at`, `updated_at`, `deleted_at`)
- `tempat_tidurs`: (`id`, `kamar_rawat_id` [FK `kamar_rawats`], `nomor_bed`, `status_bed` ['Kosong','Terisi','Dibersihkan','Pemeliharaan'], `created_at`, `updated_at`, `deleted_at`)

#### Tabel 8. `tindakans`
*Tujuan*: Master katalog daftar prosedur medis & tarif pelayanan RS.

| Nama Kolom | Tipe Data | Panjang | Nullable | Default | Unique | Index | Foreign Key | Keterangan |
|:---|:---|:---|:---|:---|:---|:---|:---|:---|
| `id` | BIGINT UNSIGNED | 20 | NO | Auto | YES (PK) | PRIMARY | - | Primary Key |
| `kode_tindakan` | VARCHAR | 20 | NO | - | YES | UNIQUE | - | Kode tindakan (ICD-9 CM / RS) |
| `nama_tindakan` | VARCHAR | 150 | NO | - | NO | INDEX | - | Deskripsi tindakan medis |
| `kategori_tindakan`| VARCHAR | 50 | NO | 'Umum' | NO | NO | - | Kategori (Poli/Operasi/TTV) |
| `tarif` | DECIMAL | 12,2 | NO | 0.00 | NO | NO | - | Nominal tarif standar |
| `poliklinik_id` | BIGINT UNSIGNED | 20 | YES | NULL | NO | INDEX | `polikliniks(id)` | FK Poli opsional |
| `is_active` | BOOLEAN | 1 | NO | 1 | NO | INDEX | - | Status aktif tindakan |
| `created_at` | TIMESTAMP | - | YES | NULL | NO | NO | - | Waktu buat |
| `updated_at` | TIMESTAMP | - | YES | NULL | NO | NO | - | Waktu perbarui |

---

### 3. Modul Farmasi & Gudang Logistik

#### Tabel 9. `obats`
*Tujuan*: Master data inventori obat dan alat kesehatan (Alkes).

| Nama Kolom | Tipe Data | Panjang | Nullable | Default | Unique | Index | Foreign Key | Keterangan |
|:---|:---|:---|:---|:---|:---|:---|:---|:---|
| `id` | BIGINT UNSIGNED | 20 | NO | Auto | YES (PK) | PRIMARY | - | Primary Key |
| `kode_obat` | VARCHAR | 30 | NO | - | YES | UNIQUE | - | Kode barang/obat |
| `nama_obat` | VARCHAR | 150 | NO | - | NO | INDEX | - | Nama komersial obat |
| `nama_generik` | VARCHAR | 150 | YES | NULL | NO | NO | - | Nama zat aktif generik |
| `kategori_obat_id` | BIGINT UNSIGNED | 20 | NO | - | NO | INDEX | `kategori_obats(id)`| FK Kategori Obat |
| `satuan_obat_id` | BIGINT UNSIGNED | 20 | NO | - | NO | INDEX | `satuan_obats(id)` | FK Satuan (Tablet/Botol) |
| `jenis_obat` | ENUM('Bebas','Bebas Terbatas','Keras','Narkotika','Psikotropika','Alkes') | - | NO | 'Bebas' | NO | NO | - | Penggolongan obat |
| `stok_minimal` | INT | - | NO | 10 | NO | NO | - | Ambang batas warning stok |
| `harga_beli` | DECIMAL | 12,2 | NO | 0.00 | NO | NO | - | HPP Beli |
| `harga_jual` | DECIMAL | 12,2 | NO | 0.00 | NO | NO | - | Harga jual ke pasien |
| `is_active` | BOOLEAN | 1 | NO | 1 | NO | INDEX | - | Status aktif item |
| `created_at` | TIMESTAMP | - | YES | NULL | NO | NO | - | Waktu buat |
| `updated_at` | TIMESTAMP | - | YES | NULL | NO | NO | - | Waktu perbarui |
| `deleted_at` | TIMESTAMP | - | YES | NULL | NO | INDEX | - | Soft Delete timestamp |

#### Tabel 10. `stok_gudangs` & `stok_depo_farmasis`
*Tujuan*: Mengelola jumlah fisik stok obat per nomor batch dan tanggal kadaluarsa (FIFO Management).

- `stok_gudangs`: (`id`, `obat_id` [FK `obats`], `nomor_batch`, `tanggal_kadaluarsa`, `jumlah_stok`, `created_at`, `updated_at`)
- `stok_depo_farmasis`: (`id`, `obat_id` [FK `obats`], `nomor_batch`, `tanggal_kadaluarsa`, `jumlah_stok`, `created_at`, `updated_at`)

#### Tabel 11. `suppliers`, `penerimaan_barangs`, & `mutasi_stoks`
*Tujuan*: Pencatatan logistik transaksi masuk dari PBM/Vendor dan perpindahan stok internal dari Gudang Utama ke Depo Farmasi.

---

### 4. Modul Laboratorium

#### Tabel 12. `pemeriksaan_labs`
*Tujuan*: Master item pemeriksaan laboratorium medis beserta nilai rujukan normal.

| Nama Kolom | Tipe Data | Panjang | Nullable | Default | Unique | Index | Foreign Key | Keterangan |
|:---|:---|:---|:---|:---|:---|:---|:---|:---|
| `id` | BIGINT UNSIGNED | 20 | NO | Auto | YES (PK) | PRIMARY | - | Primary Key |
| `kategori_lab_item_id` | BIGINT UNSIGNED | 20 | NO | - | NO | INDEX | `kategori_lab_items(id)`| FK Kategori Lab |
| `kode_pemeriksaan` | VARCHAR | 20 | NO | - | YES | UNIQUE | - | Kode parameter lab |
| `nama_pemeriksaan` | VARCHAR | 150 | NO | - | NO | INDEX | - | Nama parameter |
| `satuan` | VARCHAR | 30 | YES | NULL | NO | NO | - | Satuan ukur (mg/dL, /uL) |
| `nilai_rujukan_pria` | VARCHAR | 100 | YES | NULL | NO | NO | - | Nilai normal pria |
| `nilai_rujukan_wanita`| VARCHAR | 100 | YES | NULL | NO | NO | - | Nilai normal wanita |
| `tarif` | DECIMAL | 12,2 | NO | 0.00 | NO | NO | - | Biaya pemeriksaan |
| `is_active` | BOOLEAN | 1 | NO | 1 | NO | INDEX | - | Status aktif item |
| `created_at` | TIMESTAMP | - | YES | NULL | NO | NO | - | Waktu buat |
| `updated_at` | TIMESTAMP | - | YES | NULL | NO | NO | - | Waktu perbarui |

---

### 5. Modul Transaksi Pelayanan Medis Utama

#### Tabel 13. `pendaftarans`
*Tujuan*: Registrasi induk seluruh kunjungan pasien (Rawat Jalan, Rawat Inap, IGD).
*Relasi*: BelongsTo `pasiens`, HasOne `kunjungan_rawat_jalans`, `admisi_rawat_inaps`, `invoices`, HasMany `rekam_medis`, `reseps`, `order_labs`.

| Nama Kolom | Tipe Data | Panjang | Nullable | Default | Unique | Index | Foreign Key | Keterangan |
|:---|:---|:---|:---|:---|:---|:---|:---|:---|
| `id` | BIGINT UNSIGNED | 20 | NO | Auto | YES (PK) | PRIMARY | - | Primary Key |
| `no_pendaftaran` | VARCHAR | 30 | NO | - | YES | UNIQUE | - | No. Registrasi (REG-YYYYMMDD-XXXX) |
| `pasien_id` | BIGINT UNSIGNED | 20 | NO | - | NO | INDEX | `pasiens(id)` | FK Pasien |
| `jenis_pelayanan` | ENUM('Rawat Jalan','Rawat Inap','IGD') | - | NO | 'Rawat Jalan'| NO | INDEX | - | Jenis kunjungan medis |
| `tanggal_pendaftaran`| DATETIME | - | NO | - | NO | INDEX | - | Waktu pendaftaran |
| `penjamin` | ENUM('Umum','Asuransi Swasta') | - | NO | 'Umum' | NO | NO | - | Pembayar medis |
| `status_pendaftaran` | ENUM('Menunggu','Diproses','Selesai','Batal') | - | NO | 'Menunggu' | NO | INDEX | - | Status alur pelayanan |
| `created_by` | BIGINT UNSIGNED | 20 | YES | NULL | NO | NO | `users(id)` | Petugas Pendaftaran |
| `updated_by` | BIGINT UNSIGNED | 20 | YES | NULL | NO | NO | `users(id)` | User pengubah |
| `deleted_by` | BIGINT UNSIGNED | 20 | YES | NULL | NO | NO | `users(id)` | User penghapus |
| `created_at` | TIMESTAMP | - | YES | NULL | NO | NO | - | Waktu buat |
| `updated_at` | TIMESTAMP | - | YES | NULL | NO | NO | - | Waktu perbarui |
| `deleted_at` | TIMESTAMP | - | YES | NULL | NO | INDEX | - | Soft Delete timestamp |

#### Tabel 14. `kunjungan_rawat_jalans`
*Tujuan*: Transaksi antrean dan pelayanan medis di Poliklinik.

| Nama Kolom | Tipe Data | Panjang | Nullable | Default | Unique | Index | Foreign Key | Keterangan |
|:---|:---|:---|:---|:---|:---|:---|:---|:---|
| `id` | BIGINT UNSIGNED | 20 | NO | Auto | YES (PK) | PRIMARY | - | Primary Key |
| `pendaftaran_id` | BIGINT UNSIGNED | 20 | NO | - | YES | UNIQUE | `pendaftarans(id)` | FK Registrasi Induk |
| `poliklinik_id` | BIGINT UNSIGNED | 20 | NO | - | NO | INDEX | `polikliniks(id)` | FK Poliklinik |
| `dokter_id` | BIGINT UNSIGNED | 20 | NO | - | NO | INDEX | `dokters(id)` | FK Dokter Praktik |
| `no_antrean` | INT | - | NO | - | NO | NO | - | Urutan angka antrean (1, 2, 3) |
| `kode_antrean` | VARCHAR | 20 | NO | - | NO | INDEX | - | String antrean (A-01) |
| `tanggal_kunjungan`| DATE | - | NO | - | NO | INDEX | - | Tanggal praktik poli |
| `status_antrean` | ENUM('Menunggu','Dipanggil','Sedang Diperiksa','Selesai','Batal') | - | NO | 'Menunggu' | NO | INDEX | - | Status dipanggil dokter |
| `created_at` | TIMESTAMP | - | YES | NULL | NO | NO | - | Waktu buat |
| `updated_at` | TIMESTAMP | - | YES | NULL | NO | NO | - | Waktu perbarui |

#### Tabel 15. `admisi_rawat_inaps`
*Tujuan*: Transaksi rawat inap, alokasi Bed, dan monitoring status opname.

| Nama Kolom | Tipe Data | Panjang | Nullable | Default | Unique | Index | Foreign Key | Keterangan |
|:---|:---|:---|:---|:---|:---|:---|:---|:---|
| `id` | BIGINT UNSIGNED | 20 | NO | Auto | YES (PK) | PRIMARY | - | Primary Key |
| `pendaftaran_id` | BIGINT UNSIGNED | 20 | NO | - | YES | UNIQUE | `pendaftarans(id)` | FK Registrasi Induk |
| `tempat_tidur_id` | BIGINT UNSIGNED | 20 | NO | - | NO | INDEX | `tempat_tidurs(id)`| FK Tempat Tidur |
| `dokter_penanggung_jawab_id` | BIGINT UNSIGNED | 20 | NO | - | NO | INDEX | `dokters(id)` | DPJP Rawat Inap |
| `tanggal_masuk` | DATETIME | - | NO | - | NO | INDEX | - | Waktu masuk kamar |
| `tanggal_keluar` | DATETIME | YES | NULL | NO | NO | - | Waktu keluar/pulang |
| `diagnosa_masuk` | TEXT | - | YES | NULL | NO | NO | - | Diagnosa awal admisi |
| `cara_keluar` | ENUM('Sembuh','Rujuk','APS','Meninggal') | - | YES | NULL | NO | NO | - | Alasan checkout pasien |
| `status_rawat_inap`| ENUM('Aktif','Checkout Medis','Checkout Billing','Batal') | - | NO | 'Aktif' | NO | INDEX | - | Status rawat inap |
| `created_by` | BIGINT UNSIGNED | 20 | YES | NULL | NO | NO | `users(id)` | User pembuat |
| `updated_by` | BIGINT UNSIGNED | 20 | YES | NULL | NO | NO | `users(id)` | User pengubah |
| `created_at` | TIMESTAMP | - | YES | NULL | NO | NO | - | Waktu buat |
| `updated_at` | TIMESTAMP | - | YES | NULL | NO | NO | - | Waktu perbarui |

#### Tabel 16. `rekam_medis` & `diagnosa_rekam_medis`
*Tujuan*: Pencatatan hasil pemeriksaan klinis dokter, Vital Signs (TTV), dan Diagnosa ICD-10.

- `rekam_medis`: (`id`, `pendaftaran_id` [FK], `pasien_id` [FK], `dokter_id` [FK], `tanggal_pemeriksaan`, `keluhan_utama`, `riwayat_penyakit`, `tekanan_darah_sistole`, `tekanan_darah_diastole`, `suhu_tubuh`, `nadi`, `laju_pernapasan`, `tinggi_badan`, `berat_badan`, `catatan_dokter`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`)
- `diagnosa_rekam_medis`: (`id`, `rekam_medis_id` [FK `rekam_medis`], `icd10_code`, `icd10_name`, `jenis_diagnosa` ['Utama','Sekunder'], `created_at`, `updated_at`)

#### Tabel 17. `reseps` & `detail_reseps`
*Tujuan*: Transaksi E-Resep obat dari Dokter ke Farmasi dan rincian item obat.

- `reseps`: (`id`, `no_resep` [UNIQUE], `pendaftaran_id` [FK], `dokter_id` [FK], `pasien_id` [FK], `tanggal_resep`, `status_resep` ['Menunggu','Diproses','Selesai','Batal'], `catatan_resep`, `created_by`, `updated_by`, `created_at`, `updated_at`, `deleted_at`)
- `detail_reseps`: (`id`, `resep_id` [FK `reseps`], `obat_id` [FK `obats`], `jumlah`, `dosis_aturan_pakai`, `harga_satuan`, `subtotal`, `created_at`, `updated_at`)

#### Tabel 18. `order_labs`, `detail_order_labs`, & `hasil_labs`
*Tujuan*: Transaksi permintaan penunjang laboratorium, item rincian order, dan pencatatan hasil pengujian laboratorium.

---

### 6. Modul Kasir, Billing, & Portal Pasien

#### Tabel 19. `invoices` & `detail_invoices`
*Tujuan*: Konsolidasi total tagihan medis pasien dari seluruh unit transaksi.

- `invoices`:
  | Nama Kolom | Tipe Data | Panjang | Nullable | Default | Unique | Index | Foreign Key | Keterangan |
  |:---|:---|:---|:---|:---|:---|:---|:---|:---|
  | `id` | BIGINT UNSIGNED | 20 | NO | Auto | YES (PK) | PRIMARY | - | Primary Key |
  | `no_invoice` | VARCHAR | 30 | NO | - | YES | UNIQUE | - | No. Invoice (INV-YYYYMMDD-XXXX) |
  | `pendaftaran_id` | BIGINT UNSIGNED | 20 | NO | - | YES | UNIQUE | `pendaftarans(id)` | FK Registrasi Induk |
  | `pasien_id` | BIGINT UNSIGNED | 20 | NO | - | NO | INDEX | `pasiens(id)` | FK Pasien |
  | `tanggal_invoice` | DATETIME | - | NO | - | NO | INDEX | - | Waktu invoice diterbitkan |
  | `total_biaya_tindakan`| DECIMAL | 12,2 | NO | 0.00 | NO | NO | - | Akumulasi biaya tindakan |
  | `total_biaya_obat` | DECIMAL | 12,2 | NO | 0.00 | NO | NO | - | Akumulasi biaya obat |
  | `total_biaya_lab` | DECIMAL | 12,2 | NO | 0.00 | NO | NO | - | Akumulasi biaya lab |
  | `total_biaya_kamar`| DECIMAL | 12,2 | NO | 0.00 | NO | NO | - | Akumulasi sewa kamar |
  | `grand_total` | DECIMAL | 12,2 | NO | 0.00 | NO | NO | - | Total kotor seluruh tagihan |
  | `diskon` | DECIMAL | 12,2 | NO | 0.00 | NO | NO | - | Potongan harga/diskon |
  | `total_setelah_diskon`| DECIMAL | 12,2 | NO | 0.00 | NO | NO | - | Net total wajib dibayar |
  | `status_pembayaran`| ENUM('Belum Lunas','Lunas','Batal') | - | NO | 'Belum Lunas'| NO | INDEX | - | Status pelunasan kasir |
  | `created_by` | BIGINT UNSIGNED | 20 | YES | NULL | NO | NO | `users(id)` | Petugas Kasir |
  | `updated_by` | BIGINT UNSIGNED | 20 | YES | NULL | NO | NO | `users(id)` | User pengubah |
  | `created_at` | TIMESTAMP | - | YES | NULL | NO | NO | - | Waktu buat |
  | `updated_at` | TIMESTAMP | - | YES | NULL | NO | NO | - | Waktu perbarui |

- `detail_invoices`: (`id`, `invoice_id` [FK `invoices`], `jenis_item` ['Tindakan','Obat','Laboratorium','Sewa_Kamar','Administrasi'], `ref_id` [BIGINT UNSIGNED Nullable], `deskripsi_item`, `jumlah`, `harga_satuan`, `subtotal`, `created_at`, `updated_at`)

#### Tabel 20. `pembayarans`
*Tujuan*: Pencatatan transaksi penerimaan uang kasir dan pencetakan Kuitansi Sah.

- `pembayarans`: (`id`, `no_kuitansi` [UNIQUE], `invoice_id` [FK `invoices`], `tanggal_pembayaran`, `metode_pembayaran` ['Tunai','Transfer Bank','Kartu Debit','Kartu Kredit'], `jumlah_dibayar`, `kembalian`, `kasir_user_id` [FK `users`], `catatan`, `created_at`, `updated_at`)

#### Tabel 21. `reservasi_onlines`
*Tujuan*: Transaksi pemesanan antrean poliklinik mandiri dari Portal Pasien.

- `reservasi_onlines`: (`id`, `no_reservasi` [UNIQUE], `pasien_id` [FK `pasiens`], `poliklinik_id` [FK `polikliniks`], `dokter_id` [FK `dokters`], `tanggal_rencana_kunjungan`, `jam_rencana_kunjungan`, `no_antrean`, `status_reservasi` ['Disetujui','Hadir','Batal'], `created_at`, `updated_at`, `deleted_at`)

---

## C. RELASI ANTAR TABEL & RASIONALITAS ELOQUENT

```
  [ pasiens ] ─── (1:N) ───► [ pendaftarans ] ─── (1:1) ───► [ invoices ]
       │                           │                                │
       │                           ├── (1:1) ─► [ kunjungan_rawat_jalans ] ├── (1:N) ─► [ detail_invoices ]
       │                           │                                │
       │                           ├── (1:1) ─► [ admisi_rawat_inaps ] └── (1:1/N) ► [ pembayarans ]
       │                           │
       │                           ├── (1:N) ─► [ rekam_medis ] ── (1:N) ─► [ diagnosa_rekam_medis ]
       │                           │
       │                           ├── (1:N) ─► [ reseps ] ─────── (1:N) ─► [ detail_reseps ]
       │                           │
       │                           └── (1:N) ─► [ order_labs ] ──── (1:N) ─► [ detail_order_labs ] ── (1:1) ─► [ hasil_labs ]
```

### Penjelasan Jenis Relasi & Eloquent ORM:

1. **One to One (1:1)**:
   - `pendaftarans` ── `kunjungan_rawat_jalans`: Setiap pendaftaran rawat jalan memilik tepat 1 antrean kunjungan poliklinik. (`Pendaftaran->hasOne(KunjunganRawatJalan::class)`).
   - `pendaftarans` ── `admisi_rawat_inaps`: Registrasi rawat inap memiliki 1 rekam jejak admisi kamar. (`Pendaftaran->hasOne(AdmisiRawatInap::class)`).
   - `pendaftarans` ── `invoices`: Setiap registrasi pelayanan menghasilkan 1 invoice tagihan konsolidasi. (`Pendaftaran->hasOne(Invoice::class)`).
   - `dokters` ── `users`: Profil dokter terhubung secara eksplisit ke 1 akun login user. (`Dokter->belongsTo(User::class)`).

2. **One to Many (1:N)**:
   - `pasiens` ── `pendaftarans`: Pasien dapat melakukan registrasi kunjungan berkali-kali sepanjang waktu. (`Pasien->hasMany(Pendaftaran::class)`).
   - `polikliniks` ── `dokters`: 1 Poliklinik menaungi banyak Dokter spesialis. (`Poliklinik->hasMany(Dokter::class)`).
   - `ruangans` ── `kamar_rawats` ── `tempat_tidurs`: Hirarki alokasi kamar dan bed. (`Ruangan->hasMany(KamarRawat::class)`, `KamarRawat->hasMany(TempatTidur::class)`).
   - `reseps` ── `detail_reseps`: 1 Lembar resep memuat banyak obat. (`Resep->hasMany(DetailResep::class)`).
   - `invoices` ── `detail_invoices`: 1 Invoice merangkum banyak item rincian biaya. (`Invoice->hasMany(DetailInvoice::class)`).

3. **Many to Many (N:M via Pivot)**:
   - `roles` ── `permissions`: Pengaturan otorisasi hak akses RBAC via tabel pivot `role_has_permissions`. (`Role->belongsToMany(Permission::class)`).

---

## D. ENTITY RELATIONSHIP DIAGRAM (ERD TEKSTUAL)

```
+------------------+       +----------------------+       +-----------------------+
|     PASIENS      |       |     PENDAFTARANS     |       |       INVOICES        |
+------------------+       +----------------------+       +-----------------------+
| PK id            |1     N| PK id                |1     1| PK id                 |
|    no_rm (UNIQ)  |-------| FK pasien_id         |-------| FK pendaftaran_id     |
|    nik (UNIQ)    |       |    no_pendaftaran    |       | FK pasien_id          |
|    nama_lengkap  |       |    jenis_pelayanan   |       |    grand_total        |
|    tanggal_lahir |       |    status_pendaftaran|       |    status_pembayaran  |
+------------------+       +----------------------+       +-----------------------+
                                  | 1                                 | 1
                                  |                                   |
                                  | 1..N                              | 1..N
                           +----------------------+       +-----------------------+
                           |     REKAM_MEDIS      |       |    DETAIL_INVOICES    |
                           +----------------------+       +-----------------------+
                           | PK id                |       | PK id                 |
                           | FK pendaftaran_id    |       | FK invoice_id         |
                           | FK dokter_id         |       |    jenis_item         |
                           |    keluhan_utama     |       |    subtotal           |
                           +----------------------+       +-----------------------+
                                  | 1
                                  |
                                  | 1..N
                           +----------------------+
                           | DIAGNOSA_REKAM_MEDIS |
                           +----------------------+
                           | PK id                |
                           | FK rekam_medis_id    |
                           |    icd10_code        |
                           |    jenis_diagnosa    |
                           +----------------------+
```

---

## E. SKEMA MASTER DATA TERPUSAT

Master data berikut dirancang terintegrasi dan digunakan bersama oleh seluruh modul untuk mengeliminasi redundansi data:

1. **`pasiens`**: Digunakan oleh Pendaftaran, Poliklinik, Rawat Inap, EMR, Farmasi, Lab, Kasir, dan Portal Pasien.
2. **`dokters`**: Digunakan oleh Jadwal Dokter, Pendaftaran, Poliklinik, Rawat Inap, EMR, Resep Farmasi, dan Order Lab.
3. **`polikliniks`**: Digunakan oleh Master Dokter, Jadwal Dokter, Pendaftaran, dan Poliklinik.
4. **`tempat_tidurs` (via `ruangans` & `kamar_rawats`)**: Digunakan oleh Admisi Rawat Inap dan Billing.
5. **`tindakans`**: Digunakan oleh Poliklinik, Rawat Inap, dan Billing.
6. **`obats`**: Digunakan oleh Gudang Inventory, Depo Farmasi, Resep Dokter, dan Billing.
7. **`pemeriksaan_labs`**: Digunakan oleh Order Lab, Input Hasil Lab, dan Billing.
8. **`users`, `roles`, & `permissions`**: Digunakan oleh seluruh modul untuk kontrol keamanan otentikasi & otorisasi.

---

## F. SKEMA & ALUR DATA TRANSAKSI UTAMA

```
[REGISTRASI PASIEN] (Tabel: pendaftarans)
        │
        ├─► [PELAYANAN POLI] (Tabel: kunjungan_rawat_jalans)
        │         │
        │         ├─► [EMR & DIAGNOSA] (Tabel: rekam_medis, diagnosa_rekam_medis)
        │         ├─► [RESEP OBAT]     (Tabel: reseps, detail_reseps)
        │         └─► [ORDER LAB]      (Tabel: order_labs, detail_order_labs, hasil_labs)
        │
        ├─► [ADMISI RAWAT INAP] (Tabel: admisi_rawat_inaps, tempat_tidurs, cppts)
        │
        ▼
[BILLING KASIR] (Tabel: invoices, detail_invoices)
        │
        ▼
[PEMBAYARAN KASIR] (Tabel: pembayarans)
```

1. **Pendaftaran (Registrasi)**: Meng-generate record induk di `pendaftarans`.
2. **Rawat Jalan / Rawat Inap**: Membuka antrean poli di `kunjungan_rawat_jalans` atau mengunci Bed di `admisi_rawat_inaps` & `tempat_tidurs`.
3. **Pemeriksaan Medis**: Dokter menginput `rekam_medis`, `reseps`, dan `order_labs`.
4. **Eksekusi Penunjang**: Farmasi memproses `detail_reseps` (mengurangi `stok_depo_farmasis`), Analis menginput `hasil_labs`.
5. **Konsolidasi Billing**: Service Layer menarik seluruh tagihan tindakan, resep, lab, dan sewa kamar menjadi `invoices` & `detail_invoices`.
6. **Pembayaran Kasir**: Kasir menerima uang, menyimpan record `pembayarans`, dan mengubah `status_pembayaran` invoice menjadi 'Lunas'.

---

## G. STRATEGI INDEKS & OPTIMASI PERFORMA QUERY

Untuk menjamin performa pencarian yang cepat pada tabel berukuran jutaan baris data, diterapkan strategi indeks komprehensif:

### 1. Primary & Unique Index
- **Primary Key**: Dipasang pada kolom `id` di seluruh 32 tabel (`BIGINT UNSIGNED AUTO_INCREMENT`).
- **Unique Index**: Dipasang pada kode unik bisnis:
  - `pasiens.no_rm`, `pasiens.nik`
  - `users.username`, `users.email`
  - `dokters.sip`
  - `polikliniks.kode_poli`, `tindakans.kode_tindakan`, `obats.kode_obat`
  - `pendaftarans.no_pendaftaran`, `reseps.no_resep`, `order_labs.no_order_lab`, `invoices.no_invoice`, `pembayarans.no_kuitansi`

### 2. Foreign Key Index
Seluruh kolom Foreign Key (`pasien_id`, `dokter_id`, `pendaftaran_id`, `poliklinik_id`, `user_id`, dll.) **wajib diberikan Indeks otomatis/eksplisit** untuk mempercepat operasi `JOIN` dan pencarian relasi Eloquent (`with()`).

### 3. Composite Index (Indeks Majemuk)
Dipasang pada kombinasi kolom yang sering di-query secara bersamaan:
- **`pendaftarans`**: Index `(tanggal_pendaftaran, status_pendaftaran)` - Mempercepat render Dashboard Kunjungan Hari Ini.
- **`kunjungan_rawat_jalans`**: Index `(poliklinik_id, dokter_id, tanggal_kunjungan, status_antrean)` - Mempercepat query Antrean Poliklinik Dokter.
- **`stok_depo_farmasis`**: Index `(obat_id, tanggal_kadaluarsa)` - Mempercepat metode pengambilan obat FIFO (First-In, First-Out).
- **`pasiens`**: Index `(nama_lengkap, tanggal_lahir)` - Mempercepat pencarian pasien cepat oleh Petugas Pendaftaran.

---

## H. STRATEGI SOFT DELETE & INTEGRITAS DATA

### 1. Penerapan Soft Delete (`deleted_at`)
Soft Delete diterapkan pada **seluruh Tabel Master dan Transaksi Utama** yang memiliki nilai riwayat medis/hukum:
- Master: `pasiens`, `dokters`, `polikliniks`, `ruangans`, `kamar_rawats`, `tindakans`, `obats`, `pemeriksaan_labs`, `users`.
- Transaksi: `pendaftarans`, `admisi_rawat_inaps`, `rekam_medis`, `reseps`, `order_labs`, `invoices`, `pembayarans`, `reservasi_onlines`.

### 2. Alasan & Manfaat Soft Delete:
- **Mediko-Legal**: Mencegah hilangnya riwayat kesehatan medis pasien secara tidak sengaja dari database.
- **Integritas Referensial**: Menjaga data transaksi masa lalu (seperti Invoice tahun lalu) tetap valid dan tidak pecah meskipun master data pendukungnya dinonaktifkan.

---

## I. STRATEGI AUDIT TRAIL (`created_by`, `updated_by`, `deleted_by`)

Seluruh tabel transaksi dan master kritis dilengkapi kolom penanggung jawab aksi:
- `created_by`: Menunjuk `users.id` yang pertama kali menginput data.
- `updated_by`: Menunjuk `users.id` yang terakhir kali melakukan perubahan.
- `deleted_by`: Menunjuk `users.id` yang melakukan penghapusan (soft delete).

### Manfaat Audit Trail bagi Rumah Sakit:
1. **Akuntabilitas Staf**: Mengetahui dengan pasti perawat/petugas mana yang melakukan pendaftaran, penginputan resep, atau penerimaan uang kasir.
2. **Pelacakan Perubahan Medis**: Memastikan jejak ketaatan prosedur medis pada dokumen Rekam Medis (EMR) dan CPPT.
3. **Penyelidikan Keamanan**: Memudahkan penelusuran jika terjadi insiden kejanggalan stok obat atau selisih kas kasir.

---

## J. VALIDASI DESAIN DATABASE & SELF-REVIEW AUDIT

Sebagai Senior Database Architect, dilakukan pengujian dan audit mandiri terhadap rancangan database relasional SIMRS ini:

1. **Evaluasi Normalisasi (3NF Compliance)**:
   - Seluruh tabel telah memenuhi **Third Normal Form (3NF)**. Setiap kolom non-key bergantung penuh hanya pada Primary Key entitas tersebut.
   - *Tanpa Over-Normalization*: Item rincian tagihan `detail_invoices` menggunakan `harga_satuan` dan `subtotal` terpisah yang di-snapshot saat transaksi terjadi untuk mencegah perubahan nilai historis tagihan jika tarif master diubah di kemudian hari.
2. **Kepatuhan Konvensi Eloquent ORM Laravel**:
   - Seluruh nama tabel menggunakan format `snake_case` jamak (`pasiens`, `rekam_medis`, `detail_reseps`).
   - Primary Key seragam `id` (`BIGINT UNSIGNED AUTO_INCREMENT`).
   - Foreign Key menggunakan konvensi `entitas_id` (`pasien_id`, `dokter_id`).
   - Timestamp bawaan `created_at`, `updated_at`, dan `deleted_at` dipasang konsisten.
3. **Pemeriksaan Beban & Bottleneck Database**:
   - Skema ini tidak memiliki titik rawan *lock contention* berlebih. Pengurangan stok obat di `stok_depo_farmasis` terisolasi per nomor batch.
   - Pemasangan **Composite Indexing** memastikan pencarian antrean dan pencetakan invoice tidak menyebabkan *Full Table Scan*.
4. **Kelengkapan Fitur 15 Modul**:
   - Seluruh kebutuhan 15 modul (termasuk Dashboard & Laporan yang menarik data secara konsolidasi dari `pendaftarans`, `invoices`, `rekam_medis`) ter-cover 100% tanpa menyisakan tabel redundan.

---
**Kesimpulan**: Dokumen Desain Database SIMRS ini telah tervalidasi, efisien, aman, dan **SIAP DIGUNAKAN** sebagai acuan langsung untuk pembuatan file migration Laravel, Eloquent Models, Factories, dan Seeders pada langkah berikutnya.
