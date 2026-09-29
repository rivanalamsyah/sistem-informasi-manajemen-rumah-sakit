<!-- Pasien Portal Specific Dashboard View -->
<div class="space-y-6">
    <!-- Welcome Banner Pasien -->
    <div class="p-6 bg-gradient-to-r from-teal-600 to-emerald-700 rounded-2xl text-white shadow-md flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
        <div>
            <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-xs rounded-full text-xs font-semibold mb-2">Portal Pasien Mandiri</span>
            <h2 class="text-xl font-extrabold tracking-tight">Selamat Datang di RSU Rajawali Citra</h2>
            <p class="text-xs text-teal-100 mt-1 max-w-xl">
                Pantau riwayat rekam medis, status pendaftaran antrean berobat, serta informasi jadwal praktik dokter dengan mudah dan cepat.
            </p>
        </div>
        <a href="{{ route('home') }}" class="px-4 py-2.5 bg-white text-teal-700 hover:bg-teal-50 font-bold rounded-xl text-xs transition shadow-sm inline-flex items-center gap-2">
            <i data-lucide="home" class="w-4 h-4"></i> Website Utama RS
        </a>
    </div>

    <!-- Summary Pasien -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <x-kpi-card
            title="Nomor Rekam Medis (RM)"
            value="{{ auth()->user()->patient->mr_number ?? 'Belum Ada' }}"
            icon="id-card"
            color="indigo"
            subtext="Identitas Pasien Terdaftar"
        />

        <x-kpi-card
            title="Total Kunjungan Berobat"
            value="{{ number_format($pasienRegistrationsList->count()) }}"
            icon="calendar-check"
            color="teal"
            subtext="Riwayat Registrasi Berobat"
        />

        <x-kpi-card
            title="Status Akun Pasien"
            value="AKTIF"
            icon="check-circle"
            color="emerald"
            subtext="Portal Akun Pasien Terverifikasi"
        />
    </div>

    <!-- Table Riwayat Berobat Pasien -->
    <x-card title="Riwayat Pendaftaran & Kunjungan Berobat Anda" icon="clock">
        <x-table :headers="['No. Reg', 'Tanggal Berobat', 'Poliklinik Tujuan', 'Dokter Pemeriksa', 'Status']">
            @forelse($pasienRegistrationsList as $reg)
                <tr class="hover:bg-slate-50/80 transition-colors">
                    <td class="font-bold text-teal-600 text-xs">{{ $reg->registration_number }}</td>
                    <td class="text-xs text-slate-700 font-semibold">{{ \Carbon\Carbon::parse($reg->registration_date)->translatedFormat('d M Y, H:i') }}</td>
                    <td class="text-xs text-slate-600">{{ $reg->queue->department->name ?? '-' }}</td>
                    <td class="text-xs text-slate-600">{{ $reg->queue->doctor->name ?? '-' }}</td>
                    <td><x-badge :type="$reg->status">{{ $reg->status }}</x-badge></td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">
                        <x-empty-state title="Belum Ada Riwayat Kunjungan" description="Anda belum pernah mendaftar berobat di RSU Rajawali Citra." icon="calendar-x" />
                    </td>
                </tr>
            @endforelse
        </x-table>
    </x-card>
</div>
