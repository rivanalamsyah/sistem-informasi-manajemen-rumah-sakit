@extends('layouts.admin')

@section('title', 'Detail Barang Gudang')

@section('content')
    <x-page-header
        title="{{ $item->name }}"
        subtitle="Detail informasi barang gudang, saldo stok per gudang, & riwayat pergerakan."
        :breadcrumb="[
            ['label' => 'Gudang', 'url' => route('warehouse.index')],
            ['label' => 'Master Barang', 'url' => route('warehouse.items.index')],
            ['label' => $item->code, 'url' => null]
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('warehouse.items.edit', $item) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold rounded-xl shadow-xs transition">
                <i data-lucide="pencil" class="w-4 h-4"></i> Edit Barang
            </a>
            <a href="{{ route('warehouse.items.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
            </a>
        </x-slot>
    </x-page-header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-5">
            <x-card class="p-6">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-teal-100 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="package" class="w-7 h-7 text-teal-600"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">{{ $item->name }}</h2>
                        <p class="text-xs text-slate-500 font-mono">{{ $item->code }} @if($item->barcode) · BC: {{ $item->barcode }} @endif</p>
                    </div>
                    <x-badge :type="$item->is_active ? 'Aktif' : 'Batal'" class="ml-auto">{{ $item->is_active ? 'Aktif' : 'Nonaktif' }}</x-badge>
                </div>

                <dl class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-xs">
                    <div class="bg-slate-50 rounded-xl p-3">
                        <dt class="text-slate-500 font-medium mb-0.5">Kategori</dt>
                        <dd class="font-bold text-slate-800">{{ $item->category }}</dd>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3">
                        <dt class="text-slate-500 font-medium mb-0.5">Satuan</dt>
                        <dd class="font-mono font-bold text-slate-800">{{ $item->unit }}</dd>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3">
                        <dt class="text-slate-500 font-medium mb-0.5">Harga Beli HPP</dt>
                        <dd class="font-bold text-emerald-600">Rp {{ number_format($item->purchase_price, 0, ',', '.') }}</dd>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3">
                        <dt class="text-slate-500 font-medium mb-0.5">Min / Max Stock</dt>
                        <dd class="font-bold text-slate-800">{{ $item->min_stock }} / {{ $item->max_stock }}</dd>
                    </div>
                </dl>
            </x-card>

            {{-- Saldo Stok per Gudang --}}
            <x-card title="Saldo Stok Terdaftar per Gudang" icon="warehouse" class="p-6">
                <x-table :headers="['Gudang', 'Batch Number', 'Expired Date', 'Jumlah Stok']">
                    @forelse($item->stocks as $stk)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-3 font-semibold text-slate-800 text-xs">{{ $stk->warehouse->name ?? '-' }}</td>
                            <td class="px-6 py-3 font-mono text-xs text-slate-600">{{ $stk->batch_number }}</td>
                            <td class="px-6 py-3 text-xs text-slate-500">{{ $stk->expired_date ? $stk->expired_date->format('d/m/Y') : '-' }}</td>
                            <td class="px-6 py-3 font-bold text-teal-600 text-xs">{{ $stk->stock }} {{ $item->unit }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <x-empty-state title="Belum Ada Stok" description="Belum ada transaksi penerimaan atau saldo stok di gudang manapun." icon="box" />
                            </td>
                        </tr>
                    @endforelse
                </x-table>
            </x-card>
        </div>

        <div>
            <x-card title="Supplier & Informasi Link" icon="info" class="p-5 space-y-4">
                <div class="text-xs">
                    <span class="text-slate-500 block">Supplier Utama</span>
                    <span class="font-bold text-slate-800">{{ $item->supplier->name ?? 'Tidak Ditentukan' }}</span>
                </div>
                <div class="text-xs">
                    <span class="text-slate-500 block">Link Obat Farmasi</span>
                    <span class="font-bold text-teal-600">{{ $item->medicine->name ?? 'Tidak Terhubung' }}</span>
                </div>
            </x-card>
        </div>
    </div>
@endsection
