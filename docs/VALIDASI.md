# Aturan Validasi Form Request (Validation Rules)

Dokumen ini mencatat seluruh aturan validasi Form Request pada **SIMRS Enterprise**.

---

## 📝 Daftar Aturan Validasi Utama

### 1. `StoreRegistrationRequest` (Pendaftaran Pasien)
- `patient_id`: `required|exists:patients,id`
- `department_id`: `required|exists:departments,id`
- `doctor_id`: `required|exists:doctors,id`
- `payment_type`: `required|in:Umum,BPJS,Asuransi`
- `complaint`: `nullable|string|max:500`

### 2. `StoreMedicalRecordRequest` (EMR SOAP Dokter)
- `registration_id`: `required|exists:registrations,id`
- `subjective`: `required|string|min:5`
- `objective`: `required|string|min:5`
- `assessment`: `required|string|min:5`
- `plan`: `required|string|min:5`
- `icd10_code`: `required|string|max:10`
- `icd10_name`: `required|string|max:255`

### 3. `StoreWarehouseReceiptRequest` (Penerimaan Barang Gudang)
- `supplier_id`: `required|exists:suppliers,id`
- `warehouse_id`: `required|exists:warehouses,id`
- `invoice_number`: `required|string|max:100|unique:warehouse_receipts,invoice_number`
- `items`: `required|array|min:1`
- `items.*.warehouse_item_id`: `required|exists:warehouse_items,id`
- `items.*.quantity`: `required|numeric|min:1`
- `items.*.unit_price`: `required|numeric|min:0`

---

*Pesan Galat Validasi*: Seluruh pesan galat validasi dikembalikan dalam Bahasa Indonesia yang ramah pengguna.
