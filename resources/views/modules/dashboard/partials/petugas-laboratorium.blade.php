<!-- Petugas Laboratorium Specific Dashboard View -->
<div class="space-y-6">
    <!-- Header Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <x-kpi-card
            title="Order Lab Pending"
            value="{{ number_format($roleContext['pendingLabOrders']) }}"
            icon="flask-conical"
            color="amber"
            subtext="Menunggu Pengambilan Sampel"
        />

        <x-kpi-card
            title="Total Pemeriksaan Hari Ini"
            value="{{ number_format($pendingLabOrdersList->count()) }}"
            icon="microscope"
            color="indigo"
            subtext="Order Laboratorium Masuk"
        />

        <x-kpi-card
            title="Dokter Pengirim Active"
            value="{{ number_format($metrics['activeDoctors']) }}"
            icon="user-check"
            color="teal"
            subtext="Order Dari Dokter Sp. & Umum"
        />
    </div>

    <!-- Quick Actions Lab -->
    <x-card title="Aksi Pelayanan Laboratorium" icon="zap">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <a href="{{ route('laboratory.index') }}" class="p-4 bg-slate-50 hover:bg-teal-50/60 border border-slate-200/80 rounded-xl flex items-center gap-3 transition group">
                <div class="w-10 h-10 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center font-bold">
                    <i data-lucide="flask-conical" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-800">Daftar Order Laboratorium</div>
                    <span class="text-[10px] text-slate-500">Ambil Sampel & Input Hasil Lab</span>
                </div>
            </a>

            <a href="{{ route('laboratory.index', ['status' => 'PENDING']) }}" class="p-4 bg-slate-50 hover:bg-amber-50/60 border border-slate-200/80 rounded-xl flex items-center gap-3 transition group">
                <div class="w-10 h-10 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center font-bold">
                    <i data-lucide="test-tube" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-800">Sampel Menunggu Diproses</div>
                    <span class="text-[10px] text-slate-500">Filter Order Status Pending</span>
                </div>
            </a>
        </div>
    </x-card>

    <!-- Table Order Lab Pending -->
    <x-card title="Daftar Permintaan Order Laboratorium (Terbaru)" icon="microscope">
        <x-table :headers="['No. Order', 'Pasien / No. RM', 'Dokter Perujuk', 'Tgl Order', 'Status', 'Aksi']">
            @forelse($pendingLabOrdersList as $lab)
                <tr class="hover:bg-slate-50/80 transition-colors">
                    <td class="font-bold text-teal-600 text-xs">{{ $lab->order_number }}</td>
                    <td>
                        <div class="font-semibold text-slate-800 text-xs">{{ $lab->medicalRecord->patient->name ?? '-' }}</div>
                        <span class="text-[11px] text-slate-400 font-mono">{{ $lab->medicalRecord->patient->mr_number ?? '-' }}</span>
                    </td>
                    <td class="text-xs text-slate-600">{{ $lab->doctor->name ?? '-' }}</td>
                    <td class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($lab->order_date)->translatedFormat('d M Y, H:i') }}</td>
                    <td><x-badge :type="$lab->status">{{ $lab->status }}</x-badge></td>
                    <td>
                        <a href="{{ route('laboratory.show', $lab->id) }}" class="px-3 py-1 bg-teal-50 hover:bg-teal-100 text-teal-700 rounded-lg text-xs font-semibold transition border border-teal-200 inline-flex items-center gap-1">
                            <i data-lucide="flask-conical" class="w-3.5 h-3.5"></i> Proses Lab
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        <x-empty-state title="Tidak Ada Order Pending" description="Belum ada permintaan laboratorium baru yang perlu diproses saat ini." icon="check-circle" />
                    </td>
                </tr>
            @endforelse
        </x-table>
    </x-card>
</div>
