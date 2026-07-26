<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\LaboratoryOrder;
use App\Models\LaboratoryResult;
use App\Models\LaboratoryTest;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Database\Seeder;

class LaboratoryOrderSeeder extends Seeder
{
    public function run(): void
    {
        $registrations = Registration::take(400)->get();
        $labTests = LaboratoryTest::all();
        $doctors = Doctor::all();
        $analyst = User::where('username', 'analis1')->first() ?? User::first();

        foreach ($registrations as $idx => $reg) {
            $doc = $doctors[$idx % count($doctors)];
            $oNum = 'LAB-'.date('Ymd', strtotime($reg->registration_date)).'-'.str_pad($idx + 1, 4, '0', STR_PAD_LEFT);

            $order = LaboratoryOrder::create([
                'order_number' => $oNum,
                'registration_id' => $reg->id,
                'patient_id' => $reg->patient_id,
                'doctor_id' => $doc->id,
                'order_date' => $reg->registration_date,
                'status' => LaboratoryOrder::STATUS_COMPLETED,
                'clinical_notes' => 'Pemeriksaan rutin evaluasi klinis pasien',
            ]);

            // Add 1 to 3 lab test results
            $testCount = rand(1, 3);
            for ($k = 0; $k < $testCount; $k++) {
                $test = $labTests[($idx * 3 + $k) % count($labTests)];
                $isAbnormal = $k === 0 && $idx % 4 === 0;

                LaboratoryResult::create([
                    'laboratory_order_id' => $order->id,
                    'laboratory_test_id' => $test->id,
                    'result_value' => $isAbnormal ? '185 mg/dL (Tinggi)' : '110 mg/dL (Normal)',
                    'reference_range' => $test->reference_range_male ?? '70-140',
                    'unit' => $test->unit ?? 'mg/dL',
                    'is_abnormal' => $isAbnormal,
                    'notes' => $isAbnormal ? 'Diperlukan konfirmasi pemeriksaan ulang' : 'Hasil pemeriksaan dalam batas normal',
                    'analyst_user_id' => $analyst->id,
                    'doctor_in_charge_id' => $doc->id,
                    'result_date' => (clone $reg->registration_date)->addHours(2),
                ]);
            }
        }
    }
}
