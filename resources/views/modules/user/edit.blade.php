@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
    <x-page-header
        title="Edit User: {{ $user->name }}"
        subtitle="Perbarui informasi akun pengguna, penugasan role, dan status keaktifan."
        :breadcrumb="[
            ['label' => 'Manajemen User', 'url' => route('users.index')],
            ['label' => 'Edit User', 'url' => null]
        ]"
    />

    <form method="POST" action="{{ route('users.update', $user) }}">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-5">
                <x-card title="Informasi Identitas & Login" icon="user" class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <x-form-input name="name" label="Nama Lengkap & Gelar" required :value="old('name', $user->name)" />
                        <x-form-input name="username" label="Username (Login)" required :value="old('username', $user->username)" />
                        <x-form-input name="email" label="Alamat Email" type="email" required :value="old('email', $user->email)" />
                        <x-form-input name="nik" label="NIK Pegawai" :value="old('nik', $user->nik)" />
                        <x-form-input name="phone" label="Nomor Telepon / WhatsApp" :value="old('phone', $user->phone)" />
                    </div>
                </x-card>

                <x-card title="Penugasan Role / Peran Hak Akses" icon="shield" class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($roles as $r)
                            <label class="flex items-start gap-3 p-3 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer hover:bg-teal-50/50 transition">
                                <input type="checkbox" name="roles[]" value="{{ $r->id }}" class="mt-0.5 rounded text-teal-600 focus:ring-teal-500"
                                    {{ in_array($r->id, $userRoleIds) ? 'checked' : '' }}>
                                <div>
                                    <span class="text-xs font-bold text-slate-800 block">{{ $r->name }}</span>
                                    <span class="text-[10px] text-slate-500 block">{{ $r->description ?? 'Tanpa deskripsi' }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </x-card>
            </div>

            <div class="space-y-5">
                <x-card title="Status Akun" icon="toggle-right" class="p-6">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <div class="relative">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-slate-200 peer-checked:bg-teal-500 rounded-full transition-colors"></div>
                            <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></div>
                        </div>
                        <span class="text-xs font-semibold text-slate-800">Aktifkan Akun</span>
                    </label>
                </x-card>

                <x-card title="Reset Kata Sandi" icon="key" class="p-5">
                    <form method="POST" action="{{ route('users.reset-password', $user) }}">
                        @csrf
                        <div class="space-y-3">
                            <input type="password" name="new_password" required placeholder="Password Baru (Min. 8 Karakter)" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs">
                            <button type="submit" class="w-full py-2 bg-amber-600 hover:bg-amber-700 text-white font-bold text-xs rounded-xl shadow-xs transition">
                                Reset Password User Ini
                            </button>
                        </div>
                    </form>
                </x-card>
            </div>
        </div>

        <x-action-bar>
            <a href="{{ route('users.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Batal
            </a>
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl shadow-xs transition">
                <i data-lucide="save" class="w-4 h-4"></i> Simpan Perubahan
            </button>
        </x-action-bar>
    </form>
@endsection
