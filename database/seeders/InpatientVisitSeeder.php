<?php

namespace Database\Seeders;

use App\Models\Bed;
use App\Models\Doctor;
use App\Models\InpatientVisit;
use App\Models\Registration;
use Illuminate\Database\Seeder;

class InpatientVisitSeeder extends Seeder
{
    public function run(): void
    {
        $registrations = Registration::where('service_type', Registration::TYPE_INPATIENT)
            ->take(200)
            ->get();

        $beds = Bed::all();
        $doctors = Doctor::all();

        $diagnoses = [
            'Dengue Hemorrhagic Fever (DHF) Grade II',
            'Gastroenteritis Akut (GEA) dengan Dehidrasi Sedang',
            'Demam Tifoid / Typhoid Fever',
            'Pneumonia Komunitas derajat Sedang',
            'Diabetes Mellitus Tipe 2 Terkontrol Buruk',
            'Hipertensi Grade II dengan Cephalgia',
            'Appendisitis Akut Terencana Appendektomi',
        ];

        foreach ($registrations as $idx => $reg) {
            $bed = $beds[$idx % count($beds)];
            $doc = $doctors[$idx % count($doctors)];
            $isDischarged = $idx < 160; // 160 discharged, 40 currently active inpatient

            InpatientVisit::firstOrCreate(['registration_id' => $reg->id], [
                'bed_id' => $bed->id,
                'doctor_id' => $doc->id,
                'admission_date' => $reg->registration_date,
                'discharge_date' => $isDischarged ? (clone $reg->registration_date)->addDays(rand(2, 7)) : null,
                'initial_diagnosis' => $diagnoses[$idx % count($diagnoses)],
                'discharge_reason' => $isDischarged ? 'Sembuh' : null,
                'status' => $isDischarged ? InpatientVisit::STATUS_CHECKOUT_BILLING : InpatientVisit::STATUS_ACTIVE,
            ]);

            if (! $isDischarged) {
                $bed->update(['status' => Bed::STATUS_OCCUPIED]);
            }
        }
    }
}
