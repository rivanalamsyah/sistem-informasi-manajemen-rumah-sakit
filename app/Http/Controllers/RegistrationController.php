<?php

namespace App\Http\Controllers;

use App\Http\Requests\Registration\StoreRegistrationRequest;
use App\Http\Requests\Registration\UpdateRegistrationRequest;
use App\Models\Department;
use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Queue;
use App\Models\Registration;
use App\Services\RegistrationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    public function __construct(
        protected RegistrationService $registrationService
    ) {}

    /**
     * Dashboard & Daftar Registrasi Pasien.
     */
    public function index(Request $request): View
    {
        $this->authorize('viewAny', Registration::class);

        $today = now()->today();

        // Ringkasan Metrics Dashboard Pendaftaran
        $metrics = [
            'todayRegistrations' => Registration::whereDate('registration_date', $today)->count(),
            'newPatients' => Patient::whereDate('created_at', $today)->count(),
            'oldPatients' => Registration::whereDate('registration_date', $today)
                ->whereHas('patient', function ($q) use ($today) {
                    $q->whereDate('created_at', '<', $today);
                })->count(),
            'totalQueues' => Queue::whereDate('queue_date', $today)->count(),
            'busyDepartment' => Department::withCount(['queues' => function ($q) use ($today) {
                $q->whereDate('queue_date', $today);
            }])->orderByDesc('queues_count')->first(),
            'topDoctor' => Doctor::withCount(['queues' => function ($q) use ($today) {
                $q->whereDate('queue_date', $today);
            }])->orderByDesc('queues_count')->first(),
        ];

        // Query Daftar Registrasi
        $query = Registration::with(['patient', 'queue.department', 'queue.doctor']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('registration_number', 'like', "%{$search}%")
                    ->orWhereHas('patient', function ($pq) use ($search) {
                        $pq->where('name', 'like', "%{$search}%")
                            ->orWhere('mr_number', 'like', "%{$search}%")
                            ->orWhere('nik', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('date')) {
            $query->whereDate('registration_date', $request->date);
        } else {
            $query->whereDate('registration_date', $today);
        }

        if ($request->filled('department_id')) {
            $query->whereHas('queue', function ($q) use ($request) {
                $q->where('department_id', $request->department_id);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $registrations = $query->latest('registration_date')->paginate(15)->withQueryString();

        $departments = Department::where('is_active', true)->get();
        $doctors = Doctor::where('is_active', true)->get();

        return view('modules.registration.index', compact('registrations', 'metrics', 'departments', 'doctors'));
    }

    /**
     * Form Pendaftaran Baru.
     */
    public function create(): View
    {
        $this->authorize('create', Registration::class);

        $departments = Department::where('is_active', true)->get();
        $doctors = Doctor::with('department')->where('is_active', true)->get();

        return view('modules.registration.create', compact('departments', 'doctors'));
    }

    /**
     * Menyimpan Registrasi Pasien & Antrean.
     */
    public function store(StoreRegistrationRequest $request): RedirectResponse
    {
        $this->authorize('create', Registration::class);

        $registration = $this->registrationService->registerPatient($request->validated());

        return redirect()->route('registrations.show', $registration)
            ->with('success', "Pendaftaran Pasien berhasil! No. Registrasi: {$registration->registration_number}, No. Antrean: " . ($registration->queue->queue_code ?? '-'));
    }

    /**
     * Detail Registrasi Pasien.
     */
    public function show(Registration $registration): View
    {
        $this->authorize('view', $registration);

        $registration->load(['patient.registrations.queue.department', 'queue.department', 'queue.doctor']);

        return view('modules.registration.show', compact('registration'));
    }

    /**
     * Edit Pendaftaran (Ubah Poli / Dokter / Status sebelum diperiksa).
     */
    public function edit(Registration $registration): View
    {
        $this->authorize('update', $registration);

        $registration->load(['patient', 'queue']);
        $departments = Department::where('is_active', true)->get();
        $doctors = Doctor::where('is_active', true)->get();

        return view('modules.registration.edit', compact('registration', 'departments', 'doctors'));
    }

    /**
     * Perbarui Data Pendaftaran.
     */
    public function update(UpdateRegistrationRequest $request, Registration $registration): RedirectResponse
    {
        $this->authorize('update', $registration);

        $registration->update([
            'status' => $request->status,
            'notes'  => $request->notes,
        ]);

        if ($registration->queue) {
            $registration->queue->update([
                'department_id' => $request->department_id,
                'doctor_id'     => $request->doctor_id,
                'status'        => $request->status === Registration::STATUS_CANCELLED ? Queue::STATUS_CANCELLED : $registration->queue->status,
            ]);
        }

        return redirect()->route('registrations.show', $registration)
            ->with('success', 'Data Pendaftaran Pasien berhasil diperbarui!');
    }

    /**
     * Pembatalan Registrasi Pasien.
     */
    public function cancel(Request $request, Registration $registration): RedirectResponse
    {
        $this->authorize('cancel', $registration);

        $registration->update(['status' => Registration::STATUS_CANCELLED]);

        if ($registration->queue) {
            $registration->queue->update(['status' => Queue::STATUS_CANCELLED]);
        }

        return redirect()->route('registrations.index')
            ->with('info', "Registrasi {$registration->registration_number} telah dibatalkan.");
    }

    /**
     * Hapus (Soft Delete) Registrasi — hanya Super Admin & Admin.
     */
    public function destroy(Registration $registration): RedirectResponse
    {
        $this->authorize('delete', $registration);

        $registrationNumber = $registration->registration_number;
        $registration->delete();

        return redirect()->route('registrations.index')
            ->with('success', "Registrasi {$registrationNumber} berhasil dihapus dari sistem.");
    }

    /**
     * API Search Pasien Lama (AJAX JSON).
     */
    public function searchPatients(Request $request): JsonResponse
    {
        $query = $request->get('q');

        if (empty($query) || strlen($query) < 2) {
            return response()->json([]);
        }

        $patients = Patient::search($query)
            ->take(10)
            ->get(['id', 'mr_number', 'nik', 'name', 'phone', 'birth_date', 'gender', 'address']);

        return response()->json($patients);
    }
}
