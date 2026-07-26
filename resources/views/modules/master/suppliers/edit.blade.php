@extends('layouts.admin')

@section('title', 'Edit Supplier')

@section('content')
    <x-page-header
        title="Edit Supplier: {{ $supplier->name }}"
        subtitle="Perbarui data distributor atau PBF pemasok obat dan alkes."
        :breadcrumb="[
            ['label' => 'Master Data', 'url' => route('master.index')],
            ['label' => 'Supplier', 'url' => route('master.suppliers.index')],
            ['label' => 'Edit', 'url' => null]
        ]"
    />

    <form method="POST" action="{{ route('master.suppliers.update', $supplier) }}">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-5">
                <x-card title="Identitas Supplier / PBF" icon="building-2" class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <x-form-input name="code" label="Kode Supplier" required :value="old('code', $supplier->code)" />
                        <x-form-input name="name" label="Nama Perusahaan / PBF" required :value="old('name', $supplier->name)" />
                        <x-form-input name="contact_name" label="Nama PIC / Kontak Person" :value="old('contact_name', $supplier->contact_name)" />
                        <x-form-input name="phone" label="Nomor Telepon" required :value="old('phone', $supplier->phone)" />
                        <x-form-input name="email" label="Alamat Email" type="email" :value="old('email', $supplier->email)" />
                    </div>
                </x-card>
                <x-card title="Alamat Perusahaan" icon="map-pin" class="p-6">
                    <textarea name="address" rows="3"
                              class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">{{ old('address', $supplier->address) }}</textarea>
                </x-card>
            </div>
            <div class="space-y-5">
                <x-card title="Status Supplier" icon="toggle-right" class="p-6">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <div class="relative">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer"
                                   {{ old('is_active', $supplier->is_active) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-slate-200 peer-checked:bg-teal-500 rounded-full transition-colors"></div>
                            <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></div>
                        </div>
                        <span class="text-xs font-semibold text-slate-800">Aktifkan Supplier</span>
                    </label>
                </x-card>
                <x-card class="p-4 bg-slate-50">
                    <p class="text-[11px] text-slate-500">Dibuat: {{ $supplier->created_at?->format('d/m/Y H:i') ?? '-' }}</p>
                    <p class="text-[11px] text-slate-500">Diperbarui: {{ $supplier->updated_at?->format('d/m/Y H:i') ?? '-' }}</p>
                </x-card>
            </div>
        </div>

        <x-action-bar>
            <a href="{{ route('master.suppliers.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl shadow-sm transition">
                <i data-lucide="save" class="w-4 h-4"></i> Simpan Perubahan
            </button>
        </x-action-bar>
    </form>
@endsection
