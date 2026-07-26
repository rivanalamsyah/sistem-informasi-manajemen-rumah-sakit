@extends('layouts.admin')

@section('title', 'Dashboard Manajemen Gudang & Logistik')

@section('content')
    <x-page-header
        title="Dashboard Gudang & Logistik"
        subtitle="Monitoring stok barang, persediaan logistik medis, penerimaan, pengeluaran, & mutasi barang."
        :breadcrumb="[
            ['label' => 'Logistik & Gudang', 'url' => null]
        ]"
    >
        <x-slot name="actions">
            <div class="flex items-center gap-2">
                <a href="{{ route('warehouse.receipts.create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl shadow-xs transition">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i> Penerimaan
                </a>
                <a href="{{ route('warehouse.dispatches.create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold rounded-xl shadow-xs transition">
                    <i data-lucide="arrow-up-right" class="w-4 h-4"></i> Pengeluaran
                </a>
                <a href="{{ route('warehouse.mutations.create') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-xs transition">
                    <i data-lucide="arrow-left-right" class="w-4 h-4"></i> Mutasi
                </a>
            </div>
        </x-slot>
    </x-page-header>

    {{-- Sub Navigation Tabs --}}
    <div class="flex items-center gap-2 border-b border-slate-200 pb-3 mb-6 overflow-x-auto">
        <a href="{{ route('warehouse.index') }}" class="px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-bold flex items-center gap-2 shadow-xs">
            <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
        </a>
        <a href="{{ route('warehouse.items.index') }}" class="px-4 py-2 bg-white text-slate-700 hover:bg-slate-100 border border-slate-200 rounded-xl text-xs font-semibold flex items-center gap-2 transition">
            <i data-lucide="package" class="w-4 h-4"></i> Master Barang
        </a>
        <a href="{{ route('warehouse.masters.index') }}" class="px-4 py-2 bg-white text-slate-700 hover:bg-slate-100 border border-slate-200 rounded-xl text-xs font-semibold flex items-center gap-2 transition">
            <i data-lucide="warehouse" class="w-4 h-4"></i> Gudang & Rak
        </a>
        <a href="{{ route('warehouse.receipts.index') }}" class="px-4 py-2 bg-white text-slate-700 hover:bg-slate-100 border border-slate-200 rounded-xl text-xs font-semibold flex items-center gap-2 transition">
            <i data-lucide="file-input" class="w-4 h-4"></i> Penerimaan
        </a>
        <a href="{{ route('warehouse.dispatches.index') }}" class="px-4 py-2 bg-white text-slate-700 hover:bg-slate-100 border border-slate-200 rounded-xl text-xs font-semibold flex items-center gap-2 transition">
            <i data-lucide="file-output" class="w-4 h-4"></i> Pengeluaran
        </a>
        <a href="{{ route('warehouse.mutations.index') }}" class="px-4 py-2 bg-white text-slate-700 hover:bg-slate-100 border border-slate-200 rounded-xl text-xs font-semibold flex items-center gap-2 transition">
            <i data-lucide="arrow-left-right" class="w-4 h-4"></i> Mutasi
        </a>
        <a href="{{ route('warehouse.opnames.index') }}" class="px-4 py-2 bg-white text-slate-700 hover:bg-slate-100 border border-slate-200 rounded-xl text-xs font-semibold flex items-center gap-2 transition">
            <i data-lucide="clipboard-check" class="w-4 h-4"></i> Stock Opname
        </a>
        <a href="{{ route('warehouse.stock-card') }}" class="px-4 py-2 bg-white text-slate-700 hover:bg-slate-100 border border-slate-200 rounded-xl text-xs font-semibold flex items-center gap-2 transition">
            <i data-lucide="credit-card" class="w-4 h-4"></i> Kartu Stok
        </a>
        <a href="{{ route('warehouse.reports') }}" class="px-4 py-2 bg-white text-slate-700 hover:bg-slate-100 border border-slate-200 rounded-xl text-xs font-semibold flex items-center gap-2 transition">
            <i data-lucide="bar-chart-2" class="w-4 h-4"></i> Laporan
        </a>
    </div>

    {{-- Stats Cards Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-card class="p-5">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Item Barang</span>
                    <h2 class="text-2xl font-black text-slate-900 mt-1">{{ number_format($metrics['totalItems']) }}</h2>
                    <span class="text-[11px] text-slate-500 mt-0.5 block">Item Terdaftar</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center">
                    <i data-lucide="package" class="w-6 h-6"></i>
                </div>
            </div>
        </x-card>

        <x-card class="p-5">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Nilai Persediaan</span>
                    <h2 class="text-2xl font-black text-emerald-600 mt-1">Rp {{ number_format($metrics['totalValue'], 0, ',', '.') }}</h2>
                    <span class="text-[11px] text-emerald-600 mt-0.5 block">Akumulasi Aset Gudang</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <i data-lucide="wallet" class="w-6 h-6"></i>
                </div>
            </div>
        </x-card>

        <x-card class="p-5">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Barang Min Stock</span>
                    <h2 class="text-2xl font-black text-amber-600 mt-1">{{ number_format($metrics['lowStockCount']) }} Item</h2>
                    <span class="text-[11px] text-amber-600 mt-0.5 block">Perlu Reorder / PO</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <i data-lucide="alert-triangle" class="w-6 h-6"></i>
                </div>
            </div>
        </x-card>

        <x-card class="p-5">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Kedaluwarsa < 6 Bln</span>
                    <h2 class="text-2xl font-black text-rose-600 mt-1">{{ number_format($metrics['expiringCount']) }} Batch</h2>
                    <span class="text-[11px] text-rose-600 mt-0.5 block">Pantau Tanggal Expired</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center">
                    <i data-lucide="calendar-x" class="w-6 h-6"></i>
                </div>
            </div>
        </x-card>
    </div>

    {{-- Section 2: Chart & Alerts Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Chart --}}
        <div class="lg:col-span-2">
            <x-card title="Pergerakan Stok Barang (7 Hari Terakhir)" icon="line-chart" class="p-6">
                <div class="h-64">
                    <canvas id="movementChart"></canvas>
                </div>
            </x-card>
        </div>

        {{-- Side Cards --}}
        <div class="space-y-6">
            <x-card title="Ringkasan Transaksi Hari Ini" icon="clock" class="p-5">
                <div class="space-y-3 text-xs">
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                        <span class="text-slate-600 font-medium flex items-center gap-2">
                            <i data-lucide="arrow-down-left" class="w-4 h-4 text-emerald-600"></i> Penerimaan Masuk
                        </span>
                        <span class="font-bold text-slate-800">{{ $metrics['todayReceiptCount'] }} Faktur</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl">
                        <span class="text-slate-600 font-medium flex items-center gap-2">
                            <i data-lucide="arrow-up-right" class="w-4 h-4 text-sky-600"></i> Pengeluaran Distribusi
                        </span>
                        <span class="font-bold text-slate-800">{{ $metrics['todayDispatchCount'] }} Dokumen</span>
                    </div>
                </div>
            </x-card>

            <x-card title="Peringatan Stok Rendah" icon="alert-triangle" class="p-5">
                @forelse($lowStockItems as $it)
                    <div class="flex items-center justify-between py-2 border-b border-slate-100 last:border-0 text-xs">
                        <div>
                            <span class="font-bold text-slate-800 block">{{ $it->name }}</span>
                            <span class="text-[11px] text-slate-400 font-mono">{{ $it->code }}</span>
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-0.5 rounded-full text-[11px] font-bold bg-amber-100 text-amber-800 border border-amber-200">
                                Sisa: {{ $it->total_stock }} {{ $it->unit }}
                            </span>
                            <span class="text-[10px] text-slate-400 block mt-0.5">Min: {{ $it->min_stock }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-xs text-slate-400 text-center py-2">Semua stok barang dalam kondisi cukup.</p>
                @endforelse
            </x-card>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('movementChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($charts['labels']),
                datasets: [
                    {
                        label: 'Barang Masuk',
                        data: @json($charts['inData']),
                        borderColor: '#0d9488',
                        backgroundColor: 'rgba(13, 148, 136, 0.1)',
                        fill: true,
                        tension: 0.3
                    },
                    {
                        label: 'Barang Keluar',
                        data: @json($charts['outData']),
                        borderColor: '#0284c7',
                        backgroundColor: 'rgba(2, 132, 199, 0.1)',
                        fill: true,
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'top' }
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    });
</script>
@endpush
