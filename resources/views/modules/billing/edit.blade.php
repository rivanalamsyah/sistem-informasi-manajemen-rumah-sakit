@extends('layouts.admin')

@section('title', 'Pembatalan Invoice (Void)')

@section('content')
    <x-page-header
        title="Pembatalan Invoice: {{ $invoice->invoice_number }}"
        subtitle="Form alasan pembatalan / void tagihan kasir pasien."
        :breadcrumb="[
            ['label' => 'Kasir & Billing', 'url' => route('billing.index')],
            ['label' => $invoice->invoice_number, 'url' => route('billing.show', $invoice)],
            ['label' => 'Void Invoice', 'url' => null]
        ]"
    />

    <form method="POST" action="{{ route('billing.update', $invoice) }}">
        @csrf @method('PUT')
        <div class="max-w-2xl">
            <x-card title="Konfirmasi Pembatalan Invoice" icon="alert-triangle" class="p-6 space-y-4">
                <div class="p-4 bg-rose-50 border border-rose-200 rounded-xl text-xs text-rose-800 space-y-1">
                    <p class="font-bold flex items-center gap-1.5"><i data-lucide="alert-circle" class="w-4 h-4 text-rose-600"></i> Perhatian Penting</p>
                    <p>Pembatalan invoice ini akan mengubah status tagihan menjadi <strong>Dibatalkan (CANCELLED)</strong>. Tindakan ini tidak dapat dibatalkan kembali.</p>
                </div>

                <div class="grid grid-cols-2 gap-3 text-xs bg-slate-50 p-4 rounded-xl">
                    <div>
                        <span class="text-slate-500 block">Nama Pasien</span>
                        <span class="font-bold text-slate-800">{{ $invoice->patient->name ?? '-' }}</span>
                    </div>
                    <div>
                        <span class="text-slate-500 block">Total Tagihan</span>
                        <span class="font-bold text-rose-600">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1.5">Alasan Pembatalan / Void <span class="text-rose-500">*</span></label>
                    <textarea name="cancellation_reason" rows="3" required
                              class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-rose-500 @error('cancellation_reason') border-rose-400 @enderror"
                              placeholder="Jelaskan alasan pembatalan invoice (misal: kesalahan input, registrasi ganda)...">{{ old('cancellation_reason') }}</textarea>
                    @error('cancellation_reason') <p class="text-rose-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </x-card>
        </div>

        <x-action-bar>
            <a href="{{ route('billing.show', $invoice) }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Batal
            </a>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-5 py-2 bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold rounded-xl shadow-sm transition">
                <i data-lucide="x-circle" class="w-4 h-4"></i> Batalkan Invoice Ini
            </button>
        </x-action-bar>
    </form>
@endsection
