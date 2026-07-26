@extends('layouts.admin')

@section('title', 'Detail Kunjungan Rawat Jalan')

@section('content')
    <x-page-header
        title="Kunjungan Poli: {{ $outpatientVisit->department->name ?? '-' }}"
        subtitle="Pasien: {{ $outpatientVisit->registration->patient->name ?? '-' }} ({{ $outpatientVisit->registration->patient->mr_number ?? '-' }})"
        :breadcrumb="[
            ['label' => 'Rawat Jalan (Poli)', 'url' => route('outpatients.index')],
            ['label' => 'Detail Kunjungan', 'url' => null]
        ]"
    >
        <x-slot name="actions">
            @if ($outpatientVisit->status !== 'Selesai')
                <form action="{{ route('outpatients.complete', $outpatientVisit) }}" method="POST" id="form-complete">
                    @csrf
                    <button type="button" onclick="confirmComplete()"
                        class="inline-flex items-center gap-1.5 px-4 py-2 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold text-xs rounded-xl shadow-sm transition">
                        <i data-lucide="check-circle-2" class="w-3.5 h-3.5"></i> Selesaikan
                    </button>
                </form>
            @endif
            <a href="{{ route('outpatients.edit', $outpatientVisit) }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white font-semibold text-xs rounded-xl shadow-sm transition">
                <i data-lucide="pencil" class="w-3.5 h-3.5"></i> Update TTV
            </a>
            <a href="{{ route('outpatients.index') }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Kembali
            </a>
        </x-slot>
    </x-page-header>

    {{-- Status Header Banner --}}
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-5 mb-5">
        <div class="flex flex-col sm:flex-row items-center gap-5">
            <div class="w-16 h-16 rounded-xl bg-teal-600 flex items-center justify-center">
                <span class="text-2xl font-black text-white">{{ $outpatientVisit->registration->queue->queue_code ?? '-' }}</span>
            </div>
            <div class="text-center sm:text-left flex-1">
                <h2 class="text-lg font-black text-slate-900">{{ $outpatientVisit->department->name ?? '-' }}</h2>
                <p class="text-xs text-slate-500 flex items-center gap-1 justify-center sm:justify-start mt-0.5">
                    <i data-lucide="stethoscope" class="w-3.5 h-3.5"></i>
                    Dokter: {{ $outpatientVisit->doctor->name ?? '-' }}
                </p>
            </div>
            <div class="text-center">
                <p class="text-xs text-slate-500 mb-1">Status Pelayanan</p>
                <x-badge :type="$outpatientVisit->status">{{ $outpatientVisit->status }}</x-badge>
            </div>
        </div>
    </div>

    {{-- Vital Signs Grid --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-5">
        <div class="bg-white border border-slate-200 rounded-xl p-4 text-center shadow-sm">
            <p class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider">Tekanan Darah</p>
            <p class="text-2xl font-black text-teal-600 my-1.5">
                {{ $outpatientVisit->vital_signs['systole'] ?? '-' }}/{{ $outpatientVisit->vital_signs['diastole'] ?? '-' }}
            </p>
            <p class="text-[10px] text-slate-400">mmHg</p>
        </div>
        <div class="bg-white border border-slate-200 rounded-xl p-4 text-center shadow-sm">
            <p class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider">Suhu Tubuh</p>
            <p class="text-2xl font-black text-red-500 my-1.5">
                {{ $outpatientVisit->vital_signs['temperature'] ?? '-' }} °C
            </p>
            <p class="text-[10px] text-slate-400">Celsius</p>
        </div>
        <div class="bg-white border border-slate-200 rounded-xl p-4 text-center shadow-sm">
            <p class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider">Denyut Nadi</p>
            <p class="text-2xl font-black text-blue-600 my-1.5">
                {{ $outpatientVisit->vital_signs['pulse'] ?? '-' }}
            </p>
            <p class="text-[10px] text-slate-400">x/menit</p>
        </div>
        <div class="bg-white border border-slate-200 rounded-xl p-4 text-center shadow-sm">
            <p class="text-[10px] font-semibold text-slate-500 uppercase tracking-wider">TB / BB / SpO2</p>
            <p class="text-lg font-black text-emerald-600 my-1.5">
                {{ $outpatientVisit->vital_signs['height'] ?? '-' }}cm / {{ $outpatientVisit->vital_signs['weight'] ?? '-' }}kg
            </p>
            <p class="text-[10px] text-slate-400">SpO2: {{ $outpatientVisit->vital_signs['spo2'] ?? '-' }}%</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        {{-- Identitas Pasien --}}
        <x-card title="Identitas Pasien" icon="user">
            <dl class="space-y-2.5">
                <div class="flex justify-between gap-2">
                    <dt class="text-xs text-slate-500">No. RM</dt>
                    <dd class="text-xs font-bold text-teal-600">{{ $outpatientVisit->registration->patient->mr_number ?? '-' }}</dd>
                </div>
                <div class="flex justify-between gap-2">
                    <dt class="text-xs text-slate-500">Nama Pasien</dt>
                    <dd class="text-xs font-semibold text-slate-800 text-right">{{ $outpatientVisit->registration->patient->name ?? '-' }}</dd>
                </div>
                <div class="flex justify-between gap-2">
                    <dt class="text-xs text-slate-500">Gender / Umur</dt>
                    <dd class="text-xs text-slate-700">{{ $outpatientVisit->registration->patient->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
                </div>
                <div class="flex justify-between gap-2">
                    <dt class="text-xs text-slate-500">Keluhan Utama</dt>
                    <dd class="text-xs text-slate-700 text-right">{{ $outpatientVisit->complaint ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>

        {{-- Rujukan Internal --}}
        <x-card title="Alur Rujukan Internal & Modul Lanjutan" icon="git-branch">
            <p class="text-xs text-slate-500 mb-3">Pasien yang selesai diperiksa siap dikirim ke modul berikut:</p>
            <div class="space-y-2">
                <a href="{{ route('medical-records.index') }}"
                   class="flex items-center justify-between p-3 bg-slate-50 hover:bg-blue-50 border border-slate-200 hover:border-blue-200 rounded-xl transition group">
                    <div class="flex items-center gap-2">
                        <i data-lucide="folder-open" class="w-4 h-4 text-blue-600"></i>
                        <span class="text-xs font-semibold text-slate-700 group-hover:text-blue-700">Rekam Medis (EMR) <span class="font-normal text-slate-400">— Diagnosis SOAP ICD-10</span></span>
                    </div>
                    <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400"></i>
                </a>
                <a href="{{ route('pharmacy.index') }}"
                   class="flex items-center justify-between p-3 bg-slate-50 hover:bg-emerald-50 border border-slate-200 hover:border-emerald-200 rounded-xl transition group">
                    <div class="flex items-center gap-2">
                        <i data-lucide="pill" class="w-4 h-4 text-emerald-600"></i>
                        <span class="text-xs font-semibold text-slate-700 group-hover:text-emerald-700">Resep Farmasi <span class="font-normal text-slate-400">— Order Resep E-Apotek</span></span>
                    </div>
                    <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400"></i>
                </a>
                <a href="{{ route('laboratory.index') }}"
                   class="flex items-center justify-between p-3 bg-slate-50 hover:bg-red-50 border border-slate-200 hover:border-red-200 rounded-xl transition group">
                    <div class="flex items-center gap-2">
                        <i data-lucide="flask-conical" class="w-4 h-4 text-red-500"></i>
                        <span class="text-xs font-semibold text-slate-700 group-hover:text-red-700">Order Laboratorium <span class="font-normal text-slate-400">— Tes Darah & Sampel</span></span>
                    </div>
                    <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400"></i>
                </a>
                <a href="{{ route('billing.index') }}"
                   class="flex items-center justify-between p-3 bg-slate-50 hover:bg-amber-50 border border-slate-200 hover:border-amber-200 rounded-xl transition group">
                    <div class="flex items-center gap-2">
                        <i data-lucide="receipt" class="w-4 h-4 text-amber-600"></i>
                        <span class="text-xs font-semibold text-slate-700 group-hover:text-amber-700">Kasir & Billing <span class="font-normal text-slate-400">— Pembayaran Tagihan</span></span>
                    </div>
                    <i data-lucide="chevron-right" class="w-4 h-4 text-slate-400"></i>
                </a>
            </div>
        </x-card>
    </div>
@endsection

@push('scripts')
<script>
function confirmComplete() {
    if (confirm('Apakah pemeriksaan pasien ini sudah SELESAI?')) {
        document.getElementById('form-complete').submit();
    }
}
</script>
@endpush
