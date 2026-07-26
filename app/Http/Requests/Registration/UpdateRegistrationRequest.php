<?php

namespace App\Http\Requests\Registration;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'department_id' => ['required', 'exists:departments,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'status' => ['required', 'string', 'in:Menunggu,Diproses,Selesai,Batal'],
            'notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'department_id.required' => 'Poliklinik tujuan wajib dipilih.',
            'doctor_id.required' => 'Dokter spesialis/DPJP wajib dipilih.',
            'status.required' => 'Status pendaftaran wajib dipilih.',
        ];
    }
}
