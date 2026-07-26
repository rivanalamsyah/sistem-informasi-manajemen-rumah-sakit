<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['group' => 'general', 'key' => 'hospital_name', 'value' => 'RSU Rajawali Citra', 'type' => 'string', 'desc' => 'Nama Resmi Rumah Sakit'],
            ['group' => 'general', 'key' => 'hospital_code', 'value' => '3402034', 'type' => 'string', 'desc' => 'Kode Registrasi Kemenkes RS'],
            ['group' => 'general', 'key' => 'hospital_address', 'value' => 'Jl. Pleret No.KM 2.5, Banjardadap, Potorono, Kec. Banguntapan, Kabupaten Bantul, Daerah Istimewa Yogyakarta 55196', 'type' => 'string', 'desc' => 'Alamat Domisili RS'],
            ['group' => 'general', 'key' => 'hospital_phone', 'value' => '0821-3431-3535', 'type' => 'string', 'desc' => 'Telepon Call Center RS'],
            ['group' => 'general', 'key' => 'hospital_email', 'value' => 'info@rsurajawalicitra.co.id', 'type' => 'string', 'desc' => 'Email Layanan Pelanggan'],
            ['group' => 'print', 'key' => 'receipt_footer', 'value' => 'Terima Kasih Atas Kepercayaan Anda Berobat di RSU Rajawali Citra. Semoga Lekas Sembuh.', 'type' => 'string', 'desc' => 'Footer Cetak Kuitansi'],
            ['group' => 'display', 'key' => 'running_text', 'value' => 'Selamat Datang di RSU Rajawali Citra. Budayakan Antre dengan Tertib. Utamakan Keselamatan & Kesehatan Anda.', 'type' => 'string', 'desc' => 'Running Text Public Display'],
        ];

        foreach ($settings as $st) {
            Setting::firstOrCreate(['key' => $st['key']], [
                'group' => $st['group'],
                'value' => $st['value'],
                'type' => $st['type'],
                'description' => $st['desc'],
            ]);
        }
    }
}
