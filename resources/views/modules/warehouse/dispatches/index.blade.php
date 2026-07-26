@extends('layouts.admin')

@section('title', 'Pengeluaran Barang & Distribusi')

@section('content')
    <x-page-header
        title="Pengeluaran Barang & Distribusi (Outbound)"
        subtitle="Riwayat pengeluaran barang logistik dari gudang ke farmasi, poliklinik, rawat inap, atau unit kerja."
        :breadcrumb="[
            ['label' => 'Gudang', 'url' => route('warehouse.index')],
            ['label' => 'Pengeluaran', 'url' => null]
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('warehouse.dispatches.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold rounded-xl shadow-xs transition">
                <i data-lucide="plus" class="w-4 h-4"></i> Pengeluaran Baru
            </a>
        </x-slot>
    </x-page-header>

    <x-card class="p-4 mb-6">
        <form method="GET" action="{{ route('warehouse.dispatches.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-6">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-sky-500"
                           placeholder="Cari no pengeluaran atau unit tujuan...">
                </div>
            </div>
            <div class="sm:col-span-2 flex gap-2">
                <button type="submit" class="px-4 py-2 bg-sky-600 text-white rounded-xl text-xs font-semibold hover:bg-sky-700 transition flex items-center gap-1.5">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i> Filter
                </button>
                <a href="{{ route('warehouse.dispatches.index') }}" class="px-3 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold border border-slate-200 hover:bg-slate-200 transition">Reset</a>
            </div>
        </form>
    </x-card>

    <x-table :headers="['No. Pengeluaran & Tanggal', 'Gudang Asal', 'Tipe Tujuan', 'Unit / Ruangan Tujuan', 'Jumlah Item', 'Status', 'Petugas', 'Aksi']">
        @forelse($dispatches as $disp)
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-4">
                    <div class="font-bold text-sky-600 text-xs font-mono">{{ $disp->dispatch_number }}</div>
                    <span class="text-[11px] text-slate-400">{{ $disp->dispatch_date ? $disp->dispatch_date->format('d/m/Y') : '-' }}</span>
                </td>
                <td class="px-6 py-4 font-semibold text-slate-800 text-xs">{{ $disp->sourceWarehouse->name ?? '-' }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-0.5 text-[11px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-full">{{ $disp->destination_type }}</span>
                </td>
                <td class="px-6 py-4 font-bold text-slate-800 text-xs">{{ $disp->destination_name }}</td>
                <td class="px-6 py-4 text-xs font-bold text-slate-800">{{ $disp->items->count() }} Item</td>
                <td class="px-6 py-4"><x-badge type="Selesai">Selesai</x-badge></td>
                <td class="px-6 py-4 text-xs text-slate-600">{{ $disp->creator->name ?? 'Staf Gudang' }}</td>
                <td class="px-6 py-4">
                    <a href="{{ route('warehouse.dispatches.show', $disp) }}" class="p-1.5 text-slate-400 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition" title="Detail">
                        <i data-lucide="eye" class="w-4 h-4"></i>
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8">
                    <x-empty-state title="Belum Ada Transaksi Pengeluaran" description="Klik tombol Pengeluaran Baru untuk mendistribusikan barang ke unit/farmasi." icon="file-output" />
                </td>
            </tr>
        @endforelse
    </x-table>
    <div class="mt-4">{{ $dispatches->links() }}</div>
@endsection
