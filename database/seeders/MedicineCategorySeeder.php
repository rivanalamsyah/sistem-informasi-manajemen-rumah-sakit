<?php

namespace Database\Seeders;

use App\Models\MedicineCategory;
use Illuminate\Database\Seeder;

class MedicineCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Analgesik & Antipiretik' => 'Obat pereda nyeri dan penurun demam',
            'Antibiotik & Antimikroba' => 'Obat infeksi bakteri dan antimikroba',
            'Antihistamin & Alergi' => 'Obat pereda gejala alergi dan gatal',
            'Vitamin & Suplemen' => 'Vitamin suplemen penunjang daya tahan tubuh',
            'Obat Saluran Cerna' => 'Obat maag, asam lambung, diare, & mual',
            'Obat Kardiovaskular' => 'Obat antihipertensi, jantung, & pembuluh darah',
            'Obat Pernapasan' => 'Obat asma, bronkodilator, & batuk ekspektoran',
            'Obat Diabetes & Endokrin' => 'Obat penurun gula darah & hormon',
            'Saraf & Analgesik Keras' => 'Obat nyeri saraf, sedatif, & relaksan otot',
            'Alat Kesehatan & BMHP' => 'Bahan medis habis pakai, spuit, infus, & perban',
        ];

        foreach ($categories as $name => $desc) {
            MedicineCategory::firstOrCreate(['name' => $name], [
                'description' => $desc,
            ]);
        }
    }
}
