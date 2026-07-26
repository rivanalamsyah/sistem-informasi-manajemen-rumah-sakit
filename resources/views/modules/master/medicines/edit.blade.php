@extends('layouts.admin')

@section('title', 'Edit Obat: ' . $medicine->name)

@section('content')
    <x-page-header 
        title="Edit Obat: {{ $medicine->name }}" 
        subtitle="Perbarui rincian obat atau alat kesehatan."
        :breadcrumb="[
            ['label' => 'Master Data', 'url' => route('master.index')],
            ['label' => 'Obat & Alkes', 'url' => route('master.medicines.index')],
            ['label' => 'Edit Obat', 'url' => null]
        ]"
    />

    <div class="max-w-4xl">
        <x-card class="p-6">
            <form method="POST" action="{{ route('master.medicines.update', $medicine) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 sm:col-span-4">
                        <x-form-input name="code" label="Kode Obat" required :value="$medicine->code" />
                    </div>
                    <div class="col-span-12 sm:col-span-8">
                        <x-form-input name="name" label="Nama Obat / Alkes" required :value="$medicine->name" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <x-form-input name="generic_name" label="Nama Generik / Zat Aktif" :value="$medicine->generic_name" />
                    <x-form-select name="category_id" label="Kategori Obat" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $medicine->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </x-form-select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <x-form-input name="unit" label="Satuan Kemasan" required :value="$medicine->unit" />
                    <x-form-select name="type" label="Golongan Obat" required>
                        @foreach(['Bebas', 'Bebas Terbatas', 'Keras', 'Narkotika', 'Psikotropika', 'Alkes'] as $t)
                            <option value="{{ $t }}" {{ old('type', $medicine->type) == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </x-form-select>
                    <x-form-input name="min_stock" label="Stok Minimal Alert" type="number" required :value="$medicine->min_stock" min="0" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <x-form-input name="purchase_price" label="Harga Beli / HPP (Rp)" type="number" required :value="$medicine->purchase_price" min="0" step="100" />
                    <x-form-input name="selling_price" label="Harga Jual ke Pasien (Rp)" type="number" required :value="$medicine->selling_price" min="0" step="100" />
                </div>

                <x-action-bar :cancelUrl="route('master.medicines.index')" saveLabel="Perbarui Data Obat" />
            </form>
        </x-card>
    </div>
@endsection
