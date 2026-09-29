<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

/**
 * UpdateUserRequest — Validasi pembaruan data akun pengguna SIMRS.
 * Authorization dilakukan via UserPolicy.
 */
class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        $targetUser = $this->route('user');

        return $this->user()->can('update', $targetUser);
    }

    public function rules(): array
    {
        $userId = $this->route('user')?->id;

        return [
            'name'      => ['required', 'string', 'max:150'],
            'username'  => ['required', 'string', 'max:50', 'unique:users,username,' . $userId],
            'email'     => ['required', 'email:rfc,dns', 'max:150', 'unique:users,email,' . $userId],
            'nik'       => ['nullable', 'string', 'size:16', 'unique:users,nik,' . $userId],
            'phone'     => ['nullable', 'string', 'max:20'],
            'roles'     => ['nullable', 'array'],
            'roles.*'   => ['exists:roles,id'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'Nama lengkap wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique'   => 'Username sudah digunakan. Pilih username lain.',
            'email.required'    => 'Email wajib diisi.',
            'email.unique'      => 'Email sudah terdaftar dalam sistem.',
            'email.email'       => 'Format email tidak valid.',
            'nik.size'          => 'NIK harus berjumlah tepat 16 digit.',
            'nik.unique'        => 'NIK sudah terdaftar dalam sistem.',
            'roles.*.exists'    => 'Role yang dipilih tidak valid.',
        ];
    }
}
