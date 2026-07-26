<?php

namespace App\Http\Requests\Inpatient;

use Illuminate\Foundation\Http\FormRequest;

class DischargeInpatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'discharge_reason' => ['required', 'string', 'in:Sembuh,Rujuk,APS,Meninggal'],
            'discharge_notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'discharge_reason.required' => 'Alasan pemulangan pasien wajib dipilih.',
        ];
    }
}
