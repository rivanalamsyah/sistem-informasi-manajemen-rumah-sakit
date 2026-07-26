<?php

namespace App\Http\Requests\Laboratory;

use Illuminate\Foundation\Http\FormRequest;

class StoreLabOrderRequest extends FormRequest
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
            'order_date' => ['required', 'date'],
            'laboratory_test_ids' => ['required', 'array', 'min:1'],
            'laboratory_test_ids.*' => ['exists:laboratory_tests,id'],
            'clinical_notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'registration_id.required' => 'Pendaftaran pasien wajib dipilih.',
            'doctor_id.required' => 'Dokter pengirim order lab wajib dipilih.',
            'laboratory_test_ids.required' => 'Minimal 1 item pemeriksaan laboratorium wajib dipilih.',
        ];
    }
}
