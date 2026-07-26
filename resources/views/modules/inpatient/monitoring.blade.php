@extends('layouts.admin')

@section('title', 'Bed Monitoring & Okupansi Kamar')

@section('content')
    <x-page-header
        title="Real-Time Bed Monitoring & Status Kamar"
        subtitle="Visualisasi ketersediaan tempat tidur (Kosong, Terisi, Dibersihkan, & Pemeliharaan) per bangsal."
        :breadcrumb="[
            ['label' => 'Rawat Inap', 'url' => route('inpatients.index')],
            ['label' => 'Bed Monitoring', 'url' => null]
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('inpatients.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar Pasien
            </a>
        </x-slot>
    </x-page-header>

    <!-- Summary Indicators Grid -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        <x-card class="p-4 text-center">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Total Bed RS</span>
            <h3 class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($metrics['totalBeds']) }}</h3>
            <span class="text-[11px] text-slate-500 mt-0.5 block">{{ $metrics['totalRooms'] }} Ruangan</span>
        </x-card>
        <x-card class="p-4 text-center">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Bed Kosong (Tersedia)</span>
            <h3 class="text-2xl font-bold text-emerald-600 mt-1">{{ number_format($metrics['emptyBeds']) }}</h3>
            <span class="text-[11px] text-emerald-600 mt-0.5 block">Siap Digunakan</span>
        </x-card>
        <x-card class="p-4 text-center">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Bed Terisi (Opname)</span>
            <h3 class="text-2xl font-bold text-amber-600 mt-1">{{ number_format($metrics['occupiedBeds']) }}</h3>
            <span class="text-[11px] text-amber-600 mt-0.5 block">Sedang Dirawat</span>
        </x-card>
        <x-card class="p-4 text-center">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Tingkat Okupansi (BOR)</span>
            <h3 class="text-2xl font-bold text-teal-600 mt-1">{{ $metrics['bor'] }}%</h3>
            <span class="text-[11px] text-teal-600 mt-0.5 block">Bed Occupancy Rate</span>
        </x-card>
    </div>

    <!-- Room Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($rooms as $rm)
            <x-card class="p-5 flex flex-col justify-between">
                <div>
                    <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
                        <div>
                            <h3 class="font-bold text-slate-900 text-sm">{{ $rm->name }}</h3>
                            <span class="text-[11px] text-slate-500">Gedung {{ $rm->building }} (Lt.{{ $rm->floor }}) — {{ $rm->room_type }}</span>
                        </div>
                        <span class="px-2.5 py-1 rounded-full bg-slate-100 border border-slate-200 text-slate-700 font-bold text-xs">{{ $rm->beds->count() }} Bed</span>
                    </div>

                    <div class="grid grid-cols-3 gap-2">
                        @forelse($rm->beds as $bd)
                            @php
                                $statusStyle = match($bd->status) {
                                    'Kosong' => 'bg-emerald-50 text-emerald-700 border-emerald-200/80',
                                    'Terisi' => 'bg-amber-50 text-amber-800 border-amber-200/80',
                                    'Dibersihkan' => 'bg-sky-50 text-sky-700 border-sky-200/80',
                                    'Pemeliharaan' => 'bg-rose-50 text-rose-700 border-rose-200/80',
                                    default => 'bg-slate-100 text-slate-700 border-slate-200',
                                };
                            @endphp
                            <div class="p-2.5 rounded-xl border text-center {{ $statusStyle }}">
                                <div class="font-bold text-xs">Bed {{ $bd->bed_number }}</div>
                                <span class="text-[10px] block truncate font-medium mt-0.5">{{ $bd->class }}</span>
                                <span class="text-[10px] font-bold block mt-1 uppercase tracking-wider">{{ $bd->status }}</span>
                            </div>
                        @empty
                            <div class="col-span-3 text-center text-slate-400 text-xs py-3">Belum ada bed terdaftar di ruangan ini.</div>
                        @endforelse
                    </div>
                </div>
            </x-card>
        @endforeach
    </div>
@endsection
