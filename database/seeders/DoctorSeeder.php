<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        $doctorsData = [
            ['name' => 'Ahmad Hidayat', 'prefix' => 'dr.', 'suffix' => 'Sp.PD', 'spec' => 'Penyakit Dalam', 'poli' => 'POL-PDALAM', 'username' => 'dokter1'],
            ['name' => 'Siti Rahmawati', 'prefix' => 'dr.', 'suffix' => 'Sp.A', 'spec' => 'Kesehatan Anak', 'poli' => 'POL-ANAK', 'username' => 'dokter2'],
            ['name' => 'Budi Santoso', 'prefix' => 'dr.', 'suffix' => 'Sp.B', 'spec' => 'Bedah Umum', 'poli' => 'POL-BEDAH', 'username' => 'dokter3'],
            ['name' => 'Dewi Lestari', 'prefix' => 'dr.', 'suffix' => 'Sp.OG', 'spec' => 'Kandungan & Kebidanan', 'poli' => 'POL-KANDUNG', 'username' => 'dokter4'],
            ['name' => 'Hendra Wijaya', 'prefix' => 'dr.', 'suffix' => 'Sp.M', 'spec' => 'Spesialis Mata', 'poli' => 'POL-MATA', 'username' => 'dokter5'],
            ['name' => 'Maya Putri', 'prefix' => 'dr.', 'suffix' => 'Sp.THT-KL', 'spec' => 'Spesialis THT', 'poli' => 'POL-THT', 'username' => 'dokter6'],
            ['name' => 'Rizky Pratama', 'prefix' => 'dr.', 'suffix' => 'Sp.S', 'spec' => 'Spesialis Saraf', 'poli' => 'POL-SARAF', 'username' => 'dokter7'],
            ['name' => 'Anisa Nurul', 'prefix' => 'dr.', 'suffix' => 'Sp.JP', 'spec' => 'Jantung & Pembuluh Darah', 'poli' => 'POL-JANTUNG', 'username' => 'dokter8'],
            ['name' => 'Eko Prasetyo', 'prefix' => 'drg.', 'suffix' => 'Sp.KG', 'spec' => 'Konservasi Gigi', 'poli' => 'POL-GIGI', 'username' => 'dokter9'],
            ['name' => 'Farida Hanum', 'prefix' => 'dr.', 'suffix' => 'Sp.P', 'spec' => 'Dokter Umum & Paru', 'poli' => 'POL-UMUM', 'username' => 'dokter10'],

            ['name' => 'Gita Gutawa', 'prefix' => 'dr.', 'suffix' => 'M.Kes', 'spec' => 'Dokter Umum', 'poli' => 'POL-UMUM', 'username' => null],
            ['name' => 'Hadi Sucipto', 'prefix' => 'dr.', 'suffix' => 'Sp.A', 'spec' => 'Pediatri & Tumbuh Tumbuh', 'poli' => 'POL-ANAK', 'username' => null],
            ['name' => 'Irfan Hakim', 'prefix' => 'dr.', 'suffix' => 'Sp.PD', 'spec' => 'Endokrin & Diabetes', 'poli' => 'POL-PDALAM', 'username' => null],
            ['name' => 'Julia Rahayu', 'prefix' => 'dr.', 'suffix' => 'Sp.B', 'spec' => 'Bedah Onkologi', 'poli' => 'POL-BEDAH', 'username' => null],
            ['name' => 'Kartika Sari', 'prefix' => 'dr.', 'suffix' => 'Sp.OG', 'spec' => 'Fertilitas & Kebidanan', 'poli' => 'POL-KANDUNG', 'username' => null],
            ['name' => 'Lukman Hakim', 'prefix' => 'drg.', 'suffix' => '', 'spec' => 'Kedokteran Gigi Umum', 'poli' => 'POL-GIGI', 'username' => null],
            ['name' => 'Muhammad Ali', 'prefix' => 'dr.', 'suffix' => 'Sp.M', 'spec' => 'Katarak & Refraksi', 'poli' => 'POL-MATA', 'username' => null],
            ['name' => 'Nurmala Dewi', 'prefix' => 'dr.', 'suffix' => 'Sp.THT-KL', 'spec' => 'THT & Audiologi', 'poli' => 'POL-THT', 'username' => null],
            ['name' => 'Oktavianus', 'prefix' => 'dr.', 'suffix' => 'Sp.S', 'spec' => 'Neurologi Klinis', 'poli' => 'POL-SARAF', 'username' => null],
            ['name' => 'Pratiwi Sudarmono', 'prefix' => 'dr.', 'suffix' => 'Sp.JP', 'spec' => 'Kardiologi Intervensi', 'poli' => 'POL-JANTUNG', 'username' => null],
        ];

        foreach ($doctorsData as $idx => $doc) {
            $num = $idx + 1;
            $dept = Department::where('code', $doc['poli'])->first();
            $user = $doc['username'] ? User::where('username', $doc['username'])->first() : null;

            Doctor::firstOrCreate(['sip' => 'SIP-507.01/2026/'.str_pad($num, 3, '0', STR_PAD_LEFT)], [
                'user_id' => $user?->id,
                'department_id' => $dept ? $dept->id : 1,
                'name' => $doc['name'],
                'title_prefix' => $doc['prefix'],
                'title_suffix' => $doc['suffix'],
                'specialization' => $doc['spec'],
                'phone' => '0812900080'.str_pad($num, 2, '0', STR_PAD_LEFT),
                'email' => strtolower(str_replace(' ', '', $doc['name'])).'@simrs.com',
                'is_active' => true,
            ]);
        }
    }
}
