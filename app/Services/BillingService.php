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
            $registration->load([
                'patient',
                'outpatientVisit.department',
                'inpatientVisit.bed.room',
                'prescriptions.items.medicine',
                'laboratoryOrders.results.laboratoryTest',
            ]);

            // 1. Hitung Komponen Biaya Medis
            $servicesTotal = 150000; // Biaya Pendaftaran Admisi & Konsultasi Dokter
            $medicinesTotal = 0;
            $laboratoryTotal = 0;
            $roomTotal = 0;

            // Hitung Biaya Obat dari Resep EMR
            foreach ($registration->prescriptions as $pres) {
                foreach ($pres->items as $item) {
                    $medicinesTotal += $item->total_price;
                }
            }

            // Hitung Biaya Pengujian Laboratorium
            foreach ($registration->laboratoryOrders as $lab) {
                foreach ($lab->results as $res) {
                    $laboratoryTotal += ($res->laboratoryTest->price ?? 100000);
                }
            }

            // Hitung Biaya Kamar Rawat Inap (jika opname)
            if ($registration->inpatientVisit && $registration->inpatientVisit->bed) {
                $days = (int) ($registration->inpatientVisit->admission_date ? $registration->inpatientVisit->admission_date->diffInDays($registration->inpatientVisit->discharge_date ?? now()) : 1);
                if ($days == 0) {
                    $days = 1;
                }
                $roomTotal = $days * ($registration->inpatientVisit->bed->price_per_night ?? 250000);
            }

            $subtotal = $servicesTotal + $medicinesTotal + $laboratoryTotal + $roomTotal;
            $discount = 0;
            $grandTotal = $subtotal - $discount;

            // 2. Buat Record Invoice Konsolidasi
            $invoice = Invoice::create([
                'invoice_number' => 'INV-'.date('Ymd').'-'.str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT),
                'registration_id' => $registration->id,
                'patient_id' => $registration->patient_id,
                'invoice_date' => now(),
                'services_total' => $servicesTotal,
                'medicines_total' => $medicinesTotal,
                'laboratory_total' => $laboratoryTotal,
                'room_total' => $roomTotal,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'grand_total' => $grandTotal,
                'status' => Invoice::STATUS_UNPAID,
                'created_by' => Auth::id(),
            ]);

            // 3. Catat Rincian Item Tagihan (InvoiceItems)
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'item_type' => InvoiceItem::TYPE_SERVICE,
                'item_name' => 'Biaya Registrasi Admisi & Konsultasi Medis',
                'quantity' => 1,
                'unit_price' => $servicesTotal,
                'subtotal' => $servicesTotal,
            ]);

            if ($medicinesTotal > 0) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'item_type' => InvoiceItem::TYPE_MEDICINE,
                    'item_name' => 'Paket Resep Obat Farmasi EMR',
                    'quantity' => 1,
                    'unit_price' => $medicinesTotal,
                    'subtotal' => $medicinesTotal,
                ]);
            }

            if ($laboratoryTotal > 0) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'item_type' => InvoiceItem::TYPE_LAB,
                    'item_name' => 'Pengujian Spesimen Laboratorium LIS',
                    'quantity' => 1,
                    'unit_price' => $laboratoryTotal,
                    'subtotal' => $laboratoryTotal,
                ]);
            }

            if ($roomTotal > 0) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'item_type' => InvoiceItem::TYPE_ROOM,
                    'item_name' => 'Sewa Tempat Tidur & Kamar Inap',
                    'quantity' => 1,
                    'unit_price' => $roomTotal,
                    'subtotal' => $roomTotal,
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
            $amountPaid = (float) $paymentData['amount_paid'];

            if ($amountPaid < $invoice->grand_total) {
                throw new Exception('Nominal pembayaran (Rp '.number_format($amountPaid, 0, ',', '.').') kurang dari total tagihan (Rp '.number_format($invoice->grand_total, 0, ',', '.').').');
            }

            $changeAmount = $amountPaid - $invoice->grand_total;

            // 1. Buat Record Pembayaran Kuitansi
            $payment = Payment::create([
                'receipt_number' => 'KW-'.date('Ymd').'-'.str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT),
                'invoice_id' => $invoice->id,
                'payment_date' => now(),
                'payment_method' => $paymentData['payment_method'] ?? 'Tunai',
                'amount_paid' => $amountPaid,
                'change_amount' => $changeAmount,
                'cashier_user_id' => Auth::id(),
                'notes' => $paymentData['notes'] ?? 'Pelunasan Kasir SIMRS',
            ]);

            // 2. Perbarui Status Invoice menjadi Lunas
            $invoice->update([
                'status' => Invoice::STATUS_PAID,
                'updated_by' => Auth::id(),
            ]);

            // 3. Perbarui Status Registrasi Pasien menjadi Selesai
            if ($invoice->registration) {
                $invoice->registration->update(['status' => Registration::STATUS_COMPLETED]);
            }

            return $payment;
        });
    }
}
