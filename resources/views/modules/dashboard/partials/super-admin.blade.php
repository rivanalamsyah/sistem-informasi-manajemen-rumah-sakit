 <!-- Super Admin & Admin Dashboard View -->
<div class="space-y-6">
    <!-- 1. Summary Cards (8 KPI Cards) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-kpi-card
            title="Total Pasien Terdaftar"
            value="{{ number_format($metrics['totalPatients']) }}"
            icon="users"
            color="indigo"
            subtext="Master Rekam Medis Active"
        />

        <x-kpi-card
            title="Pendaftaran Hari Ini"
            value="{{ number_format($metrics['todayPatients']) }}"
            icon="calendar-check"
            color="teal"
            subtext="Kunjungan Baru & Lama"
        />

        <x-kpi-card
            title="Rawat Jalan (Poli)"
            value="{{ number_format($metrics['todayOutpatients']) }}"
            icon="stethoscope"
            color="sky"
            subtext="Poliklinik Praktik Aktif"
        />

        <x-kpi-card
            title="Rawat Inap Aktif"
            value="{{ number_format($metrics['activeInpatients']) }}"
            icon="bed"
            color="amber"
            subtext="Sedang Jalani Opname"
        />

        <x-kpi-card
            title="Dokter Praktik Aktif"
            value="{{ number_format($metrics['activeDoctors']) }}"
            icon="user-check"
            color="slate"
            subtext="Spesialis & Dokter Umum"
        />

        <x-kpi-card
            title="Katalog Obat & Alkes"
            value="{{ number_format($metrics['totalMedicines']) }}"
            icon="package"
            color="emerald"
            subtext="Item Obat Depo Farmasi"
        />

        <x-kpi-card
            title="Pendapatan (Hari Ini)"
            value="Rp {{ number_format($metrics['todayRevenue'], 0, ',', '.') }}"
            icon="banknote"
            color="emerald"
            subtext="Penerimaan Kasir Lunas"
        />

        <x-kpi-card
            title="Invoice Belum Lunas"
            value="{{ number_format($metrics['unpaidInvoicesCount']) }}"
            icon="receipt"
            color="rose"
            subtext="Menunggu Proses Kasir"
        />
    </div>

    <!-- Quick Action Buttons -->
    <x-card title="Aksi Cepat Sistem SIMRS" icon="zap">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            <a href="{{ route('registrations.create') }}" class="p-3 bg-slate-50 hover:bg-teal-50/60 border border-slate-200/80 rounded-xl flex items-center gap-3 transition group">
                <i data-lucide="user-plus" class="w-5 h-5 text-indigo-600 group-hover:scale-110 transition"></i>
                <span class="text-xs font-semibold text-slate-700">Pasien Baru</span>
            </a>
            <a href="{{ route('registrations.index') }}" class="p-3 bg-slate-50 hover:bg-teal-50/60 border border-slate-200/80 rounded-xl flex items-center gap-3 transition group">
                <i data-lucide="file-text" class="w-5 h-5 text-teal-600 group-hover:scale-110 transition"></i>
                <span class="text-xs font-semibold text-slate-700">Registrasi</span>
            </a>
            <a href="{{ route('outpatients.index') }}" class="p-3 bg-slate-50 hover:bg-teal-50/60 border border-slate-200/80 rounded-xl flex items-center gap-3 transition group">
                <i data-lucide="stethoscope" class="w-5 h-5 text-sky-600 group-hover:scale-110 transition"></i>
                <span class="text-xs font-semibold text-slate-700">Rawat Jalan</span>
            </a>
            <a href="{{ route('pharmacy.index') }}" class="p-3 bg-slate-50 hover:bg-teal-50/60 border border-slate-200/80 rounded-xl flex items-center gap-3 transition group">
                <i data-lucide="pill" class="w-5 h-5 text-emerald-600 group-hover:scale-110 transition"></i>
                <span class="text-xs font-semibold text-slate-700">Farmasi</span>
            </a>
            <a href="{{ route('billing.index') }}" class="p-3 bg-slate-50 hover:bg-teal-50/60 border border-slate-200/80 rounded-xl flex items-center gap-3 transition group">
                <i data-lucide="wallet" class="w-5 h-5 text-amber-600 group-hover:scale-110 transition"></i>
                <span class="text-xs font-semibold text-slate-700">Kasir Billing</span>
            </a>
            <a href="{{ route('reports.index') }}" class="p-3 bg-slate-50 hover:bg-teal-50/60 border border-slate-200/80 rounded-xl flex items-center gap-3 transition group">
                <i data-lucide="bar-chart-3" class="w-5 h-5 text-purple-600 group-hover:scale-110 transition"></i>
                <span class="text-xs font-semibold text-slate-700">Laporan RS</span>
            </a>
        </div>
    </x-card>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-8">
            <x-card title="Tren Kunjungan Pasien (12 Bulan)" icon="line-chart">
                <div class="h-72">
                    <canvas id="visitsChart"></canvas>
                </div>
            </x-card>
        </div>

        <div class="lg:col-span-4">
            <x-card title="Demografi Pasien (Gender)" icon="pie-chart">
                <div class="h-72 flex items-center justify-center">
                    <canvas id="genderChart"></canvas>
                </div>
            </x-card>
        </div>
    </div>

    <!-- Chart Pendapatan -->
    <x-card title="Tren Pendapatan Kasir Bulanan (12 Bulan Terakhir)" icon="trending-up">
        <div class="h-64">
            <canvas id="revenueChart"></canvas>
        </div>
    </x-card>

    <!-- Bottom Widgets (Registrasi Terbaru & Bed Status) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-8">
            <x-card title="10 Pendaftaran Terbaru Hari Ini" icon="clock">
                <x-table :headers="['No. Reg', 'No. RM / Pasien', 'Poliklinik', 'Dokter', 'Status']">
                    @forelse($recentRegistrations as $reg)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="font-bold text-teal-600 text-xs">{{ $reg->registration_number }}</td>
                            <td>
                                <div class="font-semibold text-slate-800 text-xs">{{ $reg->patient->name ?? '-' }}</div>
                                <span class="text-[11px] text-slate-400 font-mono">{{ $reg->patient->mr_number ?? '-' }}</span>
                            </td>
                            <td class="text-xs text-slate-600">{{ $reg->queue->department->name ?? '-' }}</td>
                            <td class="text-xs text-slate-600">{{ $reg->queue->doctor->name ?? '-' }}</td>
                            <td><x-badge :type="$reg->status">{{ $reg->status }}</x-badge></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <x-empty-state title="Belum Ada Pendaftaran" description="Belum ada pendaftaran pasien baru hari ini." />
                            </td>
                        </tr>
                    @endforelse
                </x-table>
            </x-card>
        </div>

        <div class="lg:col-span-4 space-y-6">
            <x-card title="Status Tempat Tidur (BOR)" icon="hotel">
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-semibold text-slate-700">Bed Occupancy Rate (BOR)</span>
                        <span class="font-bold text-teal-600 text-sm">{{ $bedStatus['bor'] }}%</span>
                    </div>
                    <div class="w-full bg-slate-100 rounded-full h-3 overflow-hidden">
                        <div class="bg-teal-600 h-full rounded-full transition-all duration-500" style="width: {{ $bedStatus['bor'] }}%;"></div>
                    </div>
                    <div class="grid grid-cols-3 text-center pt-3 border-t border-slate-100 text-xs">
                        <div>
                            <span class="text-slate-400 text-[11px]">Total Bed</span>
                            <div class="font-bold text-slate-800 text-sm mt-0.5">{{ $bedStatus['total'] }}</div>
                        </div>
                        <div>
                            <span class="text-slate-400 text-[11px]">Terisi</span>
                            <div class="font-bold text-amber-600 text-sm mt-0.5">{{ $bedStatus['occupied'] }}</div>
                        </div>
                        <div>
                            <span class="text-slate-400 text-[11px]">Kosong</span>
                            <div class="font-bold text-emerald-600 text-sm mt-0.5">{{ $bedStatus['empty'] }}</div>
                        </div>
                    </div>
                </div>
            </x-card>

            <x-card title="Notifikasi Operasional" icon="bell">
                @if ($notifications['lowStock']->count() > 0 || $notifications['unpaidInvoices']->count() > 0)
                    <div class="space-y-2">
                        @foreach ($notifications['lowStock'] as $stk)
                            <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl text-xs flex items-center justify-between">
                                <div class="text-amber-900">
                                    <strong>Stok Rendah:</strong> {{ $stk->medicine->name ?? 'Obat' }}
                                </div>
                                <span class="px-2 py-0.5 bg-amber-200 text-amber-900 font-bold rounded text-[10px]">{{ $stk->stock }} {{ $stk->medicine->unit ?? 'Pcs' }}</span>
                            </div>
                        @endforeach

                        @foreach ($notifications['unpaidInvoices'] as $inv)
                            <div class="p-3 bg-rose-50 border border-rose-200 rounded-xl text-xs flex items-center justify-between">
                                <div class="text-rose-900">
                                    <strong>Invoice Belum Lunas:</strong> {{ $inv->invoice_number }}
                                </div>
                                <span class="font-bold text-rose-700 text-[11px]">Rp {{ number_format($inv->grand_total, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <x-empty-state title="Sistem Normal" description="Tidak ada peringatan operasional kritis saat ini." icon="check-circle" />
                @endif
            </x-card>
        </div>
    </div>
</div>
