@extends('layouts.admin')

@section('title', 'Laporan Rawat Inap & BOR')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <x-breadcrumb :items="[
                ['label' => 'Laporan & Eksekutif', 'url' => route('reports.index')],
                ['label' => 'Laporan Rawat Inap', 'url' => null]
            ]" />
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Laporan Rawat Inap & Bed Occupancy Rate (BOR)</h1>
            <p class="text-xs text-slate-500 mt-0.5">Pemantauan lama inap (LOS), tingkat hunian bed, & discharge pasien opname.</p>
        </div>
        <a href="{{ route('reports.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>
    </div>

    <!-- Monitoring Okupansi Per Ruangan -->
    <x-card title="Okupansi Kamar & Bed Management" icon="bed" class="p-6 mb-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($rooms as $rm)
                @php
                    $total = $rm->beds->count();
                    $occ = $rm->beds->where('status', 'Terisi')->count();
                    $pct = $total > 0 ? round(($occ / $total) * 100) : 0;
                @endphp
                <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-xl space-y-1.5 text-xs">
                    <div class="font-bold text-slate-800 flex justify-between">
                        <span>{{ $rm->name }} (Kelas {{ $rm->class }})</span>
                        <span class="text-amber-600 font-mono">{{ $pct }}%</span>
                    </div>
                    <div class="w-full bg-slate-200 h-2 rounded-full overflow-hidden">
                        <div class="bg-amber-500 h-full rounded-full" style="width: {{ $pct }}%"></div>
                    </div>
                    <div class="text-[11px] text-slate-500 flex justify-between pt-1">
                        <span>Terisi: <strong>{{ $occ }} Bed</strong></span>
                        <span>Kapasitas: {{ $total }} Bed</span>
                    </div>
                </div>
            @endforeach
        </div>
    </x-card>

    <x-table :headers="['Waktu Masuk', 'No. RM / Pasien', 'Kamar & Bed', 'Dokter DPJP', 'Lama Inap (LOS)', 'Status Opname']">
        @forelse($visits as $vst)
            @php
                $los = $vst->admission_date ? $vst->admission_date->diffInDays($vst->discharge_date ?? now()) : 0;
                if ($los == 0) $los = 1;
            @endphp
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-4 text-xs font-semibold text-slate-800">
                    {{ $vst->admission_date ? $vst->admission_date->format('d/m/Y H:i') : '-' }}
                </td>
                <td class="px-6 py-4">
                    <div class="font-semibold text-slate-800 text-xs">{{ $vst->registration->patient->name ?? '-' }}</div>
                    <span class="text-[11px] text-slate-400 font-mono">{{ $vst->registration->patient->mr_number ?? '-' }}</span>
                </td>
                <td class="text-xs font-bold text-amber-600 px-6 py-4">
                    {{ $vst->bed->room->name ?? 'Kamar' }} — Bed {{ $vst->bed->bed_number ?? '-' }}
                </td>
                <td class="text-xs text-slate-700 px-6 py-4">{{ $vst->doctor->full_name ?? '-' }}</td>
                <td class="px-6 py-4 font-bold text-slate-900 text-xs">{{ $los }} Hari</td>
                <td class="px-6 py-4"><x-badge :type="$vst->status">{{ $vst->status }}</x-badge></td>
            </tr>
        @empty
            <tr>
                <td colspan="6">
                    <x-empty-state title="Belum Ada Data Rawat Inap" description="Tidak ada kunjungan opname." />
                </td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-4">
        {{ $visits->links() }}
    </div>
@endsection
