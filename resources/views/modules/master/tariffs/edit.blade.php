@extends('layouts.admin')

@section('title', 'Edit Tarif Pelayanan')

@section('content')
    <x-page-header
        title="Edit Tarif: {{ $tariff->service->name ?? '-' }}"
        subtitle="Perbarui harga tarif tindakan medis berdasarkan kelas perawatan."
        :breadcrumb="[
            ['label' => 'Master Data', 'url' => route('master.index')],
            ['label' => 'Tarif Pelayanan', 'url' => route('master.tariffs.index')],
            ['label' => 'Edit', 'url' => null]
        ]"
    />

    <form method="POST" action="{{ route('master.tariffs.update', $tariff) }}">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <x-card title="Informasi Tarif Tindakan" icon="receipt" class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tindakan Medis <span class="text-rose-500">*</span></label>
                            <select name="service_id" required
                                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                                @foreach($services as $svc)
                                    <option value="{{ $svc->id }}" {{ old('service_id', $tariff->service_id) == $svc->id ? 'selected' : '' }}>
                                        {{ $svc->code }} — {{ $svc->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kelas Pelayanan <span class="text-rose-500">*</span></label>
                            <select name="class" required
                                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                                @foreach(['Umum','VVIP','VIP','Kelas 1','Kelas 2','Kelas 3'] as $cls)
                                    <option value="{{ $cls }}" {{ old('class', $tariff->class) == $cls ? 'selected' : '' }}>{{ $cls }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Harga Tarif (Rp) <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-xs text-slate-500">Rp</span>
                                <input type="number" name="amount" required min="0" step="100"
                                       value="{{ old('amount', $tariff->amount) }}"
                                       class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <x-form-input name="description" label="Keterangan (opsional)"
                                :value="old('description', $tariff->description)" />
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
                                   {{ old('is_active', $tariff->is_active) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-slate-200 peer-checked:bg-teal-500 rounded-full transition-colors"></div>
                            <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></div>
                        </div>
                        <span class="text-xs font-semibold text-slate-800">Aktifkan Tarif</span>
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
                <i data-lucide="save" class="w-4 h-4"></i> Simpan Perubahan
            </button>
        </x-action-bar>
    </form>
@endsection
