@extends('layouts.admin')

@section('title', 'Pelayanan Rawat Inap & Bed Management')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <x-breadcrumb :items="[['label' => 'Rawat Inap', 'url' => null]]" />
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Manajemen Pelayanan Rawat Inap & Bed</h1>
            <p class="text-xs text-slate-500 mt-0.5">Pusat kontrol admisi opname, alokasi tempat tidur, transfer bangsal, & pemulangan pasien.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('inpatients.monitoring') }}" class="inline-flex items-center gap-2 px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="monitor" class="w-4 h-4 text-teal-600"></i> Bed Monitoring
            </a>
            <a href="{{ route('inpatients.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold rounded-xl shadow-sm transition">
                <i data-lucide="log-in" class="w-4 h-4"></i> Admisi Pasien Masuk
            </a>
        </div>
    </div>

    <!-- Summary Metrics Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
        <x-card class="p-4">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Pasien Opname Aktif</span>
            <h2 class="text-2xl font-bold text-teal-600 mt-1">{{ number_format($metrics['activePatients']) }}</h2>
            <span class="text-[11px] text-slate-500 mt-0.5 block">Sedang Dirawat</span>
        </x-card>
        <x-card class="p-4">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Masuk Hari Ini</span>
            <h2 class="text-2xl font-bold text-indigo-600 mt-1">{{ number_format($metrics['admittedToday']) }}</h2>
            <span class="text-[11px] text-indigo-600 mt-0.5 block">Admisi Baru</span>
        </x-card>
        <x-card class="p-4">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Pulang Hari Ini</span>
            <h2 class="text-2xl font-bold text-emerald-600 mt-1">{{ number_format($metrics['dischargedToday']) }}</h2>
            <span class="text-[11px] text-emerald-600 mt-0.5 block">Discharge Medis</span>
        </x-card>
        <x-card class="p-4">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Total Bed RS</span>
            <h2 class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($metrics['totalBeds']) }}</h2>
            <span class="text-[11px] text-slate-500 mt-0.5 block">{{ $metrics['totalRooms'] }} Ruangan</span>
        </x-card>
        <x-card class="p-4">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Bed Occupancy (BOR)</span>
            <h2 class="text-2xl font-bold text-amber-600 mt-1">{{ $metrics['bor'] }}%</h2>
            <span class="text-[11px] text-amber-600 mt-0.5 block">{{ $metrics['occupiedBeds'] }} Terisi / {{ $metrics['emptyBeds'] }} Kosong</span>
        </x-card>
    </div>

    <!-- Filter Bar -->
    <x-card class="p-4 mb-6">
        <form method="GET" action="{{ route('inpatients.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-4 lg:col-span-3">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>
                    <input type="text" name="search" class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white" placeholder="No. Reg / RM / Nama Pasien..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="sm:col-span-3 lg:col-span-3">
                <select name="room_id" class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white">
                    <option value="">-- Semua Ruangan / Bangsal --</option>
                    @foreach($rooms as $rm)
                        <option value="{{ $rm->id }}" {{ request('room_id') == $rm->id ? 'selected' : '' }}>{{ $rm->name }} ({{ $rm->building }})</option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-3 lg:col-span-3">
                <select name="doctor_id" class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white">
                    <option value="">-- Semua Dokter DPJP --</option>
                    @foreach($doctors as $doc)
                        <option value="{{ $doc->id }}" {{ request('doctor_id') == $doc->id ? 'selected' : '' }}>{{ $doc->full_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-2 lg:col-span-3 flex gap-2">
                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-semibold hover:bg-teal-700 transition flex items-center gap-1.5"><i data-lucide="filter" class="w-3.5 h-3.5"></i> Filter</button>
                <a href="{{ route('inpatients.index') }}" class="px-3.5 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold border border-slate-200 hover:bg-slate-200 transition">Reset</a>
            </div>
        </form>
    </x-card>

    <!-- Table Pasien Rawat Inap -->
    <x-table :headers="['No. Reg & Masuk', 'No. RM / Nama Pasien', 'Ruangan & Bed', 'Kelas', 'Dokter DPJP', 'Lama Dirawat', 'Status', 'Aksi']">
        @forelse($visits as $vst)
            @php
                $days = $vst->admission_date ? (int) $vst->admission_date->diffInDays($vst->discharge_date ?? now()) : 0;
                if ($days == 0) $days = 1;
            @endphp
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-4">
                    <div class="font-bold text-teal-600 text-xs">{{ $vst->registration->registration_number ?? '-' }}</div>
                    <span class="text-[11px] text-slate-400">{{ $vst->admission_date ? $vst->admission_date->format('d/m/Y H:i') : '-' }}</span>
                </td>
                <td class="px-6 py-4">
                    <div class="font-semibold text-slate-800 text-xs">{{ $vst->registration->patient->name ?? '-' }}</div>
                    <span class="text-[11px] text-slate-400 font-mono">{{ $vst->registration->patient->mr_number ?? '-' }} ({{ $vst->registration->patient->gender ?? '-' }})</span>
                </td>
                <td class="px-6 py-4">
                    <div class="font-bold text-slate-800 text-xs">{{ $vst->bed->room->name ?? '-' }}</div>
                    <span class="text-[10px] font-semibold text-slate-600 bg-slate-100 border border-slate-200 px-2 py-0.5 rounded">Bed {{ $vst->bed->bed_number ?? '-' }}</span>
                </td>
                <td class="px-6 py-4">
                    <span class="text-[10px] font-bold text-indigo-700 bg-indigo-50 border border-indigo-200/60 px-2.5 py-0.5 rounded-full">{{ $vst->bed->class ?? 'Umum' }}</span>
                </td>
                <td class="text-xs text-slate-700 px-6 py-4">{{ $vst->doctor->name ?? '-' }}</td>
                <td class="px-6 py-4">
                    <span class="text-xs font-semibold text-teal-600 flex items-center gap-1"><i data-lucide="clock" class="w-3.5 h-3.5"></i> {{ $days }} Hari</span>
                </td>
                <td class="px-6 py-4">
                    <x-badge :type="$vst->status">{{ $vst->status }}</x-badge>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-1.5">
                        <a href="{{ route('inpatients.show', $vst) }}" class="p-1.5 text-slate-500 hover:text-teal-600 hover:bg-slate-100 rounded-lg transition" title="Detail Opname">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </a>
                        @if ($vst->status === 'Aktif')
                            <a href="{{ route('inpatients.edit', $vst) }}" class="p-1.5 text-slate-500 hover:text-amber-600 hover:bg-slate-100 rounded-lg transition" title="Pindah Bed / Ruangan">
                                <i data-lucide="arrow-left-right" class="w-4 h-4"></i>
                            </a>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8">
                    <x-empty-state title="Belum Ada Pasien Rawat Inap" description="Tidak ditemukan pasien opname aktif untuk kriteria filter ini." />
                </td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-4">
        {{ $visits->links() }}
    </div>
@endsection
