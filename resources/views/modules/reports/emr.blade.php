@extends('layouts.admin')

@section('title', 'Laporan Rekam Medis & ICD-10')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <x-breadcrumb :items="[
                ['label' => 'Laporan & Eksekutif', 'url' => route('reports.index')],
                ['label' => 'Laporan Rekam Medis', 'url' => null]
            ]" />
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Laporan Rekam Medis & Pengkodean ICD-10</h1>
            <p class="text-xs text-slate-500 mt-0.5">Analisis diagnosa medis utama/sekunder dan catatan SOAP episode pelayanan.</p>
        </div>
        <a href="{{ route('reports.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>
    </div>

    <!-- Search Bar -->
    <x-card class="p-4 mb-6">
        <form method="GET" action="{{ route('reports.emr') }}" class="flex gap-3">
            <input type="text" name="search" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500" placeholder="Cari Kode ICD-10 / Nama Diagnosa..." value="{{ request('search') }}">
            <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-semibold hover:bg-teal-700 transition flex items-center gap-1.5"><i data-lucide="search" class="w-3.5 h-3.5"></i> Cari</button>
        </form>
    </x-card>

    <x-table :headers="['Waktu EMR', 'No. RM / Pasien', 'Dokter DPJP', 'Keluhan Utama (SOAP)', 'Diagnosa Utama (ICD-10)', 'Diagnosa Sekunder']">
        @forelse($records as $rec)
            @php
                $primary = $rec->diagnoses->where('type', 'Utama')->first();
                $secondaries = $rec->diagnoses->where('type', 'Sekunder');
            @endphp
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-4 text-xs font-semibold text-slate-800">
                    {{ $rec->record_date ? $rec->record_date->format('d/m/Y H:i') : '-' }}
                </td>
                <td class="px-6 py-4">
                    <div class="font-semibold text-slate-800 text-xs">{{ $rec->patient->name ?? '-' }}</div>
                    <span class="text-[11px] text-slate-400 font-mono">{{ $rec->patient->mr_number ?? '-' }}</span>
                </td>
                <td class="text-xs text-slate-700 px-6 py-4">{{ $rec->doctor->full_name ?? '-' }}</td>
                <td class="text-xs text-slate-600 px-6 py-4 max-w-xs truncate">{{ $rec->subjective ?? '-' }}</td>
                <td class="px-6 py-4">
                    @if ($primary)
                        <span class="font-mono text-xs font-bold text-indigo-600 block">{{ $primary->icd10_code }}</span>
                        <span class="text-[11px] text-slate-700 block">{{ $primary->icd10_name }}</span>
                    @else
                        <span class="text-slate-400 text-xs">-</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    @forelse($secondaries as $sec)
                        <span class="text-[10px] font-mono font-bold bg-slate-100 border border-slate-200 px-1.5 py-0.5 rounded text-slate-700 mr-1">{{ $sec->icd10_code }}</span>
                    @empty
                        <span class="text-slate-400 text-xs">-</span>
                    @endforelse
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">
                    <x-empty-state title="Belum Ada Rekam Medis" description="Tidak ada catatan EMR." />
                </td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-4">
        {{ $records->links() }}
    </div>
@endsection
