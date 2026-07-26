@extends('layouts.admin')

@section('title', 'Detail Penerimaan Barang')

@section('content')
    <x-page-header
        title="Dokumen Penerimaan: {{ $receipt->receipt_number }}"
        subtitle="Detail faktur penerimaan barang masuk & catatan penambahan stok gudang."
        :breadcrumb="[
            ['label' => 'Gudang', 'url' => route('warehouse.index')],
            ['label' => 'Penerimaan', 'url' => route('warehouse.receipts.index')],
            ['label' => $receipt->receipt_number, 'url' => null]
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('warehouse.receipts.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
            </a>
        </x-slot>
    </x-page-header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-5">
            <x-card class="p-6">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-teal-100 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="file-input" class="w-7 h-7 text-teal-600"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">{{ $receipt->receipt_number }}</h2>
                        <p class="text-xs text-slate-500 font-mono">Faktur: {{ $receipt->invoice_number ?? '-' }} · Tanggal: {{ $receipt->receipt_date ? $receipt->receipt_date->format('d/m/Y') : '-' }}</p>
                    </div>
                    <div class="ml-auto text-right">
                        <span class="text-xs font-semibold text-slate-500 block">Total Transaksi</span>
                        <span class="text-lg font-bold text-emerald-600">Rp {{ number_format($receipt->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <dl class="grid grid-cols-3 gap-4 text-xs bg-slate-50 p-4 rounded-xl mb-6">
                    <div>
                        <dt class="text-slate-500 font-medium mb-0.5">Gudang Tujuan</dt>
                        <dd class="font-bold text-slate-800">{{ $receipt->warehouse->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500 font-medium mb-0.5">Supplier PBF</dt>
                        <dd class="font-bold text-slate-800">{{ $receipt->supplier->name ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500 font-medium mb-0.5">Petugas Input</dt>
                        <dd class="font-bold text-slate-800">{{ $receipt->creator->name ?? 'Staf Gudang' }}</dd>
                    </div>
                </dl>

                <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-3">Rincian Barang Diterima</h3>
                <x-table :headers="['Nama Barang', 'Quantity', 'Harga Beli', 'Batch Number', 'Expired Date', 'Subtotal']">
                    @foreach($receipt->items as $it)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-3 font-semibold text-slate-800 text-xs">{{ $it->item->name ?? '-' }}</td>
                            <td class="px-6 py-3 font-bold text-teal-600 text-xs">{{ $it->quantity }} {{ $it->item->unit ?? 'Pcs' }}</td>
                            <td class="px-6 py-3 text-xs text-slate-700">Rp {{ number_format($it->purchase_price, 0, ',', '.') }}</td>
                            <td class="px-6 py-3 font-mono text-xs text-slate-600">{{ $it->batch_number }}</td>
                            <td class="px-6 py-3 text-xs text-slate-500">{{ $it->expired_date ? $it->expired_date->format('d/m/Y') : '-' }}</td>
                            <td class="px-6 py-3 font-bold text-emerald-600 text-xs">Rp {{ number_format($it->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </x-table>
            </x-card>
        </div>

        <div>
            <x-card title="Catatan Dokumen" icon="info" class="p-5">
                <p class="text-xs text-slate-600">{{ $receipt->notes ?? 'Tidak ada catatan tambahan.' }}</p>
            </x-card>
        </div>
    </div>
@endsection
