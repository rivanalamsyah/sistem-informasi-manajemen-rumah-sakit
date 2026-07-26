@extends('layouts.admin')

@section('title', 'Buat Invoice Tagihan Pasien')

@section('content')
    <x-page-header
        title="Formulir Penerbitan Invoice Tagihan Medis"
        subtitle="Generate tagihan otomatis dari akumulasi biaya pendaftaran, dokter, kamar, obat, & laboratorium."
        :breadcrumb="[
            ['label' => 'Kasir & Billing', 'url' => route('billing.index')],
            ['label' => 'Buat Invoice Tagihan', 'url' => null]
        ]"
    />

    <div class="max-w-3xl">
        <x-card class="p-6">
            <form method="POST" action="{{ route('billing.store') }}" class="space-y-5">
                @csrf

                <x-form-select name="registration_id" id="registration_id" label="Pilih Episode Kunjungan Pasien" required>
                    <option value="">-- Pilih Pendaftaran Pasien Belum Ditagih --</option>
                    @foreach($registrations as $reg)
                        <option value="{{ $reg->id }}" {{ old('registration_id') == $reg->id ? 'selected' : '' }}>
                            [{{ $reg->service_type }}] {{ $reg->registration_number }} — {{ $reg->patient->name ?? '-' }} (RM: {{ $reg->patient->mr_number ?? '-' }})
                        </option>
                    @endforeach
                </x-form-select>

                <div class="p-4 bg-teal-50 border border-teal-200/80 rounded-xl text-xs text-teal-800 space-y-1.5">
                    <div class="font-bold flex items-center gap-1.5">
                        <i data-lucide="info" class="w-4 h-4 text-teal-600"></i>
                        Ketentuan Pembuatan Invoice Otomatis:
                    </div>
                    <p>• Sistem secara otomatis mengkalkulasi seluruh komponen biaya layanan yang telah diterima pasien.</p>
                    <p>• Biaya mencakup Pendaftaran, Konsultasi Dokter, Resep Farmasi EMR, Pengujian Laboratorium, & Sewa Kamar Inap.</p>
                </div>

                <x-action-bar :cancelUrl="route('billing.index')" saveLabel="Generate Invoice Konsolidasi" />
            </form>
        </x-card>
    </div>
@endsection
