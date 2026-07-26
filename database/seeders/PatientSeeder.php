<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    public function run(): void
    {
        $firstNamesL = ['Ahmad', 'Budi', 'Candra', 'Deni', 'Eko', 'Fajar', 'Gunawan', 'Hendra', 'Irfan', 'Joko', 'Kurniawan', 'Luki', 'Muhammad', 'Nugroho', 'Oktavian', 'Pratama', 'Rahmat', 'Santoso', 'Taufik', 'Wahyu', 'Yudi', 'Zainal'];
        $firstNamesP = ['Ani', 'Bunga', 'Citra', 'Dewi', 'Endang', 'Fitri', 'Gita', 'Hani', 'Indah', 'Juli', 'Kartika', 'Lestari', 'Maya', 'Nirmala', 'Pratiwi', 'Ratna', 'Siti', 'Tri', 'Utami', 'Wulan', 'Yulia', 'Zahra'];
        $lastNames = ['Sutrisno', 'Hidayat', 'Wibowo', 'Prasetyo', 'Saputra', 'Kusuma', 'Nugraha', 'Setiawan', 'Rahman', 'Kurnia', 'Subagyo', 'Firmansyah', 'Permana', 'Budiman', 'Laksana', 'Irawan'];

        $cities = ['Jakarta Selatan', 'Jakarta Timur', 'Bandung', 'Surabaya', 'Semarang', 'Yogyakarta', 'Medan', 'Makassar', 'Palembang', 'Depok', 'Tangerang', 'Bekasi'];
        $religions = ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha'];
        $marital = ['Belum Menikah', 'Menikah', 'Janda / Duda'];
        $bloodTypes = ['A', 'B', 'AB', 'O'];

        $patients = [];
        $now = now();

        for ($i = 1; $i <= 500; $i++) {
            $isMale = $i % 2 === 1;
            $gender = $isMale ? Patient::GENDER_MALE : Patient::GENDER_FEMALE;
            $firstName = $isMale ? $firstNamesL[array_rand($firstNamesL)] : $firstNamesP[array_rand($firstNamesP)];
            $lastName = $lastNames[array_rand($lastNames)];
            $name = "{$firstName} {$lastName}";

            $mrNumber = 'RM-'.str_pad($i, 6, '0', STR_PAD_LEFT);
            $nik = '3171'.rand(10, 99).rand(10, 99).rand(40, 99).str_pad($i, 4, '0', STR_PAD_LEFT);
            $birthYear = rand(1955, 2020);
            $birthMonth = str_pad(rand(1, 12), 2, '0', STR_PAD_LEFT);
            $birthDay = str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT);

            $patients[] = [
                'mr_number' => $mrNumber,
                'nik' => $nik,
                'name' => $name,
                'birth_place' => $cities[array_rand($cities)],
                'birth_date' => "{$birthYear}-{$birthMonth}-{$birthDay}",
                'gender' => $gender,
                'blood_type' => $bloodTypes[array_rand($bloodTypes)],
                'religion' => $religions[array_rand($religions)],
                'marital_status' => $marital[array_rand($marital)],
                'occupation' => 'Karyawan Swasta',
                'phone' => '08'.rand(11, 99).rand(100000, 999999),
                'email' => strtolower("{$firstName}.{$lastName}{$i}@gmail.com"),
                'address' => "Jl. Merdeka No. {$i}, ".$cities[array_rand($cities)],
                'guardian_name' => 'Keluarga '.$lastName,
                'guardian_phone' => '08'.rand(11, 99).rand(100000, 999999),
                'guardian_relation' => 'Suami / Istri / Orang Tua',
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        foreach (array_chunk($patients, 100) as $chunk) {
            Patient::insert($chunk);
        }
    }
}
