<?php

namespace App\Http\Requests\Registration;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'registration_type' => ['required', 'string', 'in:lama,baru'],
            'patient_id' => ['required_if:registration_type,lama', 'nullable', 'exists:patients,id'],
            'service_type' => ['required', 'string', 'in:Rawat Jalan,Rawat Inap,IGD'],
            'department_id' => ['required', 'exists:departments,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'guarantor' => ['required', 'string', 'in:Umum,BPJS Kesehatan,Asuransi Swasta,Jamsostek'],
            'registration_date' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:500'],

            // Validasi Pasien Baru
            'new_patient.name' => ['required_if:registration_type,baru', 'nullable', 'string', 'max:150'],
            'new_patient.nik' => ['required_if:registration_type,baru', 'nullable', 'digits:16', 'unique:patients,nik'],
            'new_patient.birth_place' => ['required_if:registration_type,baru', 'nullable', 'string', 'max:100'],
            'new_patient.birth_date' => ['required_if:registration_type,baru', 'nullable', 'date', 'before_or_equal:today'],
            'new_patient.gender' => ['required_if:registration_type,baru', 'nullable', 'in:L,P'],
            'new_patient.phone' => ['required_if:registration_type,baru', 'nullable', 'string', 'max:20'],
            'new_patient.address' => ['required_if:registration_type,baru', 'nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'registration_type.required' => 'Jenis pendaftaran wajib dipilih.',
            'patient_id.required_if' => 'Pasien terdaftar wajib dipilih untuk registrasi pasien lama.',
            'service_type.required' => 'Jenis pelayanan (Rawat Jalan / Rawat Inap / IGD) wajib dipilih.',
            'department_id.required' => 'Poliklinik tujuan wajib dipilih.',
            'doctor_id.required' => 'Dokter spesialis/DPJP wajib dipilih.',
            'guarantor.required' => 'Jenis penjamin biaya wajib dipilih.',
            'new_patient.name.required_if' => 'Nama lengkap pasien baru wajib diisi.',
            'new_patient.nik.required_if' => 'NIK 16 digit wajib diisi untuk pasien baru.',
            'new_patient.nik.unique' => 'NIK tersebut telah terdaftar dalam sistem.',
            'new_patient.nik.digits' => 'NIK harus berjumlah 16 digit angka.',
            'new_patient.birth_date.required_if' => 'Tanggal lahir pasien baru wajib diisi.',
            'new_patient.gender.required_if' => 'Jenis kelamin pasien baru wajib dipilih.',
            'new_patient.phone.required_if' => 'Nomor telepon pasien baru wajib diisi.',
        ];
    }
}
