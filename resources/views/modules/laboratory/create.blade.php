@extends('layouts.admin')

@section('title', 'Buat Order Laboratorium')

@section('content')
    <x-page-header
        title="Formulir Permintaan Order Laboratorium"
        subtitle="Buat permintaan tes sampel darah, urin, atau patologi klinik untuk pasien."
        :breadcrumb="[
            ['label' => 'Laboratorium', 'url' => route('laboratory.index')],
            ['label' => 'Buat Order Baru', 'url' => null]
        ]"
    />

    <div class="max-w-3xl">
        <x-card class="p-6">
            <form method="POST" action="{{ route('laboratory.store') }}" class="space-y-4">
                @csrf

                <x-form-select name="registration_id" id="registration_id" label="Pilih Pendaftaran Pasien" required>
                    <option value="">-- Pilih Kunjungan Pasien --</option>
                    @foreach($registrations as $reg)
                        <option value="{{ $reg->id }}" {{ old('registration_id') == $reg->id ? 'selected' : '' }}>
                            [{{ $reg->service_type }}] {{ $reg->registration_number }} — {{ $reg->patient->name ?? '-' }} (RM: {{ $reg->patient->mr_number ?? '-' }})
                        </option>
                    @endforeach
                </x-form-select>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <x-form-select name="doctor_id" id="doctor_id" label="Dokter Pengirim" required>
                        <option value="">-- Pilih Dokter --</option>
                        @foreach($doctors as $doc)
                            <option value="{{ $doc->id }}" {{ old('doctor_id') == $doc->id ? 'selected' : '' }}>{{ $doc->full_name }}</option>
                        @endforeach
                    </x-form-select>
                    <x-form-input name="order_date" id="order_date" label="Waktu Permintaan" type="datetime-local" required value="{{ old('order_date', date('Y-m-d\TH:i')) }}" />
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-2">Pilih Item Pemeriksaan Laboratorium <span class="text-rose-500">*</span></label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 max-h-60 overflow-y-auto p-3 bg-slate-50 border border-slate-200 rounded-xl">
                        @foreach($labTests as $lt)
                            <label class="flex items-center gap-2 p-2 bg-white rounded-lg border border-slate-200/80 text-xs font-medium text-slate-700 cursor-pointer hover:bg-teal-50 hover:border-teal-200 transition">
                                <input type="checkbox" name="laboratory_test_ids[]" value="{{ $lt->id }}" class="rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                                <span>{{ $lt->name }} <span class="text-slate-400">(Rp {{ number_format($lt->price, 0, ',', '.') }})</span></span>
                            </label>
                        @endforeach
                    </div>
                    @error('laboratory_test_ids')<p class="text-xs text-rose-600 mt-1">{{ $message }}</p>@enderror
                </div>

                <x-form-textarea name="clinical_notes" id="clinical_notes" label="Catatan Indikasi Klinis Dokter" rows="3" placeholder="Indikasi medis, keluhan klinis, atau catatan pengujian...">{{ old('clinical_notes') }}</x-form-textarea>

                <x-action-bar :cancelUrl="route('laboratory.index')" saveLabel="Buat Order Laboratorium" />
            </form>
        </x-card>
    </div>
@endsection
