@extends('layouts.admin')

@section('title', 'Detail Mutasi Barang')

@section('content')
    <x-page-header
        title="Dokumen Mutasi: {{ $mutation->mutation_number }}"
        subtitle="Detail pemindahan stok barang antar gudang & depo."
        :breadcrumb="[
            ['label' => 'Gudang', 'url' => route('warehouse.index')],
            ['label' => 'Mutasi', 'url' => route('warehouse.mutations.index')],
            ['label' => $mutation->mutation_number, 'url' => null]
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('warehouse.mutations.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
            </a>
        </x-slot>
    </x-page-header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-5">
            <x-card class="p-6">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-100 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="arrow-left-right" class="w-7 h-7 text-indigo-600"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">{{ $mutation->mutation_number }}</h2>
                        <p class="text-xs text-slate-500 font-mono">Dari: {{ $mutation->sourceWarehouse->name ?? '-' }} ➔ Ke: {{ $mutation->targetWarehouse->name ?? '-' }}</p>
                    </div>
                    <x-badge type="Selesai" class="ml-auto">Selesai</x-badge>
                </div>

                <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-3">Rincian Barang Dimutasi</h3>
                <x-table :headers="['Nama Barang', 'Quantity Mutasi', 'Batch Number']">
                    @foreach($mutation->items as $it)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-3 font-semibold text-slate-800 text-xs">{{ $it->item->name ?? '-' }}</td>
                            <td class="px-6 py-3 font-bold text-indigo-600 text-xs">{{ $it->quantity }} {{ $it->item->unit ?? 'Pcs' }}</td>
                            <td class="px-6 py-3 font-mono text-xs text-slate-600">{{ $it->batch_number }}</td>
                        </tr>
                    @endforeach
                </x-table>
            </x-card>
        </div>

        <div>
            <x-card title="Catatan Mutasi" icon="info" class="p-5">
                <p class="text-xs text-slate-600">{{ $mutation->notes ?? 'Tidak ada catatan.' }}</p>
            </x-card>
        </div>
    </div>
@endsection
