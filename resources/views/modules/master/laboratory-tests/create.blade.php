@extends('layouts.admin')

@section('title', 'Tambah Pemeriksaan Lab')

@section('content')
    <x-page-header
        title="Tambah Pemeriksaan Lab Baru"
        subtitle="Daftarkan item pengujian laboratorium beserta nilai rujukan normalnya."
        :breadcrumb="[
            ['label' => 'Master Data', 'url' => route('master.index')],
            ['label' => 'Pemeriksaan Lab', 'url' => route('master.laboratory-tests.index')],
            ['label' => 'Tambah Tes', 'url' => null]
        ]"
    />

    <form method="POST" action="{{ route('master.laboratory-tests.store') }}">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-5">
                <x-card title="Informasi Item Pemeriksaan" icon="flask-conical" class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <x-form-input name="code" label="Kode Pemeriksaan" placeholder="Contoh: LAB-HEM-01" required :value="old('code')" />
                        <x-form-input name="name" label="Nama Pemeriksaan" placeholder="Contoh: Hemoglobin (Hb)" required :value="old('name')" />
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kategori Lab <span class="text-rose-500">*</span></label>
                            <select name="category" required
                                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach(['Hematologi','Kimia Darah','Urinalisis','Imunoserologi','Mikrobiologi','Patologi Anatomi'] as $cat)
                                    <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-form-input name="unit" label="Satuan Pengukuran" placeholder="Contoh: g/dL, mg/dL, /uL" :value="old('unit')" />
                        <x-form-input name="reference_range_male" label="Nilai Rujukan Pria" placeholder="Contoh: 13.0 - 17.0" :value="old('reference_range_male')" />
                        <x-form-input name="reference_range_female" label="Nilai Rujukan Wanita" placeholder="Contoh: 12.0 - 15.0" :value="old('reference_range_female')" />
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Harga Tes Lab (Rp) <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-xs text-slate-500">Rp</span>
                                <input type="number" name="price" required min="0" step="1000"
                                       value="{{ old('price') }}"
                                       class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                            </div>
                        </div>
                    </div>
                </x-card>
            </div>
            <div>
                <x-card title="Status Item" icon="toggle-right" class="p-6">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <div class="relative">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer"
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-slate-200 peer-checked:bg-teal-500 rounded-full transition-colors"></div>
                            <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></div>
                        </div>
                        <span class="text-xs font-semibold text-slate-800">Aktifkan Tes Lab</span>
                    </label>
                </x-card>
            </div>
        </div>

        <x-action-bar>
            <a href="{{ route('master.laboratory-tests.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl shadow-sm transition">
                <i data-lucide="save" class="w-4 h-4"></i> Simpan Tes Lab
            </button>
        </x-action-bar>
    </form>
@endsection
