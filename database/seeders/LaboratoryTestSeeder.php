<?php

namespace Database\Seeders;

use App\Models\LaboratoryTest;
use Illuminate\Database\Seeder;

class LaboratoryTestSeeder extends Seeder
{
    public function run(): void
    {
        $labTests = [
            ['code' => 'LAB-001', 'name' => 'Darah Lengkap / Rutin (CBC)', 'cat' => 'Hematologi', 'unit' => 'Cell/uL', 'male' => 'Normal', 'female' => 'Normal', 'price' => 95000],
            ['code' => 'LAB-002', 'name' => 'Hemoglobin (Hb)', 'cat' => 'Hematologi', 'unit' => 'g/dL', 'male' => '13.5 - 17.5', 'female' => '12.0 - 15.5', 'price' => 35000],
            ['code' => 'LAB-003', 'name' => 'Leukosit (WBC)', 'cat' => 'Hematologi', 'unit' => '10^3/uL', 'male' => '4.5 - 11.0', 'female' => '4.5 - 11.0', 'price' => 35000],
            ['code' => 'LAB-004', 'name' => 'Trombosit (PLT)', 'cat' => 'Hematologi', 'unit' => '10^3/uL', 'male' => '150 - 450', 'female' => '150 - 450', 'price' => 35000],
            ['code' => 'LAB-005', 'name' => 'Hematokrit (Ht)', 'cat' => 'Hematologi', 'unit' => '%', 'male' => '41 - 50', 'female' => '36 - 48', 'price' => 35000],
            ['code' => 'LAB-006', 'name' => 'Laju Endap Darah (LED)', 'cat' => 'Hematologi', 'unit' => 'mm/jam', 'male' => '0 - 15', 'female' => '0 - 20', 'price' => 40000],
            ['code' => 'LAB-007', 'name' => 'Gula Darah Sewaktu (GDS)', 'cat' => 'Kimia Darah', 'unit' => 'mg/dL', 'male' => '< 140', 'female' => '< 140', 'price' => 35000],
            ['code' => 'LAB-008', 'name' => 'Gula Darah Puasa (GDP)', 'cat' => 'Kimia Darah', 'unit' => 'mg/dL', 'male' => '70 - 100', 'female' => '70 - 100', 'price' => 40000],
            ['code' => 'LAB-009', 'name' => 'HbA1c (Diabetes Index)', 'cat' => 'Kimia Darah', 'unit' => '%', 'male' => '< 5.7', 'female' => '< 5.7', 'price' => 180000],
            ['code' => 'LAB-010', 'name' => 'Kolesterol Total', 'cat' => 'Profil Lipid', 'unit' => 'mg/dL', 'male' => '< 200', 'female' => '< 200', 'price' => 45000],
            ['code' => 'LAB-011', 'name' => 'Trigliserida', 'cat' => 'Profil Lipid', 'unit' => 'mg/dL', 'male' => '< 150', 'female' => '< 150', 'price' => 50000],
            ['code' => 'LAB-012', 'name' => 'Kolesterol HDL', 'cat' => 'Profil Lipid', 'unit' => 'mg/dL', 'male' => '> 40', 'female' => '> 50', 'price' => 55000],
            ['code' => 'LAB-013', 'name' => 'Kolesterol LDL', 'cat' => 'Profil Lipid', 'unit' => 'mg/dL', 'male' => '< 100', 'female' => '< 100', 'price' => 60000],
            ['code' => 'LAB-014', 'name' => 'Asam Urat (Uric Acid)', 'cat' => 'Kimia Darah', 'unit' => 'mg/dL', 'male' => '3.4 - 7.0', 'female' => '2.4 - 6.0', 'price' => 45000],
            ['code' => 'LAB-015', 'name' => 'Ureum (BUN)', 'cat' => 'Fungsi Ginjal', 'unit' => 'mg/dL', 'male' => '10 - 50', 'female' => '10 - 50', 'price' => 50000],
            ['code' => 'LAB-016', 'name' => 'Kreatinin Darah', 'cat' => 'Fungsi Ginjal', 'unit' => 'mg/dL', 'male' => '0.7 - 1.3', 'female' => '0.6 - 1.1', 'price' => 50000],
            ['code' => 'LAB-017', 'name' => 'SGOT / AST (Fungsi Hati)', 'cat' => 'Fungsi Hati', 'unit' => 'U/L', 'male' => '< 35', 'female' => '< 31', 'price' => 50000],
            ['code' => 'LAB-018', 'name' => 'SGPT / ALT (Fungsi Hati)', 'cat' => 'Fungsi Hati', 'unit' => 'U/L', 'male' => '< 45', 'female' => '< 34', 'price' => 50000],
            ['code' => 'LAB-019', 'name' => 'Widal (Demam Tifoid)', 'cat' => 'Serologi', 'unit' => 'Titer', 'male' => 'Negatif', 'female' => 'Negatif', 'price' => 85000],
            ['code' => 'LAB-020', 'name' => 'Urinalisis Rutin Lengkap', 'cat' => 'Urine', 'unit' => 'Kuantitatif', 'male' => 'Normal', 'female' => 'Normal', 'price' => 60000],
            ['code' => 'LAB-021', 'name' => 'Tes Kehamilan (PP Test)', 'cat' => 'Urine', 'unit' => 'Kualitatif', 'male' => '-', 'female' => 'Negatif', 'price' => 35000],
            ['code' => 'LAB-022', 'name' => 'HBsAg Rapid Test (Hepatitis B)', 'cat' => 'Serologi', 'unit' => 'Kualitatif', 'male' => 'Non-Reaktif', 'female' => 'Non-Reaktif', 'price' => 90000],
            ['code' => 'LAB-023', 'name' => 'Anti-HIV Screening', 'cat' => 'Serologi', 'unit' => 'Kualitatif', 'male' => 'Non-Reaktif', 'female' => 'Non-Reaktif', 'price' => 120000],
            ['code' => 'LAB-024', 'name' => 'Swab Antigen SARS-CoV-2', 'cat' => 'Mikrobiologi', 'unit' => 'Kualitatif', 'male' => 'Negatif', 'female' => 'Negatif', 'price' => 85000],
            ['code' => 'LAB-025', 'name' => 'Tes Narkoba 6 Parameter', 'cat' => 'Toksikologi', 'unit' => 'Kualitatif', 'male' => 'Negatif', 'female' => 'Negatif', 'price' => 175000],
        ];

        foreach ($labTests as $lt) {
            LaboratoryTest::firstOrCreate(['code' => $lt['code']], [
                'name' => $lt['name'],
                'category' => $lt['cat'],
                'unit' => $lt['unit'],
                'reference_range_male' => $lt['male'],
                'reference_range_female' => $lt['female'],
                'price' => $lt['price'],
                'is_active' => true,
            ]);
        }
    }
}
