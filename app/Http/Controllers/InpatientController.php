<?php

namespace App\Http\Controllers;

use App\Http\Requests\Inpatient\DischargeInpatientRequest;
use App\Http\Requests\Inpatient\StoreInpatientAdmissionRequest;
use App\Http\Requests\Inpatient\TransferInpatientBedRequest;
use App\Models\Bed;
use App\Models\Doctor;
use App\Models\InpatientVisit;
use App\Models\Registration;
use App\Models\Room;
use App\Services\InpatientService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InpatientController extends Controller
{
    public function __construct(
        protected InpatientService $inpatientService
    ) {}

    /**
     * Dashboard & Daftar Pasien Rawat Inap.
     */
    public function index(Request $request): View
    {
        $today = now()->today();
        $metrics = $this->inpatientService->getDashboardMetrics();

        $query = InpatientVisit::with(['registration.patient', 'bed.room', 'doctor']);

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

        if ($request->filled('room_id')) {
            $query->whereHas('bed', function ($q) use ($request) {
                $q->where('room_id', $request->room_id);
            });
        }

        if ($request->filled('doctor_id')) {
            $query->where('doctor_id', $request->doctor_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            // Default tampilkan pasien rawat inap aktif
            $query->where('status', InpatientVisit::STATUS_ACTIVE);
        }

        $visits = $query->latest('admission_date')->paginate(15)->withQueryString();

        $rooms = Room::where('is_active', true)->get();
        $doctors = Doctor::where('is_active', true)->get();

        return view('modules.inpatient.index', compact('visits', 'metrics', 'rooms', 'doctors'));
    }

    /**
     * Form Admission Masuk Rawat Inap Pasien Baru.
     */
    public function create(): View
    {
        $registrations = Registration::with('patient')
            ->where('status', '!=', Registration::STATUS_CANCELLED)
            ->whereDoesntHave('inpatientVisit', function ($q) {
                $q->where('status', InpatientVisit::STATUS_ACTIVE);
            })
            ->latest('registration_date')
            ->take(50)
            ->get();

        $rooms = Room::with(['beds' => function ($q) {
            $q->where('status', Bed::STATUS_EMPTY);
        }])->where('is_active', true)->get();

        $doctors = Doctor::where('is_active', true)->get();

        return view('modules.inpatient.create', compact('registrations', 'rooms', 'doctors'));
    }

    /**
     * Memproses Admisi Masuk Rawat Inap & Alokasi Bed.
     */
    public function store(StoreInpatientAdmissionRequest $request): RedirectResponse
    {
        try {
            $visit = $this->inpatientService->admitPatient($request->validated());

            return redirect()->route('inpatients.show', $visit)
                ->with('success', 'Pasien '.($visit->registration->patient->name ?? '').' berhasil masuk ke Ruang '.($visit->bed->room->name ?? '').' (Bed '.($visit->bed->bed_number ?? '').')!');
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Detail Episode Rawat Inap Pasien.
     */
    public function show(InpatientVisit $inpatientVisit): View
    {
        $inpatientVisit->load(['registration.patient.registrations', 'bed.room', 'doctor']);
        $availableRooms = Room::with(['beds' => function ($q) {
            $q->where('status', Bed::STATUS_EMPTY);
        }])->where('is_active', true)->get();
        $doctors = Doctor::where('is_active', true)->get();

        return view('modules.inpatient.show', compact('inpatientVisit', 'availableRooms', 'doctors'));
    }

    /**
     * Form Pindah Ruangan / Tempat Tidur (Bed Transfer).
     */
    public function edit(InpatientVisit $inpatientVisit): View
    {
        $inpatientVisit->load(['registration.patient', 'bed.room', 'doctor']);
        $rooms = Room::with(['beds' => function ($q) {
            $q->where('status', Bed::STATUS_EMPTY);
        }])->where('is_active', true)->get();
        $doctors = Doctor::where('is_active', true)->get();

        return view('modules.inpatient.edit', compact('inpatientVisit', 'rooms', 'doctors'));
    }

    /**
     * Eksekusi Pindah Ruangan / Bed.
     */
    public function transfer(TransferInpatientBedRequest $request, InpatientVisit $inpatientVisit): RedirectResponse
    {
        try {
            $this->inpatientService->transferBed($inpatientVisit, $request->new_bed_id, $request->doctor_id);

            return redirect()->route('inpatients.show', $inpatientVisit)
                ->with('success', 'Pasien berhasil dipindahkan ke Ruang '.($inpatientVisit->bed->room->name ?? '').' (Bed '.($inpatientVisit->bed->bed_number ?? '').')!');
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Memproses Pemulangan Pasien (Discharge).
     */
    public function discharge(DischargeInpatientRequest $request, InpatientVisit $inpatientVisit): RedirectResponse
    {
        try {
            $this->inpatientService->dischargePatient($inpatientVisit, $request->discharge_reason);

            return redirect()->route('inpatients.show', $inpatientVisit)
                ->with('success', 'Pasien '.($inpatientVisit->registration->patient->name ?? '').' telah DIPULANGKAN! Tempat tidur '.($inpatientVisit->bed->bed_number ?? '').' kembali kosong.');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Halaman Real-time Bed Monitoring & Okupansi Kamar.
     */
    public function bedMonitoring(): View
    {
        $metrics = $this->inpatientService->getDashboardMetrics();
        $rooms = Room::with('beds')->where('is_active', true)->get();

        return view('modules.inpatient.monitoring', compact('metrics', 'rooms'));
    }
}
