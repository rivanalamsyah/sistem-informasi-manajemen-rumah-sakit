@extends('layouts.admin')

@section('title', 'Laporan Laboratorium (LIS)')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <x-breadcrumb :items="[
                ['label' => 'Laporan & Eksekutif', 'url' => route('reports.index')],
                ['label' => 'Laporan Laboratorium', 'url' => null]
            ]" />
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Laporan Pelayanan Laboratorium (LIS)</h1>
            <p class="text-xs text-slate-500 mt-0.5">Rekapitulasi pengujian spesimen sampel, parameter lab, & publikasi EMR.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('reports.export-csv', 'laboratory') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm transition">
                <i data-lucide="download" class="w-4 h-4"></i> Ekspor CSV
            </a>
            <a href="{{ route('reports.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Filter Bar -->
    <x-card class="p-4 mb-6">
        <form method="GET" action="{{ route('reports.laboratory') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-4">
                <select name="status" class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">-- Semua Status Order --</option>
                    @foreach(['Menunggu','Sampel Diambil','Pemeriksaan','Selesai','Dibatalkan'] as $st)
                        <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>{{ $st }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-3 flex gap-2">
                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-semibold hover:bg-teal-700 transition flex items-center gap-1.5">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i> Filter
                </button>
                <a href="{{ route('reports.laboratory') }}" class="px-3.5 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold border border-slate-200 hover:bg-slate-200 transition">Reset</a>
            </div>
        </form>
    </x-card>

    <x-table :headers="['No. Order & Waktu', 'No. RM / Pasien', 'Dokter Pengirim', 'Parameter Tes', 'Status Order']">
        @forelse($orders as $ord)
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-4">
                    <div class="font-bold text-teal-600 text-xs font-mono">{{ $ord->order_number }}</div>
                    <span class="text-[11px] text-slate-400">{{ $ord->order_date ? $ord->order_date->format('d/m/Y H:i') : '-' }}</span>
                </td>
                <td class="px-6 py-4">
                    <div class="font-semibold text-slate-800 text-xs">{{ $ord->patient->name ?? '-' }}</div>
                    <span class="text-[11px] text-slate-400 font-mono">{{ $ord->patient->mr_number ?? '-' }}</span>
                </td>
                <td class="text-xs text-slate-700 px-6 py-4">{{ $ord->doctor->full_name ?? '-' }}</td>
                <td class="px-6 py-4 text-xs font-bold text-slate-900">{{ $ord->results->count() }} Tes Lab</td>
                <td class="px-6 py-4"><x-badge :type="$ord->status">{{ $ord->status }}</x-badge></td>
            </tr>
        @empty
            <tr>
                <td colspan="5">
                    <x-empty-state title="Belum Ada Laporan Laboratorium" description="Tidak ada catatan pengujian sampel lab." />
                </td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
@endsection
