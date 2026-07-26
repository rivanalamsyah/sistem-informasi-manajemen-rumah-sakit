@extends('layouts.admin')

@section('title', 'Pelayanan Laboratorium (LIS)')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <x-breadcrumb :items="[['label' => 'Laboratorium', 'url' => null]]" />
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Pelayanan Sistem Informasi Laboratorium (LIS)</h1>
            <p class="text-xs text-slate-500 mt-0.5">Penerimaan order sampel, pemeriksaan spesimen, input hasil lab, & validasi analis.</p>
        </div>
        <a href="{{ route('laboratory.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold rounded-xl shadow-sm transition">
            <i data-lucide="plus-circle" class="w-4 h-4"></i> Buat Order Lab Baru
        </a>
    </div>

    <!-- Summary Metrics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
        <x-card class="p-4">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Order Lab Hari Ini</span>
            <h2 class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($metrics['ordersToday']) }}</h2>
            <span class="text-[11px] text-slate-500 mt-0.5 block">Permintaan Medis</span>
        </x-card>

        <x-card class="p-4">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Menunggu Sampel</span>
            <h2 class="text-2xl font-bold text-amber-600 mt-1">{{ number_format($metrics['waitingSample']) }}</h2>
            <span class="text-[11px] text-amber-600 flex items-center gap-1 mt-0.5"><i data-lucide="clock" class="w-3 h-3"></i> Belum Ambil Sampel</span>
        </x-card>

        <x-card class="p-4">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Sedang Diperiksa</span>
            <h2 class="text-2xl font-bold text-sky-600 mt-1">{{ number_format($metrics['processing']) }}</h2>
            <span class="text-[11px] text-sky-600 flex items-center gap-1 mt-0.5"><i data-lucide="flask-conical" class="w-3 h-3"></i> Pengujian Sampel</span>
        </x-card>

        <x-card class="p-4">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Hasil Selesai / EMR</span>
            <h2 class="text-2xl font-bold text-emerald-600 mt-1">{{ number_format($metrics['completed']) }}</h2>
            <span class="text-[11px] text-emerald-600 flex items-center gap-1 mt-0.5"><i data-lucide="check-circle" class="w-3 h-3"></i> Divalidasi Analis</span>
        </x-card>

        <x-card class="p-4">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Hasil Abnormal / Critical</span>
            <h2 class="text-2xl font-bold text-rose-600 mt-1">{{ number_format($metrics['abnormalResults']) }}</h2>
            <span class="text-[11px] text-rose-600 flex items-center gap-1 mt-0.5"><i data-lucide="alert-circle" class="w-3 h-3"></i> Perlu Perhatian DPJP</span>
        </x-card>
    </div>

    <!-- Filter & Search Bar -->
    <x-card class="p-4 mb-6">
        <form method="GET" action="{{ route('laboratory.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-5 lg:col-span-5">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>
                    <input type="text" name="search" class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white" placeholder="No. Order Lab / No. RM / Nama Pasien..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="sm:col-span-4 lg:col-span-4">
                <select name="status" class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white">
                    <option value="">-- Semua Status Order --</option>
                    <option value="Menunggu Sampel" {{ request('status') === 'Menunggu Sampel' ? 'selected' : '' }}>Menunggu Sampel</option>
                    <option value="Diproses" {{ request('status') === 'Diproses' ? 'selected' : '' }}>Diproses Pengujian</option>
                    <option value="Selesai" {{ request('status') === 'Selesai' ? 'selected' : '' }}>Selesai / Terbaca EMR</option>
                    <option value="Batal" {{ request('status') === 'Batal' ? 'selected' : '' }}>Batal Order</option>
                </select>
            </div>
            <div class="sm:col-span-3 lg:col-span-3 flex gap-2">
                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-semibold hover:bg-teal-700 transition flex items-center gap-1.5"><i data-lucide="filter" class="w-3.5 h-3.5"></i> Filter</button>
                <a href="{{ route('laboratory.index') }}" class="px-3.5 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold border border-slate-200 hover:bg-slate-200 transition">Reset</a>
            </div>
        </form>
    </x-card>

    <!-- Table Order Lab -->
    <x-table :headers="['No. Order & Waktu', 'No. RM / Nama Pasien', 'Dokter Pengirim', 'Item Tes Lab', 'Status Order', 'Aksi & Hasil']">
        @forelse($orders as $ord)
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-4">
                    <div class="font-bold text-teal-600 text-xs font-mono">{{ $ord->order_number }}</div>
                    <span class="text-[11px] text-slate-400">{{ $ord->order_date ? $ord->order_date->format('d/m/Y H:i') : '-' }}</span>
                </td>
                <td class="px-6 py-4">
                    <div class="font-semibold text-slate-800 text-xs">{{ $ord->patient->name ?? '-' }}</div>
                    <span class="text-[11px] text-slate-400 font-mono">{{ $ord->patient->mr_number ?? '-' }}</span>
                </td>
                <td class="text-xs text-slate-700 px-6 py-4">{{ $ord->doctor->full_name ?? '-' }}</td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                        <i data-lucide="flask-conical" class="w-3 h-3 text-rose-600"></i> {{ $ord->results->count() }} Parameter Tes
                    </span>
                </td>
                <td class="px-6 py-4">
                    <x-badge :type="$ord->status">{{ $ord->status }}</x-badge>
                </td>
                <td class="px-6 py-4">
                    <a href="{{ route('laboratory.show', $ord) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-teal-50 text-slate-700 hover:text-teal-700 text-xs font-semibold rounded-xl border border-slate-200/80 transition">
                        <i data-lucide="eye" class="w-4 h-4"></i> Detail & Hasil
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">
                    <x-empty-state title="Belum Ada Order Laboratorium" description="Tidak ditemukan order laboratorium untuk kriteria filter ini." icon="flask-conical" />
                </td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-4">
        {{ $orders->links() }}
    </div>
@endsection
