<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDoctorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $doctorId = $this->route('doctor')?->id;

        return [
            'department_id' => ['required', 'exists:departments,id'],
            'sip' => ['required', 'string', 'max:50', Rule::unique('doctors', 'sip')->ignore($doctorId)],
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
            'sip.required' => 'SIP Dokter wajib diisi.',
            'name.required' => 'Nama Dokter wajib diisi.',
        ];
    }
}
