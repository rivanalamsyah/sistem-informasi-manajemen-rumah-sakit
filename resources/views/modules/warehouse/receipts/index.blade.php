@extends('layouts.admin')

@section('title', 'Penerimaan Barang (Goods Receipt)')

@section('content')
    <x-page-header
        title="Penerimaan Barang (Inbound)"
        subtitle="Riwayat faktur penerimaan barang dari supplier / distributor ke gudang."
        :breadcrumb="[
            ['label' => 'Gudang', 'url' => route('warehouse.index')],
            ['label' => 'Penerimaan', 'url' => null]
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('warehouse.receipts.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl shadow-xs transition">
                <i data-lucide="plus" class="w-4 h-4"></i> Penerimaan Baru
            </a>
        </x-slot>
    </x-page-header>

    <x-card class="p-4 mb-6">
        <form method="GET" action="{{ route('warehouse.receipts.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-6">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500"
                           placeholder="Cari no penerimaan atau no faktur supplier...">
                </div>
            </div>
            <div class="sm:col-span-2 flex gap-2">
                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-semibold hover:bg-teal-700 transition flex items-center gap-1.5">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i> Filter
                </button>
                <a href="{{ route('warehouse.receipts.index') }}" class="px-3 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold border border-slate-200 hover:bg-slate-200 transition">Reset</a>
            </div>
        </form>
    </x-card>

    <x-table :headers="['No. Penerimaan & Tanggal', 'Gudang Tujuan', 'Supplier', 'No. Faktur', 'Jumlah Item', 'Total Nilai (Rp)', 'Petugas', 'Aksi']">
        @forelse($receipts as $rec)
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-4">
                    <div class="font-bold text-teal-600 text-xs font-mono">{{ $rec->receipt_number }}</div>
                    <span class="text-[11px] text-slate-400">{{ $rec->receipt_date ? $rec->receipt_date->format('d/m/Y') : '-' }}</span>
                </td>
                <td class="px-6 py-4 font-semibold text-slate-800 text-xs">{{ $rec->warehouse->name ?? '-' }}</td>
                <td class="px-6 py-4 text-xs text-slate-700">{{ $rec->supplier->name ?? '-' }}</td>
                <td class="px-6 py-4 font-mono text-xs text-slate-600">{{ $rec->invoice_number ?? '-' }}</td>
                <td class="px-6 py-4 text-xs font-bold text-slate-800">{{ $rec->items->count() }} Item</td>
                <td class="px-6 py-4 font-bold text-emerald-600 text-xs">Rp {{ number_format($rec->total_amount, 0, ',', '.') }}</td>
                <td class="px-6 py-4 text-xs text-slate-600">{{ $rec->creator->name ?? 'Staf Gudang' }}</td>
                <td class="px-6 py-4">
                    <a href="{{ route('warehouse.receipts.show', $rec) }}" class="p-1.5 text-slate-400 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition" title="Detail">
                        <i data-lucide="eye" class="w-4 h-4"></i>
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8">
                    <x-empty-state title="Belum Ada Transaksi Penerimaan" description="Klik tombol Penerimaan Baru untuk memasukkan barang dari supplier." icon="file-input" />
                </td>
            </tr>
        @endforelse
    </x-table>
    <div class="mt-4">{{ $receipts->links() }}</div>
@endsection
