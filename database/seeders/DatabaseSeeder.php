<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleAndPermissionSeeder::class,
            UserSeeder::class,
            DepartmentSeeder::class,
            DoctorSeeder::class,
            RoomAndBedSeeder::class,
            ServiceAndTariffSeeder::class,
            SupplierSeeder::class,
            MedicineCategorySeeder::class,
            MedicineSeeder::class,
            LaboratoryTestSeeder::class,
            PatientSeeder::class,
            RegistrationAndQueueSeeder::class,
            OutpatientVisitSeeder::class,
            InpatientVisitSeeder::class,
            MedicalRecordSeeder::class,
            PrescriptionSeeder::class,
            LaboratoryOrderSeeder::class,
            InvoiceAndPaymentSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
