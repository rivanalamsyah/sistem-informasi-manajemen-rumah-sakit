@extends('layouts.admin')

@section('title', 'Detail Supplier')

@section('content')
    <x-page-header
        title="{{ $supplier->name }}"
        subtitle="Detail informasi distributor dan riwayat transaksi pengadaan obat."
        :breadcrumb="[
            ['label' => 'Master Data', 'url' => route('master.index')],
            ['label' => 'Supplier', 'url' => route('master.suppliers.index')],
            ['label' => $supplier->code, 'url' => null]
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('master.suppliers.edit', $supplier) }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold rounded-xl shadow-sm transition">
                <i data-lucide="pencil" class="w-4 h-4"></i> Edit
            </a>
            <a href="{{ route('master.suppliers.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
            </a>
        </x-slot>
    </x-page-header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <x-card class="p-6">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-14 h-14 rounded-2xl bg-sky-100 flex items-center justify-center flex-shrink-0">
                        <i data-lucide="truck" class="w-7 h-7 text-sky-600"></i>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">{{ $supplier->name }}</h2>
                        <p class="text-xs text-slate-500 font-mono">{{ $supplier->code }}</p>
                    </div>
                    <x-badge :type="$supplier->is_active ? 'Aktif' : 'Batal'" class="ml-auto">
                        {{ $supplier->is_active ? 'Aktif' : 'Non-Aktif' }}
                    </x-badge>
                </div>
                <dl class="grid grid-cols-2 gap-4 text-xs">
                    <div class="bg-slate-50 rounded-xl p-3">
                        <dt class="text-slate-500 font-medium mb-0.5">Nama PIC</dt>
                        <dd class="font-bold text-slate-800">{{ $supplier->contact_name ?? '-' }}</dd>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3">
                        <dt class="text-slate-500 font-medium mb-0.5">Telepon</dt>
                        <dd class="font-bold text-slate-800">{{ $supplier->phone }}</dd>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3">
                        <dt class="text-slate-500 font-medium mb-0.5">Email</dt>
                        <dd class="font-semibold text-slate-700">{{ $supplier->email ?? '-' }}</dd>
                    </div>
                    <div class="bg-slate-50 rounded-xl p-3">
                        <dt class="text-slate-500 font-medium mb-0.5">Status</dt>
                        <dd><x-badge :type="$supplier->is_active ? 'Aktif' : 'Batal'">{{ $supplier->is_active ? 'Aktif' : 'Non-Aktif' }}</x-badge></dd>
                    </div>
                    @if($supplier->address)
                        <div class="col-span-2 bg-slate-50 rounded-xl p-3">
                            <dt class="text-slate-500 font-medium mb-0.5">Alamat Perusahaan</dt>
                            <dd class="font-semibold text-slate-700">{{ $supplier->address }}</dd>
                        </div>
                    @endif
                </dl>
            </x-card>
        </div>

        <div>
            <x-card title="Aksi Cepat" icon="zap" class="p-5">
                <div class="space-y-2">
                    <a href="{{ route('master.suppliers.edit', $supplier) }}"
                       class="flex items-center gap-2 w-full px-3 py-2 text-xs font-semibold text-sky-700 bg-sky-50 hover:bg-sky-100 border border-sky-200 rounded-xl transition">
                        <i data-lucide="pencil" class="w-3.5 h-3.5"></i> Edit Data Supplier
                    </a>
                    <form action="{{ route('master.suppliers.destroy', $supplier) }}" method="POST"
                          onsubmit="return confirm('Hapus supplier {{ $supplier->name }}?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="flex items-center gap-2 w-full px-3 py-2 text-xs font-semibold text-rose-700 bg-rose-50 hover:bg-rose-100 border border-rose-200 rounded-xl transition">
                            <i data-lucide="trash-2" class="w-3.5 h-3.5"></i> Hapus Supplier Ini
                        </button>
                    </form>
                </div>
            </x-card>
        </div>
    </div>
@endsection
