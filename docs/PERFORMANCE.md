# Panduan Optimasi Performa & Query Engine

Dokumen ini menjelaskan strategi optimasi performa frontend dan backend pada **SIMRS Enterprise**.

---

## ⚡ Strategi Optimasi Performa

1. **Eliminasi N+1 Query (Eager Loading)**:
   - Seluruh Controller & Service wajib memuat relasi terkait menggunakan method `with(...)` (Contoh: `Registration::with(['patient', 'doctor', 'queue'])->latest()->paginate(15)`).
2. **Indexing Database**:
   - Seluruh foreign key dan kolom kriteria pencarian (`mr_number`, `registration_date`, `status`, `invoice_number`, `code`) telah dilengkapi dengan indeks komposit MySQL.
3. **Asset Bundling dengan Vite & Tailwind CSS 4**:
   - Penggunaan Vite memproduksi aset CSS dan JS yang telah terkompresi (minified), meminimalkan ukuran download browser.
4. **Server-Side CSV Export (Chunking & Streaming)**:
   - Fitur ekspor laporan menggunakan mekanisme `cursor()` dan UTF-8 BOM streaming agar tidak memicu kehabisan memori (Out of Memory) pada dataset puluhan ribu baris.
