@extends('layouts.admin')

@section('title', 'Input TTV Rawat Jalan')

@section('content')
    <x-page-header
        title="Pemeriksaan Awal Tanda-Tanda Vital (TTV)"
        subtitle="Input vital signs pasien oleh perawat sebelum konsultasi dokter."
        :breadcrumb="[
            ['label' => 'Rawat Jalan (Poli)', 'url' => route('outpatients.index')],
            ['label' => 'Input TTV', 'url' => null]
        ]"
    />

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">
        {{-- Patient Summary Card --}}
        <div class="lg:col-span-4">
            <x-card title="Ringkasan Pasien" icon="user-round">
                <div class="text-center pb-4 mb-4 border-b border-slate-100">
                    <span class="inline-flex items-center justify-center px-4 py-1.5 rounded-full bg-teal-600 text-white font-bold text-sm mb-3">
                        No. Antrean: {{ $outpatientVisit->registration->queue->queue_code ?? '-' }}
                    </span>
                    <h3 class="font-bold text-slate-900 text-base">{{ $outpatientVisit->registration->patient->name ?? '-' }}</h3>
                    <p class="text-xs text-teal-600 font-mono font-semibold mt-0.5">{{ $outpatientVisit->registration->patient->mr_number ?? '-' }}</p>
                </div>
                <dl class="space-y-2.5">
                    <div class="flex justify-between gap-2">
                        <dt class="text-xs text-slate-500">Poliklinik</dt>
                        <dd class="text-xs font-semibold text-slate-800 text-right">{{ $outpatientVisit->department->name ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between gap-2">
                        <dt class="text-xs text-slate-500">Dokter DPJP</dt>
                        <dd class="text-xs font-semibold text-slate-800 text-right">{{ $outpatientVisit->doctor->name ?? '-' }}</dd>
                    </div>
                    <div class="flex justify-between gap-2">
                        <dt class="text-xs text-slate-500">Penjamin</dt>
                        <dd>
                            <span class="px-2 py-0.5 bg-slate-100 text-slate-700 rounded text-[10px] font-semibold border border-slate-200">
                                {{ $outpatientVisit->registration->guarantor ?? 'Umum' }}
                            </span>
                        </dd>
                    </div>
                </dl>
            </x-card>
        </div>

        {{-- TTV Form --}}
        <div class="lg:col-span-8">
            <x-card title="Pencatatan Vital Signs & Anamnesis Awal" icon="activity">
                <form method="POST" action="{{ route('outpatients.update-vital-signs', $outpatientVisit) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="systole" class="block text-xs font-semibold text-slate-700 mb-1.5">Tekanan Darah Sistolik (mmHg)</label>
                            <div class="flex">
                                <input type="number" name="systole" id="systole"
                                    class="flex-1 px-3 py-2 bg-slate-50 border border-slate-200 rounded-l-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition @error('systole') border-red-400 bg-red-50 @enderror"
                                    value="{{ old('systole', $outpatientVisit->vital_signs['systole'] ?? 120) }}" placeholder="120">
                                <span class="px-3 py-2 bg-slate-100 border border-l-0 border-slate-200 rounded-r-xl text-xs text-slate-500 font-medium">mmHg</span>
                            </div>
                            @error('systole')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="diastole" class="block text-xs font-semibold text-slate-700 mb-1.5">Tekanan Darah Diastolik (mmHg)</label>
                            <div class="flex">
                                <input type="number" name="diastole" id="diastole"
                                    class="flex-1 px-3 py-2 bg-slate-50 border border-slate-200 rounded-l-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition @error('diastole') border-red-400 bg-red-50 @enderror"
                                    value="{{ old('diastole', $outpatientVisit->vital_signs['diastole'] ?? 80) }}" placeholder="80">
                                <span class="px-3 py-2 bg-slate-100 border border-l-0 border-slate-200 rounded-r-xl text-xs text-slate-500 font-medium">mmHg</span>
                            </div>
                            @error('diastole')<p class="mt-1 text-xs text-red-500">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label for="temperature" class="block text-xs font-semibold text-slate-700 mb-1.5">Suhu Tubuh (°C)</label>
                            <div class="flex">
                                <input type="number" step="0.1" name="temperature" id="temperature"
                                    class="flex-1 px-3 py-2 bg-slate-50 border border-slate-200 rounded-l-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 transition"
                                    value="{{ old('temperature', $outpatientVisit->vital_signs['temperature'] ?? 36.5) }}" placeholder="36.5">
                                <span class="px-3 py-2 bg-slate-100 border border-l-0 border-slate-200 rounded-r-xl text-xs text-slate-500 font-medium">°C</span>
                            </div>
                        </div>
                        <div>
                            <label for="pulse" class="block text-xs font-semibold text-slate-700 mb-1.5">Denyut Nadi (x/mnt)</label>
                            <div class="flex">
                                <input type="number" name="pulse" id="pulse"
                                    class="flex-1 px-3 py-2 bg-slate-50 border border-slate-200 rounded-l-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 transition"
                                    value="{{ old('pulse', $outpatientVisit->vital_signs['pulse'] ?? 80) }}" placeholder="80">
                                <span class="px-3 py-2 bg-slate-100 border border-l-0 border-slate-200 rounded-r-xl text-xs text-slate-500 font-medium">x/mnt</span>
                            </div>
                        </div>
                        <div>
                            <label for="respiration" class="block text-xs font-semibold text-slate-700 mb-1.5">Laju Pernapasan / RR</label>
                            <div class="flex">
                                <input type="number" name="respiration" id="respiration"
                                    class="flex-1 px-3 py-2 bg-slate-50 border border-slate-200 rounded-l-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 transition"
                                    value="{{ old('respiration', $outpatientVisit->vital_signs['respiration'] ?? 18) }}" placeholder="18">
                                <span class="px-3 py-2 bg-slate-100 border border-l-0 border-slate-200 rounded-r-xl text-xs text-slate-500 font-medium">x/mnt</span>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div>
                            <label for="height" class="block text-xs font-semibold text-slate-700 mb-1.5">Tinggi Badan (cm)</label>
                            <div class="flex">
                                <input type="number" step="0.1" name="height" id="height"
                                    class="flex-1 px-3 py-2 bg-slate-50 border border-slate-200 rounded-l-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 transition"
                                    value="{{ old('height', $outpatientVisit->vital_signs['height'] ?? 165) }}" placeholder="165">
                                <span class="px-3 py-2 bg-slate-100 border border-l-0 border-slate-200 rounded-r-xl text-xs text-slate-500 font-medium">cm</span>
                            </div>
                        </div>
                        <div>
                            <label for="weight" class="block text-xs font-semibold text-slate-700 mb-1.5">Berat Badan (kg)</label>
                            <div class="flex">
                                <input type="number" step="0.1" name="weight" id="weight"
                                    class="flex-1 px-3 py-2 bg-slate-50 border border-slate-200 rounded-l-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 transition"
                                    value="{{ old('weight', $outpatientVisit->vital_signs['weight'] ?? 60) }}" placeholder="60">
                                <span class="px-3 py-2 bg-slate-100 border border-l-0 border-slate-200 rounded-r-xl text-xs text-slate-500 font-medium">kg</span>
                            </div>
                        </div>
                        <div>
                            <label for="spo2" class="block text-xs font-semibold text-slate-700 mb-1.5">Saturasi Oksigen SpO2 (%)</label>
                            <div class="flex">
                                <input type="number" name="spo2" id="spo2"
                                    class="flex-1 px-3 py-2 bg-slate-50 border border-slate-200 rounded-l-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 transition"
                                    value="{{ old('spo2', $outpatientVisit->vital_signs['spo2'] ?? 98) }}" placeholder="98">
                                <span class="px-3 py-2 bg-slate-100 border border-l-0 border-slate-200 rounded-r-xl text-xs text-slate-500 font-medium">%</span>
                            </div>
                        </div>
                    </div>

                    <x-form-textarea name="complaint" id="complaint" label="Catatan Keluhan Utama & Anamnesis Awal" rows="3" placeholder="Keluhan utama pasien saat periksa awal...">{{ old('complaint', $outpatientVisit->complaint) }}</x-form-textarea>

                    <x-action-bar :cancelUrl="route('outpatients.index')" saveLabel="Simpan TTV & Tandai Diperiksa" />
                </form>
            </x-card>
        </div>
    </div>
@endsection
