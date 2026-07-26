<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDepartmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $departmentId = $this->route('department')?->id;

        return [
            'code' => ['required', 'string', 'max:20', Rule::unique('departments', 'code')->ignore($departmentId)],
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
            'name.required' => 'Nama Poliklinik wajib diisi.',
        ];
    }
}
