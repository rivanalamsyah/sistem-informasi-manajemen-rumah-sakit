<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kuitansi Invoice {{ $invoice->invoice_number }} - {{ config('simrs.hospital_name') }}</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: #fff !important; }
        }
    </style>
</head>
<body class="bg-slate-100 font-sans text-slate-800 p-8 min-h-screen">

    <div class="no-print max-w-3xl mx-auto mb-4 flex justify-between items-center">
        <a href="{{ route('billing.show', $invoice) }}" class="text-xs font-semibold text-slate-600 hover:text-slate-900">← Kembali ke Detail Tagihan</a>
        <button onclick="window.print()" class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl shadow transition flex items-center gap-2">
            Cetak Kuitansi / Save PDF
        </button>
    </div>

    <!-- Printable A4 Invoice Container -->
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-2xl shadow-sm border border-slate-200 text-xs">
        <!-- Header RS -->
        <div class="flex justify-between items-start border-b border-slate-200 pb-6 mb-6">
            <div>
                <h1 class="text-lg font-bold text-slate-900 uppercase tracking-tight">{{ config('simrs.hospital_name') }}</h1>
                <p class="text-slate-500 mt-1">{{ config('simrs.address') }}</p>
                <p class="text-slate-500">Telp: {{ config('simrs.phone') }} | Email: {{ config('simrs.email') }}</p>
            </div>
            <div class="text-right">
                <span class="inline-block px-3 py-1 bg-emerald-100 text-emerald-800 font-bold rounded-full text-xs uppercase mb-2">KUITANSI LUNAS</span>
                <div class="font-mono font-bold text-slate-900 text-sm">{{ $invoice->invoice_number }}</div>
                <div class="text-slate-500 text-[11px] mt-0.5">Tanggal: {{ $invoice->invoice_date ? $invoice->invoice_date->format('d/m/Y H:i') : '-' }} WIB</div>
            </div>
        </div>

        <!-- Info Pasien -->
        <div class="grid grid-cols-2 gap-4 bg-slate-50 p-4 rounded-xl mb-6 border border-slate-200/60">
            <div>
                <span class="text-slate-400 font-medium block text-[11px]">DITERIMA DARI / PASIEN:</span>
                <strong class="text-slate-900 text-sm block mt-0.5">{{ $invoice->patient->name ?? '-' }}</strong>
                <span class="text-slate-600 text-[11px]">No. RM: <strong>{{ $invoice->patient->mr_number ?? '-' }}</strong></span>
            </div>
            <div class="text-right">
                <span class="text-slate-400 font-medium block text-[11px]">EPISODE PELAYANAN:</span>
                <strong class="text-slate-900 text-sm block mt-0.5">{{ $invoice->registration->registration_number ?? '-' }}</strong>
                <span class="text-slate-600 text-[11px]">{{ $invoice->registration->queue->department->name ?? $invoice->registration->service_type }}</span>
            </div>
        </div>

        <!-- Table Items -->
        <table class="w-full text-left border-collapse mb-6">
            <thead>
                <tr class="border-b border-slate-300 text-slate-500 uppercase text-[10px] tracking-wider">
                    <th class="py-2.5">No</th>
                    <th class="py-2.5">Komponen Layanan</th>
                    <th class="py-2.5 text-center">Qty</th>
                    <th class="py-2.5 text-right">Harga Satuan</th>
                    <th class="py-2.5 text-right">Subtotal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200 text-xs">
                @foreach($invoice->items as $idx => $item)
                    <tr>
                        <td class="py-3 text-slate-500">{{ $idx + 1 }}</td>
                        <td class="py-3 font-semibold text-slate-800">{{ $item->item_name }}</td>
                        <td class="py-3 text-center text-slate-700">{{ $item->quantity }}</td>
                        <td class="py-3 text-right text-slate-700">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                        <td class="py-3 text-right font-bold text-slate-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Summary Subtotal & Payment -->
        <div class="flex justify-between items-end border-t border-slate-300 pt-4 mb-8">
            <div class="text-slate-500 text-[11px] space-y-1">
                <div>Metode Pembayaran: <strong class="text-slate-800">{{ $invoice->payments->first()->payment_method ?? 'Tunai' }}</strong></div>
                <div>No. Kuitansi Kasir: <strong class="text-slate-800 font-mono">{{ $invoice->payments->first()->receipt_number ?? '-' }}</strong></div>
                <div>Status: <strong class="text-emerald-700">LUNAS</strong></div>
            </div>
            <div class="text-right space-y-1">
                <div class="text-slate-500 text-xs">Total Pembayaran:</div>
                <div class="text-xl font-bold text-slate-900">Rp {{ number_format($invoice->grand_total, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Tanda Tangan Kasir -->
        <div class="flex justify-end text-center pt-6 border-t border-slate-200">
            <div class="w-48">
                <p class="text-slate-500 text-[11px] mb-12">Petugas Kasir SIMRS,</p>
                <p class="font-bold text-slate-900 border-b border-slate-400 pb-1">{{ $invoice->payments->first()->cashier->name ?? 'Kasir RSU Rajawali Citra' }}</p>
                <span class="text-[10px] text-slate-400 block mt-0.5">SIP/NIP Kasir Medis</span>
            </div>
        </div>
    </div>

</body>
</html>
