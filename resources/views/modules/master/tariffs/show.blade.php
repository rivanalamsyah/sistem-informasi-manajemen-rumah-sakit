@extends('layouts.admin')

@section('title', 'Detail Tarif Pelayanan')

@section('content')
    <x-page-header
        title="Detail Tarif: {{ $tariff->service->name ?? '-' }}"
        subtitle="Informasi lengkap tarif tindakan medis untuk kelas pelayanan tertentu."
        :breadcrumb="[
            ['label' => 'Master Data', 'url' => route('master.index')],
            ['label' => 'Tarif Pelayanan', 'url' => route('master.tariffs.index')],
            ['label' => 'Detail', 'url' => null]
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('master.tariffs.edit', $tariff) }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold rounded-xl shadow-sm transition">
                <i data-lucide="pencil" class="w-4 h-4"></i> Edit
            </a>
            <a href="{{ route('master.tariffs.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
            </a>
        </x-slot>
    </x-page-header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <x-card class="p-6">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-100 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="receipt" class="w-7 h-7 text-emerald-600"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">Rp {{ number_format($tariff->amount, 0, ',', '.') }}</h2>
                        <p class="text-xs text-slate-500">{{ $tariff->service->name ?? '-' }} · Kelas {{ $tariff->class }}</p>
                    </div>
                    <x-badge :type="$tariff->is_active ? 'Aktif' : 'Batal'" class="ml-auto">
                        {{ $tariff->is_active ? 'Aktif' : 'Non-Aktif' }}
                    </x-badge>
                </div>
                <dl class="grid grid-cols-2 gap-4 text-xs">
                    <div class="bg-slate-50 rounded-xl p-3">
                        <dt class="text-slate-500 font-medium mb-0.5">Tindakan</dt>
                        <dd class="font-bold text-slate-800">{{ $tariff->service->name ?? '-' }}</dd>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3">
                        <dt class="text-slate-500 font-medium mb-0.5">Kelas Pelayanan</dt>
                        <dd class="font-bold text-indigo-700">{{ $tariff->class }}</dd>
                    </div>
                    <div class="bg-emerald-50 rounded-xl p-3 col-span-2">
                        <dt class="text-emerald-700 font-medium mb-0.5">Harga Tarif</dt>
                        <dd class="font-black text-emerald-600 text-xl">Rp {{ number_format($tariff->amount, 0, ',', '.') }}</dd>
                    </div>
                    @if($tariff->description)
                        <div class="col-span-2 bg-slate-50 rounded-xl p-3">
                            <dt class="text-slate-500 font-medium mb-0.5">Keterangan</dt>
                            <dd class="text-slate-700">{{ $tariff->description }}</dd>
                        </div>
                    @endif
                </dl>
            </x-card>
        </div>
        <div>
            <x-card title="Aksi Cepat" icon="zap" class="p-5">
                <div class="space-y-2">
                    <a href="{{ route('master.tariffs.edit', $tariff) }}"
                       class="flex items-center gap-2 w-full px-3 py-2 text-xs font-semibold text-sky-700 bg-sky-50 hover:bg-sky-100 border border-sky-200 rounded-xl transition">
                        <i data-lucide="pencil" class="w-3.5 h-3.5"></i> Edit Tarif
                    </a>
                    <form action="{{ route('master.tariffs.destroy', $tariff) }}" method="POST"
                          onsubmit="return confirm('Hapus tarif ini?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="flex items-center gap-2 w-full px-3 py-2 text-xs font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded-xl transition">
                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Hapus Tarif
                        </button>
                    </form>
                </div>
            </x-card>
        </div>
    </div>
@endsection
