@extends('layouts.admin')

@section('title', 'Aplikasi & Keamanan System')

@section('content')
    <x-page-header
        title="Pengaturan Aplikasi & Keamanan System"
        subtitle="Zona waktu, bahasa, format tampilan, session timeout, policy password, & arsitektur 2FA."
        :breadcrumb="[
            ['label' => 'Pengaturan', 'url' => route('settings.index')],
            ['label' => 'Keamanan', 'url' => null]
        ]"
    />

    <form method="POST" action="{{ route('settings.security') }}">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-5">
                <x-card title="Pengaturan Global Aplikasi" icon="sliders" class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Zona Waktu (Timezone) <span class="text-rose-500">*</span></label>
                            <select name="timezone" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                                <option value="Asia/Jakarta" {{ old('timezone', $settings['system']['timezone'] ?? 'Asia/Jakarta') === 'Asia/Jakarta' ? 'selected' : '' }}>Asia/Jakarta (WIB)</option>
                                <option value="Asia/Makassar" {{ old('timezone', $settings['system']['timezone'] ?? '') === 'Asia/Makassar' ? 'selected' : '' }}>Asia/Makassar (WITA)</option>
                                <option value="Asia/Jayapura" {{ old('timezone', $settings['system']['timezone'] ?? '') === 'Asia/Jayapura' ? 'selected' : '' }}>Asia/Jayapura (WIT)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Bahasa Sistem <span class="text-rose-500">*</span></label>
                            <select name="locale" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                                <option value="id" {{ old('locale', $settings['system']['locale'] ?? 'id') === 'id' ? 'selected' : '' }}>Bahasa Indonesia (ID)</option>
                                <option value="en" {{ old('locale', $settings['system']['locale'] ?? '') === 'en' ? 'selected' : '' }}>English (EN)</option>
                            </select>
                        </div>
                        <x-form-input name="currency" label="Mata Uang SIMRS" required :value="old('currency', $settings['system']['currency'] ?? 'IDR')" />
                        <x-form-input name="per_page" label="Data per Halaman Table" type="number" required min="5" :value="old('per_page', $settings['system']['per_page'] ?? 15)" />
                    </div>
                </x-card>

                <x-card title="Pengaturan Keamanan & Password Policy" icon="shield" class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <x-form-input name="session_timeout" label="Session Timeout (Menit)" type="number" required min="15" :value="old('session_timeout', $settings['security']['session_timeout'] ?? 120)" help="Auto-logout jika idle N menit" />
                        <x-form-input name="password_min_length" label="Panjang Minimal Password" type="number" required min="6" :value="old('password_min_length', $settings['security']['password_min_length'] ?? 8)" />
                        <x-form-input name="max_login_attempts" label="Batas Maksimal Gagal Login" type="number" required min="3" :value="old('max_login_attempts', $settings['security']['max_login_attempts'] ?? 5)" help="Akun terkunci jika salah password N kali" />
                    </div>
                </x-card>
            </div>

            <div class="space-y-5">
                <x-card title="Arsitektur 2FA" icon="key" class="p-6">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <div class="relative">
                            <input type="hidden" name="two_factor_enabled" value="0">
                            <input type="checkbox" name="two_factor_enabled" value="1" class="sr-only peer" {{ old('two_factor_enabled', $settings['security']['two_factor_enabled'] ?? '0') == '1' ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-slate-200 peer-checked:bg-teal-500 rounded-full transition-colors"></div>
                            <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></div>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-slate-800">Two-Factor Authentication</span>
                            <p class="text-[11px] text-slate-500">Nonaktifkan secara default (Siap diaktifkan kapan saja)</p>
                        </div>
                    </label>
                </x-card>
            </div>
        </div>

        <x-action-bar>
            <a href="{{ route('settings.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Batal
            </a>
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold rounded-xl shadow-xs transition">
                <i data-lucide="save" class="w-4 h-4"></i> Simpan Pengaturan Keamanan
            </button>
        </x-action-bar>
    </form>
@endsection
