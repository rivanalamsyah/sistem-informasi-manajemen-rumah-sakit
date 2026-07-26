@extends('layouts.admin')

@section('title', 'Dashboard Eksekutif & Analitik BI')

@section('content')
    <x-page-header
        title="Dashboard Eksekutif & Analitik Business Intelligence (BI)"
        subtitle="Pusat monitoring KPI operasional, grafik tren pelayanan, & analisa keuangan rumah sakit."
        :breadcrumb="[['label' => 'Laporan & Eksekutif', 'url' => null]]"
    >
        <x-slot name="actions">
            <a href="{{ route('reports.export-csv', 'financial') }}"
               class="inline-flex items-center gap-2 px-3.5 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="download" class="w-4 h-4 text-emerald-600"></i> Ekspor CSV Laporan
            </a>
        </x-slot>
    </x-page-header>


    <!-- Navigasi Sub-Laporan Quick Access Bar -->
    <x-card class="p-4 mb-6">
        <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-2 text-center text-xs font-semibold">
            <a href="{{ route('reports.registrations') }}" class="p-2.5 bg-slate-50 hover:bg-teal-50 text-slate-700 hover:text-teal-700 rounded-xl border border-slate-200/80 transition">
                <i data-lucide="users" class="w-4 h-4 mx-auto mb-1 text-teal-600"></i> Pendaftaran
            </a>
            <a href="{{ route('reports.outpatients') }}" class="p-2.5 bg-slate-50 hover:bg-teal-50 text-slate-700 hover:text-teal-700 rounded-xl border border-slate-200/80 transition">
                <i data-lucide="stethoscope" class="w-4 h-4 mx-auto mb-1 text-sky-600"></i> Rawat Jalan
            </a>
            <a href="{{ route('reports.inpatients') }}" class="p-2.5 bg-slate-50 hover:bg-teal-50 text-slate-700 hover:text-teal-700 rounded-xl border border-slate-200/80 transition">
                <i data-lucide="bed" class="w-4 h-4 mx-auto mb-1 text-amber-600"></i> Rawat Inap
            </a>
            <a href="{{ route('reports.emr') }}" class="p-2.5 bg-slate-50 hover:bg-teal-50 text-slate-700 hover:text-teal-700 rounded-xl border border-slate-200/80 transition">
                <i data-lucide="folder-open" class="w-4 h-4 mx-auto mb-1 text-indigo-600"></i> Rekam Medis
            </a>
            <a href="{{ route('reports.pharmacy') }}" class="p-2.5 bg-slate-50 hover:bg-teal-50 text-slate-700 hover:text-teal-700 rounded-xl border border-slate-200/80 transition">
                <i data-lucide="pill" class="w-4 h-4 mx-auto mb-1 text-emerald-600"></i> Farmasi
            </a>
            <a href="{{ route('reports.laboratory') }}" class="p-2.5 bg-slate-50 hover:bg-teal-50 text-slate-700 hover:text-teal-700 rounded-xl border border-slate-200/80 transition">
                <i data-lucide="flask-conical" class="w-4 h-4 mx-auto mb-1 text-rose-600"></i> Laboratorium
            </a>
            <a href="{{ route('reports.financial') }}" class="p-2.5 bg-slate-50 hover:bg-teal-50 text-slate-700 hover:text-teal-700 rounded-xl border border-slate-200/80 transition">
                <i data-lucide="banknote" class="w-4 h-4 mx-auto mb-1 text-emerald-600"></i> Keuangan
            </a>
        </div>
    </x-card>

    <!-- Summary KPI Cards Grid (6 Grid Cards) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4 mb-6">
        <x-card class="p-4">
            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Total Pasien RS</span>
            <h2 class="text-xl font-bold text-slate-900 mt-1">{{ number_format($metrics['totalPatients']) }}</h2>
            <span class="text-[10px] text-slate-500 mt-0.5 block">Pasien Terdaftar</span>
        </x-card>
        <x-card class="p-4">
            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Kunjungan Hari Ini</span>
            <h2 class="text-xl font-bold text-teal-600 mt-1">{{ number_format($metrics['todayPatients']) }}</h2>
            <span class="text-[10px] text-teal-600 mt-0.5 block">Admisi Terdaftar</span>
        </x-card>
        <x-card class="p-4">
            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Rawat Inap Aktif</span>
            <h2 class="text-xl font-bold text-amber-600 mt-1">{{ number_format($metrics['activeInpatients']) }}</h2>
            <span class="text-[10px] text-amber-600 mt-0.5 block">BOR: {{ $metrics['bor'] }}%</span>
        </x-card>
        <x-card class="p-4">
            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Pendapatan Hari Ini</span>
            <h2 class="text-lg font-bold text-emerald-600 mt-1">Rp {{ number_format($metrics['todayRevenue'], 0, ',', '.') }}</h2>
            <span class="text-[10px] text-emerald-600 mt-0.5 block">Penerimaan Kasir</span>
        </x-card>
        <x-card class="p-4">
            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Resep Diproses</span>
            <h2 class="text-xl font-bold text-indigo-600 mt-1">{{ number_format($metrics['prescriptionsProcessed']) }}</h2>
            <span class="text-[10px] text-indigo-600 mt-0.5 block">Farmasi Diserahkan</span>
        </x-card>
        <x-card class="p-4">
            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Tes Lab Divalidasi</span>
            <h2 class="text-xl font-bold text-rose-600 mt-1">{{ number_format($metrics['labTestsCompleted']) }}</h2>
            <span class="text-[10px] text-rose-600 mt-0.5 block">Laboratorium LIS</span>
        </x-card>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-6">
        <!-- Chart 1: Tren Kunjungan Harian -->
        <div class="lg:col-span-8">
            <x-card title="Tren Kunjungan Pasien (30 Hari Terakhir)" icon="line-chart" class="p-6">
                <div class="h-72">
                    <canvas id="dailyVisitsChart"></canvas>
                </div>
            </x-card>
        </div>

        <!-- Chart 2: Pasien per Poliklinik -->
        <div class="lg:col-span-4">
            <x-card title="Distribusi Pasien per Poliklinik" icon="pie-chart" class="p-6">
                <div class="h-72 flex items-center justify-center">
                    <canvas id="deptChart"></canvas>
                </div>
            </x-card>
        </div>
    </div>

    <!-- Top Diagnoses ICD-10 Widget -->
    <x-card title="5 Top Diagnosa ICD-10 Penyakit Terbanyak" icon="activity" class="p-6">
        <x-table :headers="['Kode ICD-10', 'Deskripsi Nama Diagnosa', 'Total Kasus Terbaca EMR']">
            @foreach($charts['topDiagnoses'] as $diag)
                <tr class="hover:bg-slate-50/80 transition-colors">
                    <td class="px-6 py-4 font-bold font-mono text-indigo-600 text-xs">{{ $diag->icd10_code }}</td>
                    <td class="px-6 py-4 font-semibold text-slate-800 text-xs">{{ $diag->icd10_name }}</td>
                    <td class="px-6 py-4 font-bold text-slate-900 text-xs">{{ number_format($diag->total) }} Kasus</td>
                </tr>
            @endforeach
        </x-table>
    </x-card>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Chart Tren Kunjungan Harian
        const visitCtx = document.getElementById('dailyVisitsChart').getContext('2d');
        new Chart(visitCtx, {
            type: 'line',
            data: {
                labels: @json($charts['visitLabels']),
                datasets: [{
                    label: 'Jumlah Pasien',
                    data: @json($charts['visitData']),
                    borderColor: '#0d9488',
                    backgroundColor: 'rgba(13, 148, 136, 0.12)',
                    borderWidth: 2.5,
                    fill: true,
                    tension: 0.3
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

        // Chart Pasien per Poliklinik
        const deptCtx = document.getElementById('deptChart').getContext('2d');
        new Chart(deptCtx, {
            type: 'doughnut',
            data: {
                labels: @json($charts['deptLabels']),
                datasets: [{
                    data: @json($charts['deptData']),
                    backgroundColor: ['#0d9488', '#3b82f6', '#f59e0b', '#ec4899', '#8b5cf6'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    });
</script>
@endpush
