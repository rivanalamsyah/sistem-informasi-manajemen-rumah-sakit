@extends('layouts.admin')

@section('title', 'Master Pemeriksaan Laboratorium')

@section('content')
    <x-page-header
        title="Master Pemeriksaan Laboratorium"
        subtitle="Katalog item pengujian laboratorium, satuan, nilai rujukan normal, dan harga."
        :breadcrumb="[
            ['label' => 'Master Data', 'url' => route('master.index')],
            ['label' => 'Pemeriksaan Lab', 'url' => null]
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('master.laboratory-tests.create') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl shadow-sm transition">
                <i data-lucide="plus" class="w-4 h-4"></i> Tambah Tes Lab
            </a>
        </x-slot>
    </x-page-header>

    <x-card class="p-4 mb-6">
        <form method="GET" action="{{ route('master.laboratory-tests.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-5">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500"
                           placeholder="Cari nama, kode, atau kategori tes...">
                </div>
            </div>
            <div class="sm:col-span-2 flex gap-2">
                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-semibold hover:bg-teal-700 transition flex items-center gap-1.5">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i> Filter
                </button>
                <a href="{{ route('master.laboratory-tests.index') }}" class="px-3.5 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold border border-slate-200 hover:bg-slate-200 transition">Reset</a>
            </div>
        </form>
    </x-card>

    <x-table :headers="['Kode', 'Nama Pemeriksaan', 'Kategori', 'Satuan', 'Nilai Rujukan', 'Harga (Rp)', 'Status', 'Aksi']">
        @forelse($tests as $test)
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-4 font-bold text-teal-600 text-xs font-mono">{{ $test->code }}</td>
                <td class="px-6 py-4 font-semibold text-slate-800 text-xs">{{ $test->name }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-0.5 text-[11px] font-semibold bg-violet-50 text-violet-700 border border-violet-200 rounded-full">{{ $test->category }}</span>
                </td>
                <td class="px-6 py-4 text-xs font-mono text-slate-600">{{ $test->unit ?? '-' }}</td>
                <td class="px-6 py-4 text-xs text-slate-500">
                    <span title="Pria">L: {{ $test->reference_range_male ?? '-' }}</span><br>
                    <span title="Wanita">P: {{ $test->reference_range_female ?? '-' }}</span>
                </td>
                <td class="px-6 py-4 font-bold text-emerald-600 text-xs">Rp {{ number_format($test->price, 0, ',', '.') }}</td>
                <td class="px-6 py-4"><x-badge :type="$test->is_active ? 'Aktif' : 'Batal'">{{ $test->is_active ? 'Aktif' : 'Non-Aktif' }}</x-badge></td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('master.laboratory-tests.show', $test) }}" class="p-1.5 text-slate-400 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition" title="Detail">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </a>
                        <a href="{{ route('master.laboratory-tests.edit', $test) }}" class="p-1.5 text-slate-400 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition" title="Edit">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                        </a>
                        <form action="{{ route('master.laboratory-tests.destroy', $test) }}" method="POST" class="inline"
                              onsubmit="return confirm('Hapus tes lab {{ $test->name }}?')">
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
                <td colspan="8">
                    <x-empty-state title="Belum Ada Item Tes Lab" description="Tambahkan item pengujian laboratorium seperti Hematologi, Kimia Darah, Urinalisis." icon="flask-conical" />
                </td>
            </tr>
        @endforelse
    </x-table>
    <div class="mt-4">{{ $tests->links() }}</div>
@endsection
