@extends('layouts.admin')

@section('title', 'Detail Tempat Tidur (Bed)')

@section('content')
    <x-page-header
        title="Detail Bed: {{ $bed->bed_number }}"
        subtitle="Informasi status, ruangan, dan riwayat penggunaan tempat tidur rawat inap."
        :breadcrumb="[
            ['label' => 'Master Data', 'url' => route('master.index')],
            ['label' => 'Tempat Tidur', 'url' => route('master.beds.index')],
            ['label' => $bed->bed_number, 'url' => null]
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('master.beds.edit', $bed) }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold rounded-xl shadow-sm transition">
                <i data-lucide="pencil" class="w-4 h-4"></i> Edit Bed
            </a>
            <a href="{{ route('master.beds.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
            </a>
        </x-slot>
    </x-page-header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-5">
            <x-card class="p-6">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-teal-100 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="bed" class="w-7 h-7 text-teal-600"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">Bed {{ $bed->bed_number }}</h2>
                        <p class="text-xs text-slate-500">{{ $bed->room->name ?? '-' }} (Gedung {{ $bed->room->building ?? '-' }}, Lt. {{ $bed->room->floor ?? '-' }})</p>
                    </div>
                    <x-badge :type="$bed->status" class="ml-auto">{{ $bed->status }}</x-badge>
                </div>
                <dl class="grid grid-cols-2 gap-4 text-xs">
                    <div class="bg-slate-50 rounded-xl p-3">
                        <dt class="text-slate-500 font-medium mb-0.5">Kelas Perawatan</dt>
                        <dd class="font-bold text-indigo-700">{{ $bed->class }}</dd>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3">
                        <dt class="text-slate-500 font-medium mb-0.5">Tarif per Malam</dt>
                        <dd class="font-bold text-emerald-600 text-sm">Rp {{ number_format($bed->price_per_night, 0, ',', '.') }}</dd>
                    </div>
                </dl>
            </x-card>
        </div>

        <div>
            <x-card title="Aksi Cepat" icon="zap" class="p-5">
                <div class="space-y-2">
                    <a href="{{ route('master.beds.edit', $bed) }}"
                       class="flex items-center gap-2 w-full px-3 py-2 text-xs font-semibold text-sky-700 bg-sky-50 hover:bg-sky-100 border border-sky-200 rounded-xl transition">
                        <i data-lucide="pencil" class="w-3.5 h-3.5"></i> Edit Status & Tarif Bed
                    </a>
                    <form action="{{ route('master.beds.destroy', $bed) }}" method="POST"
                          onsubmit="return confirm('Hapus bed ini?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="flex items-center gap-2 w-full px-3 py-2 text-xs font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded-xl transition">
                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Hapus Bed Ini
                        </button>
                    </form>
                </div>
            </x-card>
        </div>
    </div>
@endsection
