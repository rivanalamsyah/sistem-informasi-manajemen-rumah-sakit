<?php

namespace App\Services;

use App\Models\Department;
use App\Models\OutpatientVisit;
use App\Models\Patient;
use App\Models\Queue;
use App\Models\Registration;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegistrationService
{
    /**
     * Mendaftarkan pasien baru atau lama dan membuat antrean poli secara transaksional.
     */
    public function registerPatient(array $data): Registration
    {
        return DB::transaction(function () use ($data) {
            $patientId = $data['patient_id'] ?? null;

            // 1. Jika pendaftaran pasien baru, buat identitas Pasien baru & No. RM
            if (empty($patientId) && ! empty($data['new_patient'])) {
                $patientData = $data['new_patient'];
                $patientData['mr_number'] = $this->generateMrNumber();
                $patientData['created_by'] = Auth::id();
                $patient = Patient::create($patientData);
                $patientId = $patient->id;
            }

            // 2. Generate Nomor Registrasi Unik
            $regDate = ! empty($data['registration_date']) ? Carbon::parse($data['registration_date']) : now();
            $registrationNumber = $this->generateRegistrationNumber($regDate);

            // 3. Simpan data Registrasi
            $registration = Registration::create([
                'registration_number' => $registrationNumber,
                'patient_id' => $patientId,
                'service_type' => $data['service_type'],
                'registration_date' => $regDate,
                'guarantor' => $data['guarantor'] ?? 'Umum',
                'status' => Registration::STATUS_WAITING,
                'notes' => $data['notes'] ?? null,
                'created_by' => Auth::id(),
            ]);

            // 4. Generate & Simpan Antrean Poliklinik (bila Rawat Jalan / IGD)
            if (in_array($data['service_type'], [Registration::TYPE_OUTPATIENT, Registration::TYPE_EMERGENCY])) {
                $departmentId = $data['department_id'];
                $doctorId = $data['doctor_id'];

                $queueData = $this->generateQueueData($departmentId, $regDate);

                Queue::create([
                    'registration_id' => $registration->id,
                    'department_id' => $departmentId,
                    'doctor_id' => $doctorId,
                    'queue_number' => $queueData['number'],
                    'queue_code' => $queueData['code'],
                    'queue_date' => $regDate->toDateString(),
                    'status' => Queue::STATUS_WAITING,
                    'created_by' => Auth::id(),
                ]);

                // Buat record kunjungan Rawat Jalan awal
                OutpatientVisit::create([
                    'registration_id' => $registration->id,
                    'patient_id' => $patientId,
                    'doctor_id' => $doctorId,
                    'department_id' => $departmentId,
                    'visit_date' => $regDate->toDateString(),
                    'status' => 'Menunggu',
                    'chief_complaint' => $data['notes'] ?? 'Pendaftaran Rawat Jalan',
                ]);
            }

            return $registration->load(['patient', 'queue.department', 'queue.doctor']);
        });
    }

    /**
     * Menghasilkan Nomor Rekam Medis (No. RM) unik berurutan secara atomik.
     * Dipanggil dalam konteks DB::transaction sehingga lockForUpdate aman.
     */
    public function generateMrNumber(): string
    {
        $lastPatient = Patient::withTrashed()
            ->lockForUpdate()
            ->orderByDesc('id')
            ->first(['id']);

        $nextId = ($lastPatient?->id ?? 0) + 1;

        return 'RM-' . str_pad((string) $nextId, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Menghasilkan Nomor Registrasi Unik per Tanggal (REG-YYYYMMDD-XXXX) secara atomik.
     * Dipanggil dalam DB::transaction — lockForUpdate mencegah race condition.
     */
    public function generateRegistrationNumber(Carbon $date): string
    {
        $dateStr = $date->format('Ymd');
        $dateOnly = $date->toDateString();

        // Lock registrasi terakhir hari ini untuk mendapatkan sequence yang benar
        $lastReg = Registration::withTrashed()
            ->lockForUpdate()
            ->whereDate('registration_date', $dateOnly)
            ->orderByDesc('id')
            ->first(['id', 'registration_number']);

        $nextSeq = 1;
        if ($lastReg && $lastReg->registration_number) {
            $parts = explode('-', $lastReg->registration_number);
            $lastSeq = (int) end($parts);
            $nextSeq = $lastSeq + 1;
        }

        return 'REG-' . $dateStr . '-' . str_pad((string) $nextSeq, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Menghasilkan Nomor & Kode Antrean Poliklinik secara atomik.
     * Dipanggil dalam DB::transaction — lockForUpdate mencegah duplikat nomor antrian.
     */
    public function generateQueueData(int $departmentId, Carbon $date): array
    {
        $department = Department::findOrFail($departmentId);

        // Ambil inisial huruf dari nama/kode poli
        $prefix = strtoupper(substr($department->code, 4, 1));
        if (empty($prefix)) {
            $prefix = 'A';
        }

        // Lock antrian terakhir untuk prevent concurrent duplicate
        $maxQueueNumber = Queue::where('department_id', $departmentId)
            ->whereDate('queue_date', $date->toDateString())
            ->lockForUpdate()
            ->max('queue_number') ?? 0;

        $nextQueueNumber = $maxQueueNumber + 1;
        $queueCode = $prefix . '-' . str_pad((string) $nextQueueNumber, 3, '0', STR_PAD_LEFT);

        return [
            'number' => $nextQueueNumber,
            'code'   => $queueCode,
        ];
    }
}
