@extends('layouts.admin')

@section('title', 'Detail Tindakan Medis')

@section('content')
    <x-page-header
        title="{{ $service->name }}"
        subtitle="Detail informasi tindakan medis dan daftar tarif per kelas pelayanan."
        :breadcrumb="[
            ['label' => 'Master Data', 'url' => route('master.index')],
            ['label' => 'Tindakan Medis', 'url' => route('master.services.index')],
            ['label' => $service->code, 'url' => null]
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('master.services.edit', $service) }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold rounded-xl shadow-sm transition">
                <i data-lucide="pencil" class="w-4 h-4"></i> Edit Tindakan
            </a>
            <a href="{{ route('master.services.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
            </a>
        </x-slot>
    </x-page-header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Detail Tindakan --}}
        <div class="lg:col-span-2 space-y-5">
            <x-card class="p-6">
                <div class="flex items-start gap-4 mb-5">
                    <div class="w-14 h-14 rounded-2xl bg-teal-100 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="stethoscope" class="w-7 h-7 text-teal-600"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">{{ $service->name }}</h2>
                        <p class="text-xs text-slate-500">Kode: <span class="font-mono font-bold text-teal-600">{{ $service->code }}</span></p>
                    </div>
                    <div class="ml-auto">
                        <x-badge :type="$service->is_active ? 'Aktif' : 'Batal'">
                            {{ $service->is_active ? 'Aktif' : 'Non-Aktif' }}
                        </x-badge>
                    </div>
                </div>
                <dl class="grid grid-cols-2 gap-4 text-xs">
                    <div class="bg-slate-50 rounded-xl p-3">
                        <dt class="text-slate-500 font-medium mb-0.5">Kategori</dt>
                        <dd class="font-bold text-slate-800">{{ $service->category }}</dd>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3">
                        <dt class="text-slate-500 font-medium mb-0.5">Poliklinik</dt>
                        <dd class="font-bold text-slate-800">{{ $service->department->name ?? 'Semua Poli / Umum' }}</dd>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3">
                        <dt class="text-slate-500 font-medium mb-0.5">Dibuat</dt>
                        <dd class="font-semibold text-slate-700">{{ $service->created_at?->format('d/m/Y H:i') ?? '-' }}</dd>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3">
                        <dt class="text-slate-500 font-medium mb-0.5">Diperbarui</dt>
                        <dd class="font-semibold text-slate-700">{{ $service->updated_at?->format('d/m/Y H:i') ?? '-' }}</dd>
                    </div>
                </dl>
            </x-card>

            {{-- Daftar Tarif --}}
            <x-card title="Daftar Tarif per Kelas Pelayanan" icon="receipt" class="p-6">
                @if($service->tariffs->count())
                    <div class="divide-y divide-slate-100">
                        @foreach($service->tariffs as $tariff)
                            <div class="flex items-center justify-between py-3">
                                <div>
                                    <span class="text-xs font-semibold text-slate-700">{{ $tariff->class }}</span>
                                    @if($tariff->description)
                                        <p class="text-[11px] text-slate-400">{{ $tariff->description }}</p>
                                    @endif
                                </div>
                                <div class="text-right">
                                    <span class="text-sm font-bold text-emerald-600">Rp {{ number_format($tariff->amount, 0, ',', '.') }}</span>
                                    <x-badge :type="$tariff->is_active ? 'Aktif' : 'Batal'" class="ml-2 text-[10px]">
                                        {{ $tariff->is_active ? 'Aktif' : 'Non-Aktif' }}
                                    </x-badge>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <x-empty-state title="Belum Ada Tarif" description="Tindakan ini belum memiliki tarif. Tambahkan di menu Master Tarif." icon="receipt" />
                @endif
            </x-card>
        </div>

        {{-- Sidebar --}}
        <div>
            <x-card title="Aksi Cepat" icon="zap" class="p-5">
                <div class="space-y-2">
                    <a href="{{ route('master.services.edit', $service) }}"
                       class="flex items-center gap-2 w-full px-3 py-2 text-xs font-semibold text-sky-700 bg-sky-50 hover:bg-sky-100 border border-sky-200 rounded-xl transition">
                        <i data-lucide="pencil" class="w-3.5 h-3.5"></i> Edit Data Tindakan
                    </a>
                    <a href="{{ route('master.tariffs.create') }}"
                       class="flex items-center gap-2 w-full px-3 py-2 text-xs font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 border border-emerald-200 rounded-xl transition">
                        <i data-lucide="plus" class="w-3.5 h-3.5"></i> Tambah Tarif Tindakan
                    </a>
                    <form action="{{ route('master.services.destroy', $service) }}" method="POST"
                          onsubmit="return confirm('Hapus tindakan {{ $service->name }}?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="flex items-center gap-2 w-full px-3 py-2 text-xs font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded-xl transition">
                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Hapus Tindakan Ini
                        </button>
                    </form>
                </div>
            </x-card>
        </div>
    </div>
@endsection
