@extends('layouts.admin')

@section('title', 'Kartu Mutasi Stok Obat')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <x-breadcrumb :items="[
                ['label' => 'Farmasi & Obat', 'url' => route('pharmacy.index')],
                ['label' => 'Mutasi Stok', 'url' => null]
            ]" />
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Kartu Mutasi & Log Perubahan Stok Obat</h1>
            <p class="text-xs text-slate-500 mt-0.5">Catatan riwayat transaksi stok masuk, keluar, dispensing, & penyesuaian opname.</p>
        </div>
        <a href="{{ route('pharmacy.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>
    </div>

    <!-- Filter & Search Bar -->
    <x-card class="p-4 mb-6">
        <form method="GET" action="{{ route('pharmacy.movements') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-8 lg:col-span-8">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>
                    <input type="text" name="search" class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white" placeholder="Nama Obat / No. Referensi / Catatan..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="sm:col-span-4 lg:col-span-4 flex gap-2">
                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-semibold hover:bg-teal-700 transition flex items-center gap-1.5"><i data-lucide="filter" class="w-3.5 h-3.5"></i> Filter</button>
                <a href="{{ route('pharmacy.movements') }}" class="px-3.5 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold border border-slate-200 hover:bg-slate-200 transition">Reset</a>
            </div>
        </form>
    </x-card>

    <!-- Table Mutasi -->
    <x-table :headers="['Waktu Transaksi', 'No. Referensi', 'Nama Obat', 'Jenis Mutasi', 'Jumlah (Qty)', 'Catatan Transaksi']">
        @forelse($movements as $mvt)
            @php
                $badgeStyle = match($mvt->type) {
                    'Masuk' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
                    'Keluar' => 'bg-rose-50 text-rose-700 border-rose-200',
                    'Penyesuaian' => 'bg-amber-50 text-amber-700 border-amber-200',
                    default => 'bg-slate-100 text-slate-700 border-slate-200',
                };
            @endphp
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-4 text-xs font-semibold text-slate-800">
                    {{ $mvt->created_at ? $mvt->created_at->format('d/m/Y H:i') : '-' }}
                </td>
                <td class="font-mono text-xs font-bold text-teal-600 px-6 py-4">{{ $mvt->reference_number ?? '-' }}</td>
                <td class="font-bold text-slate-800 text-xs px-6 py-4">{{ $mvt->medicineStock->medicine->name ?? 'Obat' }}</td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold border {{ $badgeStyle }}">
                        {{ $mvt->type }}
                    </span>
                </td>
                <td class="px-6 py-4 font-bold text-xs {{ $mvt->type === 'Masuk' ? 'text-emerald-600' : 'text-slate-900' }}">
                    {{ $mvt->type === 'Masuk' ? '+' : '-' }}{{ number_format($mvt->quantity) }}
                </td>
                <td class="text-xs text-slate-600 px-6 py-4">{{ $mvt->notes ?? '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6">
                    <x-empty-state title="Belum Ada Log Mutasi" description="Tidak ada riwayat transaksi mutasi stok obat." icon="arrow-left-right" />
                </td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-4">
        {{ $movements->links() }}
    </div>
@endsection
