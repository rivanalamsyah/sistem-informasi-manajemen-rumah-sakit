<?php

namespace App\Http\Requests\Outpatient;

use Illuminate\Foundation\Http\FormRequest;

class StoreOutpatientVitalSignsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'systole' => ['nullable', 'numeric', 'min:40', 'max:250'],
            'diastole' => ['nullable', 'numeric', 'min:30', 'max:150'],
            'temperature' => ['nullable', 'numeric', 'min:30', 'max:45'],
            'pulse' => ['nullable', 'numeric', 'min:30', 'max:220'],
            'respiration' => ['nullable', 'numeric', 'min:8', 'max:60'],
            'height' => ['nullable', 'numeric', 'min:30', 'max:250'],
            'weight' => ['nullable', 'numeric', 'min:1', 'max:300'],
            'spo2' => ['nullable', 'numeric', 'min:50', 'max:100'],
            'complaint' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'systole.numeric' => 'Tekanan darah sistolik harus berupa angka.',
            'diastole.numeric' => 'Tekanan darah diastolik harus berupa angka.',
            'temperature.numeric' => 'Suhu tubuh harus berupa angka (derajat Celsius).',
            'pulse.numeric' => 'Denyut nadi harus berupa angka.',
            'respiration.numeric' => 'Laju pernapasan harus berupa angka.',
            'height.numeric' => 'Tinggi badan harus berupa angka (cm).',
            'weight.numeric' => 'Berat badan harus berupa angka (kg).',
            'spo2.numeric' => 'Saturasi oksigen SpO2 harus berupa angka persentase.',
        ];
    }
}
