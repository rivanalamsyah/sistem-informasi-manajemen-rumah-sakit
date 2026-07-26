@extends('layouts.admin')

@section('title', 'Form Penerimaan Barang')

@section('content')
    <x-page-header
        title="Form Penerimaan Barang (PO Inbound)"
        subtitle="Input barang masuk dari supplier ke gudang logistik/farmasi."
        :breadcrumb="[
            ['label' => 'Gudang', 'url' => route('warehouse.index')],
            ['label' => 'Penerimaan', 'url' => route('warehouse.receipts.index')],
            ['label' => 'Input Penerimaan', 'url' => null]
        ]"
    />

    <form method="POST" action="{{ route('warehouse.receipts.store') }}" id="receiptForm">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-5">
                <x-card title="Dokumen Faktur & Supplier" icon="file-text" class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <x-form-input name="receipt_date" label="Tanggal Penerimaan" type="date" required :value="old('receipt_date', date('Y-m-d'))" />
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Gudang Tujuan <span class="text-rose-500">*</span></label>
                            <select name="warehouse_id" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                                @foreach($warehouses as $wh)
                                    <option value="{{ $wh->id }}">{{ $wh->name }} ({{ $wh->code }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Supplier PBF</label>
                            <select name="supplier_id" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                                <option value="">-- Tanpa Supplier --</option>
                                @foreach($suppliers as $sup)
                                    <option value="{{ $sup->id }}">{{ $sup->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-form-input name="invoice_number" label="Nomor Faktur / Surat Jalan" placeholder="Contoh: FK-2026/07/0091" :value="old('invoice_number')" />
                    </div>
                </x-card>

                {{-- Dynamic Items Table --}}
                <x-card title="Daftar Barang Diterima" icon="package" class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="bg-slate-50 text-slate-600 border-b border-slate-200">
                                    <th class="p-2 font-semibold">Barang Gudang</th>
                                    <th class="p-2 font-semibold w-24">Jumlah</th>
                                    <th class="p-2 font-semibold w-32">Harga Beli</th>
                                    <th class="p-2 font-semibold w-32">Batch No</th>
                                    <th class="p-2 font-semibold w-32">Expired Date</th>
                                </tr>
                            </thead>
                            <tbody id="itemsTableBody">
                                <tr class="item-row border-b border-slate-100">
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
                                        <input type="number" name="items[0][purchase_price]" required min="0" step="500" value="0" class="w-full py-1.5 px-2 bg-slate-50 border border-slate-200 rounded-lg text-xs">
                                    </td>
                                    <td class="p-2">
                                        <input type="text" name="items[0][batch_number]" required value="BATCH-{{ date('Ym') }}" class="w-full py-1.5 px-2 bg-slate-50 border border-slate-200 rounded-lg text-xs font-mono">
                                    </td>
                                    <td class="p-2">
                                        <input type="date" name="items[0][expired_date]" class="w-full py-1.5 px-2 bg-slate-50 border border-slate-200 rounded-lg text-xs">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </x-card>
            </div>

            <div class="space-y-5">
                <x-card title="Catatan Dokumen" icon="notebook" class="p-6">
                    <textarea name="notes" rows="4" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs" placeholder="Keterangan tambahan penerimaan..."></textarea>
                </x-card>
            </div>
        </div>

        <x-action-bar>
            <a href="{{ route('warehouse.receipts.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Batal
            </a>
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl shadow-xs transition">
                <i data-lucide="check-circle" class="w-4 h-4"></i> Diproses & Tambah Stok
            </button>
        </x-action-bar>
    </form>
@endsection
