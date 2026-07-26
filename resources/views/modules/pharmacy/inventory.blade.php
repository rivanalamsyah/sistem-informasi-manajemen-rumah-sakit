@extends('layouts.admin')

@section('title', 'Inventori Stok Obat & Batch Kadaluarsa')

@section('content')
    <x-page-header
        title="Inventori Fisik Obat & Kontrol Kadaluarsa"
        subtitle="Monitoring lokasi penyimpanan (Gudang/Depo), nomor batch, tanggal expired, & opname stok."
        :breadcrumb="[
            ['label' => 'Farmasi & Obat', 'url' => route('pharmacy.index')],
            ['label' => 'Inventori Stok', 'url' => null]
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('pharmacy.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
            </a>
        </x-slot>
    </x-page-header>

    <!-- Filter & Search Bar -->
    <x-card class="p-4 mb-6">
        <form method="GET" action="{{ route('pharmacy.inventory') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-5 lg:col-span-5">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>
                    <input type="text" name="search" class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white" placeholder="Nama Obat / Kode / No. Batch..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="sm:col-span-4 lg:col-span-4">
                <select name="location" class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white">
                    <option value="">-- Semua Lokasi --</option>
                    <option value="Gudang" {{ request('location') === 'Gudang' ? 'selected' : '' }}>Gudang Utama</option>
                    <option value="Depo Farmasi" {{ request('location') === 'Depo Farmasi' ? 'selected' : '' }}>Depo Farmasi</option>
                </select>
            </div>
            <div class="sm:col-span-3 lg:col-span-3 flex gap-2">
                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-semibold hover:bg-teal-700 transition flex items-center gap-1.5"><i data-lucide="filter" class="w-3.5 h-3.5"></i> Filter</button>
                <a href="{{ route('pharmacy.inventory') }}" class="px-3.5 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold border border-slate-200 hover:bg-slate-200 transition">Reset</a>
            </div>
        </form>
    </x-card>

    <!-- Table Inventori -->
    <x-table :headers="['Nama Obat & Kode', 'Kategori', 'Lokasi Depo', 'No. Batch', 'Tanggal Kadaluarsa', 'Stok Fisik Saat Ini', 'Aksi Opname']">
        @forelse($stocks as $stk)
            @php
                $isExpiring = $stk->expired_date && $stk->expired_date->diffInDays(now(), false) >= -90;
                $isLow = $stk->stock <= 10;
            @endphp
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-4">
                    <div class="font-bold text-slate-800 text-xs">{{ $stk->medicine->name ?? 'Obat' }}</div>
                    <span class="text-[11px] text-teal-600 font-mono font-bold">{{ $stk->medicine->code ?? '-' }}</span>
                </td>
                <td class="text-xs text-slate-600 px-6 py-4">{{ $stk->medicine->category->name ?? '-' }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-0.5 rounded text-[11px] font-semibold bg-slate-100 border border-slate-200 text-slate-700">{{ $stk->location }}</span>
                </td>
                <td class="font-mono text-xs font-bold text-slate-700 px-6 py-4">{{ $stk->batch_number }}</td>
                <td class="px-6 py-4">
                    <span class="text-xs font-semibold {{ $isExpiring ? 'text-rose-600 font-bold' : 'text-slate-700' }}">
                        {{ $stk->expired_date ? $stk->expired_date->format('d/m/Y') : '-' }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <span class="text-sm font-bold {{ $isLow ? 'text-rose-600' : 'text-emerald-600' }}">
                        {{ number_format($stk->stock) }} {{ $stk->medicine->unit ?? 'Pcs' }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <!-- Inline Form Adjust Stock -->
                    <form action="{{ route('pharmacy.adjust-stock', $stk) }}" method="POST" class="flex items-center gap-2">
                        @csrf
                        <input type="number" name="stock" value="{{ $stk->stock }}" min="0" class="w-20 px-2 py-1 bg-slate-50 border border-slate-200 rounded-lg text-xs font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-500">
                        <button type="submit" class="px-2.5 py-1 bg-teal-600 hover:bg-teal-700 text-white rounded-lg text-[11px] font-semibold transition">
                            Simpan
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">
                    <x-empty-state title="Belum Ada Data Inventori" description="Tidak ada catatan stok fisik obat untuk kriteria pencarian ini." icon="package" />
                </td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-4">
        {{ $stocks->links() }}
    </div>
@endsection
