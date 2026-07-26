@extends('layouts.admin')

@section('title', 'Detail & Hasil Order Laboratorium')

@section('content')
    <x-page-header
        title="Order Lab: {{ $laboratoryOrder->order_number }}"
        subtitle="Pengambilan spesimen sampel, input nilai parameter lab, & publikasi hasil EMR."
        :breadcrumb="[
            ['label' => 'Laboratorium', 'url' => route('laboratory.index')],
            ['label' => 'Hasil Pengujian Lab', 'url' => null]
        ]"
    >
        <x-slot name="actions">
            @if ($laboratoryOrder->status === 'Menunggu Sampel')
                <form action="{{ route('laboratory.collect-sample', $laboratoryOrder) }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-xl shadow-sm transition">
                        <i data-lucide="test-tube" class="w-4 h-4"></i> Terima & Ambil Sampel
                    </button>
                </form>
            @endif
            <a href="{{ route('laboratory.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
            </a>
        </x-slot>
    </x-page-header>

    <!-- Info Banner Card -->
    <x-card class="p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-xs">
            <div>
                <span class="text-slate-400 font-medium block">Nomor Order:</span>
                <span class="font-bold text-teal-600 font-mono text-sm">{{ $laboratoryOrder->order_number }}</span>
            </div>
            <div>
                <span class="text-slate-400 font-medium block">Pasien (No. RM):</span>
                <strong class="text-slate-800">{{ $laboratoryOrder->patient->name ?? '-' }}</strong>
                <span class="text-[11px] text-teal-600 font-mono font-bold block">{{ $laboratoryOrder->patient->mr_number ?? '-' }}</span>
            </div>
            <div>
                <span class="text-slate-400 font-medium block">Dokter Pengirim:</span>
                <strong class="text-slate-800">{{ $laboratoryOrder->doctor->full_name ?? '-' }}</strong>
            </div>
            <div>
                <span class="text-slate-400 font-medium block">Status Order:</span>
                <x-badge :type="$laboratoryOrder->status">{{ $laboratoryOrder->status }}</x-badge>
            </div>
        </div>
    </x-card>

    <!-- Form Input / Tampilan Hasil Pengujian Laboratorium -->
    <x-card title="Lembar Hasil Pengujian Laboratorium Pasien" icon="flask-conical" class="p-6 mb-6">
        @if ($laboratoryOrder->status === 'Selesai')
            <!-- Lembar Hasil Selesai & Divalidasi -->
            <x-table :headers="['Parameter Pemeriksaan Lab', 'Nilai Hasil', 'Nilai Rujukan Normal', 'Satuan', 'Keterangan Evaluasi', 'Analis Penguji']">
                @foreach($laboratoryOrder->results as $res)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-800 text-xs">{{ $res->laboratoryTest->name ?? 'Tes Lab' }}</td>
                        <td class="px-6 py-4 font-bold text-sm {{ $res->is_abnormal ? 'text-rose-600' : 'text-slate-900' }}">
                            {{ $res->result_value }}
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-600">{{ $res->reference_range ?? 'Normal' }}</td>
                        <td class="px-6 py-4 text-xs font-mono text-slate-700">{{ $res->unit ?? '-' }}</td>
                        <td class="px-6 py-4">
                            @if ($res->is_abnormal)
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-rose-700 bg-rose-50 border border-rose-200 px-2 py-0.5 rounded-full">
                                    <i data-lucide="alert-triangle" class="w-3 h-3"></i> Critical / Abnormal
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-full">
                                    <i data-lucide="check-circle" class="w-3 h-3"></i> Normal
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-xs text-slate-600">{{ $res->analyst->name ?? 'Analis Medis' }}</td>
                    </tr>
                @endforeach
            </x-table>
        @else
            <!-- Form Input Hasil oleh Analis Lab -->
            <form action="{{ route('laboratory.store-results', $laboratoryOrder) }}" method="POST" class="space-y-4">
                @csrf
                <div class="overflow-x-auto rounded-xl border border-slate-200/80 bg-white">
                    <table class="w-full text-left text-sm text-slate-700 divide-y divide-slate-200/70">
                        <thead class="bg-slate-50/80 text-xs uppercase font-semibold text-slate-500 tracking-wider">
                            <tr>
                                <th class="px-4 py-3">Item Pemeriksaan Lab</th>
                                <th class="px-4 py-3">Nilai Hasil <span class="text-rose-500">*</span></th>
                                <th class="px-4 py-3">Nilai Rujukan Normal</th>
                                <th class="px-4 py-3">Satuan</th>
                                <th class="px-4 py-3">Status Abnormal?</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($laboratoryOrder->results as $res)
                                <tr>
                                    <td class="px-4 py-3 font-bold text-slate-800 text-xs">
                                        {{ $res->laboratoryTest->name ?? 'Tes Lab' }}
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="text" name="results[{{ $res->laboratory_test_id }}][value]" value="{{ old("results.{$res->laboratory_test_id}.value", $res->result_value) }}" placeholder="e.g. 12.5 atau Positif" class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs font-bold text-slate-900 focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="text" name="results[{{ $res->laboratory_test_id }}][reference_range]" value="{{ old("results.{$res->laboratory_test_id}.reference_range", $res->reference_range) }}" placeholder="e.g. 11.5 - 16.5" class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-teal-500">
                                    </td>
                                    <td class="px-4 py-3">
                                        <input type="text" name="results[{{ $res->laboratory_test_id }}][unit]" value="{{ old("results.{$res->laboratory_test_id}.unit", $res->unit) }}" placeholder="e.g. g/dL" class="w-full px-3 py-1.5 bg-slate-50 border border-slate-200 rounded-lg text-xs text-slate-700 focus:outline-none focus:ring-2 focus:ring-teal-500">
                                    </td>
                                    <td class="px-4 py-3">
                                        <label class="flex items-center gap-1.5 text-xs font-semibold text-rose-700 cursor-pointer">
                                            <input type="checkbox" name="results[{{ $res->laboratory_test_id }}][is_abnormal]" value="1" {{ $res->is_abnormal ? 'checked' : '' }} class="rounded border-slate-300 text-rose-600 focus:ring-rose-500">
                                            <span>Abnormal</span>
                                        </label>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="flex items-center gap-3 pt-2">
                    <button type="submit" class="px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs rounded-xl shadow-sm transition flex items-center gap-2">
                        <i data-lucide="check-circle" class="w-4 h-4"></i> Validasi Hasil & Publikasikan ke EMR
                    </button>
                </div>
            </form>
        @endif
    </x-card>
@endsection
