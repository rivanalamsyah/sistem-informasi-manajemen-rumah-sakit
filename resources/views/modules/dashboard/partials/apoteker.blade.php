<!-- Apoteker Specific Dashboard View -->
<div class="space-y-6">
    <!-- Header Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-kpi-card
            title="Resep Obat Pending"
            value="{{ number_format($roleContext['pendingPrescriptions']) }}"
            icon="pill"
            color="amber"
            subtext="Menunggu Dispensing Farmasi"
        />

        <x-kpi-card
            title="Total Katalog Obat"
            value="{{ number_format($metrics['totalMedicines']) }}"
            icon="package"
            color="teal"
            subtext="Katalog Depo Farmasi"
        />

        <x-kpi-card
            title="Peringatan Stok Rendah"
            value="{{ number_format($notifications['lowStock']->count()) }}"
            icon="alert-triangle"
            color="rose"
            subtext="Stok Di Bawah Minimal"
        />

        <x-kpi-card
            title="Stok Mendekati Kadaluarsa"
            value="{{ number_format($notifications['expiring']->count()) }}"
            icon="clock"
            color="purple"
            subtext="Expired Dalam 6 Bulan"
        />
    </div>

    <!-- Quick Actions Apoteker -->
    <x-card title="Aksi Pelayanan Farmasi" icon="zap">
        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
            <a href="{{ route('pharmacy.index') }}" class="p-4 bg-slate-50 hover:bg-teal-50/60 border border-slate-200/80 rounded-xl flex items-center gap-3 transition group">
                <div class="w-10 h-10 rounded-lg bg-teal-100 text-teal-700 flex items-center justify-center font-bold">
                    <i data-lucide="pill" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-800">Antrean Resep Dokter</div>
                    <span class="text-[10px] text-slate-500">Dispensing & Racik Obat</span>
                </div>
            </a>

            <a href="{{ route('pharmacy.inventory') }}" class="p-4 bg-slate-50 hover:bg-emerald-50/60 border border-slate-200/80 rounded-xl flex items-center gap-3 transition group">
                <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                    <i data-lucide="boxes" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-800">Inventaris Stok Farmasi</div>
                    <span class="text-[10px] text-slate-500">Penyesuaian & Cek Stok</span>
                </div>
            </a>

            <a href="{{ route('pharmacy.movements') }}" class="p-4 bg-slate-50 hover:bg-indigo-50/60 border border-slate-200/80 rounded-xl flex items-center gap-3 transition group">
                <div class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold">
                    <i data-lucide="arrow-left-right" class="w-5 h-5"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-slate-800">Riwayat Mutasi Stok</div>
                    <span class="text-[10px] text-slate-500">Masuk / Keluar / Penyesuaian</span>
                </div>
            </a>
        </div>
    </x-card>

    <!-- Table Resep Pending & Peringatan Stok -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-8">
            <x-card title="Antrean Resep Obat PENDING (Siap Racik & Dispense)" icon="clock">
                <x-table :headers="['No. Resep', 'Pasien', 'Dokter Penulis', 'Tgl Resep', 'Aksi']">
                    @forelse($pendingPrescriptionsList as $pres)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="font-bold text-teal-600 text-xs">{{ $pres->prescription_number }}</td>
                            <td>
                                <div class="font-semibold text-slate-800 text-xs">{{ $pres->medicalRecord->patient->name ?? '-' }}</div>
                                <span class="text-[11px] text-slate-400 font-mono">{{ $pres->medicalRecord->patient->mr_number ?? '-' }}</span>
                            </td>
                            <td class="text-xs text-slate-600">{{ $pres->doctor->name ?? '-' }}</td>
                            <td class="text-xs text-slate-500">{{ \Carbon\Carbon::parse($pres->prescription_date)->translatedFormat('d M Y') }}</td>
                            <td>
                                <a href="{{ route('pharmacy.show', $pres->id) }}" class="px-3 py-1 bg-teal-50 hover:bg-teal-100 text-teal-700 rounded-lg text-xs font-semibold transition border border-teal-200 inline-flex items-center gap-1">
                                    <i data-lucide="pill" class="w-3.5 h-3.5"></i> Dispense
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <x-empty-state title="Tidak Ada Antrean Resep" description="Semua resep medis telah selesai diproses dan didispense." icon="check-circle-2" />
                            </td>
                        </tr>
                    @endforelse
                </x-table>
            </x-card>
        </div>

        <div class="lg:col-span-4 space-y-6">
            <x-card title="Peringatan Stok Obat" icon="alert-triangle">
                <div class="space-y-2">
                    @forelse ($notifications['lowStock'] as $stk)
                        <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl text-xs flex items-center justify-between">
                            <div>
                                <div class="font-bold text-amber-900">{{ $stk->medicine->name ?? 'Obat' }}</div>
                                <span class="text-[10px] text-amber-700">Depo / Kategori: {{ $stk->medicine->category->name ?? '-' }}</span>
                            </div>
                            <span class="px-2 py-0.5 bg-amber-200 text-amber-900 font-extrabold rounded text-[10px]">{{ $stk->stock }} {{ $stk->medicine->unit ?? 'Pcs' }}</span>
                        </div>
                    @empty
                        <x-empty-state title="Stok Aman" description="Tidak ada obat yang berada di bawah stok minimal." icon="check" />
                    @endforelse
                </div>
            </x-card>
        </div>
    </div>
</div>
