<?php

namespace Database\Seeders;

use App\Models\Medicine;
use App\Models\MedicineCategory;
use App\Models\MedicineStock;
use App\Models\MedicineStockMovement;
use Illuminate\Database\Seeder;

class MedicineSeeder extends Seeder
{
    public function run(): void
    {
        $baseMedicines = [
            ['name' => 'Paracetamol 500mg', 'generic' => 'Paracetamol', 'cat' => 'Analgesik & Antipiretik', 'unit' => 'Tablet', 'type' => 'Bebas', 'buy' => 250, 'sell' => 500],
            ['name' => 'Amoxicillin 500mg', 'generic' => 'Amoxicillin Trihydrate', 'cat' => 'Antibiotik & Antimikroba', 'unit' => 'Kaplet', 'type' => 'Keras', 'buy' => 600, 'sell' => 1200],
            ['name' => 'Cefadroxil 500mg', 'generic' => 'Cefadroxil Monohydrate', 'cat' => 'Antibiotik & Antimikroba', 'unit' => 'Kapsul', 'type' => 'Keras', 'buy' => 1500, 'sell' => 3000],
            ['name' => 'Omeprazole 20mg', 'generic' => 'Omeprazole Sodium', 'cat' => 'Obat Saluran Cerna', 'unit' => 'Kapsul', 'type' => 'Keras', 'buy' => 800, 'sell' => 1800],
            ['name' => 'Metformin 500mg', 'generic' => 'Metformin HCl', 'cat' => 'Obat Diabetes & Endokrin', 'unit' => 'Tablet', 'type' => 'Keras', 'buy' => 300, 'sell' => 700],
            ['name' => 'Amlodipine 5mg', 'generic' => 'Amlodipine Besylate', 'cat' => 'Obat Kardiovaskular', 'unit' => 'Tablet', 'type' => 'Keras', 'buy' => 400, 'sell' => 900],
            ['name' => 'Amlodipine 10mg', 'generic' => 'Amlodipine Besylate', 'cat' => 'Obat Kardiovaskular', 'unit' => 'Tablet', 'type' => 'Keras', 'buy' => 600, 'sell' => 1300],
            ['name' => 'Ibuprofen 400mg', 'generic' => 'Ibuprofen', 'cat' => 'Analgesik & Antipiretik', 'unit' => 'Tablet', 'type' => 'Bebas Terbatas', 'buy' => 450, 'sell' => 1000],
            ['name' => 'Cetirizine 10mg', 'generic' => 'Cetirizine HCl', 'cat' => 'Antihistamin & Alergi', 'unit' => 'Tablet', 'type' => 'Bebas Terbatas', 'buy' => 350, 'sell' => 800],
            ['name' => 'Salbutamol Inhaler 100mcg', 'generic' => 'Salbutamol Sulfate', 'cat' => 'Obat Pernapasan', 'unit' => 'Botol', 'type' => 'Keras', 'buy' => 45000, 'sell' => 75000],
            ['name' => 'Vitamin C 500mg (Sweetlets)', 'generic' => 'Ascorbic Acid', 'cat' => 'Vitamin & Suplemen', 'unit' => 'Tablet', 'type' => 'Bebas', 'buy' => 200, 'sell' => 500],
            ['name' => 'Vitamin D3 1000 IU', 'generic' => 'Cholecalciferol', 'cat' => 'Vitamin & Suplemen', 'unit' => 'Kapsul', 'type' => 'Bebas', 'buy' => 1200, 'sell' => 2500],
            ['name' => 'Cairan Infus Ringer Laktat (RL) 500ml', 'generic' => 'Ringer Lactate', 'cat' => 'Alat Kesehatan & BMHP', 'unit' => 'Botol', 'type' => 'Keras', 'buy' => 14000, 'sell' => 25000],
            ['name' => 'Cairan Infus NaCl 0.9% 500ml', 'generic' => 'Sodium Chloride', 'cat' => 'Alat Kesehatan & BMHP', 'unit' => 'Botol', 'type' => 'Keras', 'buy' => 13000, 'sell' => 24000],
            ['name' => 'Spuit 3cc / 3ml Terumo', 'generic' => 'Disposable Syringe', 'cat' => 'Alat Kesehatan & BMHP', 'unit' => 'Pcs', 'type' => 'Alkes', 'buy' => 2500, 'sell' => 5000],
            ['name' => 'Spuit 5cc / 5ml Terumo', 'generic' => 'Disposable Syringe', 'cat' => 'Alat Kesehatan & BMHP', 'unit' => 'Pcs', 'type' => 'Alkes', 'buy' => 3000, 'sell' => 6000],
            ['name' => 'Kasa Steril Husada 16x16cm', 'generic' => 'Sterile Gauze', 'cat' => 'Alat Kesehatan & BMHP', 'unit' => 'Pcs', 'type' => 'Alkes', 'buy' => 4000, 'sell' => 8000],
            ['name' => 'Alkohol 70% Onemed 100ml', 'generic' => 'Ethanol 70%', 'cat' => 'Alat Kesehatan & BMHP', 'unit' => 'Botol', 'type' => 'Bebas', 'buy' => 6000, 'sell' => 12000],
            ['name' => 'Antasida Doen Tablet', 'generic' => 'Aluminum & Magnesium Hydroxide', 'cat' => 'Obat Saluran Cerna', 'unit' => 'Tablet', 'type' => 'Bebas', 'buy' => 150, 'sell' => 400],
            ['name' => 'Loperamide 2mg', 'generic' => 'Loperamide HCl', 'cat' => 'Obat Saluran Cerna', 'unit' => 'Tablet', 'type' => 'Bebas Terbatas', 'buy' => 300, 'sell' => 700],
        ];

        $categories = MedicineCategory::all()->pluck('id', 'name');

        // Generate 200 items by variations
        $totalItems = 200;
        $createdCount = 0;

        for ($i = 1; $i <= $totalItems; $i++) {
            $base = $baseMedicines[($i - 1) % count($baseMedicines)];
            $code = 'OBT-'.str_pad($i, 4, '0', STR_PAD_LEFT);
            $suffix = $i > count($baseMedicines) ? ' (Batch Var '.ceil($i / count($baseMedicines)).')' : '';
            $catId = $categories[$base['cat']] ?? 1;

            $med = Medicine::firstOrCreate(['code' => $code], [
                'name' => $base['name'].$suffix,
                'generic_name' => $base['generic'],
                'category_id' => $catId,
                'unit' => $base['unit'],
                'type' => $base['type'],
                'min_stock' => rand(15, 50),
                'purchase_price' => $base['buy'],
                'selling_price' => $base['sell'],
                'is_active' => true,
            ]);

            // Create Stock Gudang & Depo Farmasi for each medicine
            $gudangStock = rand(100, 1000);
            $depoStock = rand(30, 200);

            $stokGudang = MedicineStock::firstOrCreate([
                'medicine_id' => $med->id,
                'location' => MedicineStock::LOCATION_GUDANG,
                'batch_number' => 'BTC-2026-'.str_pad($i, 4, '0', STR_PAD_LEFT),
            ], [
                'expired_date' => now()->addMonths(rand(6, 36))->toDateString(),
                'stock' => $gudangStock,
            ]);

            MedicineStockMovement::create([
                'medicine_stock_id' => $stokGudang->id,
                'type' => MedicineStockMovement::TYPE_IN,
                'quantity' => $gudangStock,
                'reference_number' => 'FAK-SUP-2026-'.rand(100, 999),
                'notes' => 'Penerimaan Stok Gudang Utama dari Supplier',
            ]);

            $stokDepo = MedicineStock::firstOrCreate([
                'medicine_id' => $med->id,
                'location' => MedicineStock::LOCATION_DEPO,
                'batch_number' => 'BTC-2026-'.str_pad($i, 4, '0', STR_PAD_LEFT),
            ], [
                'expired_date' => now()->addMonths(rand(6, 36))->toDateString(),
                'stock' => $depoStock,
            ]);

            MedicineStockMovement::create([
                'medicine_stock_id' => $stokDepo->id,
                'type' => MedicineStockMovement::TYPE_MUTATION,
                'quantity' => $depoStock,
                'reference_number' => 'MUT-DEPO-2026-'.rand(100, 999),
                'notes' => 'Mutasi Stok dari Gudang Utama ke Depo Farmasi',
            ]);
        }
    }
}
