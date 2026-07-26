@extends('layouts.admin')

@section('title', 'Profil RS & Branding')

@section('content')
    <x-page-header
        title="Profil Rumah Sakit & Branding"
        subtitle="Identitas resmi rumah sakit, alamat domisili, direksi, & skema warna aplikasi."
        :breadcrumb="[
            ['label' => 'Pengaturan', 'url' => route('settings.index')],
            ['label' => 'Profil RS', 'url' => null]
        ]"
    />

    <form method="POST" action="{{ route('settings.hospital') }}">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-5">
                <x-card title="Identitas Resmi Rumah Sakit" icon="building-2" class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <x-form-input name="hospital_name" label="Nama Resmi Rumah Sakit" required :value="old('hospital_name', $settings['general']['hospital_name'] ?? 'RSU Rajawali Citra')" />
                        <x-form-input name="hospital_code" label="Kode Registrasi Kemenkes" :value="old('hospital_code', $settings['general']['hospital_code'] ?? '3402034')" />
                        <div class="sm:col-span-2">
                            <x-form-input name="hospital_address" label="Alamat Lengkap Domisili" required :value="old('hospital_address', $settings['general']['hospital_address'] ?? 'Jl. Pleret No.KM 2.5, Banjardadap, Potorono, Kec. Banguntapan, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55196')" />
                        </div>
                        <x-form-input name="hospital_phone" label="Telepon Call Center" required :value="old('hospital_phone', $settings['general']['hospital_phone'] ?? '0821-3431-3535')" />
                        <x-form-input name="hospital_email" label="Email Layanan Pelanggan" type="email" required :value="old('hospital_email', $settings['general']['hospital_email'] ?? 'info@rsurajawalicitra.co.id')" />
                        <x-form-input name="hospital_website" label="Situs Web Resmi" :value="old('hospital_website', $settings['general']['hospital_website'] ?? 'https://rsurajawalicitra.co.id')" />
                        <x-form-input name="director_name" label="Nama Direktur RS" required :value="old('director_name', $settings['general']['director_name'] ?? 'dr. H. Ahmad Fauzi, Sp.OG, MARS')" />
                        <x-form-input name="npwp" label="NPWP Badan Hukum" :value="old('npwp', $settings['general']['npwp'] ?? '01.234.567.8-012.000')" />
                        <x-form-input name="operating_hours" label="Jam Operasional Pelayanan" :value="old('operating_hours', $settings['general']['operating_hours'] ?? 'Open 24 hours (Buka 24 Jam)')" />
                    </div>
                </x-card>
            </div>

            <div class="space-y-5">
                <x-card title="Branding & Warna Tema" icon="palette" class="p-6 space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Warna Utama (Primary Color)</label>
                        <div class="flex items-center gap-2">
                            <input type="color" name="primary_color" value="{{ old('primary_color', $settings['branding']['primary_color'] ?? '#0d9488') }}" class="w-10 h-10 rounded-xl border border-slate-200 cursor-pointer">
                            <input type="text" name="primary_color" value="{{ old('primary_color', $settings['branding']['primary_color'] ?? '#0d9488') }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Warna Sekunder (Sidebar / Header)</label>
                        <div class="flex items-center gap-2">
                            <input type="color" name="secondary_color" value="{{ old('secondary_color', $settings['branding']['secondary_color'] ?? '#0f172a') }}" class="w-10 h-10 rounded-xl border border-slate-200 cursor-pointer">
                            <input type="text" name="secondary_color" value="{{ old('secondary_color', $settings['branding']['secondary_color'] ?? '#0f172a') }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs font-mono">
                        </div>
                    </div>
                </x-card>
            </div>
        </div>

        <x-action-bar>
            <a href="{{ route('settings.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Batal
            </a>
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl shadow-xs transition">
                <i data-lucide="save" class="w-4 h-4"></i> Simpan Profil RS
            </button>
        </x-action-bar>
    </form>
@endsection
