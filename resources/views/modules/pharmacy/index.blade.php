@extends('layouts.admin')

@section('title', 'Pelayanan Farmasi & E-Resep')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <x-breadcrumb :items="[['label' => 'Farmasi & Obat', 'url' => null]]" />
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Pelayanan E-Resep & Depo Farmasi</h1>
            <p class="text-xs text-slate-500 mt-0.5">Pemrosesan resep medis, penyerahan obat (dispensing), & kontrol stok apotek.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('pharmacy.inventory') }}" class="inline-flex items-center gap-2 px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="package" class="w-4 h-4 text-emerald-600"></i> Inventori Stok
            </a>
            <a href="{{ route('pharmacy.movements') }}" class="inline-flex items-center gap-2 px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left-right" class="w-4 h-4 text-indigo-600"></i> Mutasi Stok
            </a>
        </div>
    </div>

    <!-- Summary Metrics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <x-card class="p-4">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">E-Resep Masuk Hari Ini</span>
            <h2 class="text-2xl font-bold text-teal-600 mt-1">{{ number_format($metrics['prescriptionsToday']) }}</h2>
            <span class="text-[11px] text-teal-600 flex items-center gap-1 mt-0.5"><i data-lucide="receipt" class="w-3 h-3"></i> Resep Dokter</span>
        </x-card>
        <x-card class="p-4">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Menunggu Diproses</span>
            <h2 class="text-2xl font-bold text-amber-600 mt-1">{{ number_format($metrics['waitingPrescriptions']) }}</h2>
            <span class="text-[11px] text-amber-600 flex items-center gap-1 mt-0.5"><i data-lucide="clock" class="w-3 h-3"></i> Antrean Apotek</span>
        </x-card>
        <x-card class="p-4">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Selesai Diserahkan</span>
            <h2 class="text-2xl font-bold text-emerald-600 mt-1">{{ number_format($metrics['completedPrescriptions']) }}</h2>
            <span class="text-[11px] text-emerald-600 flex items-center gap-1 mt-0.5"><i data-lucide="check-circle" class="w-3 h-3"></i> Dispensing Selesai</span>
        </x-card>
        <x-card class="p-4">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Stok Kritis / Expiring</span>
            <h2 class="text-2xl font-bold text-rose-600 mt-1">{{ number_format($metrics['lowStockCount'] + $metrics['expiringCount']) }}</h2>
            <span class="text-[11px] text-rose-600 flex items-center gap-1 mt-0.5"><i data-lucide="alert-triangle" class="w-3 h-3"></i> Perlu Re-order</span>
        </x-card>
    </div>

    <!-- Filter & Search Bar -->
    <x-card class="p-4 mb-6">
        <form method="GET" action="{{ route('pharmacy.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-5 lg:col-span-5">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>
                    <input type="text" name="search" class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white" placeholder="No. Resep / No. RM / Nama Pasien..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="sm:col-span-4 lg:col-span-4">
                <select name="status" class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white">
                    <option value="">-- Semua Status Resep --</option>
                    <option value="Menunggu" {{ request('status') === 'Menunggu' ? 'selected' : '' }}>Menunggu Validasi</option>
                    <option value="Diproses" {{ request('status') === 'Diproses' ? 'selected' : '' }}>Diproses Apotek</option>
                    <option value="Selesai" {{ request('status') === 'Selesai' ? 'selected' : '' }}>Selesai (Diserahkan)</option>
                    <option value="Batal" {{ request('status') === 'Batal' ? 'selected' : '' }}>Batal</option>
                </select>
            </div>
            <div class="sm:col-span-3 lg:col-span-3 flex gap-2">
                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-semibold hover:bg-teal-700 transition flex items-center gap-1.5"><i data-lucide="filter" class="w-3.5 h-3.5"></i> Filter</button>
                <a href="{{ route('pharmacy.index') }}" class="px-3.5 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold border border-slate-200 hover:bg-slate-200 transition">Reset</a>
            </div>
        </form>
    </x-card>

    <!-- Table E-Resep -->
    <x-table :headers="['No. Resep & Waktu', 'No. RM / Nama Pasien', 'Dokter Pengirim', 'Item Obat', 'Status Resep', 'Aksi & Dispensing']">
        @forelse($prescriptions as $pres)
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-4">
                    <div class="font-bold text-teal-600 text-xs font-mono">{{ $pres->prescription_number }}</div>
                    <span class="text-[11px] text-slate-400">{{ $pres->prescription_date ? $pres->prescription_date->format('d/m/Y H:i') : '-' }}</span>
                </td>
                <td class="px-6 py-4">
                    <div class="font-semibold text-slate-800 text-xs">{{ $pres->patient->name ?? '-' }}</div>
                    <span class="text-[11px] text-slate-400 font-mono">{{ $pres->patient->mr_number ?? '-' }}</span>
                </td>
                <td class="text-xs text-slate-700 px-6 py-4">{{ $pres->doctor->full_name ?? '-' }}</td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                        <i data-lucide="pill" class="w-3 h-3 text-emerald-600"></i> {{ $pres->items->count() }} Item Obat
                    </span>
                </td>
                <td class="px-6 py-4">
                    <x-badge :type="$pres->status">{{ $pres->status }}</x-badge>
                </td>
                <td class="px-6 py-4">
                    <a href="{{ route('pharmacy.show', $pres) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-teal-50 text-slate-700 hover:text-teal-700 text-xs font-semibold rounded-xl border border-slate-200/80 transition">
                        <i data-lucide="eye" class="w-4 h-4"></i> Detail Resep
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">
                    <x-empty-state title="Belum Ada Resep Farmasi" description="Tidak ditemukan e-resep dokter untuk kriteria filter ini." icon="pill" />
                </td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-4">
        {{ $prescriptions->links() }}
    </div>
@endsection
