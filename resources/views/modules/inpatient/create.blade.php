@extends('layouts.admin')

@section('title', 'Admisi Masuk Rawat Inap')

@section('content')
    <x-page-header
        title="Form Admisi Masuk Rawat Inap"
        subtitle="Proses penerimaan pasien opname dan penempatan tempat tidur (Bed) kamar inap."
        :breadcrumb="[
            ['label' => 'Rawat Inap', 'url' => route('inpatients.index')],
            ['label' => 'Admisi Pasien Masuk', 'url' => null]
        ]"
    />

    <div class="max-w-4xl">
        <x-card class="p-6">
            <form method="POST" action="{{ route('inpatients.store') }}" class="space-y-4">
                @csrf

                <x-form-select name="registration_id" id="registration_id" label="Pilih Pendaftaran Pasien" required>
                    <option value="">-- Pilih Pasien Terdaftar --</option>
                    @foreach($registrations as $reg)
                        <option value="{{ $reg->id }}" {{ old('registration_id') == $reg->id ? 'selected' : '' }}>
                            {{ $reg->registration_number }} — {{ $reg->patient->name ?? '-' }} (No. RM: {{ $reg->patient->mr_number ?? '-' }}) — {{ $reg->service_type }}
                        </option>
                    @endforeach
                </x-form-select>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <x-form-select name="room_id" id="room_id" label="Ruangan / Bangsal" required>
                        <option value="">-- Pilih Ruangan --</option>
                        @foreach($rooms as $rm)
                            <option value="{{ $rm->id }}" {{ old('room_id') == $rm->id ? 'selected' : '' }}>
                                {{ $rm->name }} ({{ $rm->building }} - Lt.{{ $rm->floor }}) — {{ $rm->beds->count() }} Bed Kosong
                            </option>
                        @endforeach
                    </x-form-select>

                    <x-form-select name="bed_id" id="bed_id" label="Tempat Tidur (Bed)" required>
                        <option value="">-- Pilih Bed Kosong --</option>
                        @foreach($rooms as $rm)
                            @foreach($rm->beds as $bd)
                                <option value="{{ $bd->id }}" data-room="{{ $rm->id }}" {{ old('bed_id') == $bd->id ? 'selected' : '' }}>
                                    [Ruang {{ $rm->name }}] Bed {{ $bd->bed_number }} (Kelas: {{ $bd->class }} — Rp {{ number_format($bd->price_per_night, 0, ',', '.') }}/malam)
                                </option>
                            @endforeach
                        @endforeach
                    </x-form-select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <x-form-select name="doctor_id" id="doctor_id" label="Dokter DPJP Penanggung Jawab" required>
                        <option value="">-- Pilih Dokter DPJP --</option>
                        @foreach($doctors as $doc)
                            <option value="{{ $doc->id }}" {{ old('doctor_id') == $doc->id ? 'selected' : '' }}>{{ $doc->full_name }} ({{ $doc->specialization }})</option>
                        @endforeach
                    </x-form-select>

                    <x-form-input name="admission_date" id="admission_date" label="Waktu Masuk Kamar" type="datetime-local" required value="{{ old('admission_date', date('Y-m-d\TH:i')) }}" />
                </div>

                <x-form-textarea name="initial_diagnosis" id="initial_diagnosis" label="Diagnosis Awal / Catatan Admisi" rows="3" placeholder="Diagnosis masuk rawat inap, indikasi medis, keluhan utama...">{{ old('initial_diagnosis') }}</x-form-textarea>

                <x-action-bar :cancelUrl="route('inpatients.index')" saveLabel="Proses Masuk Rawat Inap" />
            </form>
        </x-card>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roomSelect = document.getElementById('room_id');
        const bedSelect = document.getElementById('bed_id');
        const bedOptions = Array.from(bedSelect.options);

        function filterBedsByRoom() {
            const selectedRoom = roomSelect.value;
            bedSelect.innerHTML = '';
            
            const defaultOpt = document.createElement('option');
            defaultOpt.value = '';
            defaultOpt.textContent = '-- Pilih Bed Kosong --';
            bedSelect.appendChild(defaultOpt);

            bedOptions.forEach(opt => {
                if (opt.value && (!selectedRoom || opt.dataset.room === selectedRoom)) {
                    bedSelect.appendChild(opt.cloneNode(true));
                }
            });
        }

        roomSelect.addEventListener('change', filterBedsByRoom);
    });
</script>
@endpush
