<?php

namespace App\Services;

use App\Models\Bed;
use App\Models\InpatientVisit;
use App\Models\Registration;
use App\Models\Room;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InpatientService
{
    /**
     * Mengambil ringkasan statistik Dashboard Rawat Inap & Bed Occupancy Rate (BOR).
     */
    public function getDashboardMetrics(): array
    {
        $today = now()->today();

        $activePatients = InpatientVisit::where('status', InpatientVisit::STATUS_ACTIVE)->count();
        $admittedToday = InpatientVisit::whereDate('admission_date', $today)->count();
        $dischargedToday = InpatientVisit::whereDate('discharge_date', $today)->count();

        $totalRooms = Room::count();
        $totalBeds = Bed::count();
        $occupiedBeds = Bed::where('status', Bed::STATUS_OCCUPIED)->count();
        $emptyBeds = Bed::where('status', Bed::STATUS_EMPTY)->count();
        $maintenanceBeds = Bed::whereIn('status', [Bed::STATUS_CLEANING, Bed::STATUS_MAINTENANCE])->count();
        $bor = $totalBeds > 0 ? round(($occupiedBeds / $totalBeds) * 100, 1) : 0;

        return [
            'activePatients' => $activePatients,
            'admittedToday' => $admittedToday,
            'dischargedToday' => $dischargedToday,
            'totalRooms' => $totalRooms,
            'totalBeds' => $totalBeds,
            'occupiedBeds' => $occupiedBeds,
            'emptyBeds' => $emptyBeds,
            'maintenanceBeds' => $maintenanceBeds,
            'bor' => $bor,
        ];
    }

    /**
     * Memproses penerimaan admisi Rawat Inap pasien & alokasi tempat tidur (Bed).
     *
     * @throws Exception
     */
    public function admitPatient(array $data): InpatientVisit
    {
        return DB::transaction(function () use ($data) {
            $bed = Bed::lockForUpdate()->findOrFail($data['bed_id']);

            if ($bed->status !== Bed::STATUS_EMPTY) {
                throw new Exception("Tempat tidur {$bed->bed_number} saat ini tidak tersedia (Status: {$bed->status}).");
            }

            // 1. Buat record Rawat Inap
            $visit = InpatientVisit::create([
                'registration_id' => $data['registration_id'],
                'bed_id' => $bed->id,
                'doctor_id' => $data['doctor_id'],
                'admission_date' => $data['admission_date'] ?? now(),
                'initial_diagnosis' => $data['initial_diagnosis'] ?? 'Admisi Rawat Inap',
                'status' => InpatientVisit::STATUS_ACTIVE,
                'created_by' => Auth::id(),
            ]);

            // 2. Ubah status Bed menjadi Terisi
            $bed->update(['status' => Bed::STATUS_OCCUPIED]);

            // 3. Ubah status pendaftaran menjadi Diproses
            if ($visit->registration) {
                $visit->registration->update(['status' => Registration::STATUS_PROCESSING]);
            }

            return $visit;
        });
    }

    /**
     * Memindahkan pasien ke Tempat Tidur (Bed) atau Ruangan lain.
     *
     * @throws Exception
     */
    public function transferBed(InpatientVisit $visit, int $newBedId, ?int $newDoctorId = null): InpatientVisit
    {
        return DB::transaction(function () use ($visit, $newBedId, $newDoctorId) {
            $newBed = Bed::lockForUpdate()->findOrFail($newBedId);

            if ($newBed->id === $visit->bed_id) {
                return $visit;
            }

            if ($newBed->status !== Bed::STATUS_EMPTY) {
                throw new Exception("Tempat tidur tujuan ({$newBed->bed_number}) sedang tidak tersedia.");
            }

            // 1. Kosongkan Bed Lama
            if ($visit->bed) {
                $visit->bed->update(['status' => Bed::STATUS_EMPTY]);
            }

            // 2. Isi Bed Baru
            $newBed->update(['status' => Bed::STATUS_OCCUPIED]);

            // 3. Perbarui record Rawat Inap Pasien
            $visit->update([
                'bed_id' => $newBed->id,
                'doctor_id' => $newDoctorId ?? $visit->doctor_id,
                'updated_by' => Auth::id(),
            ]);

            return $visit;
        });
    }

    /**
     * Memproses pemulangan pasien (Discharge) & pelepasan tempat tidur.
     */
    public function dischargePatient(InpatientVisit $visit, string $reason = 'Sembuh'): InpatientVisit
    {
        return DB::transaction(function () use ($visit, $reason) {
            $visit->update([
                'status' => InpatientVisit::STATUS_CHECKOUT_MEDICAL,
                'discharge_date' => now(),
                'discharge_reason' => $reason,
                'updated_by' => Auth::id(),
            ]);

            // Kosongkan Tempat Tidur (Bed) secara otomatis
            if ($visit->bed) {
                $visit->bed->update(['status' => Bed::STATUS_EMPTY]);
            }

            // Tandai pendaftaran selesai jika tidak ada proses penunjang lain
            if ($visit->registration) {
                $visit->registration->update(['status' => Registration::STATUS_PROCESSING]);
            }

            return $visit;
        });
    }
}
