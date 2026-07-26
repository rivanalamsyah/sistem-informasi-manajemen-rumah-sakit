@extends('layouts.admin')

@section('title', 'Master Tempat Tidur (Bed)')

@section('content')
    <x-page-header
        title="Master Tempat Tidur (Bed)"
        subtitle="Daftar status ketersediaan tempat tidur rawat inap di seluruh ruangan rumah sakit."
        :breadcrumb="[
            ['label' => 'Master Data', 'url' => route('master.index')],
            ['label' => 'Tempat Tidur', 'url' => null]
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('master.beds.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl shadow-sm transition">
                <i data-lucide="plus" class="w-4 h-4"></i> Tambah Bed
            </a>
        </x-slot>
    </x-page-header>

    <x-card class="p-4 mb-6">
        <form method="GET" action="{{ route('master.beds.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-5">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500"
                           placeholder="Cari no. bed atau ruangan...">
                </div>
            </div>
            <div class="sm:col-span-3">
                <select name="status" class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">-- Semua Status --</option>
                    @foreach(['Kosong','Terisi','Dibersihkan','Pemeliharaan'] as $st)
                        <option value="{{ $st }}" {{ request('status') == $st ? 'selected' : '' }}>{{ $st }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-2 flex gap-2">
                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-semibold hover:bg-teal-700 transition flex items-center gap-1.5">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i> Filter
                </button>
                <a href="{{ route('master.beds.index') }}" class="px-3.5 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold border border-slate-200 hover:bg-slate-200 transition">Reset</a>
            </div>
        </form>
    </x-card>

    <x-table :headers="['No. Bed', 'Ruangan / Bangsal', 'Kelas Perawatan', 'Tarif / Malam', 'Status Bed', 'Aksi']">
        @forelse($beds as $bed)
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-4 font-bold text-teal-600 text-xs font-mono">{{ $bed->bed_number }}</td>
                <td class="px-6 py-4">
                    <div class="font-semibold text-slate-800 text-xs">{{ $bed->room->name ?? '-' }}</div>
                    <span class="text-[11px] text-slate-400">{{ $bed->room->building ?? '' }} (Lt. {{ $bed->room->floor ?? '' }})</span>
                </td>
                <td class="px-6 py-4">
                    <span class="px-2.5 py-0.5 text-[11px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-full">{{ $bed->class }}</span>
                </td>
                <td class="px-6 py-4 font-bold text-emerald-600 text-xs">Rp {{ number_format($bed->price_per_night, 0, ',', '.') }}</td>
                <td class="px-6 py-4"><x-badge :type="$bed->status">{{ $bed->status }}</x-badge></td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('master.beds.show', $bed) }}" class="p-1.5 text-slate-400 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition" title="Detail">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </a>
                        <a href="{{ route('master.beds.edit', $bed) }}" class="p-1.5 text-slate-400 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition" title="Edit">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                        </a>
                        <form action="{{ route('master.beds.destroy', $bed) }}" method="POST" class="inline"
                              onsubmit="return confirm('Hapus bed {{ $bed->bed_number }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">
                    <x-empty-state title="Belum Ada Bed" description="Tambahkan tempat tidur (bed) ke ruangan rawat inap." icon="bed" />
                </td>
            </tr>
        @endforelse
    </x-table>
    <div class="mt-4">{{ $beds->links() }}</div>
@endsection
