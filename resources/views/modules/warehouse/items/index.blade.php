@extends('layouts.admin')

@section('title', 'Master Barang Gudang')

@section('content')
    <x-page-header
        title="Master Barang Gudang & Logistik"
        subtitle="Katalog barang logistik, obat, BMHP, dan alat kesehatan rumah sakit."
        :breadcrumb="[
            ['label' => 'Gudang', 'url' => route('warehouse.index')],
            ['label' => 'Master Barang', 'url' => null]
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('warehouse.items.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl shadow-xs transition">
                <i data-lucide="plus" class="w-4 h-4"></i> Tambah Barang
            </a>
        </x-slot>
    </x-page-header>

    <x-card class="p-4 mb-6">
        <form method="GET" action="{{ route('warehouse.items.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-5">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500"
                           placeholder="Cari kode, barcode, atau nama barang...">
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
                <a href="{{ route('warehouse.items.index') }}" class="px-3 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold border border-slate-200 hover:bg-slate-200 transition">Reset</a>
            </div>
        </form>
    </x-card>

    <x-table :headers="['Kode & Barcode', 'Nama Barang', 'Kategori', 'Satuan', 'Min / Max Stock', 'Harga Beli', 'Total Stok', 'Status', 'Aksi']">
        @forelse($items as $item)
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-4">
                    <div class="font-bold text-teal-600 text-xs font-mono">{{ $item->code }}</div>
                    @if($item->barcode)
                        <span class="text-[10px] text-slate-400 font-mono">BC: {{ $item->barcode }}</span>
                    @endif
                </td>
                <td class="px-6 py-4 font-semibold text-slate-800 text-xs">{{ $item->name }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-0.5 text-[11px] font-semibold bg-sky-50 text-sky-700 border border-sky-200 rounded-full">{{ $item->category }}</span>
                </td>
                <td class="px-6 py-4 text-xs font-mono text-slate-600">{{ $item->unit }}</td>
                <td class="px-6 py-4 text-xs text-slate-500 font-mono">{{ $item->min_stock }} / {{ $item->max_stock }}</td>
                <td class="px-6 py-4 text-xs font-bold text-slate-700">Rp {{ number_format($item->purchase_price, 0, ',', '.') }}</td>
                <td class="px-6 py-4">
                    @php $stk = $item->total_stock; @endphp
                    @if($stk <= 0)
                        <span class="px-2 py-0.5 text-[11px] font-bold bg-rose-100 text-rose-800 rounded-full">Habis (0)</span>
                    @elseif($stk <= $item->min_stock)
                        <span class="px-2 py-0.5 text-[11px] font-bold bg-amber-100 text-amber-800 rounded-full">Rendah ({{ $stk }})</span>
                    @else
                        <span class="px-2 py-0.5 text-[11px] font-bold bg-emerald-100 text-emerald-800 rounded-full">{{ $stk }} {{ $item->unit }}</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <x-badge :type="$item->is_active ? 'Aktif' : 'Batal'">{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}</x-badge>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('warehouse.items.show', $item) }}" class="p-1.5 text-slate-400 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition" title="Detail">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </a>
                        <a href="{{ route('warehouse.items.edit', $item) }}" class="p-1.5 text-slate-400 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition" title="Edit">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                        </a>
                        <form action="{{ route('warehouse.items.destroy', $item) }}" method="POST" class="inline" onsubmit="return confirm('Hapus barang {{ $item->name }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9">
                    <x-empty-state title="Belum Ada Barang Gudang" description="Daftarkan item barang logistik, obat, atau alat kesehatan baru." icon="package" />
                </td>
            </tr>
        @endforelse
    </x-table>
    <div class="mt-4">{{ $items->links() }}</div>
@endsection
