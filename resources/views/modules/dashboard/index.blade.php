@extends('layouts.admin')

@section('title', 'Dashboard Operasional SIMRS')

@section('content')

    <!-- 1. Header & Welcome Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <x-breadcrumb :items="[['label' => 'Dashboard Operasional', 'url' => null]]" />
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">
                Selamat Datang, {{ auth()->user()->name ?? 'Pengguna Medis' }}
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">
                Ringkasan operasional dan indikator kinerja utama (KPI) RSU Rajawali Citra.
            </p>
        </div>
        <div>
            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-teal-50 text-teal-700 border border-teal-200 shadow-2xs">
                <i data-lucide="shield" class="w-3.5 h-3.5"></i> Peran: {{ auth()->user()->roles->first()->name ?? 'Super Admin' }}
            </span>
        </div>
    </div>

    <!-- 2. Role-Specific Modular Dashboard Component -->
    @php
        $roleName = auth()->user()->roles->first()?->name ?? 'Super Admin';
    @endphp

    @if ($roleName === 'Dokter')
        @include('modules.dashboard.partials.dokter')
    @elseif ($roleName === 'Perawat')
        @include('modules.dashboard.partials.perawat')
    @elseif ($roleName === 'Apoteker')
        @include('modules.dashboard.partials.apoteker')
    @elseif ($roleName === 'Petugas Laboratorium')
        @include('modules.dashboard.partials.petugas-laboratorium')
    @elseif ($roleName === 'Petugas Pendaftaran')
        @include('modules.dashboard.partials.petugas-pendaftaran')
    @elseif ($roleName === 'Kasir')
        @include('modules.dashboard.partials.kasir')
    @elseif ($roleName === 'Pasien')
        @include('modules.dashboard.partials.pasien')
    @else
        @include('modules.dashboard.partials.super-admin')
    @endif

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Render Charts only if canvas elements exist (Super Admin / Admin view)
        const visitsCanvas = document.getElementById('visitsChart');
        if (visitsCanvas) {
            const visitsCtx = visitsCanvas.getContext('2d');
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
        }

        const genderCanvas = document.getElementById('genderChart');
        if (genderCanvas) {
            const genderCtx = genderCanvas.getContext('2d');
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
        }

        const revenueCanvas = document.getElementById('revenueChart');
        if (revenueCanvas) {
            const revenueCtx = revenueCanvas.getContext('2d');
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
        }
    });
</script>
@endpush
