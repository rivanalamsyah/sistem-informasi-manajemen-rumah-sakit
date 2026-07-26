@extends('layouts.admin')

@section('title', 'Master Gudang & Lokasi Rak')

@section('content')
    <x-page-header
        title="Master Gudang & Lokasi Rak"
        subtitle="Kelola gedung gudang, depo farmasi, & penataan rak penyimpanan barang."
        :breadcrumb="[
            ['label' => 'Gudang', 'url' => route('warehouse.index')],
            ['label' => 'Gudang & Rak', 'url' => null]
        ]"
    />

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- List Gudang --}}
        <div class="lg:col-span-2 space-y-6">
            @foreach($warehouses as $wh)
                <x-card class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="font-bold text-slate-900 text-sm">{{ $wh->name }}</h3>
                                <span class="px-2 py-0.5 text-[10px] font-bold bg-teal-100 text-teal-800 rounded-full font-mono">{{ $wh->code }}</span>
                            </div>
                            <p class="text-xs text-slate-500 mt-0.5">{{ $wh->type }} · {{ $wh->location_description ?? 'Tidak ada keterangan lokasi' }}</p>
                        </div>
                        <x-badge :type="$wh->is_active ? 'Aktif' : 'Batal'">{{ $wh->is_active ? 'Aktif' : 'Nonaktif' }}</x-badge>
                    </div>

                    <div class="border-t border-slate-100 pt-4">
                        <h4 class="text-xs font-bold text-slate-700 mb-2 flex items-center gap-1.5"><i data-lucide="layers" class="w-3.5 h-3.5 text-teal-600"></i> Lokasi & Rak Penyimpanan ({{ $wh->locations->count() }})</h4>
                        @if($wh->locations->count())
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                @foreach($wh->locations as $loc)
                                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs flex justify-between items-center">
                                        <div>
                                            <span class="font-bold text-slate-800">{{ $loc->name }}</span>
                                            <span class="text-[10px] text-slate-400 block font-mono">Kode: {{ $loc->code }} | Rak: {{ $loc->rack_number ?? '-' }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-xs text-slate-400">Belum ada rak/lokasi terdaftar di gudang ini.</p>
                        @endif
                    </div>
                </x-card>
            @endforeach
        </div>

        {{-- Form Tambah --}}
        <div class="space-y-6">
            <x-card title="Tambah Gudang Baru" icon="plus-circle" class="p-5">
                <form method="POST" action="{{ route('warehouse.masters.store-warehouse') }}" class="space-y-4">
                    @csrf
                    <x-form-input name="code" label="Kode Gudang" placeholder="Contoh: GUD-02" required />
                    <x-form-input name="name" label="Nama Gudang / Depo" placeholder="Contoh: Depo Rawat Inap Lt 2" required />
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Tipe Gudang <span class="text-rose-500">*</span></label>
                        <select name="type" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                            @foreach(['Gudang Utama','Depo Farmasi','Gudang Alkes','Depo Logistik'] as $t)
                                <option value="{{ $t }}">{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                    <x-form-input name="location_description" label="Keterangan Lokasi" placeholder="Contoh: Gedung B Lt 2" />
                    <button type="submit" class="w-full py-2 bg-teal-600 hover:bg-teal-700 text-white font-bold text-xs rounded-xl shadow-xs transition">
                        Simpan Gudang Baru
                    </button>
                </form>
            </x-card>

            <x-card title="Tambah Rak / Lokasi Baru" icon="layers" class="p-5">
                <form method="POST" action="{{ route('warehouse.masters.store-location') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Pilih Gudang <span class="text-rose-500">*</span></label>
                        <select name="warehouse_id" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                            @foreach($warehouses as $wh)
                                <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <x-form-input name="code" label="Kode Lokasi" placeholder="Contoh: RAK-C1" required />
                    <x-form-input name="name" label="Nama Rak / Posisi" placeholder="Contoh: Rak Obat Keras C1" required />
                    <x-form-input name="rack_number" label="Nomor Rak" placeholder="Contoh: C-01" />
                    <button type="submit" class="w-full py-2 bg-sky-600 hover:bg-sky-700 text-white font-bold text-xs rounded-xl shadow-xs transition">
                        Simpan Rak Baru
                    </button>
                </form>
            </x-card>
        </div>
    </div>
@endsection
