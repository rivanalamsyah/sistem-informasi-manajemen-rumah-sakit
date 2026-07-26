@extends('layouts.admin')

@section('title', 'Edit Poliklinik')

@section('content')
    <x-page-header 
        title="Edit Poliklinik: {{ $department->name }}" 
        subtitle="Perbarui informasi data poliklinik rumah sakit."
        :breadcrumb="[
            ['label' => 'Master Data', 'url' => route('master.index')],
            ['label' => 'Poliklinik', 'url' => route('master.departments.index')],
            ['label' => 'Edit Poli', 'url' => null]
        ]"
    />

    <div class="max-w-3xl">
        <x-card class="p-6">
            <form method="POST" action="{{ route('master.departments.update', $department) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <x-form-input 
                    name="code" 
                    label="Kode Poliklinik" 
                    :value="$department->code"
                    required 
                />

                <x-form-input 
                    name="name" 
                    label="Nama Poliklinik" 
                    :value="$department->name"
                    required 
                />

                <x-form-textarea 
                    name="description" 
                    label="Deskripsi Layanan" 
                    :value="$department->description"
                />

                <div class="pt-2">
                    <label class="flex items-center gap-2 text-xs font-semibold text-slate-700 cursor-pointer">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ $department->is_active ? 'checked' : '' }} class="rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                        <span>Status Aktif Pelayanan Poliklinik</span>
                    </label>
                </div>

                <x-action-bar :cancelUrl="route('master.departments.index')" saveLabel="Perbarui Data Poli" />
            </form>
        </x-card>
    </div>
@endsection
