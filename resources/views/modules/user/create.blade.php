@extends('layouts.admin')

@section('title', 'Tambah User Baru')

@section('content')
    <x-page-header
        title="Tambah Akun Pengguna Baru"
        subtitle="Daftarkan akun pegawai, perawat, apoteker, atau staf medis baru ke SIMRS."
        :breadcrumb="[
            ['label' => 'Manajemen User', 'url' => route('users.index')],
            ['label' => 'Tambah User', 'url' => null]
        ]"
    />

    <form method="POST" action="{{ route('users.store') }}">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-5">
                <x-card title="Informasi Identitas & Login" icon="user" class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <x-form-input name="name" label="Nama Lengkap & Gelar" placeholder="Contoh: dr. Budi Santoso, Sp.PD" required :value="old('name')" />
                        <x-form-input name="username" label="Username (Login)" placeholder="Contoh: budi.santoso" required :value="old('username')" />
                        <x-form-input name="email" label="Alamat Email" type="email" placeholder="Contoh: budi@kencanamedika.co.id" required :value="old('email')" />
                        <x-form-input name="password" label="Kata Sandi (Password)" type="password" required placeholder="Minimal 8 karakter" />
                        <x-form-input name="nik" label="NIK Pegawai (16 Digit)" placeholder="Contoh: 3171010101900001" :value="old('nik')" />
                        <x-form-input name="phone" label="Nomor Telepon / WhatsApp" placeholder="Contoh: 081234567890" :value="old('phone')" />
                    </div>
                </x-card>

                <x-card title="Penugasan Role / Peran Hak Akses" icon="shield" class="p-6">
                    <p class="text-xs text-slate-500 mb-3">Pilih satu atau beberapa role hak akses untuk menentukan wewenang pengguna di sistem:</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($roles as $r)
                            <label class="flex items-start gap-3 p-3 bg-slate-50 border border-slate-200 rounded-xl cursor-pointer hover:bg-teal-50/50 transition">
                                <input type="checkbox" name="roles[]" value="{{ $r->id }}" class="mt-0.5 rounded text-teal-600 focus:ring-teal-500">
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
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', true) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-slate-200 peer-checked:bg-teal-500 rounded-full transition-colors"></div>
                            <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></div>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-slate-800">Aktifkan Akun</span>
                            <p class="text-[11px] text-slate-500">User aktif dapat login ke sistem</p>
                        </div>
                    </label>
                </x-card>
            </div>
        </div>

        <x-action-bar>
            <a href="{{ route('users.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Batal
            </a>
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl shadow-xs transition">
                <i data-lucide="user-check" class="w-4 h-4"></i> Simpan User Baru
            </button>
        </x-action-bar>
    </form>
@endsection
