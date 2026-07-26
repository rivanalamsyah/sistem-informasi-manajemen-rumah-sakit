@extends('layouts.admin')

@section('title', 'Tambah Tindakan Medis')

@section('content')
    <x-page-header
        title="Tambah Tindakan Medis Baru"
        subtitle="Daftarkan tindakan, prosedur, atau layanan medis baru ke katalog sistem."
        :breadcrumb="[
            ['label' => 'Master Data', 'url' => route('master.index')],
            ['label' => 'Tindakan Medis', 'url' => route('master.services.index')],
            ['label' => 'Tambah Tindakan', 'url' => null]
        ]"
    />

    <form method="POST" action="{{ route('master.services.store') }}">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Form Utama --}}
            <div class="lg:col-span-2 space-y-5">
                <x-card title="Informasi Tindakan Medis" icon="stethoscope" class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <x-form-input name="code" label="Kode Tindakan" placeholder="Contoh: TND-001" required
                            :value="old('code')" help="Kode unik tindakan (maks. 20 karakter)" />
                        <x-form-input name="name" label="Nama Tindakan / Prosedur" placeholder="Contoh: Konsultasi Dokter Umum" required
                            :value="old('name')" />
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kategori Tindakan <span class="text-rose-500">*</span></label>
                            <select name="category" required
                                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500 @error('category') border-rose-400 @enderror">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach(['Konsultasi','Tindakan','Operasi','Rawat Inap','Penunjang','Radiologi','Rehabilitasi'] as $cat)
                                    <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                            @error('category') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Poliklinik Terkait</label>
                            <select name="department_id"
                                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                                <option value="">-- Semua Poli / Umum --</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </x-card>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-5">
                <x-card title="Status & Publikasi" icon="toggle-right" class="p-6">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <div class="relative">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer"
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-slate-200 peer-checked:bg-teal-500 rounded-full transition-colors"></div>
                            <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></div>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-slate-800">Aktifkan Tindakan</span>
                            <p class="text-[11px] text-slate-500">Tindakan aktif tersedia di form pendaftaran</p>
                        </div>
                    </label>
                </x-card>

                <x-card class="p-5 bg-sky-50 border border-sky-200">
                    <div class="flex gap-3">
                        <i data-lucide="info" class="w-4 h-4 text-sky-600 flex-shrink-0 mt-0.5"></i>
                        <div class="text-xs text-sky-700">
                            <p class="font-semibold mb-1">Tentang Kode Tindakan</p>
                            <p>Kode tindakan digunakan sebagai referensi di EMR, billing, dan laporan. Gunakan format yang konsisten, misalnya <strong>KON-001</strong> untuk konsultasi.</p>
                        </div>
                    </div>
                </x-card>
            </div>
        </div>

        <x-action-bar>
            <a href="{{ route('master.services.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl shadow-sm transition">
                <i data-lucide="save" class="w-4 h-4"></i> Simpan Tindakan
            </button>
        </x-action-bar>
    </form>
@endsection
