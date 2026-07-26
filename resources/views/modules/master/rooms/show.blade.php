@extends('layouts.admin')

@section('title', 'Detail Ruangan')

@section('content')
    <x-page-header
        title="{{ $room->name }}"
        subtitle="Detail informasi ruangan dan daftar tempat tidur (bed) yang tersedia."
        :breadcrumb="[
            ['label' => 'Master Data', 'url' => route('master.index')],
            ['label' => 'Ruang Rawat', 'url' => route('master.rooms.index')],
            ['label' => $room->code, 'url' => null]
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('master.rooms.edit', $room) }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold rounded-xl shadow-sm transition">
                <i data-lucide="pencil" class="w-4 h-4"></i> Edit Ruangan
            </a>
            <a href="{{ route('master.rooms.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
            </a>
        </x-slot>
    </x-page-header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-5">
            <x-card class="p-6">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-teal-100 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="hospital" class="w-7 h-7 text-teal-600"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">{{ $room->name }}</h2>
                        <p class="text-xs text-slate-500 font-mono">{{ $room->code }} · {{ $room->building }} (Lantai {{ $room->floor }})</p>
                    </div>
                    <x-badge :type="$room->is_active ? 'Aktif' : 'Batal'" class="ml-auto">
                        {{ $room->is_active ? 'Aktif' : 'Non-Aktif' }}
                    </x-badge>
                </div>
                <dl class="grid grid-cols-2 gap-4 text-xs">
                    <div class="bg-slate-50 rounded-xl p-3">
                        <dt class="text-slate-500 font-medium mb-0.5">Tipe Ruangan</dt>
                        <dd class="font-bold text-violet-700">{{ $room->room_type }}</dd>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3">
                        <dt class="text-slate-500 font-medium mb-0.5">Gedung / Lantai</dt>
                        <dd class="font-bold text-slate-800">{{ $room->building }} / Lt. {{ $room->floor }}</dd>
                    </div>
                </dl>
            </x-card>

            <x-card title="Daftar Tempat Tidur (Bed) di Ruangan Ini" icon="bed" class="p-6">
                @if($room->beds->count())
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach($room->beds as $bed)
                            <div class="p-3 bg-slate-50 border border-slate-200 rounded-xl flex items-center justify-between">
                                <div>
                                    <span class="text-xs font-bold text-slate-800">Bed {{ $bed->bed_number }}</span>
                                    <p class="text-[11px] text-slate-500">Kelas {{ $bed->class }} · Rp {{ number_format($bed->price_per_night, 0, ',', '.') }}/malam</p>
                                </div>
                                <x-badge :type="$bed->status">{{ $bed->status }}</x-badge>
                            </div>
                        @endforeach
                    </div>
                @else
                    <x-empty-state title="Belum Ada Bed" description="Belum ada tempat tidur yang didaftarkan di ruangan ini." icon="bed" />
                @endif
            </x-card>
        </div>

        <div>
            <x-card title="Aksi Cepat" icon="zap" class="p-5">
                <div class="space-y-2">
                    <a href="{{ route('master.beds.create') }}?room_id={{ $room->id }}"
                       class="flex items-center gap-2 w-full px-3 py-2 text-xs font-semibold text-teal-700 bg-teal-50 hover:bg-teal-100 border border-teal-200 rounded-xl transition">
                        <i data-lucide="plus" class="w-3.5 h-3.5"></i> Tambah Bed di Ruangan Ini
                    </a>
                    <a href="{{ route('master.rooms.edit', $room) }}"
                       class="flex items-center gap-2 w-full px-3 py-2 text-xs font-semibold text-sky-700 bg-sky-50 hover:bg-sky-100 border border-sky-200 rounded-xl transition">
                        <i data-lucide="pencil" class="w-3.5 h-3.5"></i> Edit Ruangan
                    </a>
                </div>
            </x-card>
        </div>
    </div>
@endsection
