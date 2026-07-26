@extends('layouts.admin')

@section('title', 'Penomoran Dokumen Otomatis')

@section('content')
    <x-page-header
        title="Penomoran Dokumen Otomatis"
        subtitle="Konfigurasi prefix, suffix, & format nomor otomatis untuk RM, registrasi, invoice, resep, lab, & rawat inap."
        :breadcrumb="[
            ['label' => 'Pengaturan', 'url' => route('settings.index')],
            ['label' => 'Penomoran Dokumen', 'url' => null]
        ]"
    />

    <form method="POST" action="{{ route('settings.numbering') }}">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-5">
                <x-card title="Prefix Penomoran Dokumen SIMRS" icon="hash" class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <x-form-input name="rm_prefix" label="Prefix Nomor RM Pasien" required :value="old('rm_prefix', $settings['numbering']['rm_prefix'] ?? 'RM')" help="Format: RM-YYYYMMDD-XXXX" />
                        <x-form-input name="reg_prefix" label="Prefix Nomor Pendaftaran" required :value="old('reg_prefix', $settings['numbering']['reg_prefix'] ?? 'REG')" help="Format: REG-YYYYMMDD-XXXX" />
                        <x-form-input name="billing_prefix" label="Prefix Nomor Billing" required :value="old('billing_prefix', $settings['numbering']['billing_prefix'] ?? 'BIL')" />
                        <x-form-input name="invoice_prefix" label="Prefix Nomor Invoice" required :value="old('invoice_prefix', $settings['numbering']['invoice_prefix'] ?? 'INV')" />
                        <x-form-input name="prescription_prefix" label="Prefix Nomor Resep Obat" required :value="old('prescription_prefix', $settings['numbering']['prescription_prefix'] ?? 'RX')" />
                        <x-form-input name="lab_prefix" label="Prefix Nomor Order Lab" required :value="old('lab_prefix', $settings['numbering']['lab_prefix'] ?? 'LAB')" />
                        <x-form-input name="inpatient_prefix" label="Prefix Nomor Admisi Rawat Inap" required :value="old('inpatient_prefix', $settings['numbering']['inpatient_prefix'] ?? 'RANAP')" />
                    </div>
                </x-card>
            </div>

            <div class="space-y-5">
                <x-card title="Frekuensi Reset Running Number" icon="rotate-ccw" class="p-6">
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Reset Nomor Berurut <span class="text-rose-500">*</span></label>
                    <select name="reset_frequency" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <option value="yearly" {{ (old('reset_frequency', $settings['numbering']['reset_frequency'] ?? 'yearly') === 'yearly') ? 'selected' : '' }}>Reset Setiap Tahun Baru (Default)</option>
                        <option value="monthly" {{ (old('reset_frequency', $settings['numbering']['reset_frequency'] ?? 'yearly') === 'monthly') ? 'selected' : '' }}>Reset Setiap Awal Bulan</option>
                        <option value="never" {{ (old('reset_frequency', $settings['numbering']['reset_frequency'] ?? 'yearly') === 'never') ? 'selected' : '' }}>Tidak Pernah Reset (Continuous)</option>
                    </select>
                </x-card>
            </div>
        </div>

        <x-action-bar>
            <a href="{{ route('settings.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Batal
            </a>
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl shadow-xs transition">
                <i data-lucide="save" class="w-4 h-4"></i> Simpan Format Penomoran
            </button>
        </x-action-bar>
    </form>
@endsection
