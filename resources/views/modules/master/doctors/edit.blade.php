@extends('layouts.admin')

@section('title', 'Edit Dokter')

@section('content')
    <x-page-header 
        title="Edit Dokter: {{ $doctor->full_name }}" 
        subtitle="Perbarui profil, spesialisasi, dan jadwal praktik dokter."
        :breadcrumb="[
            ['label' => 'Master Data', 'url' => route('master.index')],
            ['label' => 'Dokter', 'url' => route('master.doctors.index')],
            ['label' => 'Edit Dokter', 'url' => null]
        ]"
    />

    <div class="max-w-4xl">
        <x-card class="p-6">
            <form method="POST" action="{{ route('master.doctors.update', $doctor) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Identitas Nama Dokter -->
                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 sm:col-span-3">
                        <x-form-input name="title_prefix" label="Gelar Depan" :value="$doctor->title_prefix" placeholder="dr." />
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <x-form-input name="name" label="Nama Lengkap" :value="$doctor->name" required placeholder="Nama tanpa gelar" />
                    </div>
                    <div class="col-span-12 sm:col-span-3">
                        <x-form-input name="title_suffix" label="Gelar Belakang" :value="$doctor->title_suffix" placeholder="Sp.A, M.Kes" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <x-form-input name="sip" label="No. Surat Izin Praktik (SIP)" :value="$doctor->sip" required placeholder="SIP/XXXXX/XXXX" />
                    <x-form-select name="department_id" label="Poliklinik Utama" required>
                        <option value="">-- Pilih Poliklinik --</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ old('department_id', $doctor->department_id) == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </x-form-select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <x-form-input name="specialization" label="Spesialisasi / Keahlian" :value="$doctor->specialization" required placeholder="Spesialis Anak, Umum, dll." />
                    <x-form-input name="phone" label="Nomor Telepon" :value="$doctor->phone" required placeholder="08xx-xxxx-xxxx" />
                </div>

                <x-form-input name="email" label="Email Dokter" type="email" :value="$doctor->email" placeholder="dokter@email.com" />

                <div class="pt-2">
                    <label class="flex items-center gap-2 text-xs font-semibold text-slate-700 cursor-pointer">
                        <input type="checkbox" name="is_active" id="is_active" value="1" {{ $doctor->is_active ? 'checked' : '' }} class="rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                        <span>Status Aktif Praktik Dokter</span>
                    </label>
                </div>

                <x-action-bar :cancelUrl="route('master.doctors.index')" saveLabel="Perbarui Data Dokter" />
            </form>
        </x-card>
    </div>
@endsection
