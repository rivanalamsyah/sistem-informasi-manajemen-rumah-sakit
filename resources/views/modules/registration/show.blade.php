@extends('layouts.admin')

@section('title', 'Detail Pendaftaran: ' . $registration->registration_number)

@section('content')
    <x-page-header 
        title="Pendaftaran: {{ $registration->registration_number }}"
        subtitle="Tanggal Kunjungan: {{ $registration->registration_date->format('d F Y, H:i') }} WIB"
        :breadcrumb="[
            ['label' => 'Pendaftaran Pasien', 'url' => route('registrations.index')],
            ['label' => 'Detail Registrasi', 'url' => null]
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('registrations.edit', $registration) }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-semibold text-xs rounded-xl shadow-sm transition">
                <i data-lucide="pencil" class="w-3.5 h-3.5"></i> Edit
            </a>
            <a href="{{ route('registrations.index') }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Kembali
            </a>
        </x-slot>
    </x-page-header>

    {{-- Queue Banner --}}
    <div class="bg-gradient-to-r from-teal-600 to-teal-700 rounded-2xl p-5 mb-5 shadow-lg">
        <div class="flex flex-col sm:flex-row items-center gap-5">
            <div class="w-20 h-20 rounded-2xl bg-white/20 backdrop-blur flex items-center justify-center">
                <span class="text-4xl font-black text-white">{{ $registration->queue->queue_code ?? '-' }}</span>
            </div>
            <div class="text-center sm:text-left flex-1">
                <p class="text-teal-200 text-xs font-semibold uppercase tracking-widest">Nomor Antrean Poliklinik</p>
                <h2 class="text-2xl font-black text-white">{{ $registration->queue->department->name ?? '-' }}</h2>
                <p class="text-teal-200 text-xs mt-1 flex items-center gap-1 justify-center sm:justify-start">
                    <i data-lucide="stethoscope" class="w-3.5 h-3.5"></i>
                    Dokter: {{ $registration->queue->doctor->name ?? '-' }}
                </p>
            </div>
            <div class="text-center sm:text-right">
                <p class="text-teal-200 text-xs mb-1">Status Antrean</p>
                <span class="inline-block px-3 py-1.5 bg-white text-teal-700 font-bold text-sm rounded-full shadow">
                    {{ $registration->queue->status ?? 'Menunggu' }}
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
        {{-- Data Identitas Pasien --}}
        <x-card title="Data Identitas Pasien" icon="user">
            <dl class="space-y-2.5">
                <div class="flex justify-between items-start gap-2">
                    <dt class="text-xs text-slate-500 min-w-[130px]">No. Rekam Medis</dt>
                    <dd class="text-sm font-bold text-teal-600">{{ $registration->patient->mr_number ?? '-' }}</dd>
                </div>
                <div class="flex justify-between items-start gap-2">
                    <dt class="text-xs text-slate-500 min-w-[130px]">Nama Pasien</dt>
                    <dd class="text-xs font-semibold text-slate-800 text-right">{{ $registration->patient->name ?? '-' }}</dd>
                </div>
                <div class="flex justify-between items-start gap-2">
                    <dt class="text-xs text-slate-500 min-w-[130px]">NIK</dt>
                    <dd class="text-xs text-slate-700 text-right">{{ $registration->patient->nik ?? '-' }}</dd>
                </div>
                <div class="flex justify-between items-start gap-2">
                    <dt class="text-xs text-slate-500 min-w-[130px]">Jenis Kelamin</dt>
                    <dd class="text-xs text-slate-700">{{ $registration->patient->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
                </div>
                <div class="flex justify-between items-start gap-2">
                    <dt class="text-xs text-slate-500 min-w-[130px]">Tanggal Lahir</dt>
                    <dd class="text-xs text-slate-700">{{ $registration->patient->birth_date ? $registration->patient->birth_date->format('d/m/Y') : '-' }}</dd>
                </div>
                <div class="flex justify-between items-start gap-2">
                    <dt class="text-xs text-slate-500 min-w-[130px]">Nomor Telepon</dt>
                    <dd class="text-xs text-slate-700">{{ $registration->patient->phone ?? '-' }}</dd>
                </div>
                <div class="flex justify-between items-start gap-2">
                    <dt class="text-xs text-slate-500 min-w-[130px]">Alamat</dt>
                    <dd class="text-xs text-slate-700 text-right">{{ $registration->patient->address ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>

        {{-- Rincian Pendaftaran --}}
        <x-card title="Rincian Pendaftaran" icon="file-medical">
            <dl class="space-y-2.5">
                <div class="flex justify-between items-start gap-2">
                    <dt class="text-xs text-slate-500 min-w-[130px]">No. Registrasi</dt>
                    <dd class="text-xs font-bold text-slate-800">{{ $registration->registration_number }}</dd>
                </div>
                <div class="flex justify-between items-start gap-2">
                    <dt class="text-xs text-slate-500 min-w-[130px]">Jenis Pelayanan</dt>
                    <dd><span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded text-[10px] font-bold border border-blue-200">{{ $registration->service_type }}</span></dd>
                </div>
                <div class="flex justify-between items-start gap-2">
                    <dt class="text-xs text-slate-500 min-w-[130px]">Penjamin Biaya</dt>
                    <dd><span class="px-2 py-0.5 bg-slate-100 text-slate-700 rounded text-[10px] font-semibold border border-slate-200">{{ $registration->guarantor }}</span></dd>
                </div>
                <div class="flex justify-between items-start gap-2">
                    <dt class="text-xs text-slate-500 min-w-[130px]">Poliklinik Tujuan</dt>
                    <dd class="text-xs font-semibold text-slate-800">{{ $registration->queue->department->name ?? '-' }}</dd>
                </div>
                <div class="flex justify-between items-start gap-2">
                    <dt class="text-xs text-slate-500 min-w-[130px]">Dokter DPJP</dt>
                    <dd class="text-xs font-semibold text-slate-800">{{ $registration->queue->doctor->name ?? '-' }}</dd>
                </div>
                <div class="flex justify-between items-start gap-2">
                    <dt class="text-xs text-slate-500 min-w-[130px]">Status Registrasi</dt>
                    <dd><x-badge :type="$registration->status">{{ $registration->status }}</x-badge></dd>
                </div>
                <div class="flex justify-between items-start gap-2">
                    <dt class="text-xs text-slate-500 min-w-[130px]">Catatan / Keluhan</dt>
                    <dd class="text-xs text-slate-700 text-right">{{ $registration->notes ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>
    </div>

    {{-- Riwayat Pendaftaran Sebelumnya --}}
    <x-card title="Riwayat Pendaftaran Pasien" icon="clock">
        <div class="overflow-x-auto">
            <table class="w-full text-xs">
                <thead>
                    <tr class="border-b border-slate-100">
                        <th class="text-left py-2.5 px-3 font-semibold text-slate-600">No. Reg</th>
                        <th class="text-left py-2.5 px-3 font-semibold text-slate-600">Tanggal</th>
                        <th class="text-left py-2.5 px-3 font-semibold text-slate-600">Jenis</th>
                        <th class="text-left py-2.5 px-3 font-semibold text-slate-600">Poliklinik</th>
                        <th class="text-left py-2.5 px-3 font-semibold text-slate-600">Dokter</th>
                        <th class="text-left py-2.5 px-3 font-semibold text-slate-600">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registration->patient->registrations as $prevReg)
                        <tr class="border-b border-slate-50 hover:bg-slate-50 transition {{ $prevReg->id === $registration->id ? 'bg-teal-50/50 font-semibold' : '' }}">
                            <td class="py-2 px-3 text-teal-600 font-semibold">{{ $prevReg->registration_number }}</td>
                            <td class="py-2 px-3 text-slate-600">{{ $prevReg->registration_date->format('d/m/Y H:i') }}</td>
                            <td class="py-2 px-3 text-slate-600">{{ $prevReg->service_type }}</td>
                            <td class="py-2 px-3 text-slate-600">{{ $prevReg->queue->department->name ?? '-' }}</td>
                            <td class="py-2 px-3 text-slate-600">{{ $prevReg->queue->doctor->name ?? '-' }}</td>
                            <td class="py-2 px-3"><x-badge :type="$prevReg->status">{{ $prevReg->status }}</x-badge></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center">
                                <x-empty-state icon="clipboard-list" message="Belum ada riwayat pendaftaran sebelumnya." />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-card>
@endsection
