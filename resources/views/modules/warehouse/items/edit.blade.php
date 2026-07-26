@extends('layouts.admin')

@section('title', 'Edit Barang Gudang')

@section('content')
    <x-page-header
        title="Edit Barang: {{ $item->name }}"
        subtitle="Perbarui data spesifikasi, min/max stock, atau harga barang gudang."
        :breadcrumb="[
            ['label' => 'Gudang', 'url' => route('warehouse.index')],
            ['label' => 'Master Barang', 'url' => route('warehouse.items.index')],
            ['label' => 'Edit', 'url' => null]
        ]"
    />

    <form method="POST" action="{{ route('warehouse.items.update', $item) }}">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-5">
                <x-card title="Spesifikasi & Identitas Barang" icon="package" class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <x-form-input name="code" label="Kode Barang" required :value="old('code', $item->code)" />
                        <x-form-input name="barcode" label="Barcode EAN/UPC" :value="old('barcode', $item->barcode)" />
                        <div class="sm:col-span-2">
                            <x-form-input name="name" label="Nama Barang Gudang" required :value="old('name', $item->name)" />
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kategori Barang <span class="text-rose-500">*</span></label>
                            <select name="category" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                                @foreach(['Alat Kesehatan / BMHP','Bahan Medis Habis Pakai','Alat Perlindungan Diri','Desinfektan & Antiseptik','Obat & Farmasi','Umum'] as $cat)
                                    <option value="{{ $cat }}" {{ old('category', $item->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Satuan Barang <span class="text-rose-500">*</span></label>
                            <select name="unit" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                                @foreach(['Pcs','Box','Botol','Ampul','Vial','Tube','Packs','Roll','Set'] as $u)
                                    <option value="{{ $u }}" {{ old('unit', $item->unit) == $u ? 'selected' : '' }}>{{ $u }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Supplier Utama</label>
                            <select name="supplier_id" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                                <option value="">-- Pilih Supplier --</option>
                                @foreach($suppliers as $sup)
                                    <option value="{{ $sup->id }}" {{ old('supplier_id', $item->supplier_id) == $sup->id ? 'selected' : '' }}>{{ $sup->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Link ke Obat Farmasi</label>
                            <select name="medicine_id" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                                <option value="">-- Tidak Terhubung --</option>
                                @foreach($medicines as $med)
                                    <option value="{{ $med->id }}" {{ old('medicine_id', $item->medicine_id) == $med->id ? 'selected' : '' }}>{{ $med->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </x-card>

                <x-card title="Batas Stok & Penentuan Harga" icon="sliders" class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <x-form-input name="min_stock" label="Stok Minimum" type="number" required min="0" :value="old('min_stock', $item->min_stock)" />
                        <x-form-input name="max_stock" label="Stok Maksimum" type="number" required min="1" :value="old('max_stock', $item->max_stock)" />
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Harga Beli HPP (Rp) <span class="text-rose-500">*</span></label>
                            <input type="number" name="purchase_price" required min="0" step="500" value="{{ old('purchase_price', $item->purchase_price) }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Harga Jual / Tarif (Rp) <span class="text-rose-500">*</span></label>
                            <input type="number" name="sell_price" required min="0" step="500" value="{{ old('sell_price', $item->sell_price) }}" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>
                    </div>
                </x-card>
            </div>

            <div class="space-y-5">
                <x-card title="Status Keaktifan" icon="toggle-right" class="p-6">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <div class="relative">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', $item->is_active) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-slate-200 peer-checked:bg-teal-500 rounded-full transition-colors"></div>
                            <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></div>
                        </div>
                        <span class="text-xs font-semibold text-slate-800">Aktifkan Barang Gudang</span>
                    </label>
                </x-card>
            </div>
        </div>

        <x-action-bar>
            <a href="{{ route('warehouse.items.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Batal
            </a>
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl shadow-xs transition">
                <i data-lucide="save" class="w-4 h-4"></i> Simpan Perubahan
            </button>
        </x-action-bar>
    </form>
@endsection
