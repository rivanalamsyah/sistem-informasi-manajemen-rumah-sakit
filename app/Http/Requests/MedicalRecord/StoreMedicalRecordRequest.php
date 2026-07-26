<?php

namespace App\Http\Requests\MedicalRecord;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicalRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'registration_id' => ['required', 'exists:registrations,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'record_date' => ['required', 'date'],
            'subjective' => ['nullable', 'string', 'max:2000'],
            'objective' => ['nullable', 'string', 'max:2000'],
            'assessment' => ['nullable', 'string', 'max:2000'],
            'plan' => ['nullable', 'string', 'max:2000'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'primary_icd10_code' => ['nullable', 'string', 'max:20'],
            'primary_icd10_name' => ['nullable', 'string', 'max:255'],
            'secondary_icd10_code' => ['nullable', 'string', 'max:20'],
            'secondary_icd10_name' => ['nullable', 'string', 'max:255'],
            'medicine_id' => ['nullable', 'exists:medicines,id'],
            'medicine_qty' => ['nullable', 'integer', 'min:1', 'max:100'],
            'medicine_dosage' => ['nullable', 'string', 'max:100'],
            'medicine_instruction' => ['nullable', 'string', 'max:255'],
            'lab_test_id' => ['nullable', 'exists:laboratory_tests,id'],
            'lab_notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'registration_id.required' => 'Pendaftaran episode pasien wajib dipilih.',
            'doctor_id.required' => 'Dokter pemeriksa wajib dipilih.',
            'record_date.required' => 'Waktu tanggal pemeriksaan wajib diisi.',
        ];
    }
}
