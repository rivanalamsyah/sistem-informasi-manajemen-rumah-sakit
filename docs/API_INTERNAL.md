# Dokumentasi API Internal & SATUSEHAT Integration

Dokumen ini mendokumentasikan endpoint API internal SIMRS Enterprise serta skema mapping data ke standar Kemenkes SATUSEHAT.

---

## 🌐 1. Endpoint API Internal SIMRS

### Search Patient API (AJAX Autocomplete Pendaftaran)
- **URL**: `/api/search-patients`
- **Method**: `GET`
- **Headers**: `Accept: application/json`
- **Query Parameter**: `q` (Search keyword NIK / No. RM / Nama)
- **Sample Response**:
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "mr_number": "RM-20260101-0001",
      "name": "Budi Santoso",
      "nik": "3171010101900001",
      "gender": "L",
      "phone": "081234567890"
    }
  ]
}
```

---

## 🏥 2. Mapping Standar Interoperabilitas SATUSEHAT (HL7 FHIR)

SIMRS Enterprise menggunakan skema relasi data yang kompatibel dengan resource standar Kemenkes SATUSEHAT:

| Entitas SIMRS | Resource SATUSEHAT (FHIR v4.0.1) | Field Kunci |
|---|---|---|
| Pasien (`patients`) | `Patient` | `identifier` (NIK), `name`, `gender`, `birthDate` |
| Dokter (`doctors`) | `Practitioner` | `identifier` (NIP/NUPTK), `name` |
| Poliklinik (`departments`) | `Location` | `name`, `description`, `type` |
| Kunjungan (`registrations`) | `Encounter` | `status`, `class`, `subject`, `period` |
| EMR SOAP (`medical_records`) | `ClinicalImpression` / `Condition` | `code` (ICD-10), `note` (SOAP text) |
| E-Resep (`prescriptions`) | `MedicationRequest` | `medicationCodeableConcept`, `dosageInstruction` |
| Order Lab (`laboratory_orders`)| `ServiceRequest` / `Observation` | `code` (LOINC), `valueQuantity` |
