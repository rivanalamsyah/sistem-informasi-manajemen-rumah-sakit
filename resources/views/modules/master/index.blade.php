@extends('layouts.admin')

@section('title', 'Pusat Master Data')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <x-breadcrumb :items="[['label' => 'Master Data', 'url' => null]]" />
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Pusat Referensi Master Data SIMRS</h1>
            <p class="text-xs text-slate-500 mt-0.5">Kelola 10 kategori referensi data dasar rumah sakit untuk pelayanan medis, farmasi, & penunjang.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        <!-- 1. Poliklinik -->
        <x-card class="p-5 flex flex-col justify-between h-full">
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-600 flex items-center justify-center">
                        <i data-lucide="building-2" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-slate-900">Poliklinik (Poli)</h3>
                        <span class="text-[11px] text-slate-500">Master Unit Pelayanan</span>
                    </div>
                </div>
                <p class="text-xs text-slate-500 leading-relaxed">Pengaturan kode poliklinik, deskripsi unit, dan status aktif poli.</p>
            </div>
            <a href="{{ route('master.departments.index') }}" class="mt-4 inline-flex items-center justify-center gap-2 w-full py-2 px-3 bg-teal-50 hover:bg-teal-600 text-teal-700 hover:text-white text-xs font-semibold rounded-lg border border-teal-200 hover:border-transparent transition-all">
                Kelola Poli <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </x-card>

        <!-- 2. Dokter -->
        <x-card class="p-5 flex flex-col justify-between h-full">
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                        <i data-lucide="user-check" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-slate-900">Data Dokter</h3>
                        <span class="text-[11px] text-slate-500">Tenaga Medis Spesialis</span>
                    </div>
                </div>
                <p class="text-xs text-slate-500 leading-relaxed">SIP, spesialisasi, unit poliklinik praktik, dan kontak dokter.</p>
            </div>
            <a href="{{ route('master.doctors.index') }}" class="mt-4 inline-flex items-center justify-center gap-2 w-full py-2 px-3 bg-indigo-50 hover:bg-indigo-600 text-indigo-700 hover:text-white text-xs font-semibold rounded-lg border border-indigo-200 hover:border-transparent transition-all">
                Kelola Dokter <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </x-card>

        <!-- 3. Ruangan -->
        <x-card class="p-5 flex flex-col justify-between h-full">
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                        <i data-lucide="door-open" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-slate-900">Ruangan & Bangsal</h3>
                        <span class="text-[11px] text-slate-500">Fasilitas Rawat Inap</span>
                    </div>
                </div>
                <p class="text-xs text-slate-500 leading-relaxed">Master kode gedung, lantai, dan tipe ruangan kamar inap.</p>
            </div>
            <a href="{{ route('master.rooms.index') }}" class="mt-4 inline-flex items-center justify-center gap-2 w-full py-2 px-3 bg-amber-50 hover:bg-amber-600 text-amber-700 hover:text-white text-xs font-semibold rounded-lg border border-amber-200 hover:border-transparent transition-all">
                Kelola Ruangan <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </x-card>

        <!-- 4. Tempat Tidur (Bed) -->
        <x-card class="p-5 flex flex-col justify-between h-full">
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center">
                        <i data-lucide="bed" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-slate-900">Tempat Tidur (Bed)</h3>
                        <span class="text-[11px] text-slate-500">Kapasitas & Okupansi</span>
                    </div>
                </div>
                <p class="text-xs text-slate-500 leading-relaxed">Alokasi tempat tidur per kelas dan status ketersediaan (Kosong/Terisi).</p>
            </div>
            <a href="{{ route('master.beds.index') }}" class="mt-4 inline-flex items-center justify-center gap-2 w-full py-2 px-3 bg-sky-50 hover:bg-sky-600 text-sky-700 hover:text-white text-xs font-semibold rounded-lg border border-sky-200 hover:border-transparent transition-all">
                Kelola Bed <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </x-card>

        <!-- 5. Tindakan Medis -->
        <x-card class="p-5 flex flex-col justify-between h-full">
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                        <i data-lucide="activity" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-slate-900">Tindakan Medis</h3>
                        <span class="text-[11px] text-slate-500">Prosedur Medis RS</span>
                    </div>
                </div>
                <p class="text-xs text-slate-500 leading-relaxed">Katalog nama tindakan, kategori prosedur, & unit poliklinik.</p>
            </div>
            <a href="{{ route('master.services.index') }}" class="mt-4 inline-flex items-center justify-center gap-2 w-full py-2 px-3 bg-rose-50 hover:bg-rose-600 text-rose-700 hover:text-white text-xs font-semibold rounded-lg border border-rose-200 hover:border-transparent transition-all">
                Kelola Tindakan <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </x-card>

        <!-- 6. Tarif Pelayanan -->
        <x-card class="p-5 flex flex-col justify-between h-full">
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                        <i data-lucide="banknote" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-slate-900">Tarif Pelayanan</h3>
                        <span class="text-[11px] text-slate-500">Harga per Kelas</span>
                    </div>
                </div>
                <p class="text-xs text-slate-500 leading-relaxed">Nominal tarif per kelas pelayanan (VVIP, VIP, K1, K2, K3, Umum).</p>
            </div>
            <a href="{{ route('master.tariffs.index') }}" class="mt-4 inline-flex items-center justify-center gap-2 w-full py-2 px-3 bg-emerald-50 hover:bg-emerald-600 text-emerald-700 hover:text-white text-xs font-semibold rounded-lg border border-emerald-200 hover:border-transparent transition-all">
                Kelola Tarif <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </x-card>

        <!-- 7. Kategori Obat -->
        <x-card class="p-5 flex flex-col justify-between h-full">
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center">
                        <i data-lucide="tags" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-slate-900">Kategori Obat</h3>
                        <span class="text-[11px] text-slate-500">Pengelompokan Obat</span>
                    </div>
                </div>
                <p class="text-xs text-slate-500 leading-relaxed">Master golongan obat (Analgesik, Antibiotik, Alkes, dll).</p>
            </div>
            <a href="{{ route('master.medicine-categories.index') }}" class="mt-4 inline-flex items-center justify-center gap-2 w-full py-2 px-3 bg-slate-100 hover:bg-slate-700 text-slate-700 hover:text-white text-xs font-semibold rounded-lg border border-slate-200 hover:border-transparent transition-all">
                Kelola Kategori <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </x-card>

        <!-- 8. Katalog Obat -->
        <x-card class="p-5 flex flex-col justify-between h-full">
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-emerald-600 text-white flex items-center justify-center shadow-xs">
                        <i data-lucide="pill" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-slate-900">Katalog Obat & Alkes</h3>
                        <span class="text-[11px] text-slate-500">Item Farmasi</span>
                    </div>
                </div>
                <p class="text-xs text-slate-500 leading-relaxed">Master harga beli HPP, harga jual, & batas stok minimum obat.</p>
            </div>
            <a href="{{ route('master.medicines.index') }}" class="mt-4 inline-flex items-center justify-center gap-2 w-full py-2 px-3 bg-emerald-50 hover:bg-emerald-600 text-emerald-700 hover:text-white text-xs font-semibold rounded-lg border border-emerald-200 hover:border-transparent transition-all">
                Kelola Obat <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </x-card>

        <!-- 9. Supplier -->
        <x-card class="p-5 flex flex-col justify-between h-full">
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-slate-900 text-white flex items-center justify-center shadow-xs">
                        <i data-lucide="truck" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-slate-900">Supplier / PBM</h3>
                        <span class="text-[11px] text-slate-500">Distributor Obat</span>
                    </div>
                </div>
                <p class="text-xs text-slate-500 leading-relaxed">Kontak distributor PBM, sales, & alamat pemasok farmasi.</p>
            </div>
            <a href="{{ route('master.suppliers.index') }}" class="mt-4 inline-flex items-center justify-center gap-2 w-full py-2 px-3 bg-slate-100 hover:bg-slate-900 text-slate-800 hover:text-white text-xs font-semibold rounded-lg border border-slate-200 hover:border-transparent transition-all">
                Kelola Supplier <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </x-card>

        <!-- 10. Pemeriksaan Lab -->
        <x-card class="p-5 flex flex-col justify-between h-full">
            <div class="space-y-3">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl bg-rose-600 text-white flex items-center justify-center shadow-xs">
                        <i data-lucide="flask-conical" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-sm text-slate-900">Tes Laboratorium</h3>
                        <span class="text-[11px] text-slate-500">Parameter Lab</span>
                    </div>
                </div>
                <p class="text-xs text-slate-500 leading-relaxed">Item pemeriksaan lab, nilai rujukan normal, & biaya tes.</p>
            </div>
            <a href="{{ route('master.laboratory-tests.index') }}" class="mt-4 inline-flex items-center justify-center gap-2 w-full py-2 px-3 bg-rose-50 hover:bg-rose-600 text-rose-700 hover:text-white text-xs font-semibold rounded-lg border border-rose-200 hover:border-transparent transition-all">
                Kelola Tes Lab <i data-lucide="arrow-right" class="w-4 h-4"></i>
            </a>
        </x-card>
    </div>
@endsection
