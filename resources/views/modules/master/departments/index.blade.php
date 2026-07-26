@extends('layouts.admin')

@section('title', 'Master Poliklinik')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <x-breadcrumb :items="[
                ['label' => 'Master Data', 'url' => route('master.index')],
                ['label' => 'Poliklinik', 'url' => null]
            ]" />
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Master Poliklinik (Poli)</h1>
            <p class="text-xs text-slate-500 mt-0.5">Daftar unit pelayanan poliklinik rawat jalan di RSUD Kencana Medika.</p>
        </div>
        <a href="{{ route('master.departments.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold rounded-xl shadow-sm transition">
            <i data-lucide="plus" class="w-4 h-4"></i> Tambah Poli Baru
        </a>
    </div>

    <!-- Filter & Search Bar -->
    <x-card class="p-4 mb-6">
        <form method="GET" action="{{ route('master.departments.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-5 lg:col-span-4">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>
                    <input type="text" name="search" class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white" placeholder="Cari nama atau kode poli..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="sm:col-span-4 lg:col-span-3">
                <select name="status" class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white">
                    <option value="">-- Semua Status --</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Non-Aktif</option>
                </select>
            </div>
            <div class="sm:col-span-3 lg:col-span-2 flex gap-2">
                <button type="submit" class="px-3.5 py-2 bg-teal-600 text-white rounded-xl text-xs font-semibold hover:bg-teal-700 transition flex items-center gap-1.5"><i data-lucide="filter" class="w-3.5 h-3.5"></i> Filter</button>
                <a href="{{ route('master.departments.index') }}" class="px-3.5 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold border border-slate-200 hover:bg-slate-200 transition">Reset</a>
            </div>
        </form>
    </x-card>

    <!-- Table Data -->
    <x-table :headers="['Kode Poli', 'Nama Poliklinik', 'Deskripsi', 'Status', 'Aksi']">
        @forelse($departments as $dept)
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="font-bold text-teal-600 text-xs px-6 py-4">{{ $dept->code }}</td>
                <td class="font-semibold text-slate-800 text-xs px-6 py-4">{{ $dept->name }}</td>
                <td class="text-xs text-slate-500 px-6 py-4">{{ Str::limit($dept->description, 60) }}</td>
                <td class="px-6 py-4">
                    <x-badge :type="$dept->is_active ? 'Aktif' : 'Batal'">
                        {{ $dept->is_active ? 'Aktif' : 'Non-Aktif' }}
                    </x-badge>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-1.5">
                        <a href="{{ route('master.departments.show', $dept) }}" class="p-1.5 text-slate-500 hover:text-teal-600 hover:bg-slate-100 rounded-lg transition" title="Detail">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </a>
                        <a href="{{ route('master.departments.edit', $dept) }}" class="p-1.5 text-slate-500 hover:text-amber-600 hover:bg-slate-100 rounded-lg transition" title="Ubah">
                            <i data-lucide="edit" class="w-4 h-4"></i>
                        </a>
                        <form action="{{ route('master.departments.destroy', $dept) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus Poliklinik ini?');" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-1.5 text-slate-500 hover:text-rose-600 hover:bg-slate-100 rounded-lg transition" title="Hapus">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">
                    <x-empty-state title="Belum Ada Data Poliklinik" description="Tidak ditemukan data poliklinik sesuai kriteria pencarian." />
                </td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-4">
        {{ $departments->links() }}
    </div>
@endsection
