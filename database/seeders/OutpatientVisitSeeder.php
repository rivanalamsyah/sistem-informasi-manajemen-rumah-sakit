<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\OutpatientVisit;
use App\Models\Queue;
use App\Models\Registration;
use Illuminate\Database\Seeder;

class OutpatientVisitSeeder extends Seeder
{
    public function run(): void
    {
        $registrations = Registration::where('service_type', Registration::TYPE_OUTPATIENT)
            ->take(700)
            ->get();

        $complaints = [
            'Demam tinggi naik turun sejak 3 hari disertai pusing',
            'Batuk berdahak, sesak napas ringan, dan nyeri tenggorokan',
            'Nyeri ulu hati, mual, muntah, dan perut terasa kembung',
            'Sakit kepala berputar (vertigo) dan lemas',
            'Nyeri dada sebelah kiri tembus ke belakang',
            'Gatal-gatal pada kulit dan kemerahan setelah makan udang',
            'Pemeriksaan rutin gula darah dan kontrol hipertensi',
            'Sakit gigi berlubang geraham bawah kanan',
            'Mata merah, berair, dan terasa mengganjal',
        ];

        foreach ($registrations as $reg) {
            $queue = Queue::where('registration_id', $reg->id)->first();
            $deptId = $queue ? $queue->department_id : 1;
            $docId = $queue ? $queue->doctor_id : Doctor::first()->id;

            OutpatientVisit::firstOrCreate(['registration_id' => $reg->id], [
                'department_id' => $deptId,
                'doctor_id' => $docId,
                'visit_date' => $reg->registration_date,
                'complaint' => $complaints[array_rand($complaints)],
                'vital_signs' => [
                    'systole' => rand(110, 150),
                    'diastole' => rand(70, 95),
                    'temperature' => rand(365, 385) / 10,
                    'pulse' => rand(70, 100),
                    'rr' => rand(16, 24),
                    'height' => rand(150, 180),
                    'weight' => rand(48, 85),
                ],
                'status' => OutpatientVisit::STATUS_COMPLETED,
            ]);
        }
    }
}
