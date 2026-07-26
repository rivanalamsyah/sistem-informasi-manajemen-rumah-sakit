<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\Supplier;
use App\Models\User;
use App\Models\Warehouse;
use App\Models\WarehouseItem;
use App\Models\WarehouseLocation;
use App\Models\WarehouseStock;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WarehouseAndSettingsSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. DEFAULT WAREHOUSES & LOCATIONS ───────────────────────────────
        $mainWarehouse = Warehouse::firstOrCreate(
            ['code' => 'GUD-01'],
            [
                'name' => 'Gudang Logistik & Farmasi Pusat',
                'type' => 'Gudang Utama',
                'location_description' => 'Gedung Medik Lantai 1',
                'is_active' => true,
            ]
        );

        $depoFarmasi = Warehouse::firstOrCreate(
            ['code' => 'DEP-FAR-01'],
            [
                'name' => 'Depo Farmasi Rawat Jalan',
                'type' => 'Depo Farmasi',
                'location_description' => 'Gedung Poliklinik Lantai 1',
                'is_active' => true,
            ]
        );

        $gudangAlkes = Warehouse::firstOrCreate(
            ['code' => 'GUD-ALK-01'],
            [
                'name' => 'Gudang Alat Kesehatan & BMHP',
                'type' => 'Gudang Alkes',
                'location_description' => 'Gedung Penunjang Lantai 2',
                'is_active' => true,
            ]
        );

        // Lokasi Rak
        WarehouseLocation::firstOrCreate(
            ['warehouse_id' => $mainWarehouse->id, 'code' => 'RAK-A1'],
            ['name' => 'Rak Obat Keras A1', 'rack_number' => 'A-01', 'description' => 'Lapis 1-3']
        );
        WarehouseLocation::firstOrCreate(
            ['warehouse_id' => $mainWarehouse->id, 'code' => 'RAK-B1'],
            ['name' => 'Rak Obat Bebas B1', 'rack_number' => 'B-01', 'description' => 'Lapis 1-4']
        );
        WarehouseLocation::firstOrCreate(
            ['warehouse_id' => $gudangAlkes->id, 'code' => 'RAK-ALK-1'],
            ['name' => 'Rak BMHP Spuit & Infus', 'rack_number' => 'ALK-01', 'description' => 'Lapis 1-5']
        );

        // ── 2. WAREHOUSE ITEMS ──────────────────────────────────────────────
        $supplier = Supplier::first();
        $supplierId = $supplier?->id;

        $items = [
            [
                'code' => 'BRG-001',
                'barcode' => '899123456701',
                'name' => 'Spuit 3cc Dispo Syringe (Box @ 100 pcs)',
                'category' => 'Alat Kesehatan / BMHP',
                'unit' => 'Box',
                'min_stock' => 10,
                'max_stock' => 200,
                'purchase_price' => 75000,
                'sell_price' => 95000,
                'stock' => 50,
            ],
            [
                'code' => 'BRG-002',
                'barcode' => '899123456702',
                'name' => 'Infus Set Dewasa Steril (Pcs)',
                'category' => 'Alat Kesehatan / BMHP',
                'unit' => 'Pcs',
                'min_stock' => 50,
                'max_stock' => 1000,
                'purchase_price' => 12500,
                'sell_price' => 18000,
                'stock' => 300,
            ],
            [
                'code' => 'BRG-003',
                'barcode' => '899123456703',
                'name' => 'Kasa Steril 16x16cm Husada (Box)',
                'category' => 'Bahan Medis Habis Pakai',
                'unit' => 'Box',
                'min_stock' => 20,
                'max_stock' => 300,
                'purchase_price' => 32000,
                'sell_price' => 45000,
                'stock' => 80,
            ],
            [
                'code' => 'BRG-004',
                'barcode' => '899123456704',
                'name' => 'Handscoon Latex Steril Size M (Box @ 50 pasang)',
                'category' => 'Alat Perlindungan Diri',
                'unit' => 'Box',
                'min_stock' => 15,
                'max_stock' => 250,
                'purchase_price' => 85000,
                'sell_price' => 110000,
                'stock' => 120,
            ],
            [
                'code' => 'BRG-005',
                'barcode' => '899123456705',
                'name' => 'Alkohol 70% 1 Liter Onemed (Botol)',
                'category' => 'Desinfektan & Antiseptik',
                'unit' => 'Botol',
                'min_stock' => 30,
                'max_stock' => 500,
                'purchase_price' => 38000,
                'sell_price' => 52000,
                'stock' => 5, // Status Hampir Habis!
            ],
            [
                'code' => 'BRG-006',
                'barcode' => '899123456706',
                'name' => 'Masker Bedah 3 Ply Earloop (Box @ 50 pcs)',
                'category' => 'Alat Perlindungan Diri',
                'unit' => 'Box',
                'min_stock' => 40,
                'max_stock' => 600,
                'purchase_price' => 28000,
                'sell_price' => 38000,
                'stock' => 0, // Status Habis!
            ],
        ];

        foreach ($items as $it) {
            $item = WarehouseItem::firstOrCreate(
                ['code' => $it['code']],
                [
                    'barcode' => $it['barcode'],
                    'name' => $it['name'],
                    'category' => $it['category'],
                    'supplier_id' => $supplierId,
                    'unit' => $it['unit'],
                    'min_stock' => $it['min_stock'],
                    'max_stock' => $it['max_stock'],
                    'purchase_price' => $it['purchase_price'],
                    'sell_price' => $it['sell_price'],
                    'is_active' => true,
                ]
            );

            if ($it['stock'] > 0) {
                WarehouseStock::firstOrCreate(
                    [
                        'warehouse_id' => $mainWarehouse->id,
                        'warehouse_item_id' => $item->id,
                        'batch_number' => 'BATCH-2026-01',
                    ],
                    [
                        'expired_date' => now()->addMonths(18)->toDateString(),
                        'stock' => $it['stock'],
                    ]
                );
            }
        }

        // ── 3. EXPANDED SETTINGS SEEDER ─────────────────────────────────────
        $defaultSettings = [
            // General & Hospital Profile
            ['group' => 'general', 'key' => 'hospital_name', 'value' => 'RSU Rajawali Citra', 'type' => 'string', 'desc' => 'Nama Resmi Rumah Sakit'],
            ['group' => 'general', 'key' => 'hospital_code', 'value' => '3402034', 'type' => 'string', 'desc' => 'Kode Registrasi Kemenkes RS'],
            ['group' => 'general', 'key' => 'hospital_address', 'value' => 'Jl. Pleret No.KM 2.5, Banjardadap, Potorono, Kec. Banguntapan, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55196', 'type' => 'string', 'desc' => 'Alamat Domisili RS'],
            ['group' => 'general', 'key' => 'hospital_phone', 'value' => '0821-3431-3535', 'type' => 'string', 'desc' => 'Telepon Call Center RS'],
            ['group' => 'general', 'key' => 'hospital_email', 'value' => 'info@rsurajawalicitra.co.id', 'type' => 'string', 'desc' => 'Email Layanan Pelanggan'],
            ['group' => 'general', 'key' => 'hospital_website', 'value' => 'https://rsurajawalicitra.co.id', 'type' => 'string', 'desc' => 'Situs Web Resmi'],
            ['group' => 'general', 'key' => 'director_name', 'value' => 'dr. H. Ahmad Fauzi, Sp.OG, MARS', 'type' => 'string', 'desc' => 'Nama Direktur RS'],
            ['group' => 'general', 'key' => 'npwp', 'value' => '01.234.567.8-012.000', 'type' => 'string', 'desc' => 'NPWP Badan RS'],
            ['group' => 'general', 'key' => 'operating_hours', 'value' => 'Open 24 hours (Buka 24 Jam)', 'type' => 'string', 'desc' => 'Jam Operasional RS'],

            // Branding
            ['group' => 'branding', 'key' => 'primary_color', 'value' => '#0d9488', 'type' => 'string', 'desc' => 'Warna Utama (Teal 600)'],
            ['group' => 'branding', 'key' => 'secondary_color', 'value' => '#0f172a', 'type' => 'string', 'desc' => 'Warna Sekunder (Slate 900)'],

            // Document Numbering Configuration
            ['group' => 'numbering', 'key' => 'rm_prefix', 'value' => 'RM', 'type' => 'string', 'desc' => 'Prefix Nomor Rekam Medis'],
            ['group' => 'numbering', 'key' => 'reg_prefix', 'value' => 'REG', 'type' => 'string', 'desc' => 'Prefix Nomor Pendaftaran'],
            ['group' => 'numbering', 'key' => 'billing_prefix', 'value' => 'BIL', 'type' => 'string', 'desc' => 'Prefix Nomor Billing'],
            ['group' => 'numbering', 'key' => 'invoice_prefix', 'value' => 'INV', 'type' => 'string', 'desc' => 'Prefix Nomor Invoice'],
            ['group' => 'numbering', 'key' => 'prescription_prefix', 'value' => 'RX', 'type' => 'string', 'desc' => 'Prefix Nomor Resep'],
            ['group' => 'numbering', 'key' => 'lab_prefix', 'value' => 'LAB', 'type' => 'string', 'desc' => 'Prefix Nomor Order Lab'],
            ['group' => 'numbering', 'key' => 'inpatient_prefix', 'value' => 'RANAP', 'type' => 'string', 'desc' => 'Prefix Nomor Rawat Inap'],
            ['group' => 'numbering', 'key' => 'reset_frequency', 'value' => 'yearly', 'type' => 'string', 'desc' => 'Frekuensi Reset Running Number (yearly/monthly/never)'],

            // Email SMTP
            ['group' => 'email', 'key' => 'smtp_host', 'value' => 'smtp.gmail.com', 'type' => 'string', 'desc' => 'SMTP Host Email'],
            ['group' => 'email', 'key' => 'smtp_port', 'value' => '587', 'type' => 'string', 'desc' => 'SMTP Port'],
            ['group' => 'email', 'key' => 'smtp_username', 'value' => 'noreply@rsurajawalicitra.co.id', 'type' => 'string', 'desc' => 'SMTP Username'],
            ['group' => 'email', 'key' => 'smtp_password', 'value' => 'secret_app_password', 'type' => 'string', 'desc' => 'SMTP Password'],
            ['group' => 'email', 'key' => 'smtp_encryption', 'value' => 'tls', 'type' => 'string', 'desc' => 'Enkripsi SMTP'],
            ['group' => 'email', 'key' => 'from_name', 'value' => 'RSU Rajawali Citra', 'type' => 'string', 'desc' => 'Nama Pengirim Email'],
            ['group' => 'email', 'key' => 'from_address', 'value' => 'noreply@rsurajawalicitra.co.id', 'type' => 'string', 'desc' => 'Alamat Pengirim Email'],

            // Notifications
            ['group' => 'notification', 'key' => 'notif_email_enabled', 'value' => '1', 'type' => 'boolean', 'desc' => 'Aktifkan Notifikasi Email'],
            ['group' => 'notification', 'key' => 'notif_system_enabled', 'value' => '1', 'type' => 'boolean', 'desc' => 'Aktifkan Notifikasi Sistem'],
            ['group' => 'notification', 'key' => 'notif_min_stock_alert', 'value' => '10', 'type' => 'integer', 'desc' => 'Ambang Peringatan Stok Minimum'],
            ['group' => 'notification', 'key' => 'notif_expiry_days_alert', 'value' => '90', 'type' => 'integer', 'desc' => 'Peringatan Kedaluwarsa (Hari)'],

            // Application & Security
            ['group' => 'system', 'key' => 'timezone', 'value' => 'Asia/Jakarta', 'type' => 'string', 'desc' => 'Zona Waktu Sistem'],
            ['group' => 'system', 'key' => 'locale', 'value' => 'id', 'type' => 'string', 'desc' => 'Bahasa Utama'],
            ['group' => 'system', 'key' => 'currency', 'value' => 'IDR', 'type' => 'string', 'desc' => 'Mata Uang'],
            ['group' => 'system', 'key' => 'per_page', 'value' => '15', 'type' => 'integer', 'desc' => 'Jumlah Data per Halaman'],
            ['group' => 'security', 'key' => 'session_timeout', 'value' => '120', 'type' => 'integer', 'desc' => 'Session Timeout (Menit)'],
            ['group' => 'security', 'key' => 'password_min_length', 'value' => '8', 'type' => 'integer', 'desc' => 'Panjang Minimal Password'],
            ['group' => 'security', 'key' => 'max_login_attempts', 'value' => '5', 'type' => 'integer', 'desc' => 'Batas Maksimal Gagal Login'],
            ['group' => 'security', 'key' => 'two_factor_enabled', 'value' => '0', 'type' => 'boolean', 'desc' => 'Status Arsitektur 2FA'],
        ];

        foreach ($defaultSettings as $st) {
            Setting::updateOrCreate(
                ['key' => $st['key']],
                [
                    'group' => $st['group'],
                    'value' => $st['value'],
                    'type' => $st['type'],
                    'description' => $st['desc'],
                ]
            );
        }
    }
}
