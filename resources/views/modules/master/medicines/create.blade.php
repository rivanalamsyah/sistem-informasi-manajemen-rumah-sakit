@extends('layouts.admin')

@section('title', 'Tambah Katalog Obat Baru')

@section('content')
    <x-page-header 
        title="Tambah Katalog Obat Baru" 
        subtitle="Masukkan rincian item obat atau alat kesehatan baru."
        :breadcrumb="[
            ['label' => 'Master Data', 'url' => route('master.index')],
            ['label' => 'Obat & Alkes', 'url' => route('master.medicines.index')],
            ['label' => 'Tambah Obat', 'url' => null]
        ]"
    />

    <div class="max-w-4xl">
        <x-card class="p-6">
            <form method="POST" action="{{ route('master.medicines.store') }}" class="space-y-4">
                @csrf

                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 sm:col-span-4">
                        <x-form-input name="code" label="Kode Obat" required placeholder="OBT-0001" />
                    </div>
                    <div class="col-span-12 sm:col-span-8">
                        <x-form-input name="name" label="Nama Obat / Alkes" required placeholder="Paracetamol 500mg Tablet" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <x-form-input name="generic_name" label="Nama Generik / Zat Aktif" placeholder="Paracetamol" />
                    <x-form-select name="category_id" label="Kategori Obat" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </x-form-select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <x-form-input name="unit" label="Satuan Kemasan" required value="Tablet" placeholder="Tablet/Botol/Ampul" />
                    <x-form-select name="type" label="Golongan Obat" required>
                        @foreach(['Bebas', 'Bebas Terbatas', 'Keras', 'Narkotika', 'Psikotropika', 'Alkes'] as $t)
                            <option value="{{ $t }}" {{ old('type') == $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </x-form-select>
                    <x-form-input name="min_stock" label="Stok Minimal Alert" type="number" required value="10" min="0" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <x-form-input name="purchase_price" label="Harga Beli / HPP (Rp)" type="number" required value="0" min="0" step="100" />
                    <x-form-input name="selling_price" label="Harga Jual ke Pasien (Rp)" type="number" required value="0" min="0" step="100" />
                </div>

                <x-action-bar :cancelUrl="route('master.medicines.index')" saveLabel="Simpan Katalog Obat" />
            </form>
        </x-card>
    </div>
@endsection
