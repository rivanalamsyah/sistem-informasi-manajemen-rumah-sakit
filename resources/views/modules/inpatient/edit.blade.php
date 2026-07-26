@extends('layouts.admin')

@section('title', 'Transfer Bed / Ruangan Pasien')

@section('content')
    <x-page-header
        title="Transfer Tempat Tidur & Ruangan Pasien"
        subtitle="Pindahkan pasien ke tempat tidur atau bangsal lain yang kosong."
        :breadcrumb="[
            ['label' => 'Rawat Inap', 'url' => route('inpatients.index')],
            ['label' => 'Transfer Bed / Ruangan', 'url' => null]
        ]"
    />

    <div class="max-w-3xl">
        <x-card class="p-6">
            {{-- Current Bed Info --}}
            <div class="flex items-start gap-3 p-3 bg-amber-50 border border-amber-200 rounded-xl mb-5">
                <div class="p-2 bg-amber-100 text-amber-600 rounded-lg">
                    <i data-lucide="bed" class="w-4 h-4"></i>
                </div>
                <div>
                    <p class="text-xs text-amber-600 font-semibold">Pasien</p>
                    <p class="text-sm font-bold text-slate-800">{{ $inpatientVisit->registration->patient->name ?? '-' }} <span class="text-teal-600">({{ $inpatientVisit->registration->patient->mr_number ?? '-' }})</span></p>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Kamar Saat Ini: <strong>Ruang {{ $inpatientVisit->bed->room->name ?? '-' }} — Bed {{ $inpatientVisit->bed->bed_number ?? '-' }}</strong>
                        (Kelas: {{ $inpatientVisit->bed->class ?? '-' }})
                    </p>
                </div>
            </div>

            <form method="POST" action="{{ route('inpatients.transfer', $inpatientVisit) }}" class="space-y-4">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <x-form-select name="room_id" id="room_id" label="Ruangan Tujuan" required>
                        <option value="">-- Pilih Ruangan Tujuan --</option>
                        @foreach($rooms as $rm)
                            <option value="{{ $rm->id }}" {{ old('room_id', $inpatientVisit->bed->room_id ?? '') == $rm->id ? 'selected' : '' }}>
                                {{ $rm->name }} ({{ $rm->building }}) — {{ $rm->beds->count() }} Bed Kosong
                            </option>
                        @endforeach
                    </x-form-select>

                    <x-form-select name="new_bed_id" id="new_bed_id" label="Bed Baru yang Kosong" required>
                        <option value="">-- Pilih Bed Kosong --</option>
                        @foreach($rooms as $rm)
                            @foreach($rm->beds as $bd)
                                <option value="{{ $bd->id }}" data-room="{{ $rm->id }}" {{ old('new_bed_id') == $bd->id ? 'selected' : '' }}>
                                    Bed {{ $bd->bed_number }} (Kelas: {{ $bd->class }} — Rp {{ number_format($bd->price_per_night, 0, ',', '.') }}/malam)
                                </option>
                            @endforeach
                        @endforeach
                    </x-form-select>
                </div>

                <x-form-select name="doctor_id" id="doctor_id" label="Dokter DPJP (Bila Ganti Dokter DPJP)">
                    <option value="">-- Tetap Dokter DPJP Saat Ini ({{ $inpatientVisit->doctor->full_name ?? '-' }}) --</option>
                    @foreach($doctors as $doc)
                        <option value="{{ $doc->id }}" {{ old('doctor_id', $inpatientVisit->doctor_id) == $doc->id ? 'selected' : '' }}>{{ $doc->full_name }} ({{ $doc->specialization }})</option>
                    @endforeach
                </x-form-select>

                <x-action-bar :cancelUrl="route('inpatients.show', $inpatientVisit)" saveLabel="Eksekusi Pindah Bed" />
            </form>
        </x-card>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roomSelect = document.getElementById('room_id');
        const bedSelect = document.getElementById('new_bed_id');
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
