<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Payment;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Database\Seeder;

class InvoiceAndPaymentSeeder extends Seeder
{
    public function run(): void
    {
        $registrations = Registration::take(800)->get();
        $kasir = User::where('username', 'kasir1')->first() ?? User::first();

        foreach ($registrations as $idx => $reg) {
            $invNum = 'INV-'.date('Ymd', strtotime($reg->registration_date)).'-'.str_pad($idx + 1, 4, '0', STR_PAD_LEFT);
            $isPaid = $idx < 720; // 720 Paid, 80 Unpaid

            $srvTotal = rand(75000, 300000);
            $medTotal = rand(50000, 250000);
            $labTotal = rand(0, 1) === 1 ? rand(95000, 250000) : 0;
            $roomTotal = $reg->service_type === Registration::TYPE_INPATIENT ? rand(600000, 3000000) : 0;
            $subtotal = $srvTotal + $medTotal + $labTotal + $roomTotal;
            $discount = $idx % 10 === 0 ? 25000 : 0;
            $grandTotal = $subtotal - $discount;

            $invoice = Invoice::create([
                'invoice_number' => $invNum,
                'registration_id' => $reg->id,
                'patient_id' => $reg->patient_id,
                'invoice_date' => $reg->registration_date,
                'services_total' => $srvTotal,
                'medicines_total' => $medTotal,
                'laboratory_total' => $labTotal,
                'room_total' => $roomTotal,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'grand_total' => $grandTotal,
                'status' => $isPaid ? Invoice::STATUS_PAID : Invoice::STATUS_UNPAID,
            ]);

            // Add Invoice Items
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'item_type' => InvoiceItem::TYPE_SERVICE,
                'item_name' => 'Biaya Konsultasi & Tindakan Medis Dokter',
                'quantity' => 1,
                'unit_price' => $srvTotal,
                'subtotal' => $srvTotal,
            ]);

            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'item_type' => InvoiceItem::TYPE_MEDICINE,
                'item_name' => 'Biaya Obat-Obatan & Resep Farmasi',
                'quantity' => 1,
                'unit_price' => $medTotal,
                'subtotal' => $medTotal,
            ]);

            if ($labTotal > 0) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'item_type' => InvoiceItem::TYPE_LAB,
                    'item_name' => 'Biaya Pemeriksaan Laboratorium Medis',
                    'quantity' => 1,
                    'unit_price' => $labTotal,
                    'subtotal' => $labTotal,
                ]);
            }

            if ($roomTotal > 0) {
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'item_type' => InvoiceItem::TYPE_ROOM,
                    'item_name' => 'Biaya Sewa Kamar Rawat Inap & Asuhan Keperawatan',
                    'quantity' => 1,
                    'unit_price' => $roomTotal,
                    'subtotal' => $roomTotal,
                ]);
            }

            // Create Payment for Paid Invoices
            if ($isPaid) {
                Payment::create([
                    'receipt_number' => 'KWT-'.date('Ymd', strtotime($reg->registration_date)).'-'.str_pad($idx + 1, 4, '0', STR_PAD_LEFT),
                    'invoice_id' => $invoice->id,
                    'payment_date' => (clone $reg->registration_date)->addMinutes(30),
                    'payment_method' => Payment::METHOD_CASH,
                    'amount_paid' => $grandTotal,
                    'change_amount' => 0.00,
                    'cashier_user_id' => $kasir->id,
                    'notes' => 'Pembayaran lunas via Kasir Rawat Jalan/Inap',
                ]);
            }
        }
    }
}
