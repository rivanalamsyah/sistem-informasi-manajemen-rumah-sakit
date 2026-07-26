<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password');

        // 1. Super Admin
        $superAdmin = User::firstOrCreate(['username' => 'superadmin'], [
            'name' => 'Super Administrator',
            'email' => 'superadmin@simrs.com',
            'password' => $password,
            'nik' => '3171010101900001',
            'phone' => '081234567890',
            'is_active' => true,
        ]);
        $this->attachRole($superAdmin, 'Super Admin');

        // 2. Admin (2 User)
        for ($i = 1; $i <= 2; $i++) {
            $admin = User::firstOrCreate(['username' => "admin{$i}"], [
                'name' => "Administrator SIMRS {$i}",
                'email' => "admin{$i}@simrs.com",
                'password' => $password,
                'nik' => '317101010190000'.($i + 1),
                'phone' => "08123456789{$i}",
                'is_active' => true,
            ]);
            $this->attachRole($admin, 'Admin');
        }

        // 3. Dokter Users (10 User)
        $dokterNames = [
            'dr. Ahmad Hidayat, Sp.PD',
            'dr. Siti Rahmawati, Sp.A',
            'dr. Budi Santoso, Sp.B',
            'dr. Dewi Lestari, Sp.OG',
            'dr. Hendra Wijaya, Sp.M',
            'dr. Maya Putri, Sp.THT',
            'dr. Rizky Pratama, Sp.S',
            'dr. Anisa Nurul, Sp.JP',
            'dr. Eko Prasetyo, Sp.KG',
            'dr. Farida Hanum, Sp.P',
        ];

        foreach ($dokterNames as $idx => $name) {
            $num = $idx + 1;
            $docUser = User::firstOrCreate(['username' => "dokter{$num}"], [
                'name' => $name,
                'email' => "dokter{$num}@simrs.com",
                'password' => $password,
                'nik' => '31710102019000'.str_pad($num, 2, '0', STR_PAD_LEFT),
                'phone' => '0813100020'.str_pad($num, 2, '0', STR_PAD_LEFT),
                'is_active' => true,
            ]);
            $this->attachRole($docUser, 'Dokter');
        }

        // 4. Perawat Users (10 User)
        for ($i = 1; $i <= 10; $i++) {
            $perawat = User::firstOrCreate(['username' => "perawat{$i}"], [
                'name' => "Ns. Perawat Medis {$i}, S.Kep",
                'email' => "perawat{$i}@simrs.com",
                'password' => $password,
                'nik' => '31710103019000'.str_pad($i, 2, '0', STR_PAD_LEFT),
                'phone' => '0814100030'.str_pad($i, 2, '0', STR_PAD_LEFT),
                'is_active' => true,
            ]);
            $this->attachRole($perawat, 'Perawat');
        }

        // 5. Apoteker (2 User)
        for ($i = 1; $i <= 2; $i++) {
            $apoteker = User::firstOrCreate(['username' => "apoteker{$i}"], [
                'name' => "apt. Apoteker Farmasi {$i}, S.Farm",
                'email' => "apoteker{$i}@simrs.com",
                'password' => $password,
                'nik' => "317101040190000{$i}",
                'phone' => "08151000400{$i}",
                'is_active' => true,
            ]);
            $this->attachRole($apoteker, 'Apoteker');
        }

        // 6. Petugas Laboratorium (2 User)
        for ($i = 1; $i <= 2; $i++) {
            $lab = User::firstOrCreate(['username' => "analis{$i}"], [
                'name' => "Analis Lab Medis {$i}, A.Md.AK",
                'email' => "analis{$i}@simrs.com",
                'password' => $password,
                'nik' => "317101050190000{$i}",
                'phone' => "08161000500{$i}",
                'is_active' => true,
            ]);
            $this->attachRole($lab, 'Petugas Laboratorium');
        }

        // 7. Petugas Pendaftaran (2 User)
        for ($i = 1; $i <= 2; $i++) {
            $admisi = User::firstOrCreate(['username' => "admisi{$i}"], [
                'name' => "Petugas Admisi Pendaftaran {$i}",
                'email' => "admisi{$i}@simrs.com",
                'password' => $password,
                'nik' => "317101060190000{$i}",
                'phone' => "08171000600{$i}",
                'is_active' => true,
            ]);
            $this->attachRole($admisi, 'Petugas Pendaftaran');
        }

        // 8. Kasir (2 User)
        for ($i = 1; $i <= 2; $i++) {
            $kasir = User::firstOrCreate(['username' => "kasir{$i}"], [
                'name' => "Petugas Kasir Billing {$i}",
                'email' => "kasir{$i}@simrs.com",
                'password' => $password,
                'nik' => "317101070190000{$i}",
                'phone' => "08181000700{$i}",
                'is_active' => true,
            ]);
            $this->attachRole($kasir, 'Kasir');
        }
    }

    private function attachRole(User $user, string $roleName): void
    {
        $role = Role::where('name', $roleName)->first();
        if ($role) {
            $user->roles()->syncWithoutDetaching([$role->id]);
        }
    }
}
