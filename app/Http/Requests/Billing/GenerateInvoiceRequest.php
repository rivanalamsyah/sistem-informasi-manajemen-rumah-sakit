<?php

namespace App\Http\Requests\Billing;

use Illuminate\Foundation\Http\FormRequest;

class GenerateInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'registration_id' => ['required', 'exists:registrations,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'registration_id.required' => 'Pendaftaran episode pasien wajib dipilih.',
        ];
    }
}
