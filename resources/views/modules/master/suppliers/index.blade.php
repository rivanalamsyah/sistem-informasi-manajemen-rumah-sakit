@extends('layouts.admin')

@section('title', 'Master Supplier Obat & Alkes')

@section('content')
    <x-page-header
        title="Master Supplier Obat & Alkes"
        subtitle="Daftar distributor, pedagang besar farmasi (PBF), dan pemasok alat kesehatan."
        :breadcrumb="[
            ['label' => 'Master Data', 'url' => route('master.index')],
            ['label' => 'Supplier', 'url' => null]
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('master.suppliers.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl shadow-sm transition">
                <i data-lucide="plus" class="w-4 h-4"></i> Tambah Supplier
            </a>
        </x-slot>
    </x-page-header>

    <x-card class="p-4 mb-6">
        <form method="GET" action="{{ route('master.suppliers.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-6">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500"
                           placeholder="Cari nama, kode, atau kontak supplier...">
                </div>
            </div>
            <div class="sm:col-span-2 flex gap-2">
                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-semibold hover:bg-teal-700 transition flex items-center gap-1.5">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i> Filter
                </button>
                <a href="{{ route('master.suppliers.index') }}" class="px-3.5 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold border border-slate-200 hover:bg-slate-200 transition">Reset</a>
            </div>
        </form>
    </x-card>

    <x-table :headers="['Kode', 'Nama Supplier / PBF', 'Kontak PIC', 'Telepon', 'Email', 'Status', 'Aksi']">
        @forelse($suppliers as $sup)
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-4 font-bold text-teal-600 text-xs font-mono">{{ $sup->code }}</td>
                <td class="px-6 py-4 font-semibold text-slate-800 text-xs">{{ $sup->name }}</td>
                <td class="px-6 py-4 text-xs text-slate-600">{{ $sup->contact_name ?? '-' }}</td>
                <td class="px-6 py-4 text-xs text-slate-600">{{ $sup->phone }}</td>
                <td class="px-6 py-4 text-xs text-slate-500">{{ $sup->email ?? '-' }}</td>
                <td class="px-6 py-4">
                    <x-badge :type="$sup->is_active ? 'Aktif' : 'Batal'">
                        {{ $sup->is_active ? 'Aktif' : 'Non-Aktif' }}
                    </x-badge>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('master.suppliers.show', $sup) }}" class="p-1.5 text-slate-400 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition" title="Detail">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </a>
                        <a href="{{ route('master.suppliers.edit', $sup) }}" class="p-1.5 text-slate-400 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition" title="Edit">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                        </a>
                        <form action="{{ route('master.suppliers.destroy', $sup) }}" method="POST" class="inline"
                              onsubmit="return confirm('Hapus supplier {{ $sup->name }}?')">
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
                <td colspan="7">
                    <x-empty-state title="Belum Ada Data Supplier" description="Tambahkan distributor atau PBF pemasok obat dan alat kesehatan." icon="truck" />
                </td>
            </tr>
        @endforelse
    </x-table>
    <div class="mt-4">{{ $suppliers->links() }}</div>
@endsection
