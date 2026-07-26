# Alur Pelayanan Pasien (Workflow End-to-End)

Dokumen ini memetakan alur bisnis operasional terintegrasi pasien dari pendaftaran hingga penyelesaian billing pada **SIMRS Enterprise**.

---

## 🔄 Diagram Alur Pelayanan Pasien (Mermaid)

```mermaid
sequenceDiagram
    autonumber
    actor P as Pasien / Keluarga
    participant R as Pendaftaran & Antrean
    participant N as Perawat Poliklinik
    participant D as Dokter DPJP (EMR)
    participant F as Farmasi (Apotek)
    participant L as Laboratorium (LIS)
    participant B as Kasir Billing

    P->>R: Datang & Mendaftar (Pilih Poli & Dokter)
    R->>N: Pasien Masuk Antrean Poli (Reg & Queue Generated)
    N->>N: Perawat Catat Vital Signs (TTV)
    N->>D: Pasien Dipanggil ke Ruang Periksa
    D->>D: Dokter Input EMR SOAP & Diagnosa ICD-10
    alt Jika Perlu Obat
        D->>F: Terbitkan E-Resep Obat
        F->>F: Validasi & Dispensing (Auto-Deduct Stok)
    end
    alt Jika Perlu Test Lab
        D->>L: Order Pemeriksaan Lab
        L->>L: Ambil Sampel & Input Hasil Lab ke EMR
    end
    D->>B: Kunjungan Selesai (Tagihan Terkonsolidasi)
    P->>B: Pelunasan Pembayaran di Kasir
    B->>P: Kuitansi Resmi Diterbitkan & Pasien Pulang
```

---

## 📌 Penjelasan Rincian 7 Tahap Alur

1. **Tahap 1: Pendaftaran & Antrean**: Generasi nomor registrasi (`REG-`) dan tiket antrean.
2. **Tahap 2: Vital Signs (TTV)**: Perawat mencatat Tensi, Suhu, Nadi, Respirasi, TB, BB, SpO2.
3. **Tahap 3: Pemeriksaan Dokter & EMR**: Dokter mengisi SOAP, menentukan kode ICD-10, dan membuat order penunjang.
4. **Tahap 4: Penyiapan & Dispensing Obat**: Apoteker memproses E-Resep, memverifikasi stok obat, dan menyerahkan obat.
5. **Tahap 5: Pengujian Laboratorium**: Analis mengambil sampel, menguji, dan memasukkan hasil lab langsung ke EMR pasien.
6. **Tahap 6: Konsolidasi Tagihan (Billing)**: Sistem menghitung total otomatis (Registrasi + Dokter + Obat + Lab).
7. **Tahap 7: Pelunasan Kasir & Kuitansi**: Kasir menerima pembayaran dan mencetak kuitansi resmi A4.
