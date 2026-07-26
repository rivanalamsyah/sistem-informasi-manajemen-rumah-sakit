@extends('layouts.admin')

@section('title', 'Kartu Stok Barang Gudang')

@section('content')
    <x-page-header
        title="Kartu Stok Barang Gudang (Ledger)"
        subtitle="Buku besar histori pergerakan stok barang (masuk, keluar, mutasi, & penyesuaian)."
        :breadcrumb="[
            ['label' => 'Gudang', 'url' => route('warehouse.index')],
            ['label' => 'Kartu Stok', 'url' => null]
        ]"
    />

    <x-card class="p-4 mb-6">
        <form method="GET" action="{{ route('warehouse.stock-card') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-4">
                <select name="warehouse_id" class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">-- Semua Gudang --</option>
                    @foreach($warehouses as $wh)
                        <option value="{{ $wh->id }}" {{ request('warehouse_id') == $wh->id ? 'selected' : '' }}>{{ $wh->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-4">
                <select name="warehouse_item_id" class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">-- Semua Item Barang --</option>
                    @foreach($items as $it)
                        <option value="{{ $it->id }}" {{ request('warehouse_item_id') == $it->id ? 'selected' : '' }}>{{ $it->code }} — {{ $it->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-4 flex gap-2">
                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-semibold hover:bg-teal-700 transition flex items-center gap-1.5">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i> Filter Ledger
                </button>
                <a href="{{ route('warehouse.stock-card') }}" class="px-3 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold border border-slate-200 hover:bg-slate-200 transition">Reset</a>
            </div>
        </form>
    </x-card>

    <x-table :headers="['Waktu Transaksi', 'Gudang', 'Nama Barang', 'Jenis pergerakan', 'No. Referensi', 'Qty', 'Stok Sebelum', 'Saldo Akhir', 'User']">
        @forelse($movements as $m)
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-3 text-xs text-slate-600 font-mono">{{ $m->movement_date ? $m->movement_date->format('d/m/Y H:i') : '-' }}</td>
                <td class="px-6 py-3 font-semibold text-slate-800 text-xs">{{ $m->warehouse->name ?? '-' }}</td>
                <td class="px-6 py-3 font-semibold text-slate-900 text-xs">{{ $m->item->name ?? '-' }}</td>
                <td class="px-6 py-3">
                    @if($m->movement_type === 'Masuk' || $m->movement_type === 'Mutasi Masuk')
                        <span class="px-2 py-0.5 text-[11px] font-bold bg-emerald-100 text-emerald-800 rounded-full">{{ $m->movement_type }}</span>
                    @elseif($m->movement_type === 'Keluar' || $m->movement_type === 'Mutasi Keluar')
                        <span class="px-2 py-0.5 text-[11px] font-bold bg-sky-100 text-sky-800 rounded-full">{{ $m->movement_type }}</span>
                    @else
                        <span class="px-2 py-0.5 text-[11px] font-bold bg-amber-100 text-amber-800 rounded-full">{{ $m->movement_type }}</span>
                    @endif
                </td>
                <td class="px-6 py-3 font-mono text-xs text-teal-600 font-bold">{{ $m->reference_number }}</td>
                <td class="px-6 py-3 font-bold text-slate-900 text-xs font-mono">{{ $m->quantity }}</td>
                <td class="px-6 py-3 text-xs text-slate-500 font-mono">{{ $m->stock_before }}</td>
                <td class="px-6 py-3 font-black text-teal-600 text-xs font-mono">{{ $m->stock_after }}</td>
                <td class="px-6 py-3 text-xs text-slate-600">{{ $m->user->name ?? 'Sistem' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="9">
                    <x-empty-state title="Belum Ada Riwayat Pergerakan Stok" description="Belum ada transaksi masuk/keluar yang tercatat." icon="credit-card" />
                </td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-4">{{ $movements->links() }}</div>
@endsection
