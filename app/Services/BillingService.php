<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Payment;
use App\Models\Registration;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BillingService
{
    /**
     * Mengambil ringkasan statistik Dashboard Kasir & Billing Keuangan.
     */
    public function getMetrics(): array
    {
        $today = now()->today();

        $todayTransactionsCount = Payment::whereDate('payment_date', $today)->count();
        $todayRevenue = Payment::whereDate('payment_date', $today)->sum('amount_paid');
        $monthlyRevenue = Payment::whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->sum('amount_paid');

        $unpaidInvoicesCount = Invoice::where('status', Invoice::STATUS_UNPAID)->count();
        $paidInvoicesCount = Invoice::where('status', Invoice::STATUS_PAID)->count();
        $totalInvoicesCount = Invoice::count();

        return [
            'todayTransactionsCount' => $todayTransactionsCount,
            'todayRevenue' => $todayRevenue,
            'monthlyRevenue' => $monthlyRevenue,
            'unpaidInvoicesCount' => $unpaidInvoicesCount,
            'paidInvoicesCount' => $paidInvoicesCount,
            'totalInvoicesCount' => $totalInvoicesCount,
        ];
    }

    /**
     * Membuat Invoice Tagihan Medis Konsolidasi dari Seluruh Pelayanan Pasien.
     *
     * @throws Exception
     */
    public function generateInvoice(Registration $registration): Invoice
    {
        return DB::transaction(function () use ($registration) {
            // Validasi: pastikan belum ada invoice untuk registrasi ini
            if ($registration->invoice()->exists()) {
                throw new Exception('Invoice untuk registrasi ' . $registration->registration_number . ' sudah pernah dibuat.');
            }

            $registration->load([
                'patient',
                'outpatientVisit.department',
                'inpatientVisit.bed.room',
                'prescriptions.items.medicine',
                'laboratoryOrders.results.laboratoryTest',
            ]);

            // 1. Hitung Komponen Biaya Medis

            // Biaya Admisi & Konsultasi: ambil dari tabel tariffs berdasarkan service_type
            // Jika belum ada data di tariffs, gunakan default 0 (bukan hardcoded)
            $servicesTotal = \App\Models\Tariff::where('service_type', $registration->service_type)
                ->where('is_active', true)
                ->value('price') ?? 0;

            $medicinesTotal = 0;
            $laboratoryTotal = 0;
            $roomTotal = 0;

            // Hitung Biaya Obat dari Resep EMR (snapshot harga saat resep dibuat)
            foreach ($registration->prescriptions as $pres) {
                foreach ($pres->items as $item) {
                    $medicinesTotal += (float) $item->total_price;
                }
            }

            // Hitung Biaya Pengujian Laboratorium (snapshot tarif dari master)
            foreach ($registration->laboratoryOrders as $lab) {
                foreach ($lab->results as $res) {
                    $laboratoryTotal += (float) ($res->laboratoryTest?->price ?? 0);
                }
            }

            // Hitung Biaya Kamar Rawat Inap (jika opname)
            if ($registration->inpatientVisit && $registration->inpatientVisit->bed) {
                $admissionDate = $registration->inpatientVisit->admission_date;
                $dischargeDate = $registration->inpatientVisit->discharge_date ?? now();
                $days = $admissionDate ? (int) $admissionDate->diffInDays($dischargeDate) : 1;
                $days = max(1, $days); // Minimal 1 hari
                $roomTotal = $days * (float) ($registration->inpatientVisit->bed->price_per_night ?? 0);
            }

            $subtotal = $servicesTotal + $medicinesTotal + $laboratoryTotal + $roomTotal;
            $discount = 0;
            $grandTotal = $subtotal - $discount;

            // 2. Generate Nomor Invoice secara atomik (tidak menggunakan mt_rand)
            $invoiceNumber = $this->generateInvoiceNumber();

            // 3. Buat Record Invoice Konsolidasi
            $invoice = Invoice::create([
                'invoice_number'    => $invoiceNumber,
                'registration_id'   => $registration->id,
                'patient_id'        => $registration->patient_id,
                'invoice_date'      => now(),
                'services_total'    => $servicesTotal,
                'medicines_total'   => $medicinesTotal,
                'laboratory_total'  => $laboratoryTotal,
                'room_total'        => $roomTotal,
                'subtotal'          => $subtotal,
                'discount'          => $discount,
                'grand_total'       => $grandTotal,
                'status'            => Invoice::STATUS_UNPAID,
                'created_by'        => Auth::id(),
            ]);

            // 4. Catat Rincian Item Tagihan (InvoiceItems)
            if ($servicesTotal > 0) {
                InvoiceItem::create([
                    'invoice_id'  => $invoice->id,
                    'item_type'   => InvoiceItem::TYPE_SERVICE,
                    'item_name'   => 'Biaya Registrasi Admisi & Konsultasi Medis',
                    'quantity'    => 1,
                    'unit_price'  => $servicesTotal,
                    'subtotal'    => $servicesTotal,
                ]);
            }

            if ($medicinesTotal > 0) {
                InvoiceItem::create([
                    'invoice_id'  => $invoice->id,
                    'item_type'   => InvoiceItem::TYPE_MEDICINE,
                    'item_name'   => 'Paket Resep Obat Farmasi EMR',
                    'quantity'    => 1,
                    'unit_price'  => $medicinesTotal,
                    'subtotal'    => $medicinesTotal,
                ]);
            }

            if ($laboratoryTotal > 0) {
                InvoiceItem::create([
                    'invoice_id'  => $invoice->id,
                    'item_type'   => InvoiceItem::TYPE_LAB,
                    'item_name'   => 'Pengujian Spesimen Laboratorium',
                    'quantity'    => 1,
                    'unit_price'  => $laboratoryTotal,
                    'subtotal'    => $laboratoryTotal,
                ]);
            }

            if ($roomTotal > 0) {
                InvoiceItem::create([
                    'invoice_id'  => $invoice->id,
                    'item_type'   => InvoiceItem::TYPE_ROOM,
                    'item_name'   => 'Sewa Tempat Tidur & Kamar Inap',
                    'quantity'    => 1,
                    'unit_price'  => $roomTotal,
                    'subtotal'    => $roomTotal,
                ]);
            }

            return $invoice;
        });
    }

    /**
     * Memproses Pelunasan Pembayaran Kasir & Menerbitkan Kuitansi.
     *
     * @throws Exception
     */
    public function processPayment(Invoice $invoice, array $paymentData): Payment
    {
        return DB::transaction(function () use ($invoice, $paymentData) {
            // Guard: invoice harus dalam status belum lunas
            if ($invoice->status !== Invoice::STATUS_UNPAID) {
                throw new Exception("Invoice {$invoice->invoice_number} tidak dalam status 'Belum Lunas'. Status saat ini: {$invoice->status}.");
            }

            $amountPaid = (float) $paymentData['amount_paid'];

            if ($amountPaid < $invoice->grand_total) {
                throw new Exception('Nominal pembayaran (Rp ' . number_format($amountPaid, 0, ',', '.') . ') kurang dari total tagihan (Rp ' . number_format($invoice->grand_total, 0, ',', '.') . ').');
            }

            $changeAmount = $amountPaid - $invoice->grand_total;

            // 1. Generate Nomor Kuitansi secara atomik
            $receiptNumber = $this->generateReceiptNumber();

            // 2. Buat Record Pembayaran Kuitansi
            $payment = Payment::create([
                'receipt_number'   => $receiptNumber,
                'invoice_id'       => $invoice->id,
                'payment_date'     => now(),
                'payment_method'   => $paymentData['payment_method'] ?? 'Tunai',
                'amount_paid'      => $amountPaid,
                'change_amount'    => $changeAmount,
                'cashier_user_id'  => Auth::id(),
                'notes'            => $paymentData['notes'] ?? 'Pelunasan Kasir SIMRS',
            ]);

            // 3. Perbarui Status Invoice menjadi Lunas
            $invoice->update([
                'status'     => Invoice::STATUS_PAID,
                'updated_by' => Auth::id(),
            ]);

            // 4. Perbarui Status Registrasi Pasien menjadi Selesai
            if ($invoice->registration) {
                $invoice->registration->update(['status' => Registration::STATUS_COMPLETED]);
            }

            return $payment;
        });
    }

    /**
     * Menghasilkan Nomor Invoice secara atomik menggunakan sequence berbasis DB.
     * Dipanggil di dalam DB::transaction untuk mencegah duplikat.
     */
    private function generateInvoiceNumber(): string
    {
        $dateStr = now()->format('Ymd');

        // Lock invoice terakhir hari ini untuk mendapatkan sequence yang benar
        $lastInvoice = Invoice::lockForUpdate()
            ->whereDate('invoice_date', today())
            ->orderByDesc('id')
            ->first(['id', 'invoice_number']);

        $nextSeq = 1;
        if ($lastInvoice && $lastInvoice->invoice_number) {
            $parts = explode('-', $lastInvoice->invoice_number);
            $lastSeq = (int) end($parts);
            $nextSeq = $lastSeq + 1;
        }

        return 'INV-' . $dateStr . '-' . str_pad((string) $nextSeq, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Menghasilkan Nomor Kuitansi secara atomik menggunakan sequence berbasis DB.
     * Dipanggil di dalam DB::transaction untuk mencegah duplikat.
     */
    private function generateReceiptNumber(): string
    {
        $dateStr = now()->format('Ymd');

        // Lock kuitansi terakhir hari ini untuk mendapatkan sequence yang benar
        $lastPayment = Payment::lockForUpdate()
            ->whereDate('payment_date', today())
            ->orderByDesc('id')
            ->first(['id', 'receipt_number']);

        $nextSeq = 1;
        if ($lastPayment && $lastPayment->receipt_number) {
            $parts = explode('-', $lastPayment->receipt_number);
            $lastSeq = (int) end($parts);
            $nextSeq = $lastSeq + 1;
        }

        return 'KW-' . $dateStr . '-' . str_pad((string) $nextSeq, 4, '0', STR_PAD_LEFT);
    }
}
