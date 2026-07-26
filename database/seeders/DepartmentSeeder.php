<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['code' => 'POL-UMUM', 'name' => 'Poliklinik Umum', 'description' => 'Pelayanan kesehatan umum & konsultasi awal'],
            ['code' => 'POL-ANAK', 'name' => 'Poliklinik Anak', 'description' => 'Pelayanan kesehatan bayi & anak-anak'],
            ['code' => 'POL-PDALAM', 'name' => 'Poliklinik Penyakit Dalam', 'description' => 'Spesialis ginjal, usus, paru, & organ dalam'],
            ['code' => 'POL-BEDAH', 'name' => 'Poliklinik Bedah Umum', 'description' => 'Pelayanan tindakan bedah minor & konsultasi operasi'],
            ['code' => 'POL-KANDUNG', 'name' => 'Poliklinik Kandungan & Kebidanan', 'description' => 'Pemeriksaan kehamilan & kesehatan reproduksi wanita'],
            ['code' => 'POL-GIGI', 'name' => 'Poliklinik Gigi & Mulut', 'description' => 'Perawatan & tindakan medis kesehatan gigi'],
            ['code' => 'POL-MATA', 'name' => 'Poliklinik Mata', 'description' => 'Pemeriksaan indra penglihatan & refraksi mata'],
            ['code' => 'POL-THT', 'name' => 'Poliklinik THT-KL', 'description' => 'Spesialis telinga, hidung, tenggorokan, kepala & leher'],
            ['code' => 'POL-SARAF', 'name' => 'Poliklinik Saraf', 'description' => 'Pelayanan sistem saraf, stroke, & nyeri kepala'],
            ['code' => 'POL-JANTUNG', 'name' => 'Poliklinik Jantung', 'description' => 'Pelayanan kesehatan kardiovaskular & EKG'],
        ];

        foreach ($departments as $dept) {
            Department::firstOrCreate(['code' => $dept['code']], [
                'name' => $dept['name'],
                'description' => $dept['description'],
                'is_active' => true,
            ]);
        }
    }
}
