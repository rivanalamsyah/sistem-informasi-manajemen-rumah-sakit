<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Medicine;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\Registration;
use Illuminate\Database\Seeder;

class PrescriptionSeeder extends Seeder
{
    public function run(): void
    {
        $registrations = Registration::take(700)->get();
        $medicines = Medicine::all();
        $doctors = Doctor::all();

        $dosages = [
            '3x1 Tablet sesudah makan',
            '2x1 Kaplet sesudah makan',
            '3x1 Sendok teh sesudah makan',
            '1x1 Kapsul sebelum tidur',
            '3x1 Tablet sebelum makan',
            '2x1 Tablet bila demam',
        ];

        foreach ($registrations as $idx => $reg) {
            $doc = $doctors[$idx % count($doctors)];
            $pNum = 'RSP-'.date('Ymd', strtotime($reg->registration_date)).'-'.str_pad($idx + 1, 4, '0', STR_PAD_LEFT);

            $prescription = Prescription::create([
                'prescription_number' => $pNum,
                'registration_id' => $reg->id,
                'patient_id' => $reg->patient_id,
                'doctor_id' => $doc->id,
                'prescription_date' => $reg->registration_date,
                'status' => Prescription::STATUS_COMPLETED,
                'notes' => 'Minum obat teratur dan habiskan antibiotik',
            ]);

            // Add 2 to 5 prescription items
            $itemCount = rand(2, 5);
            for ($k = 1; $k <= $itemCount; $k++) {
                $med = $medicines[($idx * 5 + $k) % count($medicines)];
                $qty = rand(10, 30);
                $subtotal = $qty * $med->selling_price;

                PrescriptionItem::create([
                    'prescription_id' => $prescription->id,
                    'medicine_id' => $med->id,
                    'quantity' => $qty,
                    'dosage' => $dosages[array_rand($dosages)],
                    'unit_price' => $med->selling_price,
                    'subtotal' => $subtotal,
                    'notes' => 'Gunakan sesuai petunjuk dosis',
                ]);
            }
        }
    }
}
