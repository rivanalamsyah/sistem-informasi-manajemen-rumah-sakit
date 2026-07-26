@extends('layouts.admin')

@section('title', 'Detail Pengeluaran Barang')

@section('content')
    <x-page-header
        title="Dokumen Pengeluaran: {{ $dispatch->dispatch_number }}"
        subtitle="Detail bukti pengeluaran dan distribusi barang logistik."
        :breadcrumb="[
            ['label' => 'Gudang', 'url' => route('warehouse.index')],
            ['label' => 'Pengeluaran', 'url' => route('warehouse.dispatches.index')],
            ['label' => $dispatch->dispatch_number, 'url' => null]
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('warehouse.dispatches.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
            </a>
        </x-slot>
    </x-page-header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-5">
            <x-card class="p-6">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-sky-100 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="file-output" class="w-7 h-7 text-sky-600"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">{{ $dispatch->dispatch_number }}</h2>
                        <p class="text-xs text-slate-500 font-mono">Tujuan: {{ $dispatch->destination_name }} ({{ $dispatch->destination_type }}) · Tanggal: {{ $dispatch->dispatch_date ? $dispatch->dispatch_date->format('d/m/Y') : '-' }}</p>
                    </div>
                    <x-badge type="Selesai" class="ml-auto">Selesai</x-badge>
                </div>

                <dl class="grid grid-cols-3 gap-4 text-xs bg-slate-50 p-4 rounded-xl mb-6">
                    <div>
                        <dt class="text-slate-500 font-medium mb-0.5">Gudang Asal</dt>
                        <dd class="font-bold text-slate-800">{{ $dispatch->sourceWarehouse->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500 font-medium mb-0.5">Unit Tujuan</dt>
                        <dd class="font-bold text-slate-800">{{ $dispatch->destination_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500 font-medium mb-0.5">Petugas Input</dt>
                        <dd class="font-bold text-slate-800">{{ $dispatch->creator->name ?? 'Staf Gudang' }}</dd>
                    </div>
                </dl>

                <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-3">Rincian Barang Dikeluarkan</h3>
                <x-table :headers="['Nama Barang', 'Quantity Keluar', 'Batch Number', 'Keterangan']">
                    @foreach($dispatch->items as $it)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-3 font-semibold text-slate-800 text-xs">{{ $it->item->name ?? '-' }}</td>
                            <td class="px-6 py-3 font-bold text-sky-600 text-xs">{{ $it->quantity }} {{ $it->item->unit ?? 'Pcs' }}</td>
                            <td class="px-6 py-3 font-mono text-xs text-slate-600">{{ $it->batch_number }}</td>
                            <td class="px-6 py-3 text-xs text-slate-500">{{ $it->notes ?? '-' }}</td>
                        </tr>
                    @endforeach
                </x-table>
            </x-card>
        </div>

        <div>
            <x-card title="Catatan Pengeluaran" icon="info" class="p-5">
                <p class="text-xs text-slate-600">{{ $dispatch->notes ?? 'Tidak ada catatan.' }}</p>
            </x-card>
        </div>
    </div>
@endsection
