@extends('layouts.admin')

@section('title', 'Pelayanan Rawat Jalan (Poliklinik)')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <x-breadcrumb :items="[['label' => 'Rawat Jalan (Poli)', 'url' => null]]" />
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Manajemen Antrean & Kunjungan Rawat Jalan</h1>
            <p class="text-xs text-slate-500 mt-0.5">Pemanggilan pasien antrean poliklinik, pencatatan TTV (Vital Signs), & pemeriksaan dokter.</p>
        </div>
    </div>

    <!-- Summary Metrics Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <x-card class="p-5">
            <span class="text-xs font-medium text-slate-500 uppercase tracking-wider">Total Kunjungan Poli</span>
            <h2 class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($metrics['totalVisitsToday']) }}</h2>
            <span class="text-[11px] text-slate-500 mt-1 block">Pasien Hari Ini</span>
        </x-card>
        <x-card class="p-5">
            <span class="text-xs font-medium text-slate-500 uppercase tracking-wider">Pasien Menunggu</span>
            <h2 class="text-2xl font-bold text-amber-600 mt-1">{{ number_format($metrics['waitingPatients']) }}</h2>
            <span class="text-[11px] text-amber-600 flex items-center gap-1 mt-1"><i data-lucide="clock" class="w-3 h-3"></i> Dalam Antrean</span>
        </x-card>
        <x-card class="p-5">
            <span class="text-xs font-medium text-slate-500 uppercase tracking-wider">Sedang Diperiksa</span>
            <h2 class="text-2xl font-bold text-sky-600 mt-1">{{ number_format($metrics['examiningPatients']) }}</h2>
            <span class="text-[11px] text-sky-600 flex items-center gap-1 mt-1"><i data-lucide="stethoscope" class="w-3 h-3"></i> Konsultasi Dokter</span>
        </x-card>
        <x-card class="p-5">
            <span class="text-xs font-medium text-slate-500 uppercase tracking-wider">Selesai Diperiksa</span>
            <h2 class="text-2xl font-bold text-emerald-600 mt-1">{{ number_format($metrics['completedPatients']) }}</h2>
            <span class="text-[11px] text-emerald-600 flex items-center gap-1 mt-1"><i data-lucide="check-circle" class="w-3 h-3"></i> Pemeriksaan Selesai</span>
        </x-card>
    </div>

    <!-- Filter Bar -->
    <x-card class="p-4 mb-6">
        <form method="GET" action="{{ route('outpatients.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-4 lg:col-span-3">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>
                    <input type="text" name="search" class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white" placeholder="No. Reg / RM / Nama Pasien..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="sm:col-span-3 lg:col-span-3">
                <select name="department_id" class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white">
                    <option value="">-- Semua Poliklinik --</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ request('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
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
                <a href="{{ route('outpatients.index') }}" class="px-3.5 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold border border-slate-200 hover:bg-slate-200 transition">Reset</a>
            </div>
        </form>
    </x-card>

    <!-- Table Kunjungan Rawat Jalan -->
    <x-table :headers="['No. Antrean', 'No. Reg & RM', 'Nama Pasien', 'Poliklinik', 'Dokter DPJP', 'Status TTV', 'Status Antrean', 'Aksi & Pemanggilan']">
        @forelse($visits as $vst)
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-4">
                    <span class="inline-flex items-center justify-center px-3 py-1 rounded-lg bg-teal-50 text-teal-700 font-bold text-sm border border-teal-200/60">
                        {{ $vst->registration->queue->queue_number ?? '-' }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <div class="font-bold text-teal-600 text-xs">{{ $vst->registration->registration_number ?? '-' }}</div>
                    <span class="text-[11px] text-slate-400 font-mono">{{ $vst->registration->patient->mr_number ?? '-' }}</span>
                </td>
                <td class="px-6 py-4">
                    <div class="font-semibold text-slate-800 text-xs">{{ $vst->registration->patient->name ?? '-' }}</div>
                    <span class="text-[11px] text-slate-400">{{ $vst->registration->patient->gender ?? '-' }} ({{ $vst->registration->patient->age ?? '-' }} thn)</span>
                </td>
                <td class="text-xs text-slate-700 px-6 py-4">{{ $vst->department->name ?? '-' }}</td>
                <td class="text-xs text-slate-700 px-6 py-4">{{ $vst->doctor->name ?? '-' }}</td>
                <td class="px-6 py-4">
                    @if (!empty($vst->vital_signs))
                        <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">
                            <i data-lucide="check-circle-2" class="w-3 h-3"></i> TTV Dicatat
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 text-[11px] font-semibold text-amber-700 bg-amber-50 px-2 py-0.5 rounded-full border border-amber-200">
                            <i data-lucide="alert-circle" class="w-3 h-3"></i> Belum Input TTV
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <x-badge :type="$vst->status">{{ $vst->status }}</x-badge>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        @if ($vst->status === 'Menunggu')
                            <form action="{{ route('outpatients.call-queue', $vst) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-semibold rounded-lg shadow-xs transition flex items-center gap-1">
                                    <i data-lucide="volume-2" class="w-3.5 h-3.5"></i> Panggil
                                </button>
                            </form>
                        @endif
                        <a href="{{ route('outpatients.show', $vst) }}" class="p-1.5 text-slate-500 hover:text-teal-600 hover:bg-slate-100 rounded-lg transition" title="Detail / Periksa">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </a>
                        <a href="{{ route('outpatients.edit', $vst) }}" class="p-1.5 text-slate-500 hover:text-sky-600 hover:bg-slate-100 rounded-lg transition" title="Input TTV">
                            <i data-lucide="activity" class="w-4 h-4"></i>
                        </a>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8">
                    <x-empty-state title="Belum Ada Pasien Rawat Jalan" description="Tidak ada antrean pasien rawat jalan untuk kriteria filter ini." />
                </td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-4">
        {{ $visits->links() }}
    </div>
@endsection
