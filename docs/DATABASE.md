# Spesifikasi Database & Struktur Tabel SIMRS Enterprise

Dokumen ini berisi rincian spesifikasi 32+ tabel database MySQL pada proyek **SIMRS Enterprise**.

---

## 🗄️ Daftar Tabel Utama & Fungsi

| Nama Tabel | Fungsi Utama | Keterangan Foreign Key |
|---|---|---|
| `users` | Akun pengguna sistem (Dokter, Perawat, Kasir, Admin) | - |
| `roles` & `permissions` | Peran dan wewenang hak akses (Spatie RBAC) | - |
| `model_has_roles` | Pivot penugasan role ke user | `user_id`, `role_id` |
| `patients` | Master data demografi pasien | `mr_number` (Unique) |
| `departments` | Master poliklinik & instalasi medis | - |
| `doctors` | Master dokter DPJP & spesialisasi | `department_id`, `user_id` |
| `rooms` & `beds` | Master ruangan rawat inap & tempat tidur | `room_id` |
| `services` & `tariffs` | Master tindakan pelayanan & tarif nominal | `service_id` |
| `suppliers` | Master Pedagang Besar Farmasi (PBF) / Distributor | - |
| `medicine_categories` | Master kelompok/golongan obat | - |
| `medicines` | Master obat & BMHP | `category_id` |
| `medicine_stocks` | Saldo stok fisik obat per lokasi & batch | `medicine_id` |
| `medicine_stock_movements` | Buku besar (ledger) mutasi obat | `medicine_stock_id` |
| `laboratory_tests` | Master jenis pengujian lab & nilai rujukan | - |
| `registrations` | Transaksi pendaftaran pasien | `patient_id`, `doctor_id` |
| `queues` | Antrean poliklinik & pendaftaran | `registration_id`, `department_id` |
| `outpatient_visits` | Transaksi kunjungan poliklinik | `registration_id`, `doctor_id` |
| `inpatient_visits` | Episode rawat inap pasien | `registration_id`, `bed_id` |
| `medical_records` | EMR SOAP & catatan medis | `patient_id`, `registration_id` |
| `diagnoses` | Diagnosa penyakit ICD-10 pasien | `medical_record_id` |
| `prescriptions` & `items` | Transaksi E-Resep & rincian obat | `registration_id`, `medicine_id` |
| `laboratory_orders` & `results` | Transaksi LIS lab & hasil pengujian | `registration_id`, `lab_test_id` |
| `invoices` & `items` | Invoice tagihan & rincian biaya konsolidasi | `registration_id` |
| `payments` | Transaksi pelunasan kasir & kuitansi | `invoice_id`, `cashier_id` |
| `warehouses` & `locations` | Master gedung gudang & lokasi rak | `warehouse_id` |
| `warehouse_items` & `stocks` | Master barang gudang & saldo stok batch | `warehouse_id`, `item_id` |
| `warehouse_receipts` & `items` | Penerimaan barang dari supplier (Inbound) | `supplier_id`, `warehouse_id` |
| `warehouse_dispatches` & `items` | Pengeluaran barang ke unit (Outbound) | `source_warehouse_id` |
| `warehouse_mutations` & `items` | Pemindahan stok antar gudang | `source_id`, `target_id` |
| `stock_opnames` & `items` | Audit pencocokan fisik stok opname | `warehouse_id` |
| `activity_logs` | Audit trail pencatatan aktivitas pengguna | `user_id` |
| `user_logins` | Log riwayat sesi login & logout | `user_id` |
| `backups` | Arsip file cadangan database CLI | `user_id` |
