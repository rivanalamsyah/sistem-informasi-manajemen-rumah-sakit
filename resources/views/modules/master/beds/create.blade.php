@extends('layouts.admin')

@section('title', 'Tambah Tempat Tidur (Bed)')

@section('content')
    <x-page-header
        title="Tambah Tempat Tidur (Bed)"
        subtitle="Daftarkan bed tempat tidur baru ke dalam ruangan rawat inap."
        :breadcrumb="[
            ['label' => 'Master Data', 'url' => route('master.index')],
            ['label' => 'Tempat Tidur', 'url' => route('master.beds.index')],
            ['label' => 'Tambah Bed', 'url' => null]
        ]"
    />

    <form method="POST" action="{{ route('master.beds.store') }}">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2">
                <x-card title="Informasi Bed Tempat Tidur" icon="bed" class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Ruangan <span class="text-rose-500">*</span></label>
                            <select name="room_id" required
                                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                                <option value="">-- Pilih Ruangan --</option>
                                @foreach($rooms as $rm)
                                    <option value="{{ $rm->id }}" {{ (old('room_id', request('room_id')) == $rm->id) ? 'selected' : '' }}>
                                        {{ $rm->code }} — {{ $rm->name }} (Lt. {{ $rm->floor }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <x-form-input name="bed_number" label="Nomor Bed" placeholder="Contoh: B-101-A" required :value="old('bed_number')" />
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kelas Perawatan <span class="text-rose-500">*</span></label>
                            <select name="class" required
                                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach(['VVIP','VIP','Kelas 1','Kelas 2','Kelas 3'] as $cls)
                                    <option value="{{ $cls }}" {{ old('class') == $cls ? 'selected' : '' }}>{{ $cls }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Status Bed <span class="text-rose-500">*</span></label>
                            <select name="status" required
                                    class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                                @foreach(['Kosong','Terisi','Dibersihkan','Pemeliharaan'] as $st)
                                    <option value="{{ $st }}" {{ old('status', 'Kosong') == $st ? 'selected' : '' }}>{{ $st }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tarif per Malam (Rp) <span class="text-rose-500">*</span></label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-xs text-slate-500">Rp</span>
                                <input type="number" name="price_per_night" required min="0" step="1000"
                                       value="{{ old('price_per_night') }}"
                                       class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                            </div>
                        </div>
                    </div>
                </x-card>
            </div>
        </div>

        <x-action-bar>
            <a href="{{ route('master.beds.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl shadow-sm transition">
                <i data-lucide="save" class="w-4 h-4"></i> Simpan Bed
            </button>
        </x-action-bar>
    </form>
@endsection
