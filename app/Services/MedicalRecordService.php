<?php

namespace App\Services;

use App\Models\Diagnosis;
use App\Models\LaboratoryOrder;
use App\Models\LaboratoryResult;
use App\Models\MedicalRecord;
use App\Models\Medicine;
use App\Models\Prescription;
use App\Models\PrescriptionItem;
use App\Models\Registration;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MedicalRecordService
{
    /**
     * Mengambil ringkasan komprehensif statistik EMR / Rekam Medis.
     */
    public function getMetrics(): array
    {
        $today = now()->today();

        $totalRecords = MedicalRecord::count();
        $recordsToday = MedicalRecord::whereDate('record_date', $today)->count();

        $outpatientEpisodes = MedicalRecord::whereHas('registration', function ($q) {
            $q->where('service_type', 'Rawat Jalan');
        })->count();

        $inpatientEpisodes = MedicalRecord::whereHas('registration', function ($q) {
            $q->where('service_type', 'Rawat Inap');
        })->count();

        $topDiagnoses = Diagnosis::select('icd10_code', 'icd10_name', DB::raw('count(*) as total'))
            ->groupBy('icd10_code', 'icd10_name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return [
            'totalRecords' => $totalRecords,
            'recordsToday' => $recordsToday,
            'outpatientEpisodes' => $outpatientEpisodes,
            'inpatientEpisodes' => $inpatientEpisodes,
            'topDiagnoses' => $topDiagnoses,
        ];
    }

    /**
     * Menyimpan data Episode EMR SOAP, ICD-10, Order Lab, & Resep Obat secara transaksional.
     *
     * @throws Exception
     */
    public function createRecord(array $data): MedicalRecord
    {
        return DB::transaction(function () use ($data) {
            $registration = Registration::findOrFail($data['registration_id']);

            // 1. Simpan Record EMR (SOAP)
            $record = MedicalRecord::create([
                'registration_id' => $registration->id,
                'patient_id' => $registration->patient_id,
                'doctor_id' => $data['doctor_id'],
                'record_date' => $data['record_date'] ?? now(),
                'subjective' => $data['subjective'] ?? null,
                'objective' => $data['objective'] ?? null,
                'assessment' => $data['assessment'] ?? null,
                'plan' => $data['plan'] ?? null,
                'notes' => $data['notes'] ?? null,
                'created_by' => Auth::id(),
            ]);

            // 2. Simpan Diagnosa Utama ICD-10
            if (! empty($data['primary_icd10_code'])) {
                Diagnosis::create([
                    'medical_record_id' => $record->id,
                    'icd10_code' => strtoupper($data['primary_icd10_code']),
                    'icd10_name' => $data['primary_icd10_name'] ?? 'Diagnosa Utama',
                    'type' => Diagnosis::TYPE_PRIMARY,
                    'description' => $data['primary_description'] ?? null,
                    'created_by' => Auth::id(),
                ]);
            }

            // 3. Simpan Diagnosa Sekunder ICD-10
            if (! empty($data['secondary_icd10_code'])) {
                Diagnosis::create([
                    'medical_record_id' => $record->id,
                    'icd10_code' => strtoupper($data['secondary_icd10_code']),
                    'icd10_name' => $data['secondary_icd10_name'] ?? 'Diagnosa Sekunder',
                    'type' => Diagnosis::TYPE_SECONDARY,
                    'description' => $data['secondary_description'] ?? null,
                    'created_by' => Auth::id(),
                ]);
            }

            // 4. Buat Order E-Resep Obat jika ada obat yang dipilih
            if (! empty($data['medicine_id'])) {
                $medicine = Medicine::find($data['medicine_id']);
                if ($medicine) {
                    $prescription = Prescription::create([
                        'prescription_number' => 'RSP-'.date('Ymd').'-'.str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT),
                        'registration_id' => $registration->id,
                        'patient_id' => $registration->patient_id,
                        'doctor_id' => $data['doctor_id'],
                        'prescription_date' => now(),
                        'status' => 'Menunggu',
                        'notes' => $data['prescription_notes'] ?? 'Resep dari EMR',
                        'created_by' => Auth::id(),
                    ]);

                    PrescriptionItem::create([
                        'prescription_id' => $prescription->id,
                        'medicine_id' => $medicine->id,
                        'quantity' => $data['medicine_qty'] ?? 1,
                        'dosage' => $data['medicine_dosage'] ?? '3x1 Sehari',
                        'instruction' => $data['medicine_instruction'] ?? 'Sesudah Makan',
                        'price' => $medicine->selling_price,
                        'total_price' => ($data['medicine_qty'] ?? 1) * $medicine->selling_price,
                    ]);
                }
            }

            // 5. Buat Order Laboratorium jika ada tes lab yang dipilih
            if (! empty($data['lab_test_id'])) {
                $labOrder = LaboratoryOrder::create([
                    'order_number' => 'LAB-'.date('Ymd').'-'.str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT),
                    'registration_id' => $registration->id,
                    'patient_id' => $registration->patient_id,
                    'doctor_id' => $data['doctor_id'],
                    'order_date' => now(),
                    'status' => 'Menunggu Sampel',
                    'clinical_notes' => $data['lab_notes'] ?? 'Order Lab dari EMR',
                    'created_by' => Auth::id(),
                ]);

                LaboratoryResult::create([
                    'laboratory_order_id' => $labOrder->id,
                    'laboratory_test_id' => $data['lab_test_id'],
                    'result_value' => 'Dalam Proses Laboratorium',
                    'reference_value' => 'Normal',
                    'unit' => '-',
                    'is_abnormal' => false,
                ]);
            }

            // 6. Update Status Registrasi menjadi Diproses
            $registration->update(['status' => Registration::STATUS_PROCESSING]);

            return $record;
        });
    }
}
