@extends('layouts.admin')

@section('title', 'Rincian Tagihan & Pelunasan Kasir')

@section('content')
    <x-page-header
        title="Invoice Tagihan: {{ $invoice->invoice_number }}"
        subtitle="Rincian item pelayanan medis & formulir pelunasan kasir."
        :breadcrumb="[
            ['label' => 'Kasir & Billing', 'url' => route('billing.index')],
            ['label' => 'Rincian Invoice', 'url' => null]
        ]"
    >
        <x-slot name="actions">
            @if ($invoice->status === 'Lunas')
                <a href="{{ route('billing.print', $invoice) }}" target="_blank"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-sm transition">
                    <i data-lucide="printer" class="w-4 h-4"></i> Cetak Kuitansi (A4)
                </a>
            @endif
            <a href="{{ route('billing.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
            </a>
        </x-slot>
    </x-page-header>


    <!-- Info Banner Card -->
    <x-card class="p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-xs">
            <div>
                <span class="text-slate-400 font-medium block">Nomor Invoice:</span>
                <span class="font-bold text-teal-600 font-mono text-sm">{{ $invoice->invoice_number }}</span>
            </div>
            <div>
                <span class="text-slate-400 font-medium block">Pasien (No. RM):</span>
                <strong class="text-slate-800">{{ $invoice->patient->name ?? '-' }}</strong>
                <span class="text-[11px] text-teal-600 font-mono font-bold block">{{ $invoice->patient->mr_number ?? '-' }}</span>
            </div>
            <div>
                <span class="text-slate-400 font-medium block">Waktu Diterbitkan:</span>
                <strong class="text-slate-800">{{ $invoice->invoice_date ? $invoice->invoice_date->format('d/m/Y H:i') : '-' }} WIB</strong>
            </div>
            <div>
                <span class="text-slate-400 font-medium block">Status Pembayaran:</span>
                <x-badge :type="$invoice->status">{{ $invoice->status }}</x-badge>
            </div>
        </div>
    </x-card>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 mb-6">
        <!-- Rincian Item Tagihan -->
        <div class="lg:col-span-8 space-y-6">
            <x-card title="Rincian Komponen Tagihan Medis" icon="receipt" class="p-6">
                <x-table :headers="['Kategori Layanan', 'Deskripsi Item', 'Jumlah (Qty)', 'Tarif Satuan', 'Subtotal']">
                    @foreach($invoice->items as $item)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-4">
                                <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 border border-slate-200 text-slate-700">{{ $item->item_type }}</span>
                            </td>
                            <td class="px-6 py-4 font-semibold text-slate-800 text-xs">{{ $item->item_name }}</td>
                            <td class="px-6 py-4 text-xs font-bold text-slate-900">{{ $item->quantity }}</td>
                            <td class="px-6 py-4 text-xs text-slate-700">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 font-bold text-slate-900 text-xs">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </x-table>

                <!-- Total Summary -->
                <div class="mt-4 pt-4 border-t border-slate-200/80 space-y-2 text-xs">
                    <div class="flex justify-between text-slate-600">
                        <span>Subtotal Layanan Medis:</span>
                        <span class="font-bold text-slate-800">Rp {{ number_format($invoice->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-slate-600">
                        <span>Potongan / Diskon:</span>
                        <span class="font-bold text-emerald-600">- Rp {{ number_format($invoice->discount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-base font-bold text-slate-900 pt-2 border-t border-slate-200">
                        <span>GRAND TOTAL TAGIHAN:</span>
                        <span class="text-teal-600 text-lg">Rp {{ number_format($invoice->grand_total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- Form Kasir Pembayaran & Histori Transaksi -->
        <div class="lg:col-span-4 space-y-6">
            @if ($invoice->status === 'Belum Lunas')
                <x-card title="Form Pelunasan Kasir" icon="wallet" class="p-6">
                    <form action="{{ route('billing.pay', $invoice) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="payment_method" class="block text-xs font-semibold text-slate-700 mb-1">Metode Pembayaran <span class="text-rose-500">*</span></label>
                            <select name="payment_method" id="payment_method" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                                <option value="Tunai">Tunai / Cash</option>
                                <option value="Transfer Bank">Transfer Bank / EDC</option>
                                <option value="Kartu Debit">Kartu Debit</option>
                                <option value="Kartu Kredit">Kartu Kredit</option>
                                <option value="QRIS">QRIS Manual</option>
                            </select>
                        </div>

                        <div>
                            <label for="amount_paid" class="block text-xs font-semibold text-slate-700 mb-1">Nominal Uang Diterima (Rp) <span class="text-rose-500">*</span></label>
                            <input type="number" name="amount_paid" id="amount_paid" value="{{ old('amount_paid', $invoice->grand_total) }}" min="{{ $invoice->grand_total }}" step="1000" class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm font-bold text-emerald-600 focus:outline-none focus:ring-2 focus:ring-teal-500" required>
                        </div>

                        <div>
                            <label for="notes" class="block text-xs font-semibold text-slate-700 mb-1">Catatan Kuitansi</label>
                            <input type="text" name="notes" id="notes" value="{{ old('notes') }}" placeholder="Nomor referensi / keterangan kasir..." class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 focus:outline-none focus:ring-2 focus:ring-teal-500">
                        </div>

                        <button type="submit" class="w-full py-3 px-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-md transition flex items-center justify-center gap-2">
                            <i data-lucide="check-circle-2" class="w-5 h-5"></i> Konfirmasi Pelunasan Kasir
                        </button>
                    </form>
                </x-card>
            @else
                <!-- Histori Pembayaran -->
                <x-card title="Bukti Transaksi & Kuitansi" icon="check-circle" class="p-6">
                    @foreach($invoice->payments as $pay)
                        <div class="p-4 bg-emerald-50 border border-emerald-200 rounded-xl space-y-2 text-xs">
                            <div class="flex justify-between">
                                <span class="text-slate-500">No. Kuitansi:</span>
                                <strong class="text-emerald-800 font-mono">{{ $pay->receipt_number }}</strong>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Metode:</span>
                                <strong class="text-slate-800">{{ $pay->payment_method }}</strong>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Dibayar:</span>
                                <strong class="text-emerald-700 font-bold">Rp {{ number_format($pay->amount_paid, 0, ',', '.') }}</strong>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-500">Kembalian:</span>
                                <strong class="text-slate-800">Rp {{ number_format($pay->change_amount, 0, ',', '.') }}</strong>
                            </div>
                            <div class="flex justify-between text-[11px] text-slate-400 pt-2 border-t border-emerald-200">
                                <span>Petugas Kasir: {{ $pay->cashier->name ?? 'Kasir SIMRS' }}</span>
                                <span>{{ $pay->payment_date ? $pay->payment_date->format('d/m/Y H:i') : '-' }}</span>
                            </div>
                        </div>
                    @endforeach
                </x-card>
            @endif
        </div>
    </div>
@endsection
