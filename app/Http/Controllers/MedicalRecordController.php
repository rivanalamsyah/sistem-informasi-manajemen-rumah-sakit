<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicalRecord\StoreMedicalRecordRequest;
use App\Models\Doctor;
use App\Models\LaboratoryTest;
use App\Models\MedicalRecord;
use App\Models\Medicine;
use App\Models\Registration;
use App\Services\MedicalRecordService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MedicalRecordController extends Controller
{
    public function __construct(
        protected MedicalRecordService $medicalRecordService
    ) {}

    /**
     * Dashboard & List Episode Rekam Medis (EMR).
     */
    public function index(Request $request): View
    {
        $metrics = $this->medicalRecordService->getMetrics();

        $query = MedicalRecord::with(['patient', 'doctor', 'registration.queue.department', 'diagnoses']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('patient', function ($pq) use ($search) {
                    $pq->where('name', 'like', "%{$search}%")
                        ->orWhere('mr_number', 'like', "%{$search}%");
                })->orWhereHas('registration', function ($rq) use ($search) {
                    $rq->where('registration_number', 'like', "%{$search}%");
                })->orWhereHas('diagnoses', function ($dq) use ($search) {
                    $dq->where('icd10_code', 'like', "%{$search}%")
                        ->orWhere('icd10_name', 'like', "%{$search}%");
                });
            });
        }

        if ($request->filled('doctor_id')) {
            $query->where('doctor_id', $request->doctor_id);
        }

        if ($request->filled('service_type')) {
            $query->whereHas('registration', function ($q) use ($request) {
                $q->where('service_type', $request->service_type);
            });
        }

        $records = $query->latest('record_date')->paginate(15)->withQueryString();
        $doctors = Doctor::where('is_active', true)->get();

        return view('modules.emr.index', compact('records', 'metrics', 'doctors'));
    }

    /**
     * Form Entry Episode EMR SOAP, ICD-10, E-Resep, & Order Lab.
     */
    public function create(Request $request): View
    {
        $selectedRegistration = null;
        if ($request->filled('registration_id')) {
            $selectedRegistration = Registration::with(['patient', 'queue.department', 'queue.doctor'])->find($request->registration_id);
        }

        $registrations = Registration::with(['patient', 'queue.department', 'queue.doctor'])
            ->where('status', '!=', Registration::STATUS_CANCELLED)
            ->latest('registration_date')
            ->take(50)
            ->get();

        $doctors = Doctor::where('is_active', true)->get();
        $medicines = Medicine::where('is_active', true)->orderBy('name')->get();
        $labTests = LaboratoryTest::where('is_active', true)->orderBy('name')->get();

        return view('modules.emr.create', compact('registrations', 'selectedRegistration', 'doctors', 'medicines', 'labTests'));
    }

    /**
     * Menyimpan Catatan EMR Episode SOAP, Diagnosa ICD-10, Order Lab, & E-Resep.
     */
    public function store(StoreMedicalRecordRequest $request): RedirectResponse
    {
        try {
            $record = $this->medicalRecordService->createRecord($request->validated());

            return redirect()->route('medical-records.show', $record)
                ->with('success', 'Episode EMR Pasien '.($record->patient->name ?? '').' berhasil disimpan & diteruskan ke modul terkait!');
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Detail Episode EMR SOAP & Timeline Longitudional Rekam Medis Pasien.
     */
    public function show(MedicalRecord $medicalRecord): View
    {
        $medicalRecord->load([
            'patient',
            'doctor',
            'registration.queue.department',
            'registration.prescriptions.items.medicine',
            'registration.laboratoryOrders.results.laboratoryTest',
            'diagnoses',
        ]);

        // Histori EMR episode pasien dari kunjungan-kunjungan sebelumnya
        $patientHistory = MedicalRecord::with(['doctor', 'diagnoses', 'registration'])
            ->where('patient_id', $medicalRecord->patient_id)
            ->where('id', '!=', $medicalRecord->id)
            ->latest('record_date')
            ->take(10)
            ->get();

        return view('modules.emr.show', compact('medicalRecord', 'patientHistory'));
    }
}
