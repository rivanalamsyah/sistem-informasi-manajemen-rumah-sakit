<?php

namespace Database\Seeders;

use App\Models\Bed;
use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomAndBedSeeder extends Seeder
{
    public function run(): void
    {
        $roomsData = [
            ['code' => 'R-VIP-01', 'name' => 'Dahlia 01 (VIP)', 'building' => 'Gedung A Utama', 'floor' => 'Lantai 2', 'type' => 'VIP'],
            ['code' => 'R-VIP-02', 'name' => 'Dahlia 02 (VIP)', 'building' => 'Gedung A Utama', 'floor' => 'Lantai 2', 'type' => 'VIP'],
            ['code' => 'R-VVIP-01', 'name' => 'President Suite 01', 'building' => 'Gedung A Utama', 'floor' => 'Lantai 3', 'type' => 'VIP'],
            ['code' => 'R-ICU-01', 'name' => 'Intensive Care Unit (ICU)', 'building' => 'Gedung B Medis', 'floor' => 'Lantai 1', 'type' => 'ICU'],
            ['code' => 'R-ISO-01', 'name' => 'Ruang Isolasi Infeksius', 'building' => 'Gedung C Khusus', 'floor' => 'Lantai 1', 'type' => 'Isolasi'],
            ['code' => 'R-K1-01', 'name' => 'Melati 101 (Kelas 1)', 'building' => 'Gedung A Utama', 'floor' => 'Lantai 1', 'type' => 'Rawat Inap'],
            ['code' => 'R-K1-02', 'name' => 'Melati 102 (Kelas 1)', 'building' => 'Gedung A Utama', 'floor' => 'Lantai 1', 'type' => 'Rawat Inap'],
            ['code' => 'R-K1-03', 'name' => 'Melati 103 (Kelas 1)', 'building' => 'Gedung A Utama', 'floor' => 'Lantai 1', 'type' => 'Rawat Inap'],
            ['code' => 'R-K2-01', 'name' => 'Mawar 201 (Kelas 2)', 'building' => 'Gedung A Utama', 'floor' => 'Lantai 2', 'type' => 'Rawat Inap'],
            ['code' => 'R-K2-02', 'name' => 'Mawar 202 (Kelas 2)', 'building' => 'Gedung A Utama', 'floor' => 'Lantai 2', 'type' => 'Rawat Inap'],
            ['code' => 'R-K2-03', 'name' => 'Mawar 203 (Kelas 2)', 'building' => 'Gedung A Utama', 'floor' => 'Lantai 2', 'type' => 'Rawat Inap'],
            ['code' => 'R-K3-01', 'name' => 'Anggrek 301 (Kelas 3)', 'building' => 'Gedung B Medis', 'floor' => 'Lantai 2', 'type' => 'Rawat Inap'],
            ['code' => 'R-K3-02', 'name' => 'Anggrek 302 (Kelas 3)', 'building' => 'Gedung B Medis', 'floor' => 'Lantai 2', 'type' => 'Rawat Inap'],
            ['code' => 'R-K3-03', 'name' => 'Anggrek 303 (Kelas 3)', 'building' => 'Gedung B Medis', 'floor' => 'Lantai 2', 'type' => 'Rawat Inap'],
            ['code' => 'R-K3-04', 'name' => 'Anggrek 304 (Kelas 3)', 'building' => 'Gedung B Medis', 'floor' => 'Lantai 2', 'type' => 'Rawat Inap'],
            ['code' => 'R-VK-01', 'name' => 'Ruang Bersalin (VK 01)', 'building' => 'Gedung B Medis', 'floor' => 'Lantai 1', 'type' => 'Rawat Inap'],
            ['code' => 'R-VK-02', 'name' => 'Ruang Bersalin (VK 02)', 'building' => 'Gedung B Medis', 'floor' => 'Lantai 1', 'type' => 'Rawat Inap'],
            ['code' => 'R-PERI-01', 'name' => 'Ruang Perinatologi / NICU', 'building' => 'Gedung B Medis', 'floor' => 'Lantai 1', 'type' => 'ICU'],
            ['code' => 'R-OK-01', 'name' => 'Kamar Operasi Bedah 01', 'building' => 'Gedung B Medis', 'floor' => 'Lantai 3', 'type' => 'Operasi'],
            ['code' => 'R-OK-02', 'name' => 'Kamar Operasi Bedah 02', 'building' => 'Gedung B Medis', 'floor' => 'Lantai 3', 'type' => 'Operasi'],
        ];

        $prices = [
            'VVIP' => 1500000,
            'VIP' => 1000000,
            'Kelas 1' => 600000,
            'Kelas 2' => 400000,
            'Kelas 3' => 200000,
        ];

        foreach ($roomsData as $rData) {
            $room = Room::firstOrCreate(['code' => $rData['code']], [
                'name' => $rData['name'],
                'building' => $rData['building'],
                'floor' => $rData['floor'],
                'room_type' => $rData['type'],
                'is_active' => true,
            ]);

            // Create 4 beds per room -> Total 80 beds
            $class = match ($room->room_type) {
                'VIP' => $room->code === 'R-VVIP-01' ? 'VVIP' : 'VIP',
                'ICU', 'Isolasi' => 'Kelas 1',
                default => str_contains($room->name, 'Kelas 2') ? 'Kelas 2' : (str_contains($room->name, 'Kelas 3') ? 'Kelas 3' : 'Kelas 1'),
            };

            for ($b = 1; $b <= 4; $b++) {
                Bed::firstOrCreate([
                    'room_id' => $room->id,
                    'bed_number' => 'BED-'.str_pad($b, 2, '0', STR_PAD_LEFT),
                ], [
                    'class' => $class,
                    'status' => Bed::STATUS_EMPTY,
                    'price_per_night' => $prices[$class] ?? 300000,
                ]);
            }
        }
    }
}
