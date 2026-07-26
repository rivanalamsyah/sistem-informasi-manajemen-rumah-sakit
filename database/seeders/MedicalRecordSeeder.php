<?php

namespace Database\Seeders;

use App\Models\Diagnosis;
use App\Models\Doctor;
use App\Models\MedicalRecord;
use App\Models\Registration;
use Illuminate\Database\Seeder;

class MedicalRecordSeeder extends Seeder
{
    public function run(): void
    {
        $registrations = Registration::take(1000)->get();
        $doctors = Doctor::all();

        $icd10List = [
            ['code' => 'J00', 'name' => 'Acute nasopharyngitis [common cold]'],
            ['code' => 'A09', 'name' => 'Infectious gastroenteritis and colitis, unspecified'],
            ['code' => 'E11', 'name' => 'Non-insulin-dependent diabetes mellitus'],
            ['code' => 'I10', 'name' => 'Essential (primary) hypertension'],
            ['code' => 'K29.7', 'name' => 'Gastritis, unspecified'],
            ['code' => 'A91', 'name' => 'Dengue haemorrhagic fever'],
            ['code' => 'A01.0', 'name' => 'Typhoid fever'],
            ['code' => 'J18.9', 'name' => 'Pneumonia, unspecified'],
            ['code' => 'K35.8', 'name' => 'Acute appendicitis, other and unspecified'],
            ['code' => 'H10.1', 'name' => 'Acute atopic conjunctivitis'],
            ['code' => 'K02.9', 'name' => 'Dental caries, unspecified'],
            ['code' => 'R51', 'name' => 'Headache / Cephalgia'],
        ];

        foreach ($registrations as $idx => $reg) {
            $doc = $doctors[$idx % count($doctors)];

            $mr = MedicalRecord::create([
                'registration_id' => $reg->id,
                'patient_id' => $reg->patient_id,
                'doctor_id' => $doc->id,
                'record_date' => $reg->registration_date,
                'subjective' => 'Pasien mengeluhkan keluhan medis utama sejak beberapa hari yang lalu.',
                'objective' => 'Kesadaran Compos Mentis, TTV stabil. Pemeriksaan fisik abdomen supel, thoraks simetris.',
                'assessment' => 'Diagnosa kerja terkonfirmasi berdasarkan anamnesis & hasil pemeriksaan fisik.',
                'plan' => 'Pemberian medikamentosa symptomatic, edukasi istirahat cukup, dan kurangi makanan pedas/asam.',
                'notes' => 'Pasien disarankan kontrol ulang 3 hari kemudian.',
            ]);

            // Create Primary Diagnosis
            $icd = $icd10List[$idx % count($icd10List)];
            Diagnosis::create([
                'medical_record_id' => $mr->id,
                'icd10_code' => $icd['code'],
                'icd10_name' => $icd['name'],
                'type' => Diagnosis::TYPE_PRIMARY,
                'description' => 'Diagnosa utama hasil pemeriksaan klinis',
            ]);

            // Add Secondary Diagnosis for some records
            if ($idx % 3 === 0) {
                $icdSec = $icd10List[($idx + 3) % count($icd10List)];
                Diagnosis::create([
                    'medical_record_id' => $mr->id,
                    'icd10_code' => $icdSec['code'],
                    'icd10_name' => $icdSec['name'],
                    'type' => Diagnosis::TYPE_SECONDARY,
                    'description' => 'Diagnosa sekunder komorbid',
                ]);
            }
        }
    }
}
