<?php

namespace App\Services;

use App\Models\Medicine;
use App\Models\MedicineCategory;
use App\Models\MedicineStock;
use App\Models\MedicineStockMovement;
use App\Models\Prescription;
use App\Models\Supplier;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PharmacyService
{
    /**
     * Mengambil ringkasan statistik Dashboard Farmasi & Inventori Obat.
     */
    public function getDashboardMetrics(): array
    {
        $today = now()->today();

        $totalMedicines = Medicine::count();
        $totalCategories = MedicineCategory::count();
        $totalSuppliers = Supplier::count();

        $prescriptionsToday = Prescription::whereDate('prescription_date', $today)->count();
        $waitingPrescriptions = Prescription::where('status', Prescription::STATUS_WAITING)->count();
        $completedPrescriptions = Prescription::where('status', Prescription::STATUS_COMPLETED)->count();

        $lowStockCount = MedicineStock::where('stock', '<=', 10)->count();
        $expiringCount = MedicineStock::whereDate('expired_date', '<=', now()->addDays(90))->count();

        return [
            'totalMedicines' => $totalMedicines,
            'totalCategories' => $totalCategories,
            'totalSuppliers' => $totalSuppliers,
            'prescriptionsToday' => $prescriptionsToday,
            'waitingPrescriptions' => $waitingPrescriptions,
            'completedPrescriptions' => $completedPrescriptions,
            'lowStockCount' => $lowStockCount,
            'expiringCount' => $expiringCount,
        ];
    }

    /**
     * Memvalidasi E-Resep Obat oleh Apoteker.
     */
    public function validatePrescription(Prescription $prescription, string $status = 'Diproses', ?string $notes = null): Prescription
    {
        $prescription->update([
            'status' => $status,
            'notes' => $notes ?? $prescription->notes,
            'updated_by' => Auth::id(),
        ]);

        return $prescription;
    }

    /**
     * Memproses Penyerahan Obat (Dispensing) & pengurangan stok otomatis secara atomik.
     *
     * @throws Exception
     */
    public function dispensePrescription(Prescription $prescription): Prescription
    {
        return DB::transaction(function () use ($prescription) {
            $prescription->load(['items.medicine']);

            foreach ($prescription->items as $item) {
                // Lock row fisik stok obat
                $stockRecord = MedicineStock::lockForUpdate()
                    ->where('medicine_id', $item->medicine_id)
                    ->where('stock', '>=', $item->quantity)
                    ->first();

                if (! $stockRecord) {
                    $medName = $item->medicine->name ?? 'Obat';
                    throw new Exception("Stok fisik obat {$medName} tidak mencukupi untuk jumlah resep (Dibutuhkan: {$item->quantity}).");
                }

                // 1. Kurangi stok fisik obat
                $stockRecord->decrement('stock', $item->quantity);

                // 2. Buat Kartu Mutasi Stok Obat (Keluar - Dispensing)
                MedicineStockMovement::create([
                    'medicine_stock_id' => $stockRecord->id,
                    'type' => MedicineStockMovement::TYPE_OUT,
                    'quantity' => $item->quantity,
                    'reference_number' => $prescription->prescription_number,
                    'notes' => 'Dispensing E-Resep Pasien '.($prescription->patient->name ?? ''),
                    'created_by' => Auth::id(),
                ]);
            }

            // 3. Perbarui Status Resep menjadi Selesai
            $prescription->update([
                'status' => Prescription::STATUS_COMPLETED,
                'updated_by' => Auth::id(),
            ]);

            return $prescription;
        });
    }

    /**
     * Melakukan penyesuaian (opname) stok obat secara manual.
     */
    public function adjustStock(int $stockId, int $newStock, string $notes = 'Penyesuaian Stok Apoteker'): MedicineStock
    {
        return DB::transaction(function () use ($stockId, $newStock, $notes) {
            $stockRecord = MedicineStock::lockForUpdate()->findOrFail($stockId);
            $diff = $newStock - $stockRecord->stock;

            $stockRecord->update([
                'stock' => $newStock,
                'updated_by' => Auth::id(),
            ]);

            MedicineStockMovement::create([
                'medicine_stock_id' => $stockRecord->id,
                'type' => MedicineStockMovement::TYPE_ADJUSTMENT,
                'quantity' => abs($diff),
                'reference_number' => 'ADJ-'.date('YmdHis'),
                'notes' => $notes.' (Perubahan: '.($diff >= 0 ? "+{$diff}" : "{$diff}").')',
                'created_by' => Auth::id(),
            ]);

            return $stockRecord;
        });
    }
}
