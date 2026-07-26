@extends('layouts.admin')

@section('title', 'Master Tarif Pelayanan')

@section('content')
    <x-page-header
        title="Master Tarif Pelayanan"
        subtitle="Daftar harga tindakan dan layanan medis per kelas perawatan dan jenis jaminan."
        :breadcrumb="[
            ['label' => 'Master Data', 'url' => route('master.index')],
            ['label' => 'Tarif Pelayanan', 'url' => null]
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('master.tariffs.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl shadow-sm transition">
                <i data-lucide="plus" class="w-4 h-4"></i> Tambah Tarif
            </a>
        </x-slot>
    </x-page-header>

    <x-card class="p-4 mb-6">
        <form method="GET" action="{{ route('master.tariffs.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-5">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500"
                           placeholder="Cari nama tindakan...">
                </div>
            </div>
            <div class="sm:col-span-3">
                <select name="class" class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">-- Semua Kelas --</option>
                    @foreach(['Umum','VVIP','VIP','Kelas 1','Kelas 2','Kelas 3'] as $cls)
                        <option value="{{ $cls }}" {{ request('class') == $cls ? 'selected' : '' }}>{{ $cls }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-2 flex gap-2">
                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-semibold hover:bg-teal-700 transition flex items-center gap-1.5">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i> Filter
                </button>
                <a href="{{ route('master.tariffs.index') }}" class="px-3.5 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold border border-slate-200 hover:bg-slate-200 transition">Reset</a>
            </div>
        </form>
    </x-card>

    <x-table :headers="['Tindakan Medis', 'Kelas Layanan', 'Harga Tarif', 'Deskripsi', 'Status', 'Aksi']">
        @forelse($tariffs as $tar)
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-4">
                    <div class="font-semibold text-slate-800 text-xs">{{ $tar->service->name ?? '-' }}</div>
                    <span class="text-[11px] text-slate-400 font-mono">{{ $tar->service->code ?? '' }}</span>
                </td>
                <td class="px-6 py-4">
                    <span class="px-2.5 py-0.5 text-[11px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-full">{{ $tar->class }}</span>
                </td>
                <td class="px-6 py-4 font-bold text-emerald-600 text-sm">Rp {{ number_format($tar->amount, 0, ',', '.') }}</td>
                <td class="px-6 py-4 text-xs text-slate-500">{{ $tar->description ?? '-' }}</td>
                <td class="px-6 py-4">
                    <x-badge :type="$tar->is_active ? 'Aktif' : 'Batal'">
                        {{ $tar->is_active ? 'Aktif' : 'Non-Aktif' }}
                    </x-badge>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('master.tariffs.show', $tar) }}" class="p-1.5 text-slate-400 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition" title="Detail">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </a>
                        <a href="{{ route('master.tariffs.edit', $tar) }}" class="p-1.5 text-slate-400 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition" title="Edit">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                        </a>
                        <form action="{{ route('master.tariffs.destroy', $tar) }}" method="POST" class="inline"
                              onsubmit="return confirm('Hapus tarif ini?')">
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
                    <x-empty-state title="Belum Ada Data Tarif" description="Tambahkan tarif tindakan medis per kelas perawatan." icon="receipt" />
                </td>
            </tr>
        @endforelse
    </x-table>
    <div class="mt-4">{{ $tariffs->links() }}</div>
@endsection
