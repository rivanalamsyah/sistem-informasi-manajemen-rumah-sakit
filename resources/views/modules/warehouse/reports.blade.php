@extends('layouts.admin')

@section('title', 'Laporan Gudang & Persediaan')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <x-breadcrumb :items="[
                ['label' => 'Gudang', 'url' => route('warehouse.index')],
                ['label' => 'Laporan Persediaan', 'url' => null]
            ]" />
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Laporan Persediaan & Nilai Aset Gudang</h1>
            <p class="text-xs text-slate-500 mt-0.5">Rekapitulasi stok akhir, nilai total persediaan, dan evaluasi stok kritis.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('warehouse.export-csv') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-xs transition">
                <i data-lucide="download" class="w-4 h-4"></i> Ekspor CSV Laporan
            </a>
            <a href="{{ route('warehouse.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
            </a>
        </div>
    </div>

    <x-card class="p-4 mb-6">
        <form method="GET" action="{{ route('warehouse.reports') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-5">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500"
                           placeholder="Cari kode atau nama barang...">
                </div>
            </div>
            <div class="sm:col-span-3">
                <select name="category" class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">-- Semua Kategori --</option>
                    @foreach(['Alat Kesehatan / BMHP','Bahan Medis Habis Pakai','Alat Perlindungan Diri','Desinfektan & Antiseptik','Obat & Farmasi','Umum'] as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-2 flex gap-2">
                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-semibold hover:bg-teal-700 transition flex items-center gap-1.5">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i> Filter
                </button>
                <a href="{{ route('warehouse.reports') }}" class="px-3 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold border border-slate-200 hover:bg-slate-200 transition">Reset</a>
            </div>
        </form>
    </x-card>

    <x-table :headers="['Kode Barang', 'Nama Barang', 'Kategori', 'Satuan', 'Min / Max', 'Total Stok', 'Harga Beli (HPP)', 'Nilai Persediaan Total (Rp)']">
        @forelse($items as $item)
            @php
                $stk = $item->total_stock;
                $val = $stk * $item->purchase_price;
            @endphp
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-4 font-bold text-teal-600 text-xs font-mono">{{ $item->code }}</td>
                <td class="px-6 py-4 font-semibold text-slate-800 text-xs">{{ $item->name }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-0.5 text-[11px] font-semibold bg-sky-50 text-sky-700 border border-sky-200 rounded-full">{{ $item->category }}</span>
                </td>
                <td class="px-6 py-4 text-xs font-mono text-slate-600">{{ $item->unit }}</td>
                <td class="px-6 py-4 text-xs font-mono text-slate-500">{{ $item->min_stock }} / {{ $item->max_stock }}</td>
                <td class="px-6 py-4 font-bold text-slate-800 text-xs">{{ $stk }} {{ $item->unit }}</td>
                <td class="px-6 py-4 text-xs font-semibold text-slate-700">Rp {{ number_format($item->purchase_price, 0, ',', '.') }}</td>
                <td class="px-6 py-4 font-bold text-emerald-600 text-xs">Rp {{ number_format($val, 0, ',', '.') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="8">
                    <x-empty-state title="Belum Ada Laporan Persediaan" description="Tidak ada data barang persediaan." icon="bar-chart-2" />
                </td>
            </tr>
        @endforelse
    </x-table>
    <div class="mt-4">{{ $items->links() }}</div>
@endsection
