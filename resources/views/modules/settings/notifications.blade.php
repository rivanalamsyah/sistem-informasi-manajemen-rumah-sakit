@extends('layouts.admin')

@section('title', 'Pengaturan Notifikasi Alert')

@section('content')
    <x-page-header
        title="Pengaturan Notifikasi & Alert Sistem"
        subtitle="Kelola ambang batas peringatan stok minimum, peringatan kedaluwarsa, & notifikasi email."
        :breadcrumb="[
            ['label' => 'Pengaturan', 'url' => route('settings.index')],
            ['label' => 'Notifikasi Alert', 'url' => null]
        ]"
    />

    <form method="POST" action="{{ route('settings.notifications') }}">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-5">
                <x-card title="Ambang Batas Peringatan Stok & Kedaluwarsa" icon="bell" class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <x-form-input name="notif_min_stock_alert" label="Batas Peringatan Stok Minimum (Item)" type="number" required min="1" :value="old('notif_min_stock_alert', $settings['notification']['notif_min_stock_alert'] ?? 10)" help="Notifikasi dipicu jika stok barang <= nilai ini" />
                        <x-form-input name="notif_expiry_days_alert" label="Batas Peringatan Kedaluwarsa (Hari)" type="number" required min="1" :value="old('notif_expiry_days_alert', $settings['notification']['notif_expiry_days_alert'] ?? 90)" help="Peringatan dipicu jika barang expired dalam N hari ke depan" />
                    </div>
                </x-card>
            </div>

            <div class="space-y-5">
                <x-card title="Saluran Notifikasi" icon="toggle-right" class="p-6 space-y-4">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <div class="relative">
                            <input type="hidden" name="notif_email_enabled" value="0">
                            <input type="checkbox" name="notif_email_enabled" value="1" class="sr-only peer" {{ old('notif_email_enabled', $settings['notification']['notif_email_enabled'] ?? '1') == '1' ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-slate-200 peer-checked:bg-teal-500 rounded-full transition-colors"></div>
                            <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></div>
                        </div>
                        <span class="text-xs font-semibold text-slate-800">Aktifkan Email Alert</span>
                    </label>

                    <label class="flex items-center gap-3 cursor-pointer">
                        <div class="relative">
                            <input type="hidden" name="notif_system_enabled" value="0">
                            <input type="checkbox" name="notif_system_enabled" value="1" class="sr-only peer" {{ old('notif_system_enabled', $settings['notification']['notif_system_enabled'] ?? '1') == '1' ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-slate-200 peer-checked:bg-teal-500 rounded-full transition-colors"></div>
                            <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></div>
                        </div>
                        <span class="text-xs font-semibold text-slate-800">Aktifkan Notifikasi In-App</span>
                    </label>
                </x-card>
            </div>
        </div>

        <x-action-bar>
            <a href="{{ route('settings.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Batal
            </a>
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-amber-600 hover:bg-amber-700 text-white text-xs font-bold rounded-xl shadow-xs transition">
                <i data-lucide="save" class="w-4 h-4"></i> Simpan Notifikasi
            </button>
        </x-action-bar>
    </form>
@endsection
