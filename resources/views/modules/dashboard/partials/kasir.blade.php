<!-- Kasir Specific Dashboard View -->
<div class="space-y-6">
    <!-- Header Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <x-kpi-card
            title="Pendapatan Kasir Hari Ini"
            value="Rp {{ number_format($metrics['todayRevenue'], 0, ',', '.') }}"
            icon="wallet"
            color="emerald"
            subtext="Penerimaan Lunas Hari Ini"
        />

        <x-kpi-card
            title="Invoice Belum Lunas"
            value="{{ number_format($metrics['unpaidInvoicesCount']) }}"
            icon="receipt"
            color="rose"
            subtext="Menunggu Pelunasan Pembayaran"
        />

        <x-kpi-card
            title="Total Kunjungan Pasien Hari Ini"
            value="{{ number_format($metrics['todayPatients']) }}"
            icon="users"
            color="teal"
            subtext="Pelayanan Medis Terlayani"
        />
    </div>

    <!-- Quick Actions Kasir -->
    <x-card title="Aksi Keuangan & Billing Kasir" icon="zap">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <a href="{{ route('billing.index') }}" class="p-4 bg-teal-600 hover:bg-teal-700 text-white rounded-xl flex items-center gap-3 transition shadow-xs group">
                <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center font-bold">
                    <i data-lucide="receipt" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="text-xs font-bold">Daftar Tagihan & Kasir Billing</div>
                    <span class="text-[10px] text-teal-100">Proses Transaksi & Cetak Kuitansi</span>
                </div>
            </a>

            <a href="{{ route('billing.reports') }}" class="p-4 bg-slate-50 hover:bg-emerald-50/60 border border-slate-200/80 rounded-xl flex items-center gap-3 transition group">
                <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                    <i data-lucide="bar-chart-3" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-800">Laporan Kasir & Rekap Pendapatan</div>
                    <span class="text-[10px] text-slate-500">Laporan Penerimaan Kas Harian</span>
                </div>
            </a>
        </div>
    </x-card>

    <!-- Table Invoice Belum Lunas -->
    <x-card title="Invoice Menunggu Pembayaran (Belum Lunas)" icon="clock">
        <x-table :headers="['No. Invoice', 'Pasien / No. RM', 'Tgl Tagihan', 'Total Tagihan', 'Status', 'Aksi']">
            @forelse($notifications['unpaidInvoices'] as $inv)
                <tr class="hover:bg-slate-50/80 transition-colors">
                    <td class="font-bold text-rose-600 text-xs">{{ $inv->invoice_number }}</td>
                    <td>
                        <div class="font-semibold text-slate-800 text-xs">{{ $inv->patient->name ?? '-' }}</div>
                        <span class="text-[11px] text-slate-400 font-mono">{{ $inv->patient->mr_number ?? '-' }}</span>
                    </td>
                    <td class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($inv->created_at)->translatedFormat('d M Y, H:i') }}</td>
                    <td class="font-bold text-slate-900 text-xs">Rp {{ number_format($inv->grand_total, 0, ',', '.') }}</td>
                    <td><x-badge type="UNPAID">BELUM LUNAS</x-badge></td>
                    <td>
                        <a href="{{ route('billing.show', $inv->id) }}" class="px-3 py-1 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-xs font-semibold transition inline-flex items-center gap-1">
                            <i data-lucide="wallet" class="w-3.5 h-3.5"></i> Bayar
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        <x-empty-state title="Tidak Ada Tagihan Menunggak" description="Seluruh tagihan pasien telah lunas diproses oleh kasir." icon="check-circle-2" />
                    </td>
                </tr>
            @endforelse
        </x-table>
    </x-card>
</div>
