<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Queue;
use App\Models\Registration;
use Illuminate\Database\Seeder;

class RegistrationAndQueueSeeder extends Seeder
{
    public function run(): void
    {
        $patientIds = Patient::pluck('id')->toArray();
        $departments = Department::all();
        $doctors = Doctor::all();

        $types = [Registration::TYPE_OUTPATIENT, Registration::TYPE_OUTPATIENT, Registration::TYPE_OUTPATIENT, Registration::TYPE_INPATIENT, Registration::TYPE_EMERGENCY];
        $guarantors = ['Umum', 'Umum', 'Umum', 'Asuransi Swasta'];
        $statuses = [Registration::STATUS_COMPLETED, Registration::STATUS_COMPLETED, Registration::STATUS_COMPLETED, Registration::STATUS_PROCESSING];

        $registrations = [];
        $queues = [];
        $now = now();

        for ($i = 1; $i <= 1000; $i++) {
            $regNum = 'REG-'.date('Ymd', strtotime("-{$i} hours")).'-'.str_pad($i, 4, '0', STR_PAD_LEFT);
            $patientId = $patientIds[($i - 1) % count($patientIds)];
            $dept = $departments[($i - 1) % count($departments)];
            $doc = $doctors->where('department_id', $dept->id)->first() ?? $doctors->first();
            $serviceType = $types[$i % count($types)];
            $regDate = now()->subDays(rand(0, 90))->addMinutes(rand(0, 1440));

            $reg = Registration::create([
                'registration_number' => $regNum,
                'patient_id' => $patientId,
                'service_type' => $serviceType,
                'registration_date' => $regDate,
                'guarantor' => $guarantors[$i % count($guarantors)],
                'status' => $statuses[$i % count($statuses)],
                'notes' => 'Pendaftaran Kunjungan Pelayanan Medis',
            ]);

            if ($serviceType === Registration::TYPE_OUTPATIENT) {
                Queue::create([
                    'registration_id' => $reg->id,
                    'department_id' => $dept->id,
                    'doctor_id' => $doc->id,
                    'queue_number' => ($i % 30) + 1,
                    'queue_code' => 'POL-'.chr(65 + ($i % 5)).'-'.str_pad(($i % 30) + 1, 2, '0', STR_PAD_LEFT),
                    'queue_date' => $regDate->toDateString(),
                    'status' => Queue::STATUS_COMPLETED,
                ]);
            }
        }
    }
}
