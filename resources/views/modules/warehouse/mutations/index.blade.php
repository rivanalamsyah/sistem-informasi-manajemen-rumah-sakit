@extends('layouts.admin')

@section('title', 'Mutasi Barang Antar Gudang')

@section('content')
    <x-page-header
        title="Mutasi Barang Antar Gudang & Depo"
        subtitle="Pengiriman & pemindahan stok barang antar gudang utama, depo farmasi, & gudang alkes."
        :breadcrumb="[
            ['label' => 'Gudang', 'url' => route('warehouse.index')],
            ['label' => 'Mutasi', 'url' => null]
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('warehouse.mutations.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-xs transition">
                <i data-lucide="plus" class="w-4 h-4"></i> Mutasi Baru
            </a>
        </x-slot>
    </x-page-header>

    <x-table :headers="['No. Mutasi & Tanggal', 'Gudang Asal', 'Gudang Tujuan', 'Jumlah Item', 'Status', 'Petugas', 'Aksi']">
        @forelse($mutations as $mut)
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-4">
                    <div class="font-bold text-indigo-600 text-xs font-mono">{{ $mut->mutation_number }}</div>
                    <span class="text-[11px] text-slate-400">{{ $mut->mutation_date ? $mut->mutation_date->format('d/m/Y') : '-' }}</span>
                </td>
                <td class="px-6 py-4 font-semibold text-slate-800 text-xs">{{ $mut->sourceWarehouse->name ?? '-' }}</td>
                <td class="px-6 py-4 font-semibold text-teal-600 text-xs">{{ $mut->targetWarehouse->name ?? '-' }}</td>
                <td class="px-6 py-4 text-xs font-bold text-slate-800">{{ $mut->items->count() }} Item</td>
                <td class="px-6 py-4"><x-badge type="Selesai">Selesai</x-badge></td>
                <td class="px-6 py-4 text-xs text-slate-600">{{ $mut->creator->name ?? 'Staf Gudang' }}</td>
                <td class="px-6 py-4">
                    <a href="{{ route('warehouse.mutations.show', $mut) }}" class="p-1.5 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition" title="Detail">
                        <i data-lucide="eye" class="w-4 h-4"></i>
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">
                    <x-empty-state title="Belum Ada Transaksi Mutasi" description="Klik tombol Mutasi Baru untuk memindahkan stok antar gudang atau depo." icon="arrow-left-right" />
                </td>
            </tr>
        @endforelse
    </x-table>
    <div class="mt-4">{{ $mutations->links() }}</div>
@endsection
