@extends('layouts.admin')

@section('title', 'Tambah Dokter Baru')

@section('content')
    <x-page-header 
        title="Tambah Dokter Baru" 
        subtitle="Masukkan profil, spesialisasi, dan kontak dokter baru."
        :breadcrumb="[
            ['label' => 'Master Data', 'url' => route('master.index')],
            ['label' => 'Dokter', 'url' => route('master.doctors.index')],
            ['label' => 'Tambah Dokter', 'url' => null]
        ]"
    />

    <div class="max-w-4xl">
        <x-card class="p-6">
            <form method="POST" action="{{ route('master.doctors.store') }}" class="space-y-4">
                @csrf

                <div class="grid grid-cols-12 gap-4">
                    <div class="col-span-12 sm:col-span-3">
                        <x-form-input name="title_prefix" label="Gelar Depan" value="dr." placeholder="dr. / drg." />
                    </div>
                    <div class="col-span-12 sm:col-span-6">
                        <x-form-input name="name" label="Nama Lengkap" required placeholder="Ahmad Hidayat" />
                    </div>
                    <div class="col-span-12 sm:col-span-3">
                        <x-form-input name="title_suffix" label="Gelar Belakang" placeholder="Sp.PD / Sp.A" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <x-form-input name="sip" label="Surat Izin Praktik (SIP)" required placeholder="SIP-507.01/2026/001" />
                    <x-form-select name="department_id" label="Poliklinik Utama" required>
                        <option value="">-- Pilih Poliklinik --</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                        @endforeach
                    </x-form-select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <x-form-input name="specialization" label="Spesialisasi / Keahlian" required placeholder="Penyakit Dalam / Anak / Bedah" />
                    <x-form-input name="phone" label="Nomor Telepon" required placeholder="081234567890" />
                </div>

                <x-form-input name="email" label="Email Dokter" type="email" placeholder="dokter@simrs.com" />

                <div class="pt-2">
                    <label class="flex items-center gap-2 text-xs font-semibold text-slate-700 cursor-pointer">
                        <input type="checkbox" name="is_active" id="is_active" value="1" checked class="rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                        <span>Status Aktif Praktik Dokter</span>
                    </label>
                </div>

                <x-action-bar :cancelUrl="route('master.doctors.index')" saveLabel="Simpan Data Dokter" />
            </form>
        </x-card>
    </div>
@endsection
