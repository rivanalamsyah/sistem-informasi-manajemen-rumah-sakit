<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'department_id' => ['required', 'exists:departments,id'],
            'sip' => ['required', 'string', 'max:50', 'unique:doctors,sip'],
            'name' => ['required', 'string', 'max:150'],
            'title_prefix' => ['nullable', 'string', 'max:30'],
            'title_suffix' => ['nullable', 'string', 'max:50'],
            'specialization' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:100'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'department_id.required' => 'Poliklinik wajib dipilih.',
            'department_id.exists' => 'Poliklinik yang dipilih tidak valid.',
            'sip.required' => 'SIP Dokter wajib diisi.',
            'sip.unique' => 'SIP Dokter sudah terdaftar.',
            'name.required' => 'Nama Dokter wajib diisi.',
            'specialization.required' => 'Spesialisasi Dokter wajib diisi.',
            'phone.required' => 'Nomor telepon wajib diisi.',
        ];
    }
}
