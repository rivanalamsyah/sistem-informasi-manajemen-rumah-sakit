<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'Super Admin' => 'Akses penuh ke seluruh konfigurasi & data SIMRS',
            'Admin' => 'Manajemen master data, akun pegawai, & laporan',
            'Dokter' => 'Pelayanan medis, EMR, resep obat, & order lab',
            'Perawat' => 'Anamnesis TTV, asuhan keperawatan, & monitoring bed',
            'Apoteker' => 'Verifikasi resep, dispensing obat, & stok farmasi',
            'Petugas Laboratorium' => 'Input & validasi hasil pemeriksaan laboratorium',
            'Petugas Pendaftaran' => 'Registrasi pasien baru/lama & booking antrean',
            'Kasir' => 'Konsolidasi tagihan billing & penerimaan pembayaran',
            'Pasien' => 'Akses portal pasien mandiri & reservasi online',
        ];

        foreach ($roles as $name => $description) {
            Role::firstOrCreate(['name' => $name], [
                'guard_name' => 'web',
                'description' => $description,
            ]);
        }

        $permissions = [
            'manage-users' => 'Manajemen Akun Pengguna',
            'manage-master-data' => 'Manajemen Master Data',
            'manage-warehouse' => 'Manajemen Gudang & Logistik',
            'manage-settings' => 'Pengaturan Sistem & Backup',
            'view-dashboard' => 'Melihat Dashboard & Statistik',
            'manage-registrations' => 'Pendaftaran Pasien',
            'manage-polyclinic' => 'Pelayanan Poliklinik Rawat Jalan',
            'manage-inpatient' => 'Pelayanan Rawat Inap & Bed',
            'manage-medical-records' => 'Pengelolaan Rekam Medis (EMR)',
            'manage-pharmacy' => 'Pelayanan Farmasi & Obat',
            'manage-laboratory' => 'Pelayanan Laboratorium',
            'manage-cashier' => 'Transaksi Kasir & Billing',
            'view-reports' => 'Melihat & Export Laporan',
        ];

        foreach ($permissions as $name => $group) {
            Permission::firstOrCreate(['name' => $name], [
                'guard_name' => 'web',
                'group' => $group,
            ]);
        }

        // Map Permissions to Roles
        $rolePermissionMap = [
            'Super Admin' => array_keys($permissions),
            'Admin' => ['view-dashboard', 'manage-users', 'manage-master-data', 'manage-warehouse', 'view-reports'],
            'Dokter' => ['view-dashboard', 'manage-polyclinic', 'manage-medical-records'],
            'Perawat' => ['view-dashboard', 'manage-polyclinic', 'manage-inpatient'],
            'Apoteker' => ['view-dashboard', 'manage-pharmacy'],
            'Petugas Laboratorium' => ['view-dashboard', 'manage-laboratory'],
            'Petugas Pendaftaran' => ['view-dashboard', 'manage-registrations'],
            'Kasir' => ['view-dashboard', 'manage-cashier'],
            'Pasien' => ['view-dashboard'],
        ];

        foreach ($rolePermissionMap as $roleName => $permNames) {
            $role = Role::where('name', $roleName)->first();
            if ($role) {
                $permissionIds = Permission::whereIn('name', $permNames)->pluck('id');
                $role->permissions()->sync($permissionIds);
            }
        }
    }
}
