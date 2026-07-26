<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Service;
use App\Models\Tariff;
use Illuminate\Database\Seeder;

class ServiceAndTariffSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['code' => 'TND-001', 'name' => 'Konsultasi Dokter Spesialis', 'cat' => 'Konsultasi', 'price' => 150000],
            ['code' => 'TND-002', 'name' => 'Pemeriksaan Dokter Umum', 'cat' => 'Konsultasi', 'price' => 75000],
            ['code' => 'TND-003', 'name' => 'Pemeriksaan Tanda Vital (TTV)', 'cat' => 'Keperawatan', 'price' => 25000],
            ['code' => 'TND-004', 'name' => 'Rekam Jantung (EKG)', 'cat' => 'Penunjang Medis', 'price' => 125000],
            ['code' => 'TND-005', 'name' => 'USG Abdomen 2D/3D', 'cat' => 'Penunjang Medis', 'price' => 250000],
            ['code' => 'TND-006', 'name' => 'Tindakan Nebulizer', 'cat' => 'Tindakan Medis', 'price' => 85000],
            ['code' => 'TND-007', 'name' => 'Perawatan Luka Kecil (Luka Lecet/Jahit)', 'cat' => 'Tindakan Medis', 'price' => 100000],
            ['code' => 'TND-008', 'name' => 'Perawatan Luka Sedang / Besar', 'cat' => 'Tindakan Medis', 'price' => 200000],
            ['code' => 'TND-009', 'name' => 'Pemasangan Infus (IV Line)', 'cat' => 'Tindakan Medis', 'price' => 75000],
            ['code' => 'TND-010', 'name' => 'Pemasangan Kateter Urin', 'cat' => 'Tindakan Medis', 'price' => 90000],
            ['code' => 'TND-011', 'name' => 'Pemasangan Selang NGT', 'cat' => 'Tindakan Medis', 'price' => 110000],
            ['code' => 'TND-012', 'name' => 'Tindakan Ekstraksi Gigi / Cabut Gigi', 'cat' => 'Gigi', 'price' => 175000],
            ['code' => 'TND-013', 'name' => 'Penambalan Gigi Komposit', 'cat' => 'Gigi', 'price' => 200000],
            ['code' => 'TND-014', 'name' => 'Scaling Gigi / Pembersihan Karang', 'cat' => 'Gigi', 'price' => 250000],
            ['code' => 'TND-015', 'name' => 'Pemeriksaan Refraksi Mata', 'cat' => 'Mata', 'price' => 90000],
            ['code' => 'TND-016', 'name' => 'Irigasi Telinga (Spooling THT)', 'cat' => 'THT', 'price' => 120000],
            ['code' => 'TND-017', 'name' => 'Pemeriksaan USG Kehamilan (Kandungan)', 'cat' => 'Kandungan', 'price' => 220000],
            ['code' => 'TND-018', 'name' => 'Tindakan Imunisasi Anak', 'cat' => 'Anak', 'price' => 80000],
            ['code' => 'TND-019', 'name' => 'Tindakan Bedah Minor (Eksisi Benjolan)', 'cat' => 'Bedah', 'price' => 750000],
            ['code' => 'TND-020', 'name' => 'Oksigenasi Per Jam', 'cat' => 'Tindakan Medis', 'price' => 30000],
            ['code' => 'TND-021', 'name' => 'Visite Dokter Spesialis (Rawat Inap)', 'cat' => 'Visite', 'price' => 175000],
            ['code' => 'TND-022', 'name' => 'Visite Dokter Umum (Rawat Inap)', 'cat' => 'Visite', 'price' => 90000],
            ['code' => 'TND-023', 'name' => 'Asuhan Keperawatan Rawat Inap / Hari', 'cat' => 'Keperawatan', 'price' => 50000],
            ['code' => 'TND-024', 'name' => 'Biaya Kamar Operasi (Per Jam)', 'cat' => 'Operasi', 'price' => 1200000],
            ['code' => 'TND-025', 'name' => 'Tindakan Sirkumsisi / Khitan', 'cat' => 'Bedah', 'price' => 600000],
            ['code' => 'TND-026', 'name' => 'Biaya Kebersihan & Alkes Steril', 'cat' => 'Umum', 'price' => 35000],
            ['code' => 'TND-027', 'name' => 'Administrasi Pendaftaran Baru', 'cat' => 'Administrasi', 'price' => 20000],
            ['code' => 'TND-028', 'name' => 'Administrasi Pendaftaran Berulang', 'cat' => 'Administrasi', 'price' => 10000],
            ['code' => 'TND-029', 'name' => 'Pemeriksaan Spirometri (Paru)', 'cat' => 'Penunjang Medis', 'price' => 180000],
            ['code' => 'TND-030', 'name' => 'Terapi Inhalasi / Fisioterapi Dada', 'cat' => 'Tindakan Medis', 'price' => 130000],
        ];

        $dept = Department::first();

        foreach ($services as $srv) {
            $service = Service::firstOrCreate(['code' => $srv['code']], [
                'name' => $srv['name'],
                'category' => $srv['cat'],
                'department_id' => $dept?->id,
                'is_active' => true,
            ]);

            // Create Tariffs for classes
            foreach (['Umum', 'VVIP', 'VIP', 'Kelas 1', 'Kelas 2', 'Kelas 3'] as $class) {
                $multiplier = match ($class) {
                    'VVIP' => 1.8,
                    'VIP' => 1.5,
                    'Kelas 1' => 1.2,
                    'Kelas 2' => 1.0,
                    'Kelas 3' => 0.85,
                    default => 1.0,
                };

                Tariff::firstOrCreate([
                    'service_id' => $service->id,
                    'class' => $class,
                ], [
                    'amount' => round($srv['price'] * $multiplier, -3),
                    'description' => "Tarif {$srv['name']} untuk kelas {$class}",
                    'is_active' => true,
                ]);
            }
        }
    }
}
