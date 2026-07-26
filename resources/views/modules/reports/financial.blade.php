@extends('layouts.admin')

@section('title', 'Laporan Keuangan & Pendapatan')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <x-breadcrumb :items="[
                ['label' => 'Laporan & Eksekutif', 'url' => route('reports.index')],
                ['label' => 'Laporan Keuangan', 'url' => null]
            ]" />
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Laporan Keuangan & Audit Pendapatan Kasir</h1>
            <p class="text-xs text-slate-500 mt-0.5">Analisis pendapatan per periode, kuitansi kasir, & audit penerimaan dana medis.</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('reports.export-csv', 'financial') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-semibold rounded-xl shadow-sm transition">
                <i data-lucide="download" class="w-4 h-4"></i> Ekspor CSV Laporan
            </a>
            <a href="{{ route('reports.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
            </a>
        </div>
    </div>

    <!-- Summary Box -->
    <x-card class="p-6 mb-6 bg-gradient-to-br from-teal-700 to-teal-900 text-white">
        <span class="text-xs font-semibold uppercase tracking-wider text-teal-200">Total Akumulasi Pendapatan (Filter Terpilih)</span>
        <h2 class="text-3xl font-bold mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
        <span class="text-xs text-teal-200 mt-1 block">Telah diverifikasi lunas oleh Kasir SIMRS</span>
    </x-card>

    <x-table :headers="['Waktu Transaksi', 'No. Kuitansi', 'No. Invoice', 'Nama Pasien', 'Metode Pembayaran', 'Jumlah Dibayar', 'Kasir Petugas']">
        @forelse($payments as $pay)
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-4 text-xs font-semibold text-slate-800">
                    {{ $pay->payment_date ? $pay->payment_date->format('d/m/Y H:i') : '-' }}
                </td>
                <td class="font-mono text-xs font-bold text-emerald-600 px-6 py-4">{{ $pay->receipt_number }}</td>
                <td class="font-mono text-xs font-semibold text-teal-600 px-6 py-4">{{ $pay->invoice->invoice_number ?? '-' }}</td>
                <td class="font-semibold text-slate-800 text-xs px-6 py-4">{{ $pay->invoice->patient->name ?? '-' }}</td>
                <td class="px-6 py-4">
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">{{ $pay->payment_method }}</span>
                </td>
                <td class="px-6 py-4 font-bold text-emerald-600 text-xs">Rp {{ number_format($pay->amount_paid, 0, ',', '.') }}</td>
                <td class="text-xs text-slate-600 px-6 py-4">{{ $pay->cashier->name ?? 'Kasir' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7">
                    <x-empty-state title="Belum Ada Transaksi Keuangan" description="Tidak ada data penerimaan kasir." />
                </td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-4">
        {{ $payments->links() }}
    </div>
@endsection
