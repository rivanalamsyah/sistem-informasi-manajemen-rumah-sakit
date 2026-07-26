@extends('layouts.admin')

@section('title', 'Edit Kategori Obat')

@section('content')
    <x-page-header
        title="Edit Kategori: {{ $medicineCategory->name }}"
        subtitle="Perbarui nama atau deskripsi penggolongan obat."
        :breadcrumb="[
            ['label' => 'Master Data', 'url' => route('master.index')],
            ['label' => 'Kategori Obat', 'url' => route('master.medicine-categories.index')],
            ['label' => 'Edit', 'url' => null]
        ]"
    />

    <form method="POST" action="{{ route('master.medicine-categories.update', $medicineCategory) }}">
        @csrf @method('PUT')
        <div class="max-w-2xl">
            <x-card title="Informasi Kategori Obat" icon="pill" class="p-6 space-y-4">
                <x-form-input name="name" label="Nama Kategori" required :value="old('name', $medicineCategory->name)" />
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Deskripsi (opsional)</label>
                    <textarea name="description" rows="3"
                              class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">{{ old('description', $medicineCategory->description) }}</textarea>
                </div>
            </x-card>
        </div>

        <x-action-bar>
            <a href="{{ route('master.medicine-categories.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl shadow-sm transition">
                <i data-lucide="save" class="w-4 h-4"></i> Simpan Perubahan
            </button>
        </x-action-bar>
    </form>
@endsection
