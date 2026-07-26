@extends('layouts.admin')

@section('title', 'Detail E-Resep & Dispensing Obat')

@section('content')
    <x-page-header
        title="Detail Resep: {{ $prescription->prescription_number }}"
        subtitle="Penyiapan, pengecekan ketersediaan stok fisik, & penyerahan obat (dispensing)."
        :breadcrumb="[
            ['label' => 'Farmasi & Obat', 'url' => route('pharmacy.index')],
            ['label' => 'Detail E-Resep', 'url' => null]
        ]"
    >
        <x-slot name="actions">
            @if ($prescription->status !== 'Selesai' && $prescription->status !== 'Batal')
                <form action="{{ route('pharmacy.dispense', $prescription) }}" method="POST" id="form-dispense">
                    @csrf
                    <button type="button" onclick="confirmDispense()"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-sm transition">
                        <i data-lucide="check-circle" class="w-4 h-4"></i> Diserahkan / Dispensing Obat
                    </button>
                </form>
            @endif
            <a href="{{ route('pharmacy.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
            </a>
        </x-slot>
    </x-page-header>

    <!-- Info Banner Card -->
    <x-card class="p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-xs">
            <div>
                <span class="text-slate-400 font-medium block">Nomor Resep:</span>
                <span class="font-bold text-teal-600 font-mono text-sm">{{ $prescription->prescription_number }}</span>
            </div>
            <div>
                <span class="text-slate-400 font-medium block">Pasien (No. RM):</span>
                <strong class="text-slate-800">{{ $prescription->patient->name ?? '-' }}</strong>
                <span class="text-[11px] text-teal-600 font-mono font-bold block">{{ $prescription->patient->mr_number ?? '-' }}</span>
            </div>
            <div>
                <span class="text-slate-400 font-medium block">Dokter Pengirim:</span>
                <strong class="text-slate-800">{{ $prescription->doctor->full_name ?? '-' }}</strong>
            </div>
            <div>
                <span class="text-slate-400 font-medium block">Status Resep:</span>
                <x-badge :type="$prescription->status">{{ $prescription->status }}</x-badge>
            </div>
        </div>
    </x-card>

    <!-- Rincian Item Resep Obat & Status Stok Real-Time -->
    <x-card title="Rincian Item Obat & Ketersediaan Stok Physical" icon="pill" class="p-6 mb-6">
        <x-table :headers="['Nama Obat', 'Dosis / Signa', 'Aturan Pakai', 'Jumlah (Qty)', 'Harga Satuan', 'Total Harga', 'Stok Fisik Tersedia', 'Status Stok']">
            @foreach($prescription->items as $item)
                @php
                    $availableStock = $item->medicine->stocks->sum('stock');
                    $isSufficient = $availableStock >= $item->quantity;
                @endphp
                <tr class="hover:bg-slate-50/80 transition-colors">
                    <td class="px-6 py-4 font-bold text-slate-800 text-xs">{{ $item->medicine->name ?? 'Obat' }}</td>
                    <td class="px-6 py-4 text-xs text-slate-700 font-semibold">{{ $item->dosage }}</td>
                    <td class="px-6 py-4 text-xs text-slate-600">{{ $item->instruction }}</td>
                    <td class="px-6 py-4 font-bold text-slate-900 text-xs">{{ $item->quantity }} {{ $item->medicine->unit ?? 'Pcs' }}</td>
                    <td class="px-6 py-4 text-xs text-slate-700">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 font-bold text-teal-600 text-xs">Rp {{ number_format($item->total_price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 font-bold text-xs {{ $isSufficient ? 'text-emerald-600' : 'text-rose-600' }}">
                        {{ number_format($availableStock) }} {{ $item->medicine->unit ?? 'Pcs' }}
                    </td>
                    <td class="px-6 py-4">
                        @if ($isSufficient)
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-full">
                                <i data-lucide="check-circle" class="w-3 h-3"></i> Stok Cukup
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 text-[10px] font-bold text-rose-700 bg-rose-50 border border-rose-200 px-2 py-0.5 rounded-full">
                                <i data-lucide="alert-triangle" class="w-3 h-3"></i> Stok Kurang!
                            </span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </x-table>
    </x-card>

    <!-- Update Validasi Status Modal/Form -->
    @if ($prescription->status !== 'Selesai' && $prescription->status !== 'Batal')
        <x-card title="Validasi & Catatan Apoteker" icon="sliders" class="p-6">
            <form action="{{ route('pharmacy.validate', $prescription) }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="status" class="block text-xs font-semibold text-slate-700 mb-1">Ubah Status Resep</label>
                        <select name="status" id="status" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500">
                            <option value="Diproses" {{ $prescription->status === 'Diproses' ? 'selected' : '' }}>Diproses Apotek</option>
                            <option value="Siap Diserahkan" {{ $prescription->status === 'Siap Diserahkan' ? 'selected' : '' }}>Siap Diserahkan ke Pasien</option>
                            <option value="Batal" {{ $prescription->status === 'Batal' ? 'selected' : '' }}>Batal Resep</option>
                        </select>
                    </div>
                    <div>
                        <label for="notes" class="block text-xs font-semibold text-slate-700 mb-1">Catatan Tambahan Apoteker</label>
                        <input type="text" name="notes" id="notes" value="{{ old('notes', $prescription->notes) }}" placeholder="Catatan instruksi khusus penyiapan obat..." class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500">
                    </div>
                </div>
                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-semibold hover:bg-teal-700 transition">
                    Simpan Perubahan Validasi
                </button>
            </form>
        </x-card>
    @endif


@push('scripts')
<script>
function confirmDispense() {
    if (confirm('Apakah Anda yakin ingin menyerahkan obat dan mengurangi stok fisik secara otomatis?')) {
        document.getElementById('form-dispense').submit();
    }
}
</script>
@endpush
@endsection
