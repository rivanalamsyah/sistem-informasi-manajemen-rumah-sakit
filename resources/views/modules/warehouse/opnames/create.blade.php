@extends('layouts.admin')

@section('title', 'Form Input Stock Opname')

@section('content')
    <x-page-header
        title="Form Input Stock Opname & Penyesuaian"
        subtitle="Input hitungan fisik stok barang dan sesuaikan secara otomatis dengan stok sistem."
        :breadcrumb="[
            ['label' => 'Gudang', 'url' => route('warehouse.index')],
            ['label' => 'Stock Opname', 'url' => route('warehouse.opnames.index')],
            ['label' => 'Input Opname', 'url' => null]
        ]"
    />

    <form method="POST" action="{{ route('warehouse.opnames.store') }}">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-5">
                <x-card title="Dokumen Stock Opname" icon="clipboard-check" class="p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <x-form-input name="opname_date" label="Tanggal Opname" type="date" required :value="old('opname_date', date('Y-m-d'))" />
                        <div>
                            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Gudang Diperiksa <span class="text-rose-500">*</span></label>
                            <select name="warehouse_id" required class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                                @foreach($warehouses as $wh)
                                    <option value="{{ $wh->id }}">{{ $wh->name }} ({{ $wh->code }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </x-card>

                <x-card title="Pencatatan Stok Fisik Barang" icon="package" class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs border-collapse">
                            <thead>
                                <tr class="bg-slate-50 text-slate-600 border-b border-slate-200">
                                    <th class="p-2 font-semibold">Barang Gudang</th>
                                    <th class="p-2 font-semibold w-32">Stok Fisik Ditemukan</th>
                                    <th class="p-2 font-semibold">Catatan / Alasan Selisih</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-slate-100">
                                    <td class="p-2">
                                        <select name="items[0][warehouse_item_id]" required class="w-full py-1.5 px-2 bg-slate-50 border border-slate-200 rounded-lg text-xs">
                                            <option value="">-- Pilih Barang --</option>
                                            @foreach($items as $it)
                                                <option value="{{ $it->id }}">{{ $it->code }} — {{ $it->name }} (Stok Sistem: {{ $it->total_stock }} {{ $it->unit }})</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td class="p-2">
                                        <input type="number" name="items[0][physical_stock]" required min="0" value="0" class="w-full py-1.5 px-2 bg-slate-50 border border-slate-200 rounded-lg text-xs font-bold text-teal-600">
                                    </td>
                                    <td class="p-2">
                                        <input type="text" name="items[0][notes]" placeholder="Sebab selisih (rusak, hilangan, expired)..." class="w-full py-1.5 px-2 bg-slate-50 border border-slate-200 rounded-lg text-xs">
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </x-card>
            </div>

            <div class="space-y-5">
                <x-card title="Catatan Opname" icon="notebook" class="p-6">
                    <textarea name="notes" rows="4" class="w-full p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs" placeholder="Keterangan pelaksanaan opname..."></textarea>
                </x-card>
            </div>
        </div>

        <x-action-bar>
            <a href="{{ route('warehouse.opnames.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Batal
            </a>
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl shadow-xs transition">
                <i data-lucide="check-circle" class="w-4 h-4"></i> Selesaikan Opname & Penyesuaian
            </button>
        </x-action-bar>
    </form>
@endsection
