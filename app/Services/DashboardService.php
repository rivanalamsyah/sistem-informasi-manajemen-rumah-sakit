<?php

namespace App\Services;

use App\Models\Bed;
use App\Models\Doctor;
use App\Models\InpatientVisit;
use App\Models\Invoice;
use App\Models\Medicine;
use App\Models\MedicineStock;
use App\Models\Patient;
use App\Models\Payment;
use App\Models\Registration;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    /**
     * Mengambil seluruh data statistik agregat untuk dashboard SIMRS.
     */
    public function getDashboardData(): array
    {
        $today = now()->today();

        // 1. Stat Cards Metrics
        $totalPatients = Patient::count();
        $todayPatients = Registration::whereDate('registration_date', $today)->count();
        $todayOutpatients = Registration::whereDate('registration_date', $today)
            ->where('service_type', Registration::TYPE_OUTPATIENT)
            ->count();
        $activeInpatients = InpatientVisit::where('status', InpatientVisit::STATUS_ACTIVE)->count();
        $activeDoctors = Doctor::where('is_active', true)->count();
        $totalMedicines = Medicine::where('is_active', true)->count();
        $todayRevenue = Payment::whereDate('payment_date', $today)->sum('amount_paid');
        $unpaidInvoicesCount = Invoice::where('status', Invoice::STATUS_UNPAID)->count();

        // 2. Monthly Visits Data (12 Bulan Terakhir)
        $visitsMonthly = Registration::selectRaw("DATE_FORMAT(registration_date, '%Y-%m') as month, COUNT(*) as total")
            ->where('registration_date', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy(DB::raw("DATE_FORMAT(registration_date, '%Y-%m')"))
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $visitChartLabels = [];
        $visitChartData = [];
        for ($i = 11; $i >= 0; $i--) {
            $mKey = now()->subMonths($i)->format('Y-m');
            $visitChartLabels[] = now()->subMonths($i)->locale('id')->translatedFormat('M Y');
            $visitChartData[] = $visitsMonthly[$mKey] ?? 0;
        }

        // 3. Monthly Revenue Data (12 Bulan Terakhir)
        $revenueMonthly = Payment::selectRaw("DATE_FORMAT(payment_date, '%Y-%m') as month, SUM(amount_paid) as total")
            ->where('payment_date', '>=', now()->subMonths(11)->startOfMonth())
            ->groupBy(DB::raw("DATE_FORMAT(payment_date, '%Y-%m')"))
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $revenueChartData = [];
        for ($i = 11; $i >= 0; $i--) {
            $mKey = now()->subMonths($i)->format('Y-m');
            $revenueChartData[] = (float) ($revenueMonthly[$mKey] ?? 0);
        }

        // 4. Gender Statistics
        $genderCounts = Patient::selectRaw('gender, COUNT(*) as total')
            ->groupBy('gender')
            ->pluck('total', 'gender')
            ->toArray();

        $genderMale = $genderCounts[Patient::GENDER_MALE] ?? 0;
        $genderFemale = $genderCounts[Patient::GENDER_FEMALE] ?? 0;

        // 5. Recent Registrations (10 Terbaru)
        $recentRegistrations = Registration::with(['patient', 'queue.department', 'queue.doctor'])
            ->latest('registration_date')
            ->take(10)
            ->get();

        // 6. Dokter Aktif & Poli Hari Ini
        $activeDoctorsList = Doctor::with('department')
            ->where('is_active', true)
            ->take(6)
            ->get();

        // 7. Status Tempat Tidur & Bed Occupancy Rate (BOR)
        $totalBeds = Bed::count();
        $occupiedBeds = Bed::where('status', Bed::STATUS_OCCUPIED)->count();
        $emptyBeds = Bed::where('status', Bed::STATUS_EMPTY)->count();
        $borPercentage = $totalBeds > 0 ? round(($occupiedBeds / $totalBeds) * 100, 1) : 0;

        // 8. Notifikasi Operasional
        $lowStockMedicines = MedicineStock::with('medicine')
            ->where('stock', '<=', 30)
            ->take(5)
            ->get();

        $expiringStocks = MedicineStock::with('medicine')
            ->where('expired_date', '<=', now()->addMonths(6))
            ->where('stock', '>', 0)
            ->orderBy('expired_date')
            ->take(5)
            ->get();

        $unpaidInvoicesList = Invoice::with('patient')
            ->where('status', Invoice::STATUS_UNPAID)
            ->latest()
            ->take(5)
            ->get();

        return [
            'metrics' => [
                'totalPatients' => $totalPatients,
                'todayPatients' => $todayPatients,
                'todayOutpatients' => $todayOutpatients,
                'activeInpatients' => $activeInpatients,
                'activeDoctors' => $activeDoctors,
                'totalMedicines' => $totalMedicines,
                'todayRevenue' => $todayRevenue,
                'unpaidInvoicesCount' => $unpaidInvoicesCount,
            ],
            'charts' => [
                'visitLabels' => $visitChartLabels,
                'visitData' => $visitChartData,
                'revenueData' => $revenueChartData,
                'genderMale' => $genderMale,
                'genderFemale' => $genderFemale,
            ],
            'recentRegistrations' => $recentRegistrations,
            'activeDoctorsList' => $activeDoctorsList,
            'bedStatus' => [
                'total' => $totalBeds,
                'occupied' => $occupiedBeds,
                'empty' => $emptyBeds,
                'bor' => $borPercentage,
            ],
            'notifications' => [
                'lowStock' => $lowStockMedicines,
                'expiring' => $expiringStocks,
                'unpaidInvoices' => $unpaidInvoicesList,
            ],
        ];
    }
}
