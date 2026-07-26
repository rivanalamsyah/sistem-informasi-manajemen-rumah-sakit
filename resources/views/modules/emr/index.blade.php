@extends('layouts.admin')

@section('title', 'Rekam Medis Elektronik (EMR)')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <x-breadcrumb :items="[['label' => 'Rekam Medis (EMR)', 'url' => null]]" />
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Pusat Rekam Medis Elektronik (EMR) Pasien</h1>
            <p class="text-xs text-slate-500 mt-0.5">Pengelolaan episode pelayanan medis, SOAP klinis, pengkodean ICD-10, e-resep, & order lab.</p>
        </div>
        <a href="{{ route('medical-records.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold rounded-xl shadow-sm transition">
            <i data-lucide="plus-circle" class="w-4 h-4"></i> Input Episode EMR Baru
        </a>
    </div>

    <!-- Summary Metrics Grid (5 Grid Cards) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <x-card class="p-4">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Total Episode EMR</span>
            <h2 class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($metrics['totalRecords']) }}</h2>
            <span class="text-[11px] text-slate-500 mt-0.5 block">Histori Medis Terdaftar</span>
        </x-card>

        <x-card class="p-4">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Pemeriksaan Hari Ini</span>
            <h2 class="text-2xl font-bold text-teal-600 mt-1">{{ number_format($metrics['recordsToday']) }}</h2>
            <span class="text-[11px] text-teal-600 flex items-center gap-1 mt-0.5"><i data-lucide="file-text" class="w-3 h-3"></i> Catatan Dokter</span>
        </x-card>

        <x-card class="p-4">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Episode Rawat Jalan</span>
            <h2 class="text-2xl font-bold text-sky-600 mt-1">{{ number_format($metrics['outpatientEpisodes']) }}</h2>
            <span class="text-[11px] text-sky-600 flex items-center gap-1 mt-0.5"><i data-lucide="stethoscope" class="w-3 h-3"></i> Poliklinik</span>
        </x-card>

        <x-card class="p-4">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Episode Rawat Inap</span>
            <h2 class="text-2xl font-bold text-amber-600 mt-1">{{ number_format($metrics['inpatientEpisodes']) }}</h2>
            <span class="text-[11px] text-amber-600 flex items-center gap-1 mt-0.5"><i data-lucide="bed" class="w-3 h-3"></i> Bangsal Opname</span>
        </x-card>
    </div>

    <!-- Filter & Search Bar -->
    <x-card class="p-4 mb-6">
        <form method="GET" action="{{ route('medical-records.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-4 lg:col-span-4">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>
                    <input type="text" name="search" class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white" placeholder="No. RM / Nama Pasien / Kode ICD-10..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="sm:col-span-3 lg:col-span-3">
                <select name="doctor_id" class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white">
                    <option value="">-- Semua Dokter Pemeriksa --</option>
                    @foreach($doctors as $doc)
                        <option value="{{ $doc->id }}" {{ request('doctor_id') == $doc->id ? 'selected' : '' }}>{{ $doc->full_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-3 lg:col-span-3">
                <select name="service_type" class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white">
                    <option value="">-- Semua Pelayanan --</option>
                    <option value="Rawat Jalan" {{ request('service_type') === 'Rawat Jalan' ? 'selected' : '' }}>Rawat Jalan</option>
                    <option value="Rawat Inap" {{ request('service_type') === 'Rawat Inap' ? 'selected' : '' }}>Rawat Inap</option>
                </select>
            </div>
            <div class="sm:col-span-2 lg:col-span-2 flex gap-2">
                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-semibold hover:bg-teal-700 transition flex items-center gap-1.5"><i data-lucide="filter" class="w-3.5 h-3.5"></i> Filter</button>
                <a href="{{ route('medical-records.index') }}" class="px-3.5 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold border border-slate-200 hover:bg-slate-200 transition">Reset</a>
            </div>
        </form>
    </x-card>

    <!-- Table EMR Records -->
    <x-table :headers="['Waktu Episode', 'No. RM / Nama Pasien', 'Pelayanan', 'Dokter DPJP', 'Diagnosa ICD-10 Utama', 'Aksi']">
        @forelse($records as $rec)
            @php
                $primaryDiag = $rec->diagnoses->where('type', 'Utama')->first();
            @endphp
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-4">
                    <div class="font-bold text-slate-800 text-xs">{{ $rec->record_date ? $rec->record_date->format('d/m/Y H:i') : '-' }}</div>
                    <span class="text-[10px] text-slate-400 font-mono">{{ $rec->registration->registration_number ?? '-' }}</span>
                </td>
                <td class="px-6 py-4">
                    <div class="font-semibold text-slate-800 text-xs">{{ $rec->patient->name ?? '-' }}</div>
                    <span class="text-[11px] text-teal-600 font-mono font-bold">{{ $rec->patient->mr_number ?? '-' }}</span>
                </td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center gap-1 text-[10px] font-bold px-2 py-0.5 rounded-full border {{ $rec->registration->service_type === 'Rawat Inap' ? 'bg-amber-50 text-amber-800 border-amber-200' : 'bg-sky-50 text-sky-800 border-sky-200' }}">
                        {{ $rec->registration->service_type ?? 'Rawat Jalan' }}
                    </span>
                </td>
                <td class="text-xs text-slate-700 px-6 py-4">{{ $rec->doctor->full_name ?? '-' }}</td>
                <td class="px-6 py-4">
                    @if ($primaryDiag)
                        <span class="inline-flex items-center gap-1 text-[11px] font-bold text-indigo-700 bg-indigo-50 border border-indigo-200/80 px-2.5 py-0.5 rounded-full">
                            {{ $primaryDiag->icd10_code }} — {{ Str::limit($primaryDiag->icd10_name, 30) }}
                        </span>
                    @else
                        <span class="text-xs text-slate-400 italic">Belum diinput</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    <a href="{{ route('medical-records.show', $rec) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-teal-50 text-slate-700 hover:text-teal-700 text-xs font-semibold rounded-xl border border-slate-200/80 transition" title="Lihat EMR Episode">
                        <i data-lucide="eye" class="w-4 h-4"></i> Detail Episode EMR
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">
                    <x-empty-state title="Belum Ada Rekam Medis" description="Tidak ditemukan catatan EMR rekam medis untuk kriteria pencarian ini." />
                </td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-4">
        {{ $records->links() }}
    </div>
@endsection
