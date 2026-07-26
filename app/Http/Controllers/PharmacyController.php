<?php

namespace App\Http\Controllers;

use App\Http\Requests\Pharmacy\AdjustStockRequest;
use App\Http\Requests\Pharmacy\ValidatePrescriptionRequest;
use App\Models\MedicineStock;
use App\Models\MedicineStockMovement;
use App\Models\Prescription;
use App\Services\PharmacyService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PharmacyController extends Controller
{
    public function __construct(
        protected PharmacyService $pharmacyService
    ) {}

    /**
     * Dashboard & Daftar E-Resep Farmasi.
     */
    public function index(Request $request): View
    {
        $metrics = $this->pharmacyService->getDashboardMetrics();

        $query = Prescription::with(['patient', 'doctor', 'registration.queue.department', 'items.medicine']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('prescription_number', 'like', "%{$search}%")
                    ->orWhereHas('patient', function ($pq) use ($search) {
                        $pq->where('name', 'like', "%{$search}%")
                            ->orWhere('mr_number', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $prescriptions = $query->latest('prescription_date')->paginate(15)->withQueryString();

        return view('modules.pharmacy.index', compact('prescriptions', 'metrics'));
    }

    /**
     * Detail E-Resep & Cek Ketersediaan Stok Real-Time.
     */
    public function show(Prescription $prescription): View
    {
        $prescription->load(['patient', 'doctor', 'registration.queue.department', 'items.medicine.stocks']);

        return view('modules.pharmacy.show', compact('prescription'));
    }

    /**
     * Validasi & Ubah Status E-Resep Dokter.
     */
    public function validatePrescription(ValidatePrescriptionRequest $request, Prescription $prescription): RedirectResponse
    {
        $this->pharmacyService->validatePrescription($prescription, $request->status, $request->notes);

        return redirect()->route('pharmacy.show', $prescription)
            ->with('success', "Status resep {$prescription->prescription_number} diperbarui menjadi '{$request->status}'!");
    }

    /**
     * Penyerahan Obat (Dispensing) & Pengurangan Stok Otomatis.
     */
    public function dispense(Prescription $prescription): RedirectResponse
    {
        try {
            $this->pharmacyService->dispensePrescription($prescription);

            return redirect()->route('pharmacy.show', $prescription)
                ->with('success', "Obat resep {$prescription->prescription_number} BERHASIL DISERAHKAN! Stok fisik obat berkurang otomatis.");
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Inventori Stok Obat & Batch Kadaluarsa.
     */
    public function inventory(Request $request): View
    {
        $query = MedicineStock::with('medicine.category');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('medicine', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            })->orWhere('batch_number', 'like', "%{$search}%");
        }

        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        $stocks = $query->latest('expired_date')->paginate(15)->withQueryString();

        return view('modules.pharmacy.inventory', compact('stocks'));
    }

    /**
     * Kartu Mutasi Stok Obat.
     */
    public function movements(Request $request): View
    {
        $query = MedicineStockMovement::with('medicineStock.medicine');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('reference_number', 'like', "%{$search}%")
                ->orWhereHas('medicineStock.medicine', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }

        $movements = $query->latest('created_at')->paginate(15)->withQueryString();

        return view('modules.pharmacy.movements', compact('movements'));
    }

    /**
     * Penyesuaian (Opname) Stok Obat.
     */
    public function adjustStock(AdjustStockRequest $request, MedicineStock $medicineStock): RedirectResponse
    {
        try {
            $this->pharmacyService->adjustStock($medicineStock->id, $request->stock, $request->notes ?? 'Penyesuaian Stok Apoteker');

            return back()->with('success', 'Stok obat '.($medicineStock->medicine->name ?? '').' berhasil diperbarui!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
