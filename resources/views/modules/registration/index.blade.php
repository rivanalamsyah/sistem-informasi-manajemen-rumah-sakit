@extends('layouts.admin')

@section('title', 'Pendaftaran Pasien & Antrean')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <x-breadcrumb :items="[['label' => 'Pendaftaran Pasien', 'url' => null]]" />
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Pelayanan Pendaftaran Pasien & Antrean</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola registrasi admisi pasien baru/lama, antrean poliklinik, & penjaminan biaya.</p>
        </div>
        <a href="{{ route('registrations.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold rounded-xl shadow-sm transition">
            <i data-lucide="user-plus" class="w-4 h-4"></i> Registrasi Pasien Baru
        </a>
    </div>

    <!-- Filter & Search Bar -->
    <x-card class="p-4 mb-6">
        <form method="GET" action="{{ route('registrations.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
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
                <select name="status" class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white">
                    <option value="">-- Semua Status --</option>
                    <option value="Menunggu" {{ request('status') === 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="Diproses" {{ request('status') === 'Diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="Selesai" {{ request('status') === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="Batal" {{ request('status') === 'Batal' ? 'selected' : '' }}>Batal</option>
                </select>
            </div>
            <div class="sm:col-span-2 lg:col-span-3 flex gap-2">
                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-semibold hover:bg-teal-700 transition flex items-center gap-1.5"><i data-lucide="filter" class="w-3.5 h-3.5"></i> Filter</button>
                <a href="{{ route('registrations.index') }}" class="px-3.5 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold border border-slate-200 hover:bg-slate-200 transition">Reset</a>
            </div>
        </form>
    </x-card>

    <!-- Table Registrasi -->
    <x-table :headers="['No. Reg & Waktu', 'No. RM / Nama Pasien', 'Layanan & Poli', 'Dokter', 'Antrean', 'Penjamin', 'Status', 'Aksi']">
        @forelse($registrations as $reg)
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-4">
                    <div class="font-bold text-teal-600 text-xs">{{ $reg->registration_number }}</div>
                    <span class="text-[11px] text-slate-400">{{ $reg->registration_date ? $reg->registration_date->format('d/m/Y H:i') : '-' }}</span>
                </td>
                <td class="px-6 py-4">
                    <div class="font-semibold text-slate-800 text-xs">{{ $reg->patient->name ?? '-' }}</div>
                    <span class="text-[11px] text-slate-400 font-mono">{{ $reg->patient->mr_number ?? '-' }} ({{ $reg->patient->gender ?? '-' }})</span>
                </td>
                <td class="px-6 py-4">
                    <div class="font-medium text-slate-700 text-xs">{{ $reg->queue->department->name ?? $reg->service_type }}</div>
                    <span class="text-[10px] text-slate-400 font-medium px-2 py-0.5 rounded bg-slate-100 border border-slate-200/60 inline-block mt-0.5">{{ $reg->service_type }}</span>
                </td>
                <td class="text-xs text-slate-600 px-6 py-4">{{ $reg->queue->doctor->name ?? '-' }}</td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-lg bg-teal-50 text-teal-700 font-bold text-xs border border-teal-200/60">
                        {{ $reg->queue->queue_number ?? '-' }}
                    </span>
                </td>
                <td class="px-6 py-4">
                    <span class="text-[11px] font-semibold text-slate-700 px-2 py-0.5 bg-slate-100 border border-slate-200 rounded-md">{{ $reg->guarantor }}</span>
                </td>
                <td class="px-6 py-4">
                    <x-badge :type="$reg->status">{{ $reg->status }}</x-badge>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-1.5">
                        <a href="{{ route('registrations.show', $reg) }}" class="p-1.5 text-slate-500 hover:text-teal-600 hover:bg-slate-100 rounded-lg transition" title="Detail Registrasi">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </a>
                        <a href="{{ route('registrations.edit', $reg) }}" class="p-1.5 text-slate-500 hover:text-amber-600 hover:bg-slate-100 rounded-lg transition" title="Ubah">
                            <i data-lucide="edit" class="w-4 h-4"></i>
                        </a>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8">
                    <x-empty-state title="Belum Ada Pendaftaran Pasien" description="Tidak ditemukan data registrasi admisi pasien untuk filter kriteria ini." />
                </td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-4">
        {{ $registrations->links() }}
    </div>
@endsection
