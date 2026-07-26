@extends('layouts.admin')

@section('title', 'Detail Episode EMR Pasien')

@section('content')
    <x-page-header
        title="Resume Rekam Medis (EMR) Episode Pasien"
        subtitle="Pemeriksaan klinis medis terpadu & histori kunjungan pasien."
        :breadcrumb="[
            ['label' => 'Rekam Medis (EMR)', 'url' => route('medical-records.index')],
            ['label' => 'Detail Episode Medis', 'url' => null]
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('medical-records.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
            </a>
        </x-slot>
    </x-page-header>


    <!-- Banner Identitas Pasien & Episode -->
    <x-card class="p-6 mb-6 bg-gradient-to-r from-slate-900 via-slate-800 to-teal-950 text-white border-none shadow-md">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-teal-600/30 border border-teal-500/40 text-teal-300 flex items-center justify-center font-bold text-xl">
                    <i data-lucide="user-check" class="w-7 h-7"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-teal-400 font-mono font-bold tracking-wider uppercase">NO. RM: {{ $medicalRecord->patient->mr_number ?? '-' }}</span>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-teal-500/20 text-teal-300 border border-teal-500/30">{{ $medicalRecord->registration->service_type ?? 'Rawat Jalan' }}</span>
                    </div>
                    <h2 class="text-xl font-bold text-white tracking-tight mt-0.5">{{ $medicalRecord->patient->name ?? '-' }}</h2>
                    <p class="text-xs text-slate-300 mt-0.5">
                        {{ $medicalRecord->patient->gender === 'L' ? 'Laki-laki' : 'Perempuan' }} | NIK: {{ $medicalRecord->patient->nik ?? '-' }} | Telepon: {{ $medicalRecord->patient->phone ?? '-' }}
                    </p>
                </div>
            </div>
            <div class="text-md-right border-t md:border-t-0 md:border-l border-slate-700/80 pt-3 md:pt-0 md:pl-6 text-xs text-slate-300 space-y-1">
                <div>Dokter DPJP: <strong class="text-white">{{ $medicalRecord->doctor->full_name ?? '-' }}</strong></div>
                <div>Waktu Episode: <strong class="text-white">{{ $medicalRecord->record_date ? $medicalRecord->record_date->format('d/m/Y H:i') : '-' }} WIB</strong></div>
                <div>No. Registrasi: <strong class="text-teal-400 font-mono">{{ $medicalRecord->registration->registration_number ?? '-' }}</strong></div>
            </div>
        </div>
    </x-card>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-6">
        <!-- Main EMR Tabs Content -->
        <div class="lg:col-span-8 space-y-6">
            <!-- 1. Format SOAP Medis -->
            <x-card title="Rincian Catatan Klinis SOAP" icon="file-text" class="p-6">
                <div class="space-y-4 text-xs">
                    <!-- Subjective -->
                    <div class="p-4 bg-teal-50/60 border border-teal-200/80 rounded-xl">
                        <span class="font-bold text-teal-800 text-sm block mb-1">S — Subjective (Anamnesis & Keluhan Utama)</span>
                        <p class="text-slate-700 leading-relaxed whitespace-pre-line">{{ $medicalRecord->subjective ?: 'Tidak ada catatan subjective.' }}</p>
                    </div>

                    <!-- Objective -->
                    <div class="p-4 bg-sky-50/60 border border-sky-200/80 rounded-xl">
                        <span class="font-bold text-sky-800 text-sm block mb-1">O — Objective (Pemeriksaan Fisik & TTV)</span>
                        <p class="text-slate-700 leading-relaxed whitespace-pre-line">{{ $medicalRecord->objective ?: 'Tidak ada catatan objective.' }}</p>
                    </div>

                    <!-- Assessment -->
                    <div class="p-4 bg-amber-50/60 border border-amber-200/80 rounded-xl">
                        <span class="font-bold text-amber-800 text-sm block mb-1">A — Assessment (Analisa Klinis & Kesimpulan Dokter)</span>
                        <p class="text-slate-700 leading-relaxed whitespace-pre-line">{{ $medicalRecord->assessment ?: 'Tidak ada catatan assessment.' }}</p>
                    </div>

                    <!-- Plan -->
                    <div class="p-4 bg-emerald-50/60 border border-emerald-200/80 rounded-xl">
                        <span class="font-bold text-emerald-800 text-sm block mb-1">P — Plan (Rencana Penatalaksanaan & Terapi)</span>
                        <p class="text-slate-700 leading-relaxed whitespace-pre-line">{{ $medicalRecord->plan ?: 'Tidak ada catatan plan.' }}</p>
                    </div>
                </div>
            </x-card>

            <!-- 2. Diagnosa ICD-10 -->
            <x-card title="Diagnosa Medis ICD-10" icon="activity" class="p-6">
                <div class="space-y-3">
                    @forelse($medicalRecord->diagnoses as $diag)
                        <div class="p-3.5 rounded-xl border {{ $diag->type === 'Utama' ? 'bg-indigo-50/60 border-indigo-200' : 'bg-slate-50 border-slate-200' }} flex items-center justify-between">
                            <div>
                                <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded {{ $diag->type === 'Utama' ? 'bg-indigo-600 text-white' : 'bg-slate-200 text-slate-700' }} me-2">
                                    {{ $diag->type }}
                                </span>
                                <span class="font-bold font-mono text-sm text-slate-900 me-2">{{ $diag->icd10_code }}</span>
                                <span class="text-xs font-semibold text-slate-800">{{ $diag->icd10_name }}</span>
                            </div>
                        </div>
                    @empty
                        <span class="text-xs text-slate-400 italic">Belum ada diagnosa ICD-10 yang diinput.</span>
                    @endforelse
                </div>
            </x-card>

            <!-- 3. Resep E-Farmasi Pasien -->
            <x-card title="E-Resep Farmasi Terkait" icon="pill" class="p-6">
                @if ($medicalRecord->registration->prescriptions && $medicalRecord->registration->prescriptions->count() > 0)
                    <div class="space-y-3">
                        @foreach($medicalRecord->registration->prescriptions as $pres)
                            <div class="p-4 bg-emerald-50/50 border border-emerald-200/80 rounded-xl space-y-2">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="font-bold text-emerald-800 font-mono">{{ $pres->prescription_number }}</span>
                                    <x-badge :type="$pres->status">{{ $pres->status }}</x-badge>
                                </div>
                                <div class="divide-y divide-emerald-200/60 text-xs text-slate-700">
                                    @foreach($pres->items as $item)
                                        <div class="py-1.5 flex items-center justify-between">
                                            <div>
                                                <strong class="text-slate-800">{{ $item->medicine->name ?? 'Obat' }}</strong> — {{ $item->dosage }} ({{ $item->instruction }})
                                            </div>
                                            <span class="font-bold text-slate-900">{{ $item->quantity }} Qty</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <x-empty-state title="Belum Ada Resep Obat" description="Tidak ada e-resep farmasi yang diorder untuk episode kunjungan ini." icon="pill" />
                @endif
            </x-card>

            <!-- 4. Permintaan Laboratorium Pasien -->
            <x-card title="Order Pemeriksaan Laboratorium Terkait" icon="flask-conical" class="p-6">
                @if ($medicalRecord->registration->laboratoryOrders && $medicalRecord->registration->laboratoryOrders->count() > 0)
                    <div class="space-y-3">
                        @foreach($medicalRecord->registration->laboratoryOrders as $lab)
                            <div class="p-4 bg-sky-50/50 border border-sky-200/80 rounded-xl space-y-2">
                                <div class="flex items-center justify-between text-xs">
                                    <span class="font-bold text-sky-800 font-mono">{{ $lab->order_number }}</span>
                                    <x-badge :type="$lab->status">{{ $lab->status }}</x-badge>
                                </div>
                                <div class="divide-y divide-sky-200/60 text-xs text-slate-700">
                                    @foreach($lab->results as $res)
                                        <div class="py-1.5 flex items-center justify-between">
                                            <strong class="text-slate-800">{{ $res->laboratoryTest->name ?? 'Pemeriksaan Lab' }}</strong>
                                            <span class="font-bold text-sky-700">{{ $res->result_value }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <x-empty-state title="Belum Ada Order Lab" description="Tidak ada order pemeriksaan laboratorium untuk episode kunjungan ini." icon="flask-conical" />
                @endif
            </x-card>
        </div>

        <!-- Histori Longitudional Pasien -->
        <div class="lg:col-span-4 space-y-6">
            <x-card title="Histori Episode Pasien (Timeline)" icon="history" class="p-6">
                @if ($patientHistory->count() > 0)
                    <div class="space-y-4 relative before:absolute before:inset-0 before:left-3.5 before:w-0.5 before:bg-slate-200">
                        @foreach($patientHistory as $prevRec)
                            <div class="relative pl-8">
                                <div class="absolute left-2 top-1 w-3 h-3 rounded-full bg-teal-500 border-2 border-white shadow-xs"></div>
                                <div class="p-3 bg-slate-50 border border-slate-200/80 rounded-xl">
                                    <div class="flex items-center justify-between text-[11px] text-slate-500 mb-1">
                                        <span class="font-bold text-slate-700">{{ $prevRec->record_date ? $prevRec->record_date->format('d/m/Y') : '-' }}</span>
                                        <span class="px-1.5 py-0.5 rounded bg-slate-200 text-slate-700 font-semibold">{{ $prevRec->registration->service_type ?? 'Rawat Jalan' }}</span>
                                    </div>
                                    <div class="text-[11px] text-slate-500 mb-1">Dokter: {{ $prevRec->doctor->name ?? '-' }}</div>
                                    @php $prevDiag = $prevRec->diagnoses->first(); @endphp
                                    @if ($prevDiag)
                                        <div class="font-bold text-teal-600 text-xs font-mono mb-1">{{ $prevDiag->icd10_code }} — {{ Str::limit($prevDiag->icd10_name, 25) }}</div>
                                    @endif
                                    <p class="text-[11px] text-slate-600 line-clamp-2">{{ $prevRec->subjective }}</p>
                                    <a href="{{ route('medical-records.show', $prevRec) }}" class="inline-block text-[11px] font-semibold text-teal-600 hover:text-teal-700 mt-2">Buka Episode Ini →</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <x-empty-state title="Kunjungan Pertama" description="Ini adalah episode EMR pertama untuk pasien ini." icon="info" />
                @endif
            </x-card>
        </div>
    </div>
@endsection
