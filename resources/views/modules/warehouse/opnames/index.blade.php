@extends('layouts.admin')

@section('title', 'Stock Opname & Penyesuaian')

@section('content')
    <x-page-header
        title="Stock Opname & Penyesuaian Stok"
        subtitle="Pencocokan stok fisik gudang dengan stok sistem & rekonsiliasi selisih barang."
        :breadcrumb="[
            ['label' => 'Gudang', 'url' => route('warehouse.index')],
            ['label' => 'Stock Opname', 'url' => null]
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('warehouse.opnames.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl shadow-xs transition">
                <i data-lucide="plus" class="w-4 h-4"></i> Input Stock Opname
            </a>
        </x-slot>
    </x-page-header>

    <x-table :headers="['No. Opname & Tanggal', 'Gudang Opname', 'Jumlah Item Diperiksa', 'Status', 'Petugas Auditor', 'Aksi']">
        @forelse($opnames as $opn)
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-4">
                    <div class="font-bold text-teal-600 text-xs font-mono">{{ $opn->opname_number }}</div>
                    <span class="text-[11px] text-slate-400">{{ $opn->opname_date ? $opn->opname_date->format('d/m/Y') : '-' }}</span>
                </td>
                <td class="px-6 py-4 font-semibold text-slate-800 text-xs">{{ $opn->warehouse->name ?? '-' }}</td>
                <td class="px-6 py-4 text-xs font-bold text-slate-800">{{ $opn->items->count() }} Item</td>
                <td class="px-6 py-4"><x-badge type="Selesai">Selesai</x-badge></td>
                <td class="px-6 py-4 text-xs text-slate-600">{{ $opn->creator->name ?? 'Auditor Gudang' }}</td>
                <td class="px-6 py-4">
                    <a href="{{ route('warehouse.opnames.show', $opn) }}" class="p-1.5 text-slate-400 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition" title="Detail">
                        <i data-lucide="eye" class="w-4 h-4"></i>
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">
                    <x-empty-state title="Belum Ada Dokumen Opname" description="Klik tombol Input Stock Opname untuk memulai penyesuaian stok fisik gudang." icon="clipboard-check" />
                </td>
            </tr>
        @endforelse
    </x-table>
    <div class="mt-4">{{ $opnames->links() }}</div>
@endsection
