@extends('layouts.admin')

@section('title', 'Input Episode EMR Pasien')

@section('content')
    <x-page-header
        title="Formulir Episode Rekam Medis (EMR) Pasien"
        subtitle="Input integrasi catatan SOAP, diagnosa ICD-10, e-resep farmasi, & order pemeriksaan laboratorium."
        :breadcrumb="[
            ['label' => 'Rekam Medis (EMR)', 'url' => route('medical-records.index')],
            ['label' => 'Input Episode EMR', 'url' => null]
        ]"
    />

    <div class="max-w-5xl">
        <form method="POST" action="{{ route('medical-records.store') }}" class="space-y-6">
            @csrf

            {{-- 1. Identitas Kunjungan & Pasien --}}
            <x-card title="Data Pendaftaran Episode Pasien" icon="user-check">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <x-form-select name="registration_id" id="registration_id" label="Pilih Episode Pendaftaran Pasien" required>
                        <option value="">-- Pilih Kunjungan Pasien Terdaftar --</option>
                        @foreach($registrations as $reg)
                            <option value="{{ $reg->id }}" {{ (old('registration_id', $selectedRegistration->id ?? '') == $reg->id) ? 'selected' : '' }}>
                                [{{ $reg->service_type }}] {{ $reg->registration_number }} — {{ $reg->patient->name ?? '-' }} (No. RM: {{ $reg->patient->mr_number ?? '-' }})
                            </option>
                        @endforeach
                    </x-form-select>

                    <x-form-select name="doctor_id" id="doctor_id" label="Dokter DPJP Pemeriksa" required>
                        <option value="">-- Pilih Dokter DPJP --</option>
                        @foreach($doctors as $doc)
                            <option value="{{ $doc->id }}" {{ old('doctor_id', $selectedRegistration->queue->doctor_id ?? '') == $doc->id ? 'selected' : '' }}>{{ $doc->full_name }}</option>
                        @endforeach
                    </x-form-select>
                </div>

                <div class="mt-4">
                    <x-form-input name="record_date" id="record_date" label="Waktu Pemeriksaan" type="datetime-local" required value="{{ old('record_date', date('Y-m-d\TH:i')) }}" />
                </div>
            </x-card>

            {{-- 2. Format Catatan Medis SOAP --}}
            <x-card title="Format Catatan Medis SOAP" icon="file-text">
                <div class="space-y-4">
                    <div>
                        <label for="subjective" class="block text-xs font-bold text-teal-700 mb-1.5">S — Subjective (Keluhan Utama & Anamnesis Pasien)</label>
                        <textarea name="subjective" id="subjective" rows="3"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 transition"
                            placeholder="Keluhan utama, Riwayat Penyakit Sekarang (RPS), Riwayat Penyakit Dahulu (RPD), Alergi...">{{ old('subjective') }}</textarea>
                    </div>
                    <div>
                        <label for="objective" class="block text-xs font-bold text-sky-700 mb-1.5">O — Objective (Pemeriksaan Fisik & Tanda-Tanda Vital TTV)</label>
                        <textarea name="objective" id="objective" rows="3"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 transition"
                            placeholder="Tekanan Darah (mmHg), Suhu (°C), Nadi (x/mnt), RR (x/mnt), SpO2 (%), Berat/Tinggi Badan, Fisik...">{{ old('objective') }}</textarea>
                    </div>
                    <div>
                        <label for="assessment" class="block text-xs font-bold text-amber-700 mb-1.5">A — Assessment (Analisa Medis & Kesimpulan Klinis)</label>
                        <textarea name="assessment" id="assessment" rows="2"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 transition"
                            placeholder="Kesimpulan kondisi klinis pasien, diagnosa kerja, diagnosa banding...">{{ old('assessment') }}</textarea>
                    </div>
                    <div>
                        <label for="plan" class="block text-xs font-bold text-emerald-700 mb-1.5">P — Plan (Rencana Penatalaksanaan, Terapi, & Edukasi)</label>
                        <textarea name="plan" id="plan" rows="3"
                            class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 transition"
                            placeholder="Rencana pengobatan, edukasi pasien, jadwal kontrol ulang, rencana rujukan...">{{ old('plan') }}</textarea>
                    </div>
                </div>
            </x-card>

            {{-- 3. Diagnosa ICD-10 --}}
            <x-card title="Pengkodean Diagnosa Medis (ICD-10)" icon="activity">
                <div class="space-y-4">
                    <div class="p-4 bg-indigo-50/60 border border-indigo-200/80 rounded-xl space-y-3">
                        <span class="text-xs font-bold text-indigo-800 block">Diagnosa Utama (Primary ICD-10)</span>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <x-form-input name="primary_icd10_code" id="primary_icd10_code" label="Kode ICD-10" value="{{ old('primary_icd10_code', 'J00') }}" placeholder="Kode (e.g. J00)" />
                            <div class="sm:col-span-2">
                                <x-form-input name="primary_icd10_name" id="primary_icd10_name" label="Deskripsi Nama Diagnosa" value="{{ old('primary_icd10_name', 'Acute Nasopharyngitis (Common Cold)') }}" placeholder="Nama Diagnosa (e.g. Common Cold)" />
                            </div>
                        </div>
                    </div>
                    <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-xl space-y-3">
                        <span class="text-xs font-semibold text-slate-700 block">Diagnosa Sekunder (Secondary ICD-10 - Opsional)</span>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <x-form-input name="secondary_icd10_code" id="secondary_icd10_code" label="Kode ICD-10" value="{{ old('secondary_icd10_code') }}" placeholder="Kode (e.g. I10)" />
                            <div class="sm:col-span-2">
                                <x-form-input name="secondary_icd10_name" id="secondary_icd10_name" label="Deskripsi Nama Diagnosa Sekunder" value="{{ old('secondary_icd10_name') }}" placeholder="Deskripsi Diagnosa Sekunder..." />
                            </div>
                        </div>
                    </div>
                </div>
            </x-card>

            {{-- 4. E-Resep & Order Lab --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-card title="E-Resep Farmasi (Teruskan ke Farmasi)" icon="pill">
                    <div class="space-y-3">
                        <x-form-select name="medicine_id" id="medicine_id" label="Pilih Obat dari Katalog">
                            <option value="">-- Tanpa Resep / Pilih Obat --</option>
                            @foreach($medicines as $med)
                                <option value="{{ $med->id }}" {{ old('medicine_id') == $med->id ? 'selected' : '' }}>
                                    {{ $med->name }} (Rp {{ number_format($med->selling_price, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </x-form-select>
                        <div class="grid grid-cols-2 gap-3">
                            <x-form-input name="medicine_qty" id="medicine_qty" label="Jumlah (Qty)" type="number" value="{{ old('medicine_qty', 10) }}" min="1" />
                            <x-form-input name="medicine_dosage" id="medicine_dosage" label="Dosis / Signa" value="{{ old('medicine_dosage', '3x1 Tablet') }}" placeholder="e.g. 3x1 Tablet" />
                        </div>
                    </div>
                </x-card>

                <x-card title="Order Pemeriksaan Laboratorium" icon="flask-conical">
                    <div class="space-y-3">
                        <x-form-select name="lab_test_id" id="lab_test_id" label="Pilih Item Pemeriksaan Lab">
                            <option value="">-- Tanpa Order Lab / Pilih Tes --</option>
                            @foreach($labTests as $lt)
                                <option value="{{ $lt->id }}" {{ old('lab_test_id') == $lt->id ? 'selected' : '' }}>
                                    {{ $lt->name }} (Rp {{ number_format($lt->price, 0, ',', '.') }})
                                </option>
                            @endforeach
                        </x-form-select>
                        <x-form-input name="lab_notes" id="lab_notes" label="Catatan Klinis untuk Lab" value="{{ old('lab_notes') }}" placeholder="Catatan/indikasi pemeriksaan sampel darah..." />
                    </div>
                </x-card>
            </div>

            <x-action-bar :cancelUrl="route('medical-records.index')" saveLabel="Simpan Catatan EMR & Teruskan Order" />
        </form>
    </div>
@endsection
