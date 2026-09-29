<!-- Petugas Pendaftaran Specific Dashboard View -->
<div class="space-y-6">
    <!-- Header Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-kpi-card
            title="Total Registrasi Hari Ini"
            value="{{ number_format($metrics['todayPatients']) }}"
            icon="calendar-check"
            color="teal"
            subtext="Pasien Baru & Lama"
        />

        <x-kpi-card
            title="Pendaftaran Rawat Jalan"
            value="{{ number_format($metrics['todayOutpatients']) }}"
            icon="stethoscope"
            color="sky"
            subtext="Kunjungan Poliklinik"
        />

        <x-kpi-card
            title="Total Pasien Terdaftar"
            value="{{ number_format($metrics['totalPatients']) }}"
            icon="users"
            color="indigo"
            subtext="Master Rekam Medis"
        />

        <x-kpi-card
            title="Dokter Praktik Hari Ini"
            value="{{ number_format($metrics['activeDoctors']) }}"
            icon="user-check"
            color="emerald"
            subtext="Jadwal Dokter Aktif"
        />
    </div>

    <!-- Quick Actions Pendaftaran -->
    <x-card title="Aksi Registrasi & Admisi Pasien" icon="zap">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
            <a href="{{ route('registrations.create') }}" class="p-4 bg-teal-600 hover:bg-teal-700 text-white rounded-xl flex items-center gap-3 transition shadow-xs group">
                <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center font-bold">
                    <i data-lucide="user-plus" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="text-xs font-bold">Pendaftaran Pasien Baru</div>
                    <span class="text-[10px] text-teal-100">Registrasi RM & Antrean Poli</span>
                </div>
            </a>

            <a href="{{ route('registrations.index') }}" class="p-4 bg-slate-50 hover:bg-indigo-50/60 border border-slate-200/80 rounded-xl flex items-center gap-3 transition group">
                <div class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold">
                    <i data-lucide="file-text" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-800">Daftar Registrasi Hari Ini</div>
                    <span class="text-[10px] text-slate-500">Cetak Tracer & Kartu Antrean</span>
                </div>
            </a>

            <a href="{{ route('inpatients.index') }}" class="p-4 bg-slate-50 hover:bg-amber-50/60 border border-slate-200/80 rounded-xl flex items-center gap-3 transition group">
                <div class="w-10 h-10 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center font-bold">
                    <i data-lucide="bed" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-800">Admisi Rawat Inap</div>
                    <span class="text-[10px] text-slate-500">Pemesanan Bed Opname Pasien</span>
                </div>
            </a>
        </div>
    </x-card>

    <!-- Table Registrasi Terbaru Hari Ini -->
    <x-card title="10 Pendaftaran Terbaru Hari Ini" icon="clock">
        <x-table :headers="['No. Reg', 'Pasien / No. RM', 'Poliklinik', 'Dokter', 'Status', 'Aksi']">
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
                    <td>
                        <a href="{{ route('registrations.show', $reg->id) }}" class="px-3 py-1 bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg text-xs font-semibold transition inline-flex items-center gap-1">
                            <i data-lucide="eye" class="w-3.5 h-3.5"></i> Detail
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        <x-empty-state title="Belum Ada Registrasi" description="Belum ada pendaftaran pasien baru yang tercatat hari ini." icon="user-x" />
                    </td>
                </tr>
            @endforelse
        </x-table>
    </x-card>
</div>
