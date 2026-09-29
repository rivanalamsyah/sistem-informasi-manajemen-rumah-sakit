<!-- Perawat Specific Dashboard View -->
<div class="space-y-6">
    <!-- Header Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-kpi-card
            title="Pasien Rawat Inap Aktif"
            value="{{ number_format($metrics['activeInpatients']) }}"
            icon="bed"
            color="amber"
            subtext="Pasien Opname Saat Ini"
        />

        <x-kpi-card
            title="Bed Occupancy Rate (BOR)"
            value="{{ $bedStatus['bor'] }}%"
            icon="percent"
            color="teal"
            subtext="{{ $bedStatus['occupied'] }} dari {{ $bedStatus['total'] }} Bed Terisi"
        />

        <x-kpi-card
            title="Kunjungan Rawat Jalan"
            value="{{ number_format($metrics['todayOutpatients']) }}"
            icon="stethoscope"
            color="sky"
            subtext="Persiapan Triase & TTV"
        />

        <x-kpi-card
            title="Bed Kosong Ready"
            value="{{ number_format($bedStatus['empty']) }}"
            icon="check-circle"
            color="emerald"
            subtext="Siap Digunakan Admisian"
        />
    </div>

    <!-- Quick Actions Perawat -->
    <x-card title="Aksi Keperawatan & Triase" icon="zap">
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
            <a href="{{ route('outpatients.index') }}" class="p-4 bg-slate-50 hover:bg-teal-50/60 border border-slate-200/80 rounded-xl flex items-center gap-3 transition group">
                <div class="w-10 h-10 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center font-bold">
                    <i data-lucide="activity" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-800">Antrean & Triase TTV</div>
                    <span class="text-[10px] text-slate-500">Input Tanda-Tanda Vital</span>
                </div>
            </a>

            <a href="{{ route('inpatients.index') }}" class="p-4 bg-slate-50 hover:bg-amber-50/60 border border-slate-200/80 rounded-xl flex items-center gap-3 transition group">
                <div class="w-10 h-10 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center font-bold">
                    <i data-lucide="hotel" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-800">Ruangan Rawat Inap</div>
                    <span class="text-[10px] text-slate-500">Asuhan Keperawatan</span>
                </div>
            </a>

            <a href="{{ route('inpatients.monitoring') }}" class="p-4 bg-slate-50 hover:bg-sky-50/60 border border-slate-200/80 rounded-xl flex items-center gap-3 transition group">
                <div class="w-10 h-10 rounded-lg bg-sky-100 text-sky-700 flex items-center justify-center font-bold">
                    <i data-lucide="layout-grid" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-800">Monitoring Bed Status</div>
                    <span class="text-[10px] text-slate-500">Ketersediaan Bed Realtime</span>
                </div>
            </a>
        </div>
    </x-card>

    <!-- Table Pasien Rawat Inap Aktif -->
    <x-card title="Daftar Pasien Rawat Inap Aktif (Dalam Perawatan)" icon="bed">
        <x-table :headers="['No. Reg / Tgl Masuk', 'Pasien / No. RM', 'Ruang / Bed', 'Dokter DPJP', 'Status']">
            @forelse($activeInpatientList as $inp)
                <tr class="hover:bg-slate-50/80 transition-colors">
                    <td>
                        <div class="font-bold text-teal-600 text-xs">{{ $inp->registration->registration_number ?? '-' }}</div>
                        <span class="text-[11px] text-slate-400">{{ \Carbon\Carbon::parse($inp->admission_date)->translatedFormat('d M Y, H:i') }}</span>
                    </td>
                    <td>
                        <div class="font-semibold text-slate-800 text-xs">{{ $inp->patient->name ?? '-' }}</div>
                        <span class="text-[11px] text-slate-400 font-mono">{{ $inp->patient->mr_number ?? '-' }}</span>
                    </td>
                    <td>
                        <div class="font-semibold text-slate-700 text-xs">{{ $inp->bed->room->name ?? '-' }} (Bed {{ $inp->bed->bed_number ?? '-' }})</div>
                        <span class="text-[10px] text-slate-400">{{ $inp->bed->room->department->name ?? '-' }}</span>
                    </td>
                    <td class="text-xs text-slate-600">{{ $inp->doctor->name ?? '-' }}</td>
                    <td><x-badge type="ACTIVE">DALAM PERAWATAN</x-badge></td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        <x-empty-state title="Belum Ada Pasien Opname" description="Saat ini tidak ada pasien yang sedang menjalani perawatan rawat inap." icon="hotel" />
                    </td>
                </tr>
            @endforelse
        </x-table>
    </x-card>
</div>
