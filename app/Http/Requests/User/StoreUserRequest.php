<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

/**
 * StoreUserRequest — Validasi pembuatan akun pengguna baru SIMRS.
 * Authorization dilakukan via UserPolicy.
 */
class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\User::class);
    }

    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', 'max:150'],
            'username'   => ['required', 'string', 'max:50', 'unique:users,username'],
            'email'      => ['required', 'email:rfc,dns', 'max:150', 'unique:users,email'],
            'password'   => ['required', Password::min(8)->mixedCase()->numbers()],
            'nik'        => ['nullable', 'string', 'size:16', 'unique:users,nik'],
            'phone'      => ['nullable', 'string', 'max:20'],
            'roles'      => ['nullable', 'array'],
            'roles.*'    => ['exists:roles,id'],
            'is_active'  => ['nullable', 'boolean'],
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
            'password.required' => 'Kata sandi wajib diisi.',
            'nik.size'          => 'NIK harus berjumlah tepat 16 digit.',
            'nik.unique'        => 'NIK sudah terdaftar dalam sistem.',
            'roles.*.exists'    => 'Role yang dipilih tidak valid.',
        ];
    }
}
