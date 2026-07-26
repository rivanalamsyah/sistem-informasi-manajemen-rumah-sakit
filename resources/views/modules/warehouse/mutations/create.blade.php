@extends('layouts.admin')

@section('title', 'Form Mutasi Barang')

@section('content')
    <x-page-header
        title="Form Mutasi Barang Antar Gudang"
        subtitle="Pemindahan lokasi stok barang antar gudang utama dan depo."
        :breadcrumb="[
            ['label' => 'Gudang', 'url' => route('warehouse.index')],
            ['label' => 'Mutasi', 'url' => route('warehouse.mutations.index')],
            ['label' => 'Input Mutasi', 'url' => null]
        ]"
    />

    <form method="POST" action="{{ route('warehouse.mutations.store') }}">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-5">
                <x-card title="Dokumen Mutasi Gudang" icon="arrow-left-right" class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <x-form-input name="mutation_date" label="Tanggal Mutasi" type="date" required :value="old('mutation_date', date('Y-m-d'))" />
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Gudang Asal <span class="text-rose-500">*</span></label>
                            <select name="source_warehouse_id" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                @foreach($warehouses as $wh)
                                    <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Gudang Tujuan <span class="text-rose-500">*</span></label>
                            <select name="target_warehouse_id" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                @foreach($warehouses as $wh)
                                    <option value="{{ $wh->id }}" {{ $loop->remaining == 0 ? 'selected' : '' }}>{{ $wh->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </x-card>

                <x-card title="Daftar Barang Dimutasi" icon="package" class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="bg-slate-50 text-slate-600 border-b border-slate-200">
                                    <th class="p-2 font-semibold">Barang Gudang</th>
                                    <th class="p-2 font-semibold w-28">Jumlah Mutasi</th>
                                    <th class="p-2 font-semibold w-36">Batch Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-slate-100">
                                    <td class="p-2">
                                        <select name="items[0][warehouse_item_id]" required class="w-full py-1.5 px-2 bg-slate-50 border border-slate-200 rounded-lg text-xs">
                                            <option value="">-- Pilih Barang --</option>
                                            @foreach($items as $it)
                                                <option value="{{ $it->id }}">{{ $it->code }} — {{ $it->name }} ({{ $it->unit }})</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="p-2">
                                        <input type="number" name="items[0][quantity]" required min="1" value="1" class="w-full py-1.5 px-2 bg-slate-50 border border-slate-200 rounded-lg text-xs">
                                    </td>
                                    <td class="p-2">
                                        <input type="text" name="items[0][batch_number]" value="BATCH-2026-01" class="w-full py-1.5 px-2 bg-slate-50 border border-slate-200 rounded-lg text-xs font-mono">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </x-card>
            </div>

            <div class="space-y-5">
                <x-card title="Catatan Mutasi" icon="notebook" class="p-6">
                    <textarea name="notes" rows="4" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs" placeholder="Keterangan alur mutasi barang..."></textarea>
                </x-card>
            </div>
        </div>

        <x-action-bar>
            <a href="{{ route('warehouse.mutations.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Batal
            </a>
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-xs transition">
                <i data-lucide="check-circle" class="w-4 h-4"></i> Diproses & Pindahkan Stok
            </button>
        </x-action-bar>
    </form>
@endsection
