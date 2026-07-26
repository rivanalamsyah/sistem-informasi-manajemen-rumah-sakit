<?php

namespace App\Services;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\OutpatientVisit;
use App\Models\Queue;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OutpatientService
{
    /**
     * Sinkronisasi data Pendaftaran ke Rawat Jalan (memastikan setiap Pendaftaran Rawat Jalan memiliki record OutpatientVisit).
     */
    public function syncPendingRegistrations(): void
    {
        $pendingRegs = Registration::where('service_type', Registration::TYPE_OUTPATIENT)
            ->whereDoesntHave('outpatientVisit')
            ->get();

        foreach ($pendingRegs as $reg) {
            OutpatientVisit::create([
                'registration_id' => $reg->id,
                'department_id' => $reg->queue->department_id ?? Department::first()?->id ?? 1,
                'doctor_id' => $reg->queue->doctor_id ?? Doctor::first()?->id ?? 1,
                'visit_date' => $reg->registration_date,
                'complaint' => $reg->notes ?? 'Pendaftaran Rawat Jalan',
                'status' => 'Diperiksa',
                'created_by' => Auth::id(),
            ]);
        }
    }

    /**
     * Mengambil ringkasan statistik Dashboard Rawat Jalan.
     */
    public function getDashboardMetrics(): array
    {
        $today = now()->today();

        $totalToday = Registration::whereDate('registration_date', $today)
            ->where('service_type', Registration::TYPE_OUTPATIENT)
            ->count();

        $waitingCount = Queue::whereDate('queue_date', $today)
            ->where('status', Queue::STATUS_WAITING)
            ->count();

        $examiningCount = Queue::whereDate('queue_date', $today)
            ->whereIn('status', [Queue::STATUS_CALLED, Queue::STATUS_EXAMINING])
            ->count();

        $completedCount = Queue::whereDate('queue_date', $today)
            ->where('status', Queue::STATUS_COMPLETED)
            ->count();

        $departmentVisits = Department::withCount(['queues' => function ($q) use ($today) {
            $q->whereDate('queue_date', $today);
        }])->having('queues_count', '>', 0)->get();

        $activeDoctors = Doctor::with('department')
            ->withCount(['queues' => function ($q) use ($today) {
                $q->whereDate('queue_date', $today);
            }])
            ->where('is_active', true)
            ->take(6)
            ->get();

        return [
            'totalVisitsToday'   => $totalToday,
            'waitingPatients'    => $waitingCount,
            'examiningPatients'  => $examiningCount,
            'completedPatients'  => $completedCount,
            'departmentVisits'   => $departmentVisits,
            'activeDoctors'      => $activeDoctors,
        ];
    }

    /**
     * Memulai pemeriksaan awal (Tanda-Tanda Vital / TTV & Vital Signs) pasien rawat jalan.
     */
    public function startExamination(OutpatientVisit $visit, array $vitalSigns, ?string $complaint = null): OutpatientVisit
    {
        return DB::transaction(function () use ($visit, $vitalSigns, $complaint) {
            $visit->update([
                'vital_signs' => $vitalSigns,
                'complaint' => $complaint ?? $visit->complaint,
                'status' => 'Diperiksa',
                'updated_by' => Auth::id(),
            ]);

            // Update status antrean poliklinik menjadi "Sedang Diperiksa"
            if ($visit->registration && $visit->registration->queue) {
                $visit->registration->queue->update([
                    'status' => Queue::STATUS_EXAMINING,
                ]);
                $visit->registration->update([
                    'status' => Registration::STATUS_PROCESSING,
                ]);
            }

            return $visit;
        });
    }

    /**
     * Menyelesaikan sesi kunjungan rawat jalan pasien.
     */
    public function completeVisit(OutpatientVisit $visit): OutpatientVisit
    {
        return DB::transaction(function () use ($visit) {
            $visit->update([
                'status' => OutpatientVisit::STATUS_COMPLETED,
                'updated_by' => Auth::id(),
            ]);

            if ($visit->registration && $visit->registration->queue) {
                $visit->registration->queue->update([
                    'status' => Queue::STATUS_COMPLETED,
                ]);
                $visit->registration->update([
                    'status' => Registration::STATUS_PROCESSING,
                ]);
            }

            return $visit;
        });
    }
}
