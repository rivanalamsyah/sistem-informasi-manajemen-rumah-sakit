<?php

namespace App\Http\Controllers;

use App\Http\Requests\Outpatient\StoreOutpatientVitalSignsRequest;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\OutpatientVisit;
use App\Models\Queue;
use App\Services\OutpatientService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OutpatientController extends Controller
{
    public function __construct(
        protected OutpatientService $outpatientService
    ) {}

    /**
     * Dashboard & Daftar Kunjungan Pasien Rawat Jalan (Poliklinik).
     */
    public function index(Request $request): View
    {
        // Sinkronisasi pendaftaran aktif ke rawat jalan
        $this->outpatientService->syncPendingRegistrations();

        $today = now()->today();
        $metrics = $this->outpatientService->getDashboardMetrics();

        $query = OutpatientVisit::with(['registration.patient', 'department', 'doctor', 'registration.queue']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('registration', function ($rq) use ($search) {
                    $rq->where('registration_number', 'like', "%{$search}%")
                        ->orWhereHas('patient', function ($pq) use ($search) {
                            $pq->where('name', 'like', "%{$search}%")
                                ->orWhere('mr_number', 'like', "%{$search}%");
                        });
                });
            });
        }

        if ($request->filled('date')) {
            $query->whereDate('visit_date', $request->date);
        } else {
            $query->whereDate('visit_date', $today);
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('doctor_id')) {
            $query->where('doctor_id', $request->doctor_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $visits = $query->latest('visit_date')->paginate(15)->withQueryString();

        $departments = Department::where('is_active', true)->get();
        $doctors = Doctor::where('is_active', true)->get();

        return view('modules.outpatient.index', compact('visits', 'metrics', 'departments', 'doctors'));
    }

    /**
     * Detail Kunjungan Rawat Jalan Pasien.
     */
    public function show(OutpatientVisit $outpatientVisit): View
    {
        $outpatientVisit->load(['registration.patient.registrations.queue.department', 'department', 'doctor']);

        return view('modules.outpatient.show', compact('outpatientVisit'));
    }

    /**
     * Form Pencatatan Pemeriksaan Awal (Vital Signs / TTV).
     */
    public function edit(OutpatientVisit $outpatientVisit): View
    {
        $outpatientVisit->load(['registration.patient', 'department', 'doctor']);

        return view('modules.outpatient.edit', compact('outpatientVisit'));
    }

    /**
     * Menyimpan data Tanda-Tanda Vital (TTV) & Memulai Pemeriksaan.
     */
    public function updateVitalSigns(StoreOutpatientVitalSignsRequest $request, OutpatientVisit $outpatientVisit): RedirectResponse
    {
        $vitalSigns = [
            'systole' => $request->systole,
            'diastole' => $request->diastole,
            'temperature' => $request->temperature,
            'pulse' => $request->pulse,
            'respiration' => $request->respiration,
            'height' => $request->height,
            'weight' => $request->weight,
            'spo2' => $request->spo2,
        ];

        $this->outpatientService->startExamination($outpatientVisit, $vitalSigns, $request->complaint);

        return redirect()->route('outpatients.show', $outpatientVisit)
            ->with('success', 'Pemeriksaan Awal Tanda-Tanda Vital (TTV) berhasil dicatat!');
    }

    /**
     * Pemanggilan Antrean Pasien ke Ruang Periksa.
     */
    public function callQueue(OutpatientVisit $outpatientVisit): RedirectResponse
    {
        if ($outpatientVisit->registration && $outpatientVisit->registration->queue) {
            $outpatientVisit->registration->queue->update([
                'status' => Queue::STATUS_CALLED,
            ]);
        }

        return redirect()->back()
            ->with('info', 'Pasien '.($outpatientVisit->registration->patient->name ?? '').' dipanggil ke '.($outpatientVisit->department->name ?? 'Poliklinik'));
    }

    /**
     * Menyelesaikan Pelayanan Rawat Jalan Pasien.
     */
    public function complete(OutpatientVisit $outpatientVisit): RedirectResponse
    {
        $this->outpatientService->completeVisit($outpatientVisit);

        return redirect()->route('outpatients.show', $outpatientVisit)
            ->with('success', 'Pemeriksaan Pasien di Poliklinik telah SELESAI. Pasien siap diproses ke Rekam Medis / Kasir.');
    }
}
