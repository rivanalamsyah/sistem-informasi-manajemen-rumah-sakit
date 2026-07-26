@extends('layouts.admin')

@section('title', 'Detail Stock Opname')

@section('content')
    <x-page-header
        title="Dokumen Opname: {{ $opname->opname_number }}"
        subtitle="Hasil pencocokan stok fisik vs stok sistem & rekonsiliasi selisih barang."
        :breadcrumb="[
            ['label' => 'Gudang', 'url' => route('warehouse.index')],
            ['label' => 'Stock Opname', 'url' => route('warehouse.opnames.index')],
            ['label' => $opname->opname_number, 'url' => null]
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('warehouse.opnames.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
            </a>
        </x-slot>
    </x-page-header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-5">
            <x-card class="p-6">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-teal-100 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="clipboard-check" class="w-7 h-7 text-teal-600"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">{{ $opname->opname_number }}</h2>
                        <p class="text-xs text-slate-500 font-mono">Gudang: {{ $opname->warehouse->name ?? '-' }} · Tanggal: {{ $opname->opname_date ? $opname->opname_date->format('d/m/Y') : '-' }}</p>
                    </div>
                    <x-badge type="Selesai" class="ml-auto">Selesai</x-badge>
                </div>

                <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-3">Hasil Audit & Rekonsiliasi Selisih</h3>
                <x-table :headers="['Nama Barang', 'Stok Sistem', 'Stok Fisik Audit', 'Selisih', 'Keterangan']">
                    @foreach($opname->items as $it)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-3 font-semibold text-slate-800 text-xs">{{ $it->item->name ?? '-' }}</td>
                            <td class="px-6 py-3 text-xs text-slate-600 font-mono">{{ $it->system_stock }}</td>
                            <td class="px-6 py-3 font-bold text-teal-600 text-xs font-mono">{{ $it->physical_stock }}</td>
                            <td class="px-6 py-3 text-xs font-bold font-mono">
                                @if($it->difference == 0)
                                    <span class="text-emerald-600">0 (Cocok)</span>
                                @elseif($it->difference > 0)
                                    <span class="text-sky-600">+{{ $it->difference }} (Surplus)</span>
                                @else
                                    <span class="text-rose-600">{{ $it->difference }} (Defisit)</span>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-xs text-slate-500">{{ $it->notes ?? '-' }}</td>
                        </tr>
                    @endforeach
                </x-table>
            </x-card>
        </div>

        <div>
            <x-card title="Catatan Opname" icon="info" class="p-5">
                <p class="text-xs text-slate-600">{{ $opname->notes ?? 'Tidak ada catatan.' }}</p>
            </x-card>
        </div>
    </div>
@endsection
