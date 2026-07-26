@extends('layouts.admin')

@section('title', 'Detail Kategori Obat')

@section('content')
    <x-page-header
        title="{{ $medicineCategory->name }}"
        subtitle="Detail kategori obat dan daftar obat-obatan yang tergolong dalam kategori ini."
        :breadcrumb="[
            ['label' => 'Master Data', 'url' => route('master.index')],
            ['label' => 'Kategori Obat', 'url' => route('master.medicine-categories.index')],
            ['label' => $medicineCategory->name, 'url' => null]
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('master.medicine-categories.edit', $medicineCategory) }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold rounded-xl shadow-sm transition">
                <i data-lucide="pencil" class="w-4 h-4"></i> Edit Kategori
            </a>
            <a href="{{ route('master.medicine-categories.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
            </a>
        </x-slot>
    </x-page-header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-5">
            <x-card class="p-6">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 rounded-2xl bg-teal-100 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="pill" class="w-7 h-7 text-teal-600"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">{{ $medicineCategory->name }}</h2>
                        <p class="text-xs text-slate-500">{{ $medicineCategory->description ?? 'Tidak ada deskripsi.' }}</p>
                    </div>
                </div>
            </x-card>

            <x-card title="Daftar Obat dalam Kategori Ini" icon="pill" class="p-6">
                @if($medicineCategory->medicines->count())
                    <div class="divide-y divide-slate-100">
                        @foreach($medicineCategory->medicines as $med)
                            <div class="py-2.5 flex items-center justify-between">
                                <div>
                                    <span class="text-xs font-bold text-slate-800">{{ $med->name }}</span>
                                    <p class="text-[11px] text-slate-400 font-mono">{{ $med->code }} · {{ $med->unit }}</p>
                                </div>
                                <span class="text-xs font-bold text-emerald-600">Rp {{ number_format($med->sell_price, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <x-empty-state title="Belum Ada Obat" description="Belum ada obat yang terdaftar dalam kategori ini." icon="pill" />
                @endif
            </x-card>
        </div>

        <div>
            <x-card title="Aksi Cepat" icon="zap" class="p-5">
                <div class="space-y-2">
                    <a href="{{ route('master.medicine-categories.edit', $medicineCategory) }}"
                       class="flex items-center gap-2 w-full px-3 py-2 text-xs font-semibold text-sky-700 bg-sky-50 hover:bg-sky-100 border border-sky-200 rounded-xl transition">
                        <i data-lucide="pencil" class="w-3.5 h-3.5"></i> Edit Kategori
                    </a>
                    <form action="{{ route('master.medicine-categories.destroy', $medicineCategory) }}" method="POST"
                          onsubmit="return confirm('Hapus kategori ini?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="flex items-center gap-2 w-full px-3 py-2 text-xs font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded-xl transition">
                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Hapus Kategori Ini
                        </button>
                    </form>
                </div>
            </x-card>
        </div>
    </div>
@endsection
