<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            ['code' => 'SUP-001', 'name' => 'PT Kimia Farma Trading & Distribution', 'contact' => 'Bambang Sudirman', 'phone' => '021-3847711', 'email' => 'kftd@kimiafarma.co.id'],
            ['code' => 'SUP-002', 'name' => 'PT Kalbe Farma Tbk', 'contact' => 'Rina Wijaya', 'phone' => '021-42873888', 'email' => 'order@kalbe.co.id'],
            ['code' => 'SUP-003', 'name' => 'PT Dexa Medica Central', 'contact' => 'Agus Setiawan', 'phone' => '021-7454111', 'email' => 'sales@dexa-medica.com'],
            ['code' => 'SUP-004', 'name' => 'PT Sanbe Farma Bandung', 'contact' => 'Deden Kurnia', 'phone' => '022-6031234', 'email' => 'logistik@sanbe-farma.com'],
            ['code' => 'SUP-005', 'name' => 'PT Pharos Indonesia', 'contact' => 'Sri Wahyuni', 'phone' => '021-7201988', 'email' => 'distribution@pharos.co.id'],
            ['code' => 'SUP-006', 'name' => 'PT Bio Farma (Persero)', 'contact' => 'Indra Lesmana', 'phone' => '022-2033755', 'email' => 'vaccine@biofarma.co.id'],
            ['code' => 'SUP-007', 'name' => 'PT Tempo Scan Pacific Tbk', 'contact' => 'Maya Kartika', 'phone' => '021-29241000', 'email' => 'pharma@temposcan.com'],
            ['code' => 'SUP-008', 'name' => 'PT Interbat Pharma', 'contact' => 'Toni Haryanto', 'phone' => '021-58302211', 'email' => 'sales@interbat.co.id'],
            ['code' => 'SUP-009', 'name' => 'PT Combiphar Indonesia', 'contact' => 'Dian Sastro', 'phone' => '021-5705300', 'email' => 'contact@combiphar.com'],
            ['code' => 'SUP-010', 'name' => 'PT Bernofarm Pharmaceuticals', 'contact' => 'Ferry Sunarto', 'phone' => '031-8972100', 'email' => 'sales@bernofarm.com'],
            ['code' => 'SUP-011', 'name' => 'PT OneMed Healthcare Supplies', 'contact' => 'Kevin Sanjaya', 'phone' => '031-8412000', 'email' => 'info@onemed.co.id'],
            ['code' => 'SUP-012', 'name' => 'PT Medisafe Technologies Alkes', 'contact' => 'Lestari Suwarno', 'phone' => '021-89901234', 'email' => 'alkes@medisafe.co.id'],
            ['code' => 'SUP-013', 'name' => 'PT Otto Pharmaceutical Industries', 'contact' => 'Hasan Basri', 'phone' => '022-7798100', 'email' => 'order@ottopharm.com'],
            ['code' => 'SUP-014', 'name' => 'PT Lapi Laboratories', 'contact' => 'Syarifuddin', 'phone' => '021-58353344', 'email' => 'sales@lapilabs.com'],
            ['code' => 'SUP-015', 'name' => 'PT Novell Pharmaceutical Laboratories', 'contact' => 'Wahyudi Utomo', 'phone' => '021-53651188', 'email' => 'logistics@novellpharm.com'],
            ['code' => 'SUP-016', 'name' => 'PT Dankos Farma Indonesia', 'contact' => 'Ahmad Dahlan', 'phone' => '021-4600158', 'email' => 'sales@dankos.co.id'],
            ['code' => 'SUP-017', 'name' => 'PT Soho Global Health Tbk', 'contact' => 'Nurul Arifin', 'phone' => '021-4605555', 'email' => 'info@sohoglobalhealth.com'],
            ['code' => 'SUP-018', 'name' => 'PT Pyridam Farma Tbk', 'contact' => 'Eka Cipta', 'phone' => '021-53673322', 'email' => 'distribusi@pyridam.com'],
            ['code' => 'SUP-019', 'name' => 'PT Meiji Indonesian Pharmaceutical', 'contact' => 'Kenji Sato', 'phone' => '021-5703355', 'email' => 'sales@meiji.co.id'],
            ['code' => 'SUP-020', 'name' => 'PT Guardian Pharmatama', 'contact' => 'Andi Wijaya', 'phone' => '021-58300099', 'email' => 'info@guardianpharma.co.id'],
        ];

        foreach ($suppliers as $sup) {
            Supplier::firstOrCreate(['code' => $sup['code']], [
                'name' => $sup['name'],
                'contact_name' => $sup['contact'],
                'phone' => $sup['phone'],
                'email' => $sup['email'],
                'address' => 'Kawasan Industri Jakarta/Bandung/Surabaya Blok A No. '.rand(1, 100),
                'is_active' => true,
            ]);
        }
    }
}
