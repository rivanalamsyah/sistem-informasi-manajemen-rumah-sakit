<?php

namespace App\Http\Requests\Inpatient;

use Illuminate\Foundation\Http\FormRequest;

class TransferInpatientBedRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'room_id' => ['required', 'exists:rooms,id'],
            'new_bed_id' => ['required', 'exists:beds,id'],
            'doctor_id' => ['nullable', 'exists:doctors,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'room_id.required' => 'Ruangan tujuan wajib dipilih.',
            'new_bed_id.required' => 'Tempat tidur (Bed) tujuan wajib dipilih.',
        ];
    }
}
