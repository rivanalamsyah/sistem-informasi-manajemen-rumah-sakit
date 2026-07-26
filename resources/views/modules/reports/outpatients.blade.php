@extends('layouts.admin')

@section('title', 'Laporan Rawat Jalan (Poliklinik)')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <x-breadcrumb :items="[
                ['label' => 'Laporan & Eksekutif', 'url' => route('reports.index')],
                ['label' => 'Laporan Rawat Jalan', 'url' => null]
            ]" />
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Laporan Pelayanan Rawat Jalan (Poliklinik)</h1>
            <p class="text-xs text-slate-500 mt-0.5">Statistik antrean, durasi konsultasi, dan pemeriksaan fisik TTV pasien outpatient.</p>
        </div>
        <a href="{{ route('reports.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>
    </div>

    <x-table :headers="['Waktu Kunjungan', 'No. RM / Pasien', 'Poliklinik', 'Dokter Pemeriksa', 'TTV (Tensi / Suhu)', 'Status Pelayanan']">
        @forelse($visits as $vst)
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-4 text-xs font-semibold text-slate-800">
                    {{ $vst->visit_date ? $vst->visit_date->format('d/m/Y H:i') : '-' }}
                </td>
                <td class="px-6 py-4">
                    <div class="font-semibold text-slate-800 text-xs">{{ $vst->registration->patient->name ?? '-' }}</div>
                    <span class="text-[11px] text-slate-400 font-mono">{{ $vst->registration->patient->mr_number ?? '-' }}</span>
                </td>
                <td class="text-xs font-bold text-teal-600 px-6 py-4">{{ $vst->department->name ?? '-' }}</td>
                <td class="text-xs text-slate-700 px-6 py-4">{{ $vst->doctor->full_name ?? '-' }}</td>
                <td class="px-6 py-4 text-xs font-mono text-slate-700">
                    {{ $vst->blood_pressure ?? '-' }} mmHg / {{ $vst->temperature ?? '-' }} °C
                </td>
                <td class="px-6 py-4"><x-badge :type="$vst->status">{{ $vst->status }}</x-badge></td>
            </tr>
        @empty
            <tr>
                <td colspan="6">
                    <x-empty-state title="Belum Ada Data Kunjungan Rawat Jalan" description="Tidak ada catatan kunjungan poliklinik." />
                </td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-4">
        {{ $visits->links() }}
    </div>
@endsection
