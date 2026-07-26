@extends('layouts.admin')

@section('title', 'Pengaturan Sistem Rumah Sakit')

@section('content')
    <x-page-header
        title="Pengaturan Sistem Rumah Sakit"
        subtitle="Pusat konfigurasi profil RS, penomoran dokumen, SMTP email, notifikasi, backup, & keamanan."
        :breadcrumb="[
            ['label' => 'Pengaturan', 'url' => null]
        ]"
    />

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <a href="{{ route('settings.hospital') }}" class="group">
            <x-card class="p-6 transition group-hover:border-teal-500 group-hover:shadow-md">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center group-hover:bg-teal-600 group-hover:text-white transition">
                        <i data-lucide="building-2" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-sm group-hover:text-teal-600 transition">Profil RS & Branding</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Nama RS, logo, alamat, kontak, & warna tema.</p>
                    </div>
                </div>
            </x-card>
        </a>

        <a href="{{ route('settings.numbering') }}" class="group">
            <x-card class="p-6 transition group-hover:border-sky-500 group-hover:shadow-md">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center group-hover:bg-sky-600 group-hover:text-white transition">
                        <i data-lucide="hash" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-sm group-hover:text-sky-600 transition">Penomoran Dokumen</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Format prefix & running number RM, invoice, resep.</p>
                    </div>
                </div>
            </x-card>
        </a>

        <a href="{{ route('settings.email') }}" class="group">
            <x-card class="p-6 transition group-hover:border-indigo-500 group-hover:shadow-md">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center group-hover:bg-indigo-600 group-hover:text-white transition">
                        <i data-lucide="mail" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-sm group-hover:text-indigo-600 transition">Konfigurasi Email SMTP</h3>
                        <p class="text-xs text-slate-500 mt-0.5">SMTP Host, port, credentials, & uji coba email.</p>
                    </div>
                </div>
            </x-card>
        </a>

        <a href="{{ route('settings.notifications') }}" class="group">
            <x-card class="p-6 transition group-hover:border-amber-500 group-hover:shadow-md">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center group-hover:bg-amber-600 group-hover:text-white transition">
                        <i data-lucide="bell" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-sm group-hover:text-amber-600 transition">Pengaturan Notifikasi</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Peringatan stok minimum & kedaluwarsa.</p>
                    </div>
                </div>
            </x-card>
        </a>

        <a href="{{ route('settings.backup') }}" class="group">
            <x-card class="p-6 transition group-hover:border-emerald-500 group-hover:shadow-md">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:bg-emerald-600 group-hover:text-white transition">
                        <i data-lucide="database-backup" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-sm group-hover:text-emerald-600 transition">Backup & Restore</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Backup manual database, storage, & restore.</p>
                    </div>
                </div>
            </x-card>
        </a>

        <a href="{{ route('settings.security') }}" class="group">
            <x-card class="p-6 transition group-hover:border-purple-500 group-hover:shadow-md">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center group-hover:bg-purple-600 group-hover:text-white transition">
                        <i data-lucide="shield-check" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-slate-900 text-sm group-hover:text-purple-600 transition">Aplikasi & Keamanan</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Session timeout, 2FA, timezone, & policy password.</p>
                    </div>
                </div>
            </x-card>
        </a>
    </div>
@endsection
