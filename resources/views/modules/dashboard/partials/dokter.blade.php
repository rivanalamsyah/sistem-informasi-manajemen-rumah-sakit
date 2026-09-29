<!-- Dokter Specific Dashboard View -->
<div class="space-y-6">
    <!-- Header Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-kpi-card
            title="Pasien Praktik Hari Ini"
            value="{{ number_format($roleContext['myDoctorPatients']) }}"
            icon="stethoscope"
            color="teal"
            subtext="Antrean Poliklinik Anda"
        />

        <x-kpi-card
            title="Total Pasien RS Hari Ini"
            value="{{ number_format($metrics['todayPatients']) }}"
            icon="users"
            color="indigo"
            subtext="Kunjungan Seluruh Poli"
        />

        <x-kpi-card
            title="Resep Obat Pending"
            value="{{ number_format($roleContext['pendingPrescriptions']) }}"
            icon="pill"
            color="amber"
            subtext="Menunggu Dispensing Farmasi"
        />

        <x-kpi-card
            title="Order Lab Pending"
            value="{{ number_format($roleContext['pendingLabOrders']) }}"
            icon="flask-conical"
            color="sky"
            subtext="Pemeriksaan Laboratorium"
        />
    </div>

    <!-- Quick Actions Dokter -->
    <x-card title="Aksi Medis & EMR Dokter" icon="zap">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
            <a href="{{ route('outpatients.index') }}" class="p-4 bg-slate-50 hover:bg-teal-50/60 border border-slate-200/80 rounded-xl flex items-center gap-3 transition group">
                <div class="w-10 h-10 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center font-bold">
                    <i data-lucide="stethoscope" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-800">Antrean Poliklinik</div>
                    <span class="text-[10px] text-slate-500">Pemeriksaan Pasien</span>
                </div>
            </a>

            <a href="{{ route('medical-records.index') }}" class="p-4 bg-slate-50 hover:bg-indigo-50/60 border border-slate-200/80 rounded-xl flex items-center gap-3 transition group">
                <div class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold">
                    <i data-lucide="folder-open" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-800">Rekam Medis (EMR)</div>
                    <span class="text-[10px] text-slate-500">Riwayat Medis SOAP</span>
                </div>
            </a>

            <a href="{{ route('medical-records.create') }}" class="p-4 bg-slate-50 hover:bg-sky-50/60 border border-slate-200/80 rounded-xl flex items-center gap-3 transition group">
                <div class="w-10 h-10 rounded-lg bg-sky-100 text-sky-700 flex items-center justify-center font-bold">
                    <i data-lucide="file-plus" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-800">Input EMR Baru</div>
                    <span class="text-[10px] text-slate-500">Form Diagnosis ICD-10</span>
                </div>
            </a>

            <a href="{{ route('inpatients.index') }}" class="p-4 bg-slate-50 hover:bg-amber-50/60 border border-slate-200/80 rounded-xl flex items-center gap-3 transition group">
                <div class="w-10 h-10 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center font-bold">
                    <i data-lucide="bed" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-800">Visite Rawat Inap</div>
                    <span class="text-[10px] text-slate-500">Monitoring Bed Pasien</span>
                </div>
            </a>
        </div>
    </x-card>

    <!-- Content Split: Antrean Dokter & Rekam Medis Terbaru -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Antrean Poliklinik Dokter -->
        <div class="lg:col-span-8">
            <x-card title="Daftar Antrean Pasien Praktik Anda Hari Ini" icon="clock">
                <x-table :headers="['No. Antrean', 'Pasien / No. RM', 'Poliklinik', 'Status', 'Aksi']">
                    @forelse($doctorQueueList as $reg)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="font-bold text-teal-600 text-xs">{{ $reg->queue->queue_number ?? $reg->registration_number }}</td>
                            <td>
                                <div class="font-semibold text-slate-800 text-xs">{{ $reg->patient->name ?? '-' }}</div>
                                <span class="text-[11px] text-slate-400 font-mono">{{ $reg->patient->mr_number ?? '-' }}</span>
                            </td>
                            <td class="text-xs text-slate-600">{{ $reg->queue->department->name ?? '-' }}</td>
                            <td><x-badge :type="$reg->status">{{ $reg->status }}</x-badge></td>
                            <td>
                                <a href="{{ route('outpatients.show', $reg->id) }}" class="px-3 py-1 bg-teal-50 hover:bg-teal-100 text-teal-700 rounded-lg text-xs font-semibold transition border border-teal-200 inline-flex items-center gap-1">
                                    <i data-lucide="stethoscope" class="w-3.5 h-3.5"></i> Periksa
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <x-empty-state title="Tidak Ada Antrean" description="Belum ada pasien yang mendaftar ke jadwal praktik Anda hari ini." icon="user-check" />
                            </td>
                        </tr>
                    @endforelse
                </x-table>
            </x-card>
        </div>

        <!-- Bed Occupancy & Notifikasi Medis -->
        <div class="lg:col-span-4 space-y-6">
            <x-card title="Ketersediaan Bed Rawat Inap" icon="hotel">
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
        </div>
    </div>
</div>
