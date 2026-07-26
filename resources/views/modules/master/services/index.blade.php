@extends('layouts.admin')

@section('title', 'Master Tindakan Medis')

@section('content')
    <x-page-header
        title="Master Tindakan Medis"
        subtitle="Daftar tindakan, prosedur konsultasi, dan pelayanan medis yang tersedia di rumah sakit."
        :breadcrumb="[
            ['label' => 'Master Data', 'url' => route('master.index')],
            ['label' => 'Tindakan Medis', 'url' => null]
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('master.services.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl shadow-sm transition">
                <i data-lucide="plus" class="w-4 h-4"></i> Tambah Tindakan
            </a>
        </x-slot>
    </x-page-header>

    {{-- Filter Bar --}}
    <x-card class="p-4 mb-6">
        <form method="GET" action="{{ route('master.services.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-5">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500"
                           placeholder="Cari nama atau kode tindakan...">
                </div>
            </div>
            <div class="sm:col-span-3">
                <select name="category" class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">-- Semua Kategori --</option>
                    @foreach(['Konsultasi','Tindakan','Operasi','Rawat Inap','Penunjang','Radiologi','Rehabilitasi'] as $cat)
                        <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-2 flex gap-2">
                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-semibold hover:bg-teal-700 transition flex items-center gap-1.5">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i> Filter
                </button>
                <a href="{{ route('master.services.index') }}" class="px-3.5 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold border border-slate-200 hover:bg-slate-200 transition">Reset</a>
            </div>
        </form>
    </x-card>

    {{-- Table --}}
    <x-table :headers="['Kode Tindakan', 'Nama Tindakan / Prosedur', 'Kategori', 'Poliklinik Terkait', 'Status', 'Aksi']">
        @forelse($services as $srv)
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-4 font-bold text-teal-600 text-xs font-mono">{{ $srv->code }}</td>
                <td class="px-6 py-4">
                    <div class="font-semibold text-slate-800 text-xs">{{ $srv->name }}</div>
                </td>
                <td class="px-6 py-4">
                    <span class="px-2 py-0.5 text-[11px] font-semibold bg-sky-50 text-sky-700 border border-sky-200 rounded-full">{{ $srv->category }}</span>
                </td>
                <td class="px-6 py-4 text-xs text-slate-500">{{ $srv->department->name ?? 'Semua Poli / Umum' }}</td>
                <td class="px-6 py-4">
                    <x-badge :type="$srv->is_active ? 'Aktif' : 'Batal'">
                        {{ $srv->is_active ? 'Aktif' : 'Non-Aktif' }}
                    </x-badge>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('master.services.show', $srv) }}" class="p-1.5 text-slate-400 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition" title="Detail">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </a>
                        <a href="{{ route('master.services.edit', $srv) }}" class="p-1.5 text-slate-400 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition" title="Edit">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                        </a>
                        <form action="{{ route('master.services.destroy', $srv) }}" method="POST" class="inline"
                              onsubmit="return confirm('Hapus tindakan {{ $srv->name }}?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">
                    <x-empty-state title="Belum Ada Data Tindakan" description="Belum ada tindakan medis yang terdaftar. Klik tombol Tambah Tindakan untuk memulai." icon="stethoscope" />
                </td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-4">{{ $services->links() }}</div>
@endsection
