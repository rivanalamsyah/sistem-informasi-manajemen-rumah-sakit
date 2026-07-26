<?php

namespace App\Http\Controllers;

use App\Http\Requests\Laboratory\StoreLabOrderRequest;
use App\Http\Requests\Laboratory\StoreLabResultsRequest;
use App\Models\Doctor;
use App\Models\LaboratoryOrder;
use App\Models\LaboratoryTest;
use App\Models\Registration;
use App\Services\LaboratoryService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaboratoryController extends Controller
{
    public function __construct(
        protected LaboratoryService $laboratoryService
    ) {}

    /**
     * Dashboard & Daftar Order Laboratorium.
     */
    public function index(Request $request): View
    {
        $metrics = $this->laboratoryService->getMetrics();

        $query = LaboratoryOrder::with(['patient', 'doctor', 'registration.queue.department', 'results.laboratoryTest']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhereHas('patient', function ($pq) use ($search) {
                        $pq->where('name', 'like', "%{$search}%")
                            ->orWhere('mr_number', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest('order_date')->paginate(15)->withQueryString();

        return view('modules.laboratory.index', compact('orders', 'metrics'));
    }

    /**
     * Form Buat Order Laboratorium Baru.
     */
    public function create(): View
    {
        $registrations = Registration::with(['patient', 'queue.department'])
            ->where('status', '!=', Registration::STATUS_CANCELLED)
            ->latest('registration_date')
            ->take(50)
            ->get();

        $doctors = Doctor::where('is_active', true)->get();
        $labTests = LaboratoryTest::where('is_active', true)->orderBy('name')->get();

        return view('modules.laboratory.create', compact('registrations', 'doctors', 'labTests'));
    }

    /**
     * Menyimpan Order Laboratorium Baru.
     */
    public function store(StoreLabOrderRequest $request): RedirectResponse
    {
        try {
            $order = $this->laboratoryService->createOrder($request->validated());

            return redirect()->route('laboratory.show', $order)
                ->with('success', "Order Laboratorium {$order->order_number} berhasil dibuat!");
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Detail Order Laboratorium, Penerimaan Sampel, & Form Hasil Lab.
     */
    public function show(LaboratoryOrder $laboratoryOrder): View
    {
        $laboratoryOrder->load(['patient', 'doctor', 'registration.queue.department', 'results.laboratoryTest', 'results.analyst']);

        return view('modules.laboratory.show', compact('laboratoryOrder'));
    }

    /**
     * Konfirmasi Penerimaan & Pengambilan Sampel Laboratorium.
     */
    public function collectSample(Request $request, LaboratoryOrder $laboratoryOrder): RedirectResponse
    {
        $this->laboratoryService->collectSample($laboratoryOrder, $request->notes);

        return redirect()->route('laboratory.show', $laboratoryOrder)
            ->with('success', "Sampel laboratorium untuk order {$laboratoryOrder->order_number} telah DITERIMA & DIPROSES!");
    }

    /**
     * Menyimpan Hasil Pengujian Laboratorium & Publikasi ke EMR.
     */
    public function storeResults(StoreLabResultsRequest $request, LaboratoryOrder $laboratoryOrder): RedirectResponse
    {
        try {
            $this->laboratoryService->storeResults($laboratoryOrder, $request->validated()['results']);

            return redirect()->route('laboratory.show', $laboratoryOrder)
                ->with('success', "Hasil pengujian laboratorium {$laboratoryOrder->order_number} BERHASIL DIVALIDASI & DIPUBLIKASI KE EMR!");
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }
}
