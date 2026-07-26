@extends('layouts.admin')

@section('title', 'Tambah Poliklinik Baru')

@section('content')
    <x-page-header 
        title="Tambah Poliklinik Baru" 
        subtitle="Masukkan informasi data unit pelayanan poliklinik baru rumah sakit."
        :breadcrumb="[
            ['label' => 'Master Data', 'url' => route('master.index')],
            ['label' => 'Poliklinik', 'url' => route('master.departments.index')],
            ['label' => 'Tambah Poli', 'url' => null]
        ]"
    />

    <div class="max-w-3xl">
        <x-card class="p-6">
            <form method="POST" action="{{ route('master.departments.store') }}" class="space-y-4">
                @csrf

                <x-form-input 
                    name="code" 
                    label="Kode Poliklinik" 
                    placeholder="Contoh: POL-UMUM" 
                    required 
                    helper="Kode unik identifier untuk poliklinik."
                />

                <x-form-input 
                    name="name" 
                    label="Nama Poliklinik" 
                    placeholder="Contoh: Poliklinik Spesialis Anak" 
                    required 
                />

                <x-form-textarea 
                    name="description" 
                    label="Deskripsi Layanan" 
                    placeholder="Keterangan singkat cakupan pelayanan poli..." 
                />

                <div class="pt-2">
                    <label class="flex items-center gap-2 text-xs font-semibold text-slate-700 cursor-pointer">
                        <input type="checkbox" name="is_active" id="is_active" value="1" checked class="rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                        <span>Status Aktif Pelayanan Poliklinik</span>
                    </label>
                </div>

                <x-action-bar :cancelUrl="route('master.departments.index')" saveLabel="Simpan Data Poli" />
            </form>
        </x-card>
    </div>
@endsection
