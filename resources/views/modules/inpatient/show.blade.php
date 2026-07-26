@extends('layouts.admin')

@section('title', 'Detail Episode Rawat Inap')

@section('content')
    <x-page-header
        title="Rawat Inap: {{ $inpatientVisit->registration->patient->name ?? '-' }}"
        subtitle="No. Reg: {{ $inpatientVisit->registration->registration_number ?? '-' }} | No. RM: {{ $inpatientVisit->registration->patient->mr_number ?? '-' }}"
        :breadcrumb="[
            ['label' => 'Rawat Inap', 'url' => route('inpatients.index')],
            ['label' => 'Detail Opname Pasien', 'url' => null]
        ]"
    >
        <x-slot name="actions">
            @if ($inpatientVisit->status === 'Aktif')
                <a href="{{ route('inpatients.edit', $inpatientVisit) }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-semibold text-xs rounded-xl shadow-sm transition">
                    <i data-lucide="arrows-left-right" class="w-3.5 h-3.5"></i> Pindah Bed
                </a>
                <button type="button" onclick="document.getElementById('dischargeModal').classList.remove('hidden')"
                    class="inline-flex items-center gap-1.5 px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-semibold text-xs rounded-xl shadow-sm transition">
                    <i data-lucide="log-out" class="w-3.5 h-3.5"></i> Discharge Pasien
                </button>
            @endif
            <a href="{{ route('inpatients.index') }}"
               class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Kembali
            </a>
        </x-slot>
    </x-page-header>

    {{-- Bed Status Banner --}}
    <div class="bg-white border border-slate-200 rounded-2xl shadow-sm p-5 mb-5">
        <div class="flex flex-col sm:flex-row items-center gap-5">
            <div class="w-16 h-16 rounded-xl bg-teal-600 flex items-center justify-center">
                <i data-lucide="bed" class="w-7 h-7 text-white"></i>
            </div>
            <div class="text-center sm:text-left flex-1">
                <h2 class="text-lg font-black text-slate-900">
                    Ruang {{ $inpatientVisit->bed->room->name ?? '-' }} — Bed {{ $inpatientVisit->bed->bed_number ?? '-' }}
                </h2>
                <div class="flex items-center gap-2 mt-1 justify-center sm:justify-start flex-wrap">
                    <span class="px-2 py-0.5 bg-slate-100 text-slate-700 rounded-full text-[10px] font-semibold border border-slate-200">
                        Gedung {{ $inpatientVisit->bed->room->building ?? '-' }} (Lt.{{ $inpatientVisit->bed->room->floor ?? '-' }})
                    </span>
                    <span class="px-2 py-0.5 bg-blue-100 text-blue-700 rounded-full text-[10px] font-semibold border border-blue-200">
                        Kelas {{ $inpatientVisit->bed->class ?? '-' }}
                    </span>
                    <span class="text-xs font-semibold text-emerald-600">
                        Rp {{ number_format($inpatientVisit->bed->price_per_night ?? 0, 0, ',', '.') }}/malam
                    </span>
                </div>
            </div>
            <div class="text-center">
                @php
                    $days = $inpatientVisit->admission_date ? (int) $inpatientVisit->admission_date->diffInDays($inpatientVisit->discharge_date ?? now()) : 0;
                    if ($days == 0) $days = 1;
                @endphp
                <p class="text-xs text-slate-500 mb-1">Lama Rawat Inap</p>
                <p class="text-2xl font-black text-teal-600">{{ $days }} <span class="text-sm font-semibold">Hari</span></p>
                <x-badge :type="$inpatientVisit->status" class="mt-1">{{ $inpatientVisit->status }}</x-badge>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
        {{-- Identitas Pasien --}}
        <x-card title="Data Identitas Pasien" icon="user">
            <dl class="space-y-2.5">
                <div class="flex justify-between gap-2">
                    <dt class="text-xs text-slate-500">No. Rekam Medis</dt>
                    <dd class="text-xs font-bold text-teal-600">{{ $inpatientVisit->registration?->patient?->mr_number ?? '-' }}</dd>
                </div>
                <div class="flex justify-between gap-2">
                    <dt class="text-xs text-slate-500">Nama Pasien</dt>
                    <dd class="text-xs font-semibold text-slate-800 text-right">{{ $inpatientVisit->registration?->patient?->name ?? '-' }}</dd>
                </div>
                <div class="flex justify-between gap-2">
                    <dt class="text-xs text-slate-500">NIK</dt>
                    <dd class="text-xs text-slate-700">{{ $inpatientVisit->registration?->patient?->nik ?? '-' }}</dd>
                </div>
                <div class="flex justify-between gap-2">
                    <dt class="text-xs text-slate-500">Gender / Umur</dt>
                    <dd class="text-xs text-slate-700">
                        @if($inpatientVisit->registration?->patient?->gender === 'L')
                            Laki-laki
                        @elseif($inpatientVisit->registration?->patient?->gender === 'P')
                            Perempuan
                        @else
                            -
                        @endif
                    </dd>
                </div>
                <div class="flex justify-between gap-2">
                    <dt class="text-xs text-slate-500">Nomor Telepon</dt>
                    <dd class="text-xs text-slate-700">{{ $inpatientVisit->registration?->patient?->phone ?? '-' }}</dd>
                </div>
                <div class="flex justify-between gap-2">
                    <dt class="text-xs text-slate-500">Alamat Domisili</dt>
                    <dd class="text-xs text-slate-700 text-right">{{ $inpatientVisit->registration?->patient?->address ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>

        {{-- Rincian Admisi --}}
        <x-card title="Rincian Admisi & Dokter DPJP" icon="stethoscope">
            <dl class="space-y-2.5">
                <div class="flex justify-between gap-2">
                    <dt class="text-xs text-slate-500">Dokter DPJP</dt>
                    <dd class="text-xs font-semibold text-slate-800">{{ $inpatientVisit->doctor->full_name ?? '-' }}</dd>
                </div>
                <div class="flex justify-between gap-2">
                    <dt class="text-xs text-slate-500">Waktu Masuk Kamar</dt>
                    <dd class="text-xs font-bold text-slate-800">{{ $inpatientVisit->admission_date ? $inpatientVisit->admission_date->format('d/m/Y H:i') : '-' }} WIB</dd>
                </div>
                <div class="flex justify-between gap-2">
                    <dt class="text-xs text-slate-500">Waktu Keluar / Pulang</dt>
                    <dd class="text-xs text-slate-700">{{ $inpatientVisit->discharge_date ? $inpatientVisit->discharge_date->format('d/m/Y H:i') . ' WIB' : 'Masih Dirawat' }}</dd>
                </div>
                <div class="flex justify-between gap-2">
                    <dt class="text-xs text-slate-500">Penjamin Biaya</dt>
                    <dd>
                        <span class="px-2 py-0.5 bg-slate-100 text-slate-700 rounded text-[10px] font-semibold border border-slate-200">
                            {{ $inpatientVisit->registration->guarantor ?? 'Umum' }}
                        </span>
                    </dd>
                </div>
                <div class="flex justify-between gap-2">
                    <dt class="text-xs text-slate-500">Diagnosis Awal</dt>
                    <dd class="text-xs text-slate-700 text-right">{{ $inpatientVisit->initial_diagnosis ?? '-' }}</dd>
                </div>
                <div class="flex justify-between gap-2">
                    <dt class="text-xs text-slate-500">Alasan Pulang</dt>
                    <dd class="text-xs text-slate-700">{{ $inpatientVisit->discharge_reason ?? '-' }}</dd>
                </div>
            </dl>
        </x-card>
    </div>

    {{-- Alur Penunjang Medis --}}
    <x-card title="Alur Pelayanan & Penunjang Medis Opname" icon="git-branch">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <a href="{{ route('medical-records.index') }}"
               class="flex flex-col items-center p-4 bg-slate-50 hover:bg-blue-50 border border-slate-200 hover:border-blue-200 rounded-xl transition group text-center">
                <i data-lucide="folder-open" class="w-7 h-7 text-blue-600 mb-2"></i>
                <span class="text-xs font-bold text-slate-800 group-hover:text-blue-700">Rekam Medis (EMR)</span>
                <span class="text-[10px] text-slate-400 mt-0.5">Catatan Visite & SOAP</span>
            </a>
            <a href="{{ route('pharmacy.index') }}"
               class="flex flex-col items-center p-4 bg-slate-50 hover:bg-emerald-50 border border-slate-200 hover:border-emerald-200 rounded-xl transition group text-center">
                <i data-lucide="pill" class="w-7 h-7 text-emerald-600 mb-2"></i>
                <span class="text-xs font-bold text-slate-800 group-hover:text-emerald-700">Farmasi & Resep</span>
                <span class="text-[10px] text-slate-400 mt-0.5">Obat Injeksi & Harian</span>
            </a>
            <a href="{{ route('laboratory.index') }}"
               class="flex flex-col items-center p-4 bg-slate-50 hover:bg-red-50 border border-slate-200 hover:border-red-200 rounded-xl transition group text-center">
                <i data-lucide="flask-conical" class="w-7 h-7 text-red-500 mb-2"></i>
                <span class="text-xs font-bold text-slate-800 group-hover:text-red-700">Laboratorium</span>
                <span class="text-[10px] text-slate-400 mt-0.5">Order Cek Darah/Lab</span>
            </a>
            <a href="{{ route('billing.index') }}"
               class="flex flex-col items-center p-4 bg-slate-50 hover:bg-amber-50 border border-slate-200 hover:border-amber-200 rounded-xl transition group text-center">
                <i data-lucide="receipt" class="w-7 h-7 text-amber-600 mb-2"></i>
                <span class="text-xs font-bold text-slate-800 group-hover:text-amber-700">Kasir & Billing</span>
                <span class="text-[10px] text-slate-400 mt-0.5">Perhitungan Kamar & Obat</span>
            </a>
        </div>
    </x-card>

    {{-- Discharge Modal --}}
    @if ($inpatientVisit->status === 'Aktif')
        <div id="dischargeModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md">
                <form action="{{ route('inpatients.discharge', $inpatientVisit) }}" method="POST">
                    @csrf
                    <div class="flex items-center gap-3 p-5 border-b border-slate-100">
                        <div class="p-2.5 bg-rose-100 text-rose-600 rounded-xl">
                            <i data-lucide="log-out" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-slate-900 text-sm">Pulangkan Pasien (Discharge)</h3>
                            <p class="text-xs text-slate-500 mt-0.5">Bed {{ $inpatientVisit->bed->bed_number ?? '' }} akan otomatis dikosongkan.</p>
                        </div>
                        <button type="button" onclick="document.getElementById('dischargeModal').classList.add('hidden')" class="ml-auto text-slate-400 hover:text-slate-600">
                            <i data-lucide="x" class="w-5 h-5"></i>
                        </button>
                    </div>
                    <div class="p-5 space-y-3">
                        <div>
                            <label for="discharge_reason" class="block text-xs font-semibold text-slate-700 mb-1.5">Alasan Pemulangan Pasien <span class="text-rose-500">*</span></label>
                            <select name="discharge_reason" id="discharge_reason" required
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-rose-500 transition">
                                <option value="Sembuh">Sembuh / Membaik (Medis)</option>
                                <option value="Rujuk">Rujuk ke RS Lain</option>
                                <option value="APS">Pulang Atas Permintaan Sendiri (APS)</option>
                                <option value="Meninggal">Meninggal Dunia</option>
                            </select>
                        </div>
                        <div>
                            <label for="discharge_notes" class="block text-xs font-semibold text-slate-700 mb-1.5">Catatan Kepulangan / Resume Dokter</label>
                            <textarea name="discharge_notes" id="discharge_notes" rows="3"
                                class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 transition"
                                placeholder="Kondisi akhir pasien, instruksi obat pulang..."></textarea>
                        </div>
                    </div>
                    <div class="flex items-center justify-end gap-2 p-4 bg-slate-50 rounded-b-2xl border-t border-slate-100">
                        <button type="button" onclick="document.getElementById('dischargeModal').classList.add('hidden')"
                            class="px-4 py-2 bg-white hover:bg-slate-100 text-slate-700 font-semibold text-xs rounded-xl border border-slate-200 transition">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-5 py-2 bg-rose-600 hover:bg-rose-700 text-white font-semibold text-xs rounded-xl shadow-sm transition flex items-center gap-1.5">
                            <i data-lucide="check-circle-2" class="w-3.5 h-3.5"></i> Konfirmasi Pulangkan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endsection
