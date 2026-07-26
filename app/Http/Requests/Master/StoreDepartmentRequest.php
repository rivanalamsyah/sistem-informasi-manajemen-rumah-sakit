<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => ['required', 'string', 'max:20', 'unique:departments,code'],
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Kode Poliklinik wajib diisi.',
            'code.unique' => 'Kode Poliklinik sudah digunakan.',
            'code.max' => 'Kode Poliklinik maksimal 20 karakter.',
            'name.required' => 'Nama Poliklinik wajib diisi.',
            'name.max' => 'Nama Poliklinik maksimal 100 karakter.',
        ];
    }
}
