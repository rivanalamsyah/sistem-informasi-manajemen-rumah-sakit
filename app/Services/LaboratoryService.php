<?php

namespace App\Services;

use App\Models\LaboratoryOrder;
use App\Models\LaboratoryResult;
use App\Models\LaboratoryTest;
use App\Models\Registration;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LaboratoryService
{
    /**
     * Mengambil ringkasan statistik Dashboard LIS / Laboratorium.
     */
    public function getMetrics(): array
    {
        $today = now()->today();

        $ordersToday = LaboratoryOrder::whereDate('order_date', $today)->count();
        $waitingSample = LaboratoryOrder::where('status', LaboratoryOrder::STATUS_WAITING_SAMPLE)->count();
        $processing = LaboratoryOrder::where('status', LaboratoryOrder::STATUS_PROCESSING)->count();
        $completed = LaboratoryOrder::where('status', LaboratoryOrder::STATUS_COMPLETED)->count();
        $abnormalResults = LaboratoryResult::where('is_abnormal', true)->count();

        return [
            'ordersToday' => $ordersToday,
            'waitingSample' => $waitingSample,
            'processing' => $processing,
            'completed' => $completed,
            'abnormalResults' => $abnormalResults,
        ];
    }

    /**
     * Membuat order pengujian laboratorium baru dari admisi/EMR.
     *
     * @throws Exception
     */
    public function createOrder(array $data): LaboratoryOrder
    {
        return DB::transaction(function () use ($data) {
            $registration = Registration::findOrFail($data['registration_id']);

            $order = LaboratoryOrder::create([
                'order_number' => 'LAB-'.date('Ymd').'-'.str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT),
                'registration_id' => $registration->id,
                'patient_id' => $registration->patient_id,
                'doctor_id' => $data['doctor_id'],
                'order_date' => $data['order_date'] ?? now(),
                'status' => LaboratoryOrder::STATUS_WAITING_SAMPLE,
                'clinical_notes' => $data['clinical_notes'] ?? null,
                'created_by' => Auth::id(),
            ]);

            // Tambahkan item tes lab yang dipesan
            if (! empty($data['laboratory_test_ids'])) {
                foreach ($data['laboratory_test_ids'] as $testId) {
                    $test = LaboratoryTest::find($testId);
                    if ($test) {
                        LaboratoryResult::create([
                            'laboratory_order_id' => $order->id,
                            'laboratory_test_id' => $test->id,
                            'result_value' => null,
                            'reference_range' => $test->reference_range ?? 'Normal',
                            'unit' => $test->unit ?? '-',
                            'is_abnormal' => false,
                        ]);
                    }
                }
            }

            return $order;
        });
    }

    /**
     * Konfirmasi penerimaan & pengambilan sampel laboratorium.
     */
    public function collectSample(LaboratoryOrder $order, ?string $notes = null): LaboratoryOrder
    {
        $order->update([
            'status' => LaboratoryOrder::STATUS_PROCESSING,
            'clinical_notes' => $notes ?? $order->clinical_notes,
            'updated_by' => Auth::id(),
        ]);

        return $order;
    }

    /**
     * Memproses input hasil laboratorium, evaluasi nilai abnormal, & validasi analis secara atomik.
     *
     * @throws Exception
     */
    public function storeResults(LaboratoryOrder $order, array $results): LaboratoryOrder
    {
        return DB::transaction(function () use ($order, $results) {
            foreach ($results as $testId => $resData) {
                $resultRecord = LaboratoryResult::where('laboratory_order_id', $order->id)
                    ->where('laboratory_test_id', $testId)
                    ->first();

                if ($resultRecord) {
                    $resultRecord->update([
                        'result_value' => $resData['value'] ?? null,
                        'reference_range' => $resData['reference_range'] ?? $resultRecord->reference_range,
                        'unit' => $resData['unit'] ?? $resultRecord->unit,
                        'is_abnormal' => isset($resData['is_abnormal']) ? (bool) $resData['is_abnormal'] : false,
                        'notes' => $resData['notes'] ?? null,
                        'analyst_user_id' => Auth::id(),
                        'doctor_in_charge_id' => $order->doctor_id,
                        'result_date' => now(),
                    ]);
                }
            }

            // Perbarui status Order Lab menjadi Selesai & Terbaca di EMR Pasien
            $order->update([
                'status' => LaboratoryOrder::STATUS_COMPLETED,
                'updated_by' => Auth::id(),
            ]);

            return $order;
        });
    }
}
