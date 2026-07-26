@extends('layouts.admin')

@section('title', 'Tambah Tarif Pelayanan')

@section('content')
    <x-page-header
        title="Tambah Tarif Pelayanan"
        subtitle="Tambahkan tarif harga tindakan medis berdasarkan kelas pelayanan."
        :breadcrumb="[
            ['label' => 'Master Data', 'url' => route('master.index')],
            ['label' => 'Tarif Pelayanan', 'url' => route('master.tariffs.index')],
            ['label' => 'Tambah Tarif', 'url' => null]
        ]"
    />

    <form method="POST" action="{{ route('master.tariffs.store') }}">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <x-card title="Informasi Tarif Tindakan" icon="receipt" class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tindakan Medis <span class="text-rose-500">*</span></label>
                            <select name="service_id" required
                                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500 @error('service_id') border-rose-400 @enderror">
                                <option value="">-- Pilih Tindakan / Prosedur --</option>
                                @foreach($services as $svc)
                                    <option value="{{ $svc->id }}" {{ old('service_id') == $svc->id ? 'selected' : '' }}>
                                        {{ $svc->code }} — {{ $svc->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('service_id') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kelas Pelayanan <span class="text-rose-500">*</span></label>
                            <select name="class" required
                                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500 @error('class') border-rose-400 @enderror">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach(['Umum','VVIP','VIP','Kelas 1','Kelas 2','Kelas 3'] as $cls)
                                    <option value="{{ $cls }}" {{ old('class') == $cls ? 'selected' : '' }}>{{ $cls }}</option>
                                @endforeach
                            </select>
                            @error('class') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Harga Tarif (Rp) <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-xs text-slate-500">Rp</span>
                                <input type="number" name="amount" required min="0" step="100"
                                       value="{{ old('amount') }}"
                                       class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500 @error('amount') border-rose-400 @enderror"
                                       placeholder="0">
                            </div>
                            @error('amount') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <x-form-input name="description" label="Keterangan / Catatan (opsional)"
                                placeholder="Contoh: Termasuk jasa dokter dan bahan habis pakai" :value="old('description')" />
                        </div>
                    </div>
                </x-card>
            </div>

            <div class="space-y-5">
                <x-card title="Status Tarif" icon="toggle-right" class="p-6">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <div class="relative">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer"
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-slate-200 peer-checked:bg-teal-500 rounded-full transition-colors"></div>
                            <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></div>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-slate-800">Aktifkan Tarif</span>
                            <p class="text-[11px] text-slate-500">Tarif aktif digunakan di billing</p>
                        </div>
                    </label>
                </x-card>
            </div>
        </div>

        <x-action-bar>
            <a href="{{ route('master.tariffs.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl shadow-sm transition">
                <i data-lucide="save" class="w-4 h-4"></i> Simpan Tarif
            </button>
        </x-action-bar>
    </form>
@endsection
