@extends('layouts.admin')

@section('title', 'Dashboard Operasional SIMRS')

@section('content')

    <!-- 1. Header & Welcome Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <x-breadcrumb :items="[['label' => 'Dashboard Operasional', 'url' => null]]" />
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">
                Selamat Datang, {{ auth()->user()->name ?? 'Administrator Medis' }}
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">
                Ringkasan operasional dan indikator kinerja utama (KPI) RSU Rajawali Citra hari ini.
            </p>
        </div>
        <div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-teal-50 text-teal-700 border border-teal-200">
                <i data-lucide="shield" class="w-3.5 h-3.5"></i> Peran: {{ auth()->user()->roles->first()->name ?? 'Super Admin' }}
            </span>
        </div>
    </div>

    <!-- 2. Summary Cards (8 Grid Cards) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Card 1: Total Pasien -->
        <x-card class="p-5">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Total Pasien Terdaftar</span>
                    <h2 class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($metrics['totalPatients']) }}</h2>
                    <span class="text-[11px] font-medium text-emerald-600 flex items-center gap-1 mt-1"><i data-lucide="database" class="w-3 h-3"></i> Rekam Medis Active</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
            </div>
        </x-card>

        <!-- Card 2: Pasien Hari Ini -->
        <x-card class="p-5">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Pendaftaran Hari Ini</span>
                    <h2 class="text-2xl font-bold text-teal-600 mt-1">{{ number_format($metrics['todayPatients']) }}</h2>
                    <span class="text-[11px] font-medium text-slate-500 mt-1 block">Kunjungan Hari Ini</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-teal-600 text-white flex items-center justify-center shadow-md shadow-teal-900/20">
                    <i data-lucide="calendar-check" class="w-6 h-6"></i>
                </div>
            </div>
        </x-card>

        <!-- Card 3: Rawat Jalan Hari Ini -->
        <x-card class="p-5">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Rawat Jalan (Poli)</span>
                    <h2 class="text-2xl font-bold text-sky-600 mt-1">{{ number_format($metrics['todayOutpatients']) }}</h2>
                    <span class="text-[11px] font-medium text-sky-600 flex items-center gap-1 mt-1"><i data-lucide="door-open" class="w-3 h-3"></i> Poliklinik Praktik</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center">
                    <i data-lucide="stethoscope" class="w-6 h-6"></i>
                </div>
            </div>
        </x-card>

        <!-- Card 4: Rawat Inap Aktif -->
        <x-card class="p-5">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Pasien Rawat Inap Aktif</span>
                    <h2 class="text-2xl font-bold text-amber-600 mt-1">{{ number_format($metrics['activeInpatients']) }}</h2>
                    <span class="text-[11px] font-medium text-amber-600 flex items-center gap-1 mt-1"><i data-lucide="bed" class="w-3 h-3"></i> Sedang Opname</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <i data-lucide="hotel" class="w-6 h-6"></i>
                </div>
            </div>
        </x-card>

        <!-- Card 5: Dokter Aktif -->
        <x-card class="p-5">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Dokter Praktik Aktif</span>
                    <h2 class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($metrics['activeDoctors']) }}</h2>
                    <span class="text-[11px] font-medium text-slate-500 mt-1 block">Spesialis & Umum</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center">
                    <i data-lucide="user-check" class="w-6 h-6"></i>
                </div>
            </div>
        </x-card>

        <!-- Card 6: Total Obat -->
        <x-card class="p-5">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Katalog Obat & Alkes</span>
                    <h2 class="text-2xl font-bold text-emerald-600 mt-1">{{ number_format($metrics['totalMedicines']) }}</h2>
                    <span class="text-[11px] font-medium text-emerald-600 flex items-center gap-1 mt-1"><i data-lucide="pill" class="w-3 h-3"></i> Item Tersedia</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <i data-lucide="package" class="w-6 h-6"></i>
                </div>
            </div>
        </x-card>

        <!-- Card 7: Pendapatan Hari Ini -->
        <x-card class="p-5">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Pendapatan (Hari Ini)</span>
                    <h3 class="text-xl font-bold text-emerald-600 mt-1">Rp {{ number_format($metrics['todayRevenue'], 0, ',', '.') }}</h3>
                    <span class="text-[11px] font-medium text-emerald-600 flex items-center gap-1 mt-1"><i data-lucide="wallet" class="w-3 h-3"></i> Penerimaan Lunas</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-600 text-white flex items-center justify-center shadow-md shadow-emerald-900/20">
                    <i data-lucide="banknote" class="w-6 h-6"></i>
                </div>
            </div>
        </x-card>

        <!-- Card 8: Invoice Belum Lunas -->
        <x-card class="p-5">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-medium text-slate-500">Invoice Belum Lunas</span>
                    <h2 class="text-2xl font-bold text-rose-600 mt-1">{{ number_format($metrics['unpaidInvoicesCount']) }}</h2>
                    <span class="text-[11px] font-medium text-rose-600 flex items-center gap-1 mt-1"><i data-lucide="alert-circle" class="w-3 h-3"></i> Menunggu Kasir</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center">
                    <i data-lucide="receipt" class="w-6 h-6"></i>
                </div>
            </div>
        </x-card>
    </div>

    <!-- Quick Action Buttons -->
    <x-card class="p-4 mb-6" title="Aksi Cepat / Tombol Pintas" icon="zap">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3">
            <a href="{{ route('registrations.create') }}" class="p-3 bg-slate-50 hover:bg-teal-50/60 border border-slate-200/80 rounded-xl flex items-center gap-3 transition group">
                <i data-lucide="user-plus" class="w-5 h-5 text-indigo-600 group-hover:scale-110 transition"></i>
                <span class="text-xs font-semibold text-slate-700">Pasien Baru</span>
            </a>
            <a href="{{ route('registrations.create') }}" class="p-3 bg-slate-50 hover:bg-teal-50/60 border border-slate-200/80 rounded-xl flex items-center gap-3 transition group">
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

    <!-- 3 & 4. Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-6">
        <!-- Chart 1: Kunjungan Pasien Bulanan -->
        <div class="lg:col-span-8">
            <x-card title="Tren Kunjungan Pasien (12 Bulan)" icon="line-chart">
                <div class="h-72">
                    <canvas id="visitsChart"></canvas>
                </div>
            </x-card>
        </div>

        <!-- Chart 2: Demografi Gender Pasien -->
        <div class="lg:col-span-4">
            <x-card title="Demografi Pasien (Gender)" icon="pie-chart">
                <div class="h-72 flex items-center justify-center">
                    <canvas id="genderChart"></canvas>
                </div>
            </x-card>
        </div>
    </div>

    <!-- 5. Chart Pendapatan -->
    <div class="mb-6">
        <x-card title="Tren Pendapatan Kasir Bulanan (12 Bulan Terakhir)" icon="trending-up">
            <div class="h-64">
                <canvas id="revenueChart"></canvas>
            </div>
        </x-card>
    </div>

    <!-- Bottom Widgets (Registrasi Terbaru & Bed Status) -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- 10 Registrasi Terbaru -->
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

        <!-- Widgets Side -->
        <div class="lg:col-span-4 space-y-6">
            <!-- Widget Bed Occupancy Rate (BOR) -->
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

            <!-- Widget Notifikasi -->
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

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Chart Kunjungan Pasien Bulanan
        const visitsCtx = document.getElementById('visitsChart').getContext('2d');
        new Chart(visitsCtx, {
            type: 'line',
            data: {
                labels: @json($charts['visitLabels']),
                datasets: [{
                    label: 'Jumlah Kunjungan Pasien',
                    data: @json($charts['visitData']),
                    borderColor: '#0d9488',
                    backgroundColor: 'rgba(13, 148, 136, 0.12)',
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.3,
                    pointBackgroundColor: '#0d9488',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                    x: { grid: { display: false } }
                }
            }
        });

        // 2. Chart Demografi Gender Pasien
        const genderCtx = document.getElementById('genderChart').getContext('2d');
        new Chart(genderCtx, {
            type: 'doughnut',
            data: {
                labels: ['Laki-laki', 'Perempuan'],
                datasets: [{
                    data: [{{ $charts['genderMale'] }}, {{ $charts['genderFemale'] }}],
                    backgroundColor: ['#3b82f6', '#ec4899'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } }
            }
        });

        // 3. Chart Pendapatan Bulanan
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: @json($charts['visitLabels']),
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: @json($charts['revenueData']),
                    backgroundColor: '#10b981',
                    borderRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let value = context.raw || 0;
                                return ' Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                    x: { grid: { display: false } }
                }
            }
        });
    });
</script>
@endpush
