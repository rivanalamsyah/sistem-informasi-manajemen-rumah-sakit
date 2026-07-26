@extends('layouts.admin')

@section('title', 'Laporan Pendaftaran & Kunjungan')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <x-breadcrumb :items="[
                ['label' => 'Laporan & Eksekutif', 'url' => route('reports.index')],
                ['label' => 'Laporan Pendaftaran', 'url' => null]
            ]" />
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Laporan Pendaftaran Pasien & Kunjungan</h1>
            <p class="text-xs text-slate-500 mt-0.5">Rekapitulasi registrasi admisi pasien baru/lama dan distribusi pelayanan.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('reports.export-csv', 'registrations') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm transition">
                <i data-lucide="download" class="w-4 h-4"></i> Ekspor CSV
            </a>
            <a href="{{ route('reports.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Filter Bar -->
    <x-card class="p-4 mb-6">
        <form method="GET" action="{{ route('reports.registrations') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-3">
                <input type="date" name="start_date" value="{{ request('start_date', date('Y-m-01')) }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>
            <div class="sm:col-span-3">
                <input type="date" name="end_date" value="{{ request('end_date', date('Y-m-d')) }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500">
            </div>
            <div class="sm:col-span-4">
                <select name="service_type" class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">-- Semua Jenis Pelayanan --</option>
                    <option value="Rawat Jalan" {{ request('service_type') === 'Rawat Jalan' ? 'selected' : '' }}>Rawat Jalan</option>
                    <option value="Rawat Inap" {{ request('service_type') === 'Rawat Inap' ? 'selected' : '' }}>Rawat Inap</option>
                    <option value="IGD" {{ request('service_type') === 'IGD' ? 'selected' : '' }}>IGD</option>
                </select>
            </div>
            <div class="sm:col-span-2 flex gap-2">
                <button type="submit" class="w-full py-2 bg-teal-600 text-white rounded-xl text-xs font-semibold hover:bg-teal-700 transition flex items-center justify-center gap-1.5"><i data-lucide="filter" class="w-3.5 h-3.5"></i> Filter</button>
            </div>
        </form>
    </x-card>

    <x-table :headers="['No. Reg & Tanggal', 'No. RM / Nama Pasien', 'Layanan & Poli', 'Dokter', 'Penjamin', 'Status']">
        @forelse($registrations as $reg)
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-4">
                    <div class="font-bold text-teal-600 text-xs font-mono">{{ $reg->registration_number }}</div>
                    <span class="text-[11px] text-slate-400">{{ $reg->registration_date ? $reg->registration_date->format('d/m/Y H:i') : '-' }}</span>
                </td>
                <td class="px-6 py-4">
                    <div class="font-semibold text-slate-800 text-xs">{{ $reg->patient->name ?? '-' }}</div>
                    <span class="text-[11px] text-slate-400 font-mono">{{ $reg->patient->mr_number ?? '-' }}</span>
                </td>
                <td class="text-xs text-slate-700 px-6 py-4">{{ $reg->queue->department->name ?? $reg->service_type }}</td>
                <td class="text-xs text-slate-700 px-6 py-4">{{ $reg->queue->doctor->name ?? '-' }}</td>
                <td class="px-6 py-4"><span class="text-[11px] font-semibold text-slate-700 px-2 py-0.5 bg-slate-100 border border-slate-200 rounded">{{ $reg->guarantor }}</span></td>
                <td class="px-6 py-4"><x-badge :type="$reg->status">{{ $reg->status }}</x-badge></td>
            </tr>
        @empty
            <tr>
                <td colspan="6">
                    <x-empty-state title="Belum Ada Data Pendaftaran" description="Tidak ada data pendaftaran untuk kriteria filter ini." />
                </td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-4">
        {{ $registrations->links() }}
    </div>
@endsection
