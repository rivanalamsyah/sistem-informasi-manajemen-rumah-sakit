<?php

namespace App\Services;

use App\Models\Bed;
use App\Models\Diagnosis;
use App\Models\InpatientVisit;
use App\Models\Invoice;
use App\Models\LaboratoryOrder;
use App\Models\OutpatientVisit;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\Prescription;
use App\Models\Registration;
use Illuminate\Support\Facades\DB;

class ReportService
{
    /**
     * Mengambil ringkasan eksekutif KPI & Statistik BI (Business Intelligence).
     */
    public function getExecutiveMetrics(): array
    {
        $today = now()->today();

        $totalPatients = Patient::count();
        $todayPatients = Registration::whereDate('registration_date', $today)->count();
        $activeOutpatients = OutpatientVisit::where('status', 'Diperiksa')->count();
        $activeInpatients = InpatientVisit::where('status', InpatientVisit::STATUS_ACTIVE)->count();

        $totalBeds = Bed::count();
        $occupiedBeds = Bed::where('status', Bed::STATUS_OCCUPIED)->count();
        $bor = $totalBeds > 0 ? round(($occupiedBeds / $totalBeds) * 100, 1) : 0;

        $todayRevenue = Payment::whereDate('payment_date', $today)->sum('amount_paid');
        $monthlyRevenue = Payment::whereMonth('payment_date', now()->month)
            ->whereYear('payment_date', now()->year)
            ->sum('amount_paid');

        $prescriptionsProcessed = Prescription::where('status', Prescription::STATUS_COMPLETED)->count();
        $labTestsCompleted = LaboratoryOrder::where('status', LaboratoryOrder::STATUS_COMPLETED)->count();
        $unpaidInvoicesCount = Invoice::where('status', Invoice::STATUS_UNPAID)->count();

        return [
            'totalPatients' => $totalPatients,
            'todayPatients' => $todayPatients,
            'activeOutpatients' => $activeOutpatients,
            'activeInpatients' => $activeInpatients,
            'bor' => $bor,
            'todayRevenue' => $todayRevenue,
            'monthlyRevenue' => $monthlyRevenue,
            'prescriptionsProcessed' => $prescriptionsProcessed,
            'labTestsCompleted' => $labTestsCompleted,
            'unpaidInvoicesCount' => $unpaidInvoicesCount,
        ];
    }

    /**
     * Mengambil data series grafik analitik eksekutif.
     */
    public function getChartSeries(): array
    {
        // 1. Tren Kunjungan Harian (30 Hari Terakhir)
        $visitLabels = [];
        $visitData = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $visitLabels[] = $date->format('d/m');
            $visitData[] = Registration::whereDate('registration_date', $date->toDateString())->count();
        }

        // 2. Kunjungan Pasien per Poliklinik (dari outpatient_visits yang punya department_id)
        $deptVisits = OutpatientVisit::select('department_id', DB::raw('count(*) as total'))
            ->with('department')
            ->groupBy('department_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $deptLabels = [];
        $deptData = [];
        foreach ($deptVisits as $item) {
            $deptLabels[] = $item->department->name ?? 'Poli Umum';
            $deptData[] = $item->total;
        }

        // 3. Top Diagnosa ICD-10 Penyakit
        $topDiagnoses = Diagnosis::select('icd10_code', 'icd10_name', DB::raw('count(*) as total'))
            ->groupBy('icd10_code', 'icd10_name')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return [
            'visitLabels' => $visitLabels,
            'visitData' => $visitData,
            'deptLabels' => $deptLabels,
            'deptData' => $deptData,
            'topDiagnoses' => $topDiagnoses,
        ];
    }
}
