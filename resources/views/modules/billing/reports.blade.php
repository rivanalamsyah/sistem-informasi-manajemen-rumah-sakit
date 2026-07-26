@extends('layouts.admin')

@section('title', 'Ringkasan & Laporan Keuangan SIMRS')

@section('content')
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <x-breadcrumb :items="[
                ['label' => 'Kasir & Billing', 'url' => route('billing.index')],
                ['label' => 'Laporan Keuangan', 'url' => null]
            ]" />
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">Laporan & Ringkasan Keuangan SIMRS</h1>
            <p class="text-xs text-slate-500 mt-0.5">Analisis pendapatan kasir harian, bulanan, & log penerimaan kuitansi pelunasan.</p>
        </div>
        <a href="{{ route('billing.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>
    </div>

    <!-- Summary Metrics Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <x-card class="p-5">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Pendapatan Hari Ini</span>
            <h2 class="text-2xl font-bold text-emerald-600 mt-1">Rp {{ number_format($metrics['todayRevenue'], 0, ',', '.') }}</h2>
            <span class="text-xs text-slate-500 mt-1 block">{{ $metrics['todayTransactionsCount'] }} Transaksi Penerimaan</span>
        </x-card>

        <x-card class="p-5">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Pendapatan Bulan Ini</span>
            <h2 class="text-2xl font-bold text-slate-900 mt-1">Rp {{ number_format($metrics['monthlyRevenue'], 0, ',', '.') }}</h2>
            <span class="text-xs text-slate-500 mt-1 block">Bulan {{ now()->translatedFormat('F Y') }}</span>
        </x-card>

        <x-card class="p-5">
            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Tagihan Belum Lunas</span>
            <h2 class="text-2xl font-bold text-rose-600 mt-1">{{ number_format($metrics['unpaidInvoicesCount']) }} Invoice</h2>
            <span class="text-xs text-rose-600 mt-1 block">Perlu Tindak Lanjut</span>
        </x-card>
    </div>

    <!-- Log Penerimaan Pembayaran Terbaru -->
    <x-card title="Log Penerimaan Kas & Kuitansi Terbaru" icon="receipt" class="p-6">
        <x-table :headers="['Waktu Transaksi', 'No. Kuitansi', 'No. Invoice', 'Nama Pasien', 'Metode Pembayaran', 'Jumlah Dibayar', 'Kasir Petugas']">
            @forelse($recentPayments as $pay)
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
                        <x-empty-state title="Belum Ada Transaksi Pembayaran" description="Belum ada transaksi penerimaan kuitansi kasir." icon="wallet" />
                    </td>
                </tr>
            @endforelse
        </x-table>

        <div class="mt-4">
            {{ $recentPayments->links() }}
        </div>
    </x-card>
@endsection
