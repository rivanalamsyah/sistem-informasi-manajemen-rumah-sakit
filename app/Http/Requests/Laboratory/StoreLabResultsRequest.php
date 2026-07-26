<?php

namespace App\Http\Requests\Laboratory;

use Illuminate\Foundation\Http\FormRequest;

class StoreLabResultsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'results' => ['required', 'array'],
            'results.*.value' => ['required', 'string', 'max:255'],
            'results.*.reference_range' => ['nullable', 'string', 'max:255'],
            'results.*.unit' => ['nullable', 'string', 'max:50'],
            'results.*.is_abnormal' => ['nullable', 'boolean'],
            'results.*.notes' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'results.required' => 'Hasil pemeriksaan laboratorium wajib diisi.',
            'results.*.value.required' => 'Nilai hasil tes lab tidak boleh kosong.',
        ];
    }
}
