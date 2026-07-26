@extends('layouts.admin')

@section('title', 'Edit Pendaftaran: ' . $registration->registration_number)

@section('content')
    <x-page-header 
        title="Edit Pendaftaran: {{ $registration->registration_number }}"
        subtitle="Ubah poliklinik tujuan, dokter, atau status sebelum pelayanan."
        :breadcrumb="[
            ['label' => 'Pendaftaran Pasien', 'url' => route('registrations.index')],
            ['label' => 'Edit Pendaftaran', 'url' => null]
        ]"
    />

    <div class="max-w-2xl">
        <x-card class="p-6">
            {{-- Info Pasien readonly --}}
            <div class="flex items-start gap-3 p-3 bg-slate-50 border border-slate-200 rounded-xl mb-5">
                <div class="p-2 bg-teal-100 text-teal-600 rounded-lg">
                    <i data-lucide="user" class="w-4 h-4"></i>
                </div>
                <div>
                    <p class="text-xs text-slate-500">Pasien</p>
                    <p class="text-sm font-bold text-slate-800">{{ $registration->patient->name ?? '-' }} <span class="text-teal-600">({{ $registration->patient->mr_number ?? '-' }})</span></p>
                    <p class="text-xs text-slate-500 mt-0.5">No. Antrean Saat Ini: <span class="font-bold text-teal-600">{{ $registration->queue->queue_code ?? '-' }}</span></p>
                </div>
            </div>

            <form method="POST" action="{{ route('registrations.update', $registration) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <x-form-select name="department_id" id="department_id" label="Poliklinik Tujuan" required>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ old('department_id', $registration->queue->department_id ?? '') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                    @endforeach
                </x-form-select>

                <x-form-select name="doctor_id" id="doctor_id" label="Dokter Spesialis / DPJP" required>
                    @foreach($doctors as $doc)
                        <option value="{{ $doc->id }}" {{ old('doctor_id', $registration->queue->doctor_id ?? '') == $doc->id ? 'selected' : '' }}>
                            {{ $doc->full_name }} ({{ $doc->department->name ?? 'Umum' }})
                        </option>
                    @endforeach
                </x-form-select>

                <x-form-select name="status" id="status" label="Status Pendaftaran" required>
                    @foreach(['Menunggu', 'Diproses', 'Selesai', 'Batal'] as $st)
                        <option value="{{ $st }}" {{ old('status', $registration->status) === $st ? 'selected' : '' }}>{{ $st }}</option>
                    @endforeach
                </x-form-select>

                <x-form-textarea name="notes" id="notes" label="Catatan / Keluhan Utama" rows="3">{{ old('notes', $registration->notes) }}</x-form-textarea>

                <x-action-bar :cancelUrl="route('registrations.index')" saveLabel="Perbarui Pendaftaran" />
            </form>
        </x-card>
    </div>
@endsection
