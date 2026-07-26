# Matriks Peran & Hak Akses (Role & Permission Matrix)

Dokumen ini menjelaskan matriks wewenang hak akses berbasis **Spatie Laravel-Permission** pada **SIMRS Enterprise**.

---

## 📊 Matriks Hak Akses Modul per Role

| Modul SIMRS | Super Admin | Dokter | Perawat | Apoteker | Analis Lab | Kasir | Gudang | Direktur RS |
|---|:---:|:---:|:---:|:---:|:---:|:---:|:---:|:---:|
| **Dashboard Executive** | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ | ✅ |
| **Pendaftaran Pasien** | ✅ | ❌ | ✅ | ❌ | ❌ | ❌ | ❌ | 👁 View |
| **Poliklinik Rawat Jalan** | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | 👁 View |
| **Rawat Inap & Bed** | ✅ | ✅ | ✅ | ❌ | ❌ | ❌ | ❌ | 👁 View |
| **EMR Rekam Medis** | ✅ | ✅ | 👁 View | 👁 View | 👁 View | ❌ | ❌ | 👁 View |
| **Farmasi & E-Resep** | ✅ | ✍ Order | ❌ | ✅ | ❌ | ❌ | ❌ | 👁 View |
| **Laboratorium (LIS)** | ✅ | ✍ Order | ❌ | ❌ | ✅ | ❌ | ❌ | 👁 View |
| **Kasir & Billing** | ✅ | ❌ | ❌ | ❌ | ❌ | ✅ | ❌ | 👁 View |
| **Gudang Logistik** | ✅ | ❌ | ❌ | ✍ Permintaan | ❌ | ❌ | ✅ | 👁 View |
| **User & Audit Trail** | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | 👁 View |
| **Laporan & BI** | ✅ | 👁 View | 👁 View | 👁 View | 👁 View | 👁 View | 👁 View | ✅ |
| **Pengaturan RS** | ✅ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ | ❌ |

---

*Keterangan*:
- `✅`: Akses Penuh (Create, Read, Update, Delete)
- `👁 View`: Akses Lihat / Read-only
- `✍ Order / Permintaan`: Akses Membuat Order / Permintaan khusus
- `❌`: Akses Ditolak (Access Denied)
