@extends('layouts.admin')

@section('title', 'Tambah Ruangan')

@section('content')
    <x-page-header
        title="Tambah Ruang Rawat Baru"
        subtitle="Daftarkan bangsal, kamar VIP, ICU, atau ruang perawatan baru ke sistem."
        :breadcrumb="[
            ['label' => 'Master Data', 'url' => route('master.index')],
            ['label' => 'Ruang Rawat', 'url' => route('master.rooms.index')],
            ['label' => 'Tambah Ruangan', 'url' => null]
        ]"
    />

    <form method="POST" action="{{ route('master.rooms.store') }}">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <x-card title="Informasi Ruangan" icon="hospital" class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <x-form-input name="code" label="Kode Ruangan" placeholder="Contoh: R-ICU-01" required
                            :value="old('code')" help="Kode unik ruangan (maks. 20 karakter)" />
                        <x-form-input name="name" label="Nama Ruangan" placeholder="Contoh: Ruang ICU Lantai 3" required
                            :value="old('name')" />
                        <x-form-input name="building" label="Nama Gedung" placeholder="Contoh: Gedung A / Gedung Utama" required
                            :value="old('building')" />
                        <x-form-input name="floor" label="Lantai" placeholder="Contoh: 1, 2, 3, Basement" required
                            :value="old('floor')" />
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tipe Ruangan <span class="text-rose-500">*</span></label>
                            <select name="room_type" required
                                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500 @error('room_type') border-rose-400 @enderror">
                                <option value="">-- Pilih Tipe Ruangan --</option>
                                @foreach(['Rawat Inap','ICU','Isolasi','VIP','Operasi'] as $type)
                                    <option value="{{ $type }}" {{ old('room_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                                @endforeach
                            </select>
                            @error('room_type') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </x-card>
            </div>
            <div>
                <x-card title="Status Ruangan" icon="toggle-right" class="p-6">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <div class="relative">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer"
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-slate-200 peer-checked:bg-teal-500 rounded-full transition-colors"></div>
                            <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></div>
                        </div>
                        <div>
                            <span class="text-xs font-semibold text-slate-800">Aktifkan Ruangan</span>
                            <p class="text-[11px] text-slate-500">Ruangan aktif tersedia untuk rawat inap</p>
                        </div>
                    </label>
                </x-card>
            </div>
        </div>

        <x-action-bar>
            <a href="{{ route('master.rooms.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl shadow-sm transition">
                <i data-lucide="save" class="w-4 h-4"></i> Simpan Ruangan
            </button>
        </x-action-bar>
    </form>
@endsection
