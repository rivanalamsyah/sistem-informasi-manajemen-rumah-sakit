<?php

namespace App\Http\Requests\Inpatient;

use Illuminate\Foundation\Http\FormRequest;

class StoreInpatientAdmissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'registration_id' => ['required', 'exists:registrations,id'],
            'room_id' => ['required', 'exists:rooms,id'],
            'bed_id' => ['required', 'exists:beds,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'admission_date' => ['required', 'date'],
            'initial_diagnosis' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'registration_id.required' => 'Pendaftaran pasien wajib dipilih.',
            'room_id.required' => 'Ruangan rawat inap wajib dipilih.',
            'bed_id.required' => 'Tempat tidur (Bed) wajib dipilih.',
            'doctor_id.required' => 'Dokter DPJP penanggung jawab wajib dipilih.',
            'admission_date.required' => 'Waktu admisi masuk rawat inap wajib diisi.',
        ];
    }
}
