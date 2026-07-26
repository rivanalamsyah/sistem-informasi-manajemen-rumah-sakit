@extends('layouts.admin')

@section('title', 'Pendaftaran Pasien')

@section('content')
    <x-page-header 
        title="Form Pendaftaran Pasien (Admisi)" 
        subtitle="Daftarkan pasien lama atau baru untuk mendapatkan pelayanan."
        :breadcrumb="[
            ['label' => 'Pendaftaran Pasien', 'url' => route('registrations.index')],
            ['label' => 'Pendaftaran Baru', 'url' => null]
        ]"
    />

    <form method="POST" action="{{ route('registrations.store') }}">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5">

            {{-- LEFT: Data Pasien --}}
            <div class="lg:col-span-7 space-y-5">
                <x-card title="1. Identitas & Tipe Pasien" icon="user-check">
                    {{-- Radio: Pasien Lama / Baru --}}
                    <div class="mb-4">
                        <label class="block text-xs font-semibold text-slate-700 mb-2">Jenis Pendaftaran Pasien</label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="radio" name="registration_type" id="type_lama" value="lama" {{ old('registration_type', 'lama') === 'lama' ? 'checked' : '' }}
                                    class="w-4 h-4 text-teal-600 border-slate-300 focus:ring-teal-500">
                                <span class="text-xs font-semibold text-slate-700 group-hover:text-teal-600 transition">
                                    <i data-lucide="user-check" class="w-3.5 h-3.5 inline-block mr-1 text-teal-600"></i>
                                    Pasien Lama (Terdaftar)
                                </span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="radio" name="registration_type" id="type_baru" value="baru" {{ old('registration_type') === 'baru' ? 'checked' : '' }}
                                    class="w-4 h-4 text-blue-600 border-slate-300 focus:ring-blue-500">
                                <span class="text-xs font-semibold text-slate-700 group-hover:text-blue-600 transition">
                                    <i data-lucide="user-plus" class="w-3.5 h-3.5 inline-block mr-1 text-blue-600"></i>
                                    Pasien Baru (Buat No. RM Baru)
                                </span>
                            </label>
                        </div>
                    </div>

                    {{-- Section Pasien Lama --}}
                    <div id="section_pasien_lama">
                        <div class="mb-3">
                            <label for="patient_search" class="block text-xs font-semibold text-slate-700 mb-1.5">Pencarian Pasien Terdaftar</label>
                            <div class="relative">
                                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                                <input type="text" id="patient_search"
                                    class="w-full pl-9 pr-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent transition"
                                    placeholder="Ketik Nama, No. RM, NIK, atau Telepon..." autocomplete="off">
                            </div>
                            <p class="text-xs text-slate-400 mt-1">Ketik minimal 2 karakter untuk mencari data pasien.</p>
                            <div id="search_results" class="hidden mt-1 bg-white border border-slate-200 rounded-xl shadow-lg overflow-y-auto max-h-52 z-30 relative"></div>
                        </div>

                        <input type="hidden" name="patient_id" id="patient_id" value="{{ old('patient_id') }}">
                        <div id="selected_patient_card" class="hidden bg-teal-50 border border-teal-200 rounded-xl p-3">
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-xs font-bold text-teal-700 flex items-center gap-1">
                                    <i data-lucide="id-card" class="w-3.5 h-3.5"></i> Pasien Terpilih
                                </span>
                                <button type="button" id="btn_clear_patient" class="text-xs text-red-500 hover:text-red-700 font-medium flex items-center gap-1">
                                    <i data-lucide="x-circle" class="w-3.5 h-3.5"></i> Ganti Pasien
                                </button>
                            </div>
                            <p class="text-sm font-bold text-slate-800" id="selected_patient_name">-</p>
                            <p class="text-xs text-slate-500 mt-0.5" id="selected_patient_info">-</p>
                        </div>

                        @if(old('patient_id'))
                            <script>document.getElementById('selected_patient_card').classList.remove('hidden');</script>
                        @endif
                    </div>

                    {{-- Section Pasien Baru --}}
                    <div id="section_pasien_baru" class="hidden border-t border-slate-100 pt-4 mt-4 space-y-3">
                        <div class="flex items-start gap-2 bg-blue-50 border border-blue-200 rounded-xl p-3 text-xs text-blue-700">
                            <i data-lucide="info" class="w-4 h-4 flex-shrink-0 mt-0.5"></i>
                            <span>Sistem akan secara otomatis menetapkan <strong>Nomor Rekam Medis (No. RM) baru</strong> secara terpusat.</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <x-form-input name="new_patient[name]" id="new_name" label="Nama Lengkap Pasien" placeholder="Contoh: Budi Santoso" />
                            <x-form-input name="new_patient[nik]" id="new_nik" label="NIK (16 Digit)" placeholder="3171234567890001" maxlength="16" />
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                            <x-form-input name="new_patient[birth_place]" id="new_birth_place" label="Tempat Lahir" placeholder="Jakarta" />
                            <x-form-input name="new_patient[birth_date]" id="new_birth_date" label="Tanggal Lahir" type="date" />
                            <x-form-select name="new_patient[gender]" id="new_gender" label="Jenis Kelamin">
                                <option value="">-- Pilih --</option>
                                <option value="L" {{ old('new_patient.gender') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('new_patient.gender') === 'P' ? 'selected' : '' }}>Perempuan</option>
                            </x-form-select>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <x-form-input name="new_patient[phone]" id="new_phone" label="Nomor Telepon / WA" placeholder="081234567890" />
                            <x-form-input name="new_patient[address]" id="new_address" label="Alamat Domisili" placeholder="Jl. Sudirman No. 12, Jakarta" />
                        </div>
                    </div>
                </x-card>
            </div>

            {{-- RIGHT: Tujuan Pelayanan --}}
            <div class="lg:col-span-5 space-y-5">
                <x-card title="2. Tujuan Pelayanan & Dokter" icon="stethoscope">
                    <div class="space-y-3">
                        <x-form-select name="service_type" id="service_type" label="Jenis Pelayanan" required>
                            <option value="Rawat Jalan" {{ old('service_type', 'Rawat Jalan') === 'Rawat Jalan' ? 'selected' : '' }}>Rawat Jalan (Poliklinik)</option>
                            <option value="Rawat Inap" {{ old('service_type') === 'Rawat Inap' ? 'selected' : '' }}>Rawat Inap (Opname)</option>
                            <option value="IGD" {{ old('service_type') === 'IGD' ? 'selected' : '' }}>IGD (Gawat Darurat)</option>
                        </x-form-select>

                        <x-form-select name="department_id" id="department_id" label="Poliklinik Tujuan" required>
                            <option value="">-- Pilih Poliklinik --</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                            @endforeach
                        </x-form-select>

                        <x-form-select name="doctor_id" id="doctor_id" label="Dokter Spesialis / DPJP" required>
                            <option value="">-- Pilih Dokter --</option>
                            @foreach($doctors as $doc)
                                <option value="{{ $doc->id }}" data-dept="{{ $doc->department_id }}" {{ old('doctor_id') == $doc->id ? 'selected' : '' }}>
                                    {{ $doc->full_name }} ({{ $doc->department->name ?? 'Umum' }})
                                </option>
                            @endforeach
                        </x-form-select>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <x-form-select name="guarantor" id="guarantor" label="Penjamin Biaya" required>
                                <option value="Umum" {{ old('guarantor', 'Umum') === 'Umum' ? 'selected' : '' }}>Umum (Mandiri)</option>
                                <option value="BPJS Kesehatan" {{ old('guarantor') === 'BPJS Kesehatan' ? 'selected' : '' }}>BPJS Kesehatan</option>
                                <option value="Asuransi Swasta" {{ old('guarantor') === 'Asuransi Swasta' ? 'selected' : '' }}>Asuransi Swasta</option>
                            </x-form-select>
                            <x-form-input name="registration_date" id="registration_date" label="Tanggal Kunjungan" type="date" required value="{{ old('registration_date', date('Y-m-d')) }}" />
                        </div>

                        <x-form-textarea name="notes" id="notes" label="Catatan / Keluhan Utama" rows="2" placeholder="Demam tinggi, batuk 3 hari, konsultasi...">{{ old('notes') }}</x-form-textarea>
                    </div>

                    <div class="mt-4 space-y-2">
                        <button type="submit" class="w-full py-2.5 px-4 bg-teal-600 hover:bg-teal-700 text-white font-bold text-sm rounded-xl shadow-sm transition flex items-center justify-center gap-2 focus:ring-2 focus:ring-teal-500 focus:ring-offset-2">
                            <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                            Proses Pendaftaran Pasien
                        </button>
                        <a href="{{ route('registrations.index') }}" class="w-full py-2 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-xl border border-slate-200 transition flex items-center justify-center gap-2">
                            <i data-lucide="x" class="w-3.5 h-3.5"></i> Batal
                        </a>
                    </div>
                </x-card>
            </div>

        </div>
    </form>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const typeLama = document.getElementById('type_lama');
        const typeBaru = document.getElementById('type_baru');
        const sectionLama = document.getElementById('section_pasien_lama');
        const sectionBaru = document.getElementById('section_pasien_baru');

        function togglePatientType() {
            if (typeLama.checked) {
                sectionLama.classList.remove('hidden');
                sectionBaru.classList.add('hidden');
            } else {
                sectionLama.classList.add('hidden');
                sectionBaru.classList.remove('hidden');
            }
        }

        typeLama.addEventListener('change', togglePatientType);
        typeBaru.addEventListener('change', togglePatientType);
        togglePatientType();

        // Live Patient Search via AJAX
        const searchInput = document.getElementById('patient_search');
        const searchResults = document.getElementById('search_results');
        const patientIdInput = document.getElementById('patient_id');
        const selectedCard = document.getElementById('selected_patient_card');
        const selectedName = document.getElementById('selected_patient_name');
        const selectedInfo = document.getElementById('selected_patient_info');
        const btnClear = document.getElementById('btn_clear_patient');

        let debounceTimer;
        if (searchInput) {
            searchInput.addEventListener('input', function () {
                clearTimeout(debounceTimer);
                const query = this.value.trim();
                if (query.length < 2) {
                    searchResults.classList.add('hidden');
                    return;
                }
                debounceTimer = setTimeout(() => {
                    fetch(`{{ route('registrations.search-patients') }}?q=${encodeURIComponent(query)}`)
                        .then(res => res.json())
                        .then(data => {
                            searchResults.innerHTML = '';
                            if (data.length === 0) {
                                searchResults.innerHTML = '<div class="px-4 py-3 text-xs text-slate-500">Pasien tidak ditemukan.</div>';
                            } else {
                                data.forEach(pt => {
                                    const item = document.createElement('button');
                                    item.type = 'button';
                                    item.className = 'w-full text-left px-4 py-2.5 hover:bg-slate-50 border-b border-slate-100 last:border-0 transition';
                                    item.innerHTML = `<span class="font-semibold text-xs text-slate-800">${pt.name}</span> <span class="inline-block ml-1 px-1.5 py-0.5 bg-teal-100 text-teal-700 rounded text-[10px] font-bold">${pt.mr_number}</span><br><span class="text-[11px] text-slate-500">NIK: ${pt.nik} | Tgl Lahir: ${pt.birth_date} | ${pt.phone || '-'}</span>`;
                                    item.addEventListener('click', () => selectPatient(pt));
                                    searchResults.appendChild(item);
                                });
                            }
                            searchResults.classList.remove('hidden');
                        });
                }, 300);
            });
        }

        function selectPatient(pt) {
            patientIdInput.value = pt.id;
            selectedName.textContent = `${pt.name} (${pt.mr_number})`;
            selectedInfo.textContent = `NIK: ${pt.nik} | Gender: ${pt.gender} | Telepon: ${pt.phone || '-'} | Alamat: ${pt.address || '-'}`;
            selectedCard.classList.remove('hidden');
            searchResults.classList.add('hidden');
            searchInput.value = '';
        }

        if (btnClear) {
            btnClear.addEventListener('click', () => {
                patientIdInput.value = '';
                selectedCard.classList.add('hidden');
            });
        }
    });
</script>
@endpush
