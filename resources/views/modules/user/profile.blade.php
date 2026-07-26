@extends('layouts.admin')

@section('title', 'Profil Akun Saya')

@section('content')
    <x-page-header
        title="Profil Akun Saya"
        subtitle="Pengaturan biodata diri, email, nomor telepon, & pembaruan kata sandi."
        :breadcrumb="[
            ['label' => 'Profil Saya', 'url' => null]
        ]"
    />

    <form method="POST" action="{{ route('users.update-profile') }}">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-5">
                <x-card title="Informasi Diri" icon="user" class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <x-form-input name="name" label="Nama Lengkap" required :value="old('name', $user->name)" />
                        <x-form-input name="email" label="Alamat Email" type="email" required :value="old('email', $user->email)" />
                        <x-form-input name="phone" label="Nomor Telepon / WhatsApp" :value="old('phone', $user->phone)" />
                        <div>
                            <label class="block text-xs font-semibold text-slate-500 mb-1.5">Username (Non-editable)</label>
                            <input type="text" disabled value="{{ $user->username }}" class="w-full px-3 py-2 bg-slate-100 border border-slate-200 rounded-xl text-xs font-mono text-slate-500">
                        </div>
                    </div>
                </x-card>

                <x-card title="Ganti Kata Sandi (Password)" icon="key" class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <x-form-input name="current_password" label="Kata Sandi Saat Ini" type="password" placeholder="Masukkan password lama Anda" />
                        </div>
                        <x-form-input name="new_password" label="Kata Sandi Baru" type="password" placeholder="Minimal 8 karakter" />
                        <x-form-input name="new_password_confirmation" label="Konfirmasi Kata Sandi Baru" type="password" placeholder="Ketik ulang password baru" />
                    </div>
                </x-card>
            </div>

            <div class="space-y-5">
                <x-card class="p-6 text-center">
                    <div class="w-20 h-20 rounded-3xl bg-teal-600 text-white flex items-center justify-center font-black text-2xl mx-auto mb-3 shadow-md">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h3 class="font-bold text-slate-900 text-sm">{{ $user->name }}</h3>
                    <span class="text-xs text-slate-500 font-mono block mb-3">{{ $user->email }}</span>
                    <div class="flex flex-wrap justify-center gap-1">
                        @foreach($user->roles as $r)
                            <span class="px-2.5 py-0.5 bg-indigo-50 text-indigo-700 border border-indigo-200 text-[10px] font-bold rounded-full">{{ $r->name }}</span>
                        @endforeach
                    </div>
                </x-card>
            </div>
        </div>

        <x-action-bar>
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl shadow-xs transition">
                <i data-lucide="save" class="w-4 h-4"></i> Simpan Profil Saya
            </button>
        </x-action-bar>
    </form>
@endsection
