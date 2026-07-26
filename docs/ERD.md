# Diagram Entity-Relationship (ERD) SIMRS Enterprise

Dokumen ini menyajikan gambaran diagram ERD tekstual Mermaid untuk memvisualisasikan relasi entitas inti pada sistem SIMRS Enterprise.

---

## 📐 Diagram ERD Relasi Utama (Mermaid)

```mermaid
erDiagram
    PATIENTS ||--o{ REGISTRATIONS : "memiliki"
    DEPARTMENTS ||--o{ QUEUES : "mengelola"
    DOCTORS ||--o{ REGISTRATIONS : "melayani"
    REGISTRATIONS ||--|| QUEUES : "memiliki"
    REGISTRATIONS ||--o| OUTPATIENT_VISITS : "proses"
    REGISTRATIONS ||--o| INPATIENT_VISITS : "admisi"
    ROOMS ||--o{ BEDS : "memiliki"
    BEDS ||--o| INPATIENT_VISITS : "ditempati"
    PATIENTS ||--o{ MEDICAL_RECORDS : "memiliki"
    MEDICAL_RECORDS ||--o{ DIAGNOSES : "mencatat"
    REGISTRATIONS ||--o{ PRESCRIPTIONS : "menerbitkan"
    PRESCRIPTIONS ||--o{ PRESCRIPTION_ITEMS : "rincian"
    MEDICINES ||--o{ PRESCRIPTION_ITEMS : "dipesan"
    REGISTRATIONS ||--o{ LABORATORY_ORDERS : "order"
    LABORATORY_ORDERS ||--o{ LABORATORY_RESULTS : "hasil"
    REGISTRATIONS ||--o| INVOICES : "tagihan"
    INVOICES ||--o{ INVOICE_ITEMS : "rincian"
    INVOICES ||--o{ PAYMENTS : "dilunasi"
    WAREHOUSES ||--o{ WAREHOUSE_STOCKS : "simpan"
    WAREHOUSE_ITEMS ||--o{ WAREHOUSE_STOCKS : "stok"
```
