@extends('layouts.admin')

@section('title', 'Kasir & Billing Pelayanan')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <x-breadcrumb :items="[['label' => 'Kasir & Billing', 'url' => null]]" />
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Manajemen Kasir & Billing Pelayanan</h1>
            <p class="text-xs text-slate-500 mt-0.5">Konsolidasi tagihan medis, penerimaan kas, pelunasan invoice, & cetak kuitansi.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('billing.reports') }}" class="inline-flex items-center gap-2 px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="bar-chart-3" class="w-4 h-4 text-emerald-600"></i> Laporan Keuangan
            </a>
            <a href="{{ route('billing.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-teal-600 hover:bg-teal-700 text-white text-xs font-semibold rounded-xl shadow-sm transition">
                <i data-lucide="plus-circle" class="w-4 h-4"></i> Buat Invoice Tagihan
            </a>
        </div>
    </div>

    <!-- Summary Metrics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <x-card class="p-4">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Pendapatan Kasir Hari Ini</span>
            <h2 class="text-2xl font-bold text-emerald-600 mt-1">Rp {{ number_format($metrics['todayRevenue'], 0, ',', '.') }}</h2>
            <span class="text-[11px] text-emerald-600 flex items-center gap-1 mt-0.5"><i data-lucide="check-circle" class="w-3 h-3"></i> {{ $metrics['todayTransactionsCount'] }} Transaksi Lunas</span>
        </x-card>

        <x-card class="p-4">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Pendapatan Bulan Ini</span>
            <h2 class="text-2xl font-bold text-slate-900 mt-1">Rp {{ number_format($metrics['monthlyRevenue'], 0, ',', '.') }}</h2>
            <span class="text-[11px] text-slate-500 mt-0.5 block">Bulan {{ now()->translatedFormat('F Y') }}</span>
        </x-card>

        <x-card class="p-4">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Invoice Belum Lunas</span>
            <h2 class="text-2xl font-bold text-rose-600 mt-1">{{ number_format($metrics['unpaidInvoicesCount']) }}</h2>
            <span class="text-[11px] text-rose-600 flex items-center gap-1 mt-0.5"><i data-lucide="alert-circle" class="w-3 h-3"></i> Menunggu Kasir</span>
        </x-card>

        <x-card class="p-4">
            <span class="text-[11px] font-semibold text-slate-500 uppercase tracking-wider">Total Invoice Diterbitkan</span>
            <h2 class="text-2xl font-bold text-indigo-600 mt-1">{{ number_format($metrics['totalInvoicesCount']) }}</h2>
            <span class="text-[11px] text-indigo-600 mt-0.5 block">{{ $metrics['paidInvoicesCount'] }} Lunas</span>
        </x-card>
    </div>

    <!-- Filter & Search Bar -->
    <x-card class="p-4 mb-6">
        <form method="GET" action="{{ route('billing.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-5 lg:col-span-5">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>
                    <input type="text" name="search" class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white" placeholder="No. Invoice / No. RM / Nama Pasien..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="sm:col-span-4 lg:col-span-4">
                <select name="status" class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white">
                    <option value="">-- Semua Status Pembayaran --</option>
                    <option value="Belum Lunas" {{ request('status') === 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                    <option value="Lunas" {{ request('status') === 'Lunas' ? 'selected' : '' }}>Lunas</option>
                    <option value="Batal" {{ request('status') === 'Batal' ? 'selected' : '' }}>Batal</option>
                </select>
            </div>
            <div class="sm:col-span-3 lg:col-span-3 flex gap-2">
                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-semibold hover:bg-teal-700 transition flex items-center gap-1.5"><i data-lucide="filter" class="w-3.5 h-3.5"></i> Filter</button>
                <a href="{{ route('billing.index') }}" class="px-3.5 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold border border-slate-200 hover:bg-slate-200 transition">Reset</a>
            </div>
        </form>
    </x-card>

    <!-- Table Invoice Kasir -->
    <x-table :headers="['No. Invoice & Tanggal', 'No. RM / Nama Pasien', 'Layanan', 'Total Tagihan', 'Status Pembayaran', 'Aksi & Kuitansi']">
        @forelse($invoices as $inv)
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-4">
                    <div class="font-bold text-teal-600 text-xs font-mono">{{ $inv->invoice_number }}</div>
                    <span class="text-[11px] text-slate-400">{{ $inv->invoice_date ? $inv->invoice_date->format('d/m/Y H:i') : '-' }}</span>
                </td>
                <td class="px-6 py-4">
                    <div class="font-semibold text-slate-800 text-xs">{{ $inv->patient->name ?? '-' }}</div>
                    <span class="text-[11px] text-slate-400 font-mono">{{ $inv->patient->mr_number ?? '-' }}</span>
                </td>
                <td class="text-xs text-slate-700 px-6 py-4">{{ $inv->registration->queue->department->name ?? $inv->registration->service_type }}</td>
                <td class="px-6 py-4 font-bold text-slate-900 text-xs">
                    Rp {{ number_format($inv->grand_total, 0, ',', '.') }}
                </td>
                <td class="px-6 py-4">
                    <x-badge :type="$inv->status">{{ $inv->status }}</x-badge>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('billing.show', $inv) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-teal-50 text-slate-700 hover:text-teal-700 text-xs font-semibold rounded-xl border border-slate-200/80 transition">
                            <i data-lucide="wallet" class="w-4 h-4"></i> Rincian & Bayar
                        </a>
                        @if ($inv->status === 'Lunas')
                            <a href="{{ route('billing.print', $inv) }}" target="_blank" class="p-1.5 text-slate-500 hover:text-indigo-600 hover:bg-slate-100 rounded-lg transition" title="Cetak Kuitansi A4">
                                <i data-lucide="printer" class="w-4 h-4"></i>
                            </a>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">
                    <x-empty-state title="Belum Ada Invoice Tagihan" description="Tidak ditemukan invoice tagihan medis untuk kriteria filter ini." icon="receipt" />
                </td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-4">
        {{ $invoices->links() }}
    </div>
@endsection
