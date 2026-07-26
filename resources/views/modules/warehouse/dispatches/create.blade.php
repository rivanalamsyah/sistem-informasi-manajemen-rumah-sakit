@extends('layouts.admin')

@section('title', 'Form Pengeluaran Barang')

@section('content')
    <x-page-header
        title="Form Pengeluaran Barang & Distribusi"
        subtitle="Keluar barang dari gudang utama dan distribusikan ke farmasi atau unit pelayanan."
        :breadcrumb="[
            ['label' => 'Gudang', 'url' => route('warehouse.index')],
            ['label' => 'Pengeluaran', 'url' => route('warehouse.dispatches.index')],
            ['label' => 'Input Pengeluaran', 'url' => null]
        ]"
    />

    <form method="POST" action="{{ route('warehouse.dispatches.store') }}">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-5">
                <x-card title="Dokumen Distribusi & Unit Tujuan" icon="truck" class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <x-form-input name="dispatch_date" label="Tanggal Pengeluaran" type="date" required :value="old('dispatch_date', date('Y-m-d'))" />
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Gudang Asal <span class="text-rose-500">*</span></label>
                            <select name="source_warehouse_id" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-sky-500">
                                @foreach($warehouses as $wh)
                                    <option value="{{ $wh->id }}">{{ $wh->name }} ({{ $wh->code }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tipe Unit Tujuan <span class="text-rose-500">*</span></label>
                            <select name="destination_type" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-sky-500">
                                @foreach(['Farmasi','Poliklinik','Rawat Inap','Unit Logistik'] as $t)
                                    <option value="{{ $t }}">{{ $t }}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-form-input name="destination_name" label="Nama Unit / Depo / Poli Tujuan" placeholder="Contoh: Depo Farmasi Rawat Jalan / Poli Penyakit Dalam" required :value="old('destination_name')" />
                    </div>
                </x-card>

                <x-card title="Daftar Barang Keluar" icon="package" class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="bg-slate-50 text-slate-600 border-b border-slate-200">
                                    <th class="p-2 font-semibold">Barang Gudang</th>
                                    <th class="p-2 font-semibold w-28">Jumlah Keluar</th>
                                    <th class="p-2 font-semibold w-36">Batch Number</th>
                                    <th class="p-2 font-semibold">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-slate-100">
                                    <td class="p-2">
                                        <select name="items[0][warehouse_item_id]" required class="w-full py-1.5 px-2 bg-slate-50 border border-slate-200 rounded-lg text-xs">
                                            <option value="">-- Pilih Barang --</option>
                                            @foreach($items as $it)
                                                <option value="{{ $it->id }}">{{ $it->code }} — {{ $it->name }} (Sisa Stok: {{ $it->total_stock }} {{ $it->unit }})</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="p-2">
                                        <input type="number" name="items[0][quantity]" required min="1" value="1" class="w-full py-1.5 px-2 bg-slate-50 border border-slate-200 rounded-lg text-xs">
                                    </td>
                                    <td class="p-2">
                                        <input type="text" name="items[0][batch_number]" value="BATCH-2026-01" class="w-full py-1.5 px-2 bg-slate-50 border border-slate-200 rounded-lg text-xs font-mono">
                                    </td>
                                    <td class="p-2">
                                        <input type="text" name="items[0][notes]" placeholder="Catatan item..." class="w-full py-1.5 px-2 bg-slate-50 border border-slate-200 rounded-lg text-xs">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </x-card>
            </div>

            <div class="space-y-5">
                <x-card title="Catatan Pengeluaran" icon="notebook" class="p-6">
                    <textarea name="notes" rows="4" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs" placeholder="Keterangan pengeluaran / permintaan unit..."></textarea>
                </x-card>
            </div>
        </div>

        <x-action-bar>
            <a href="{{ route('warehouse.dispatches.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Batal
            </a>
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold rounded-xl shadow-xs transition">
                <i data-lucide="check-circle" class="w-4 h-4"></i> Diproses & Kurangi Stok
            </button>
        </x-action-bar>
    </form>
@endsection
