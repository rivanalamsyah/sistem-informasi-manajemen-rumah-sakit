<?php

namespace App\Http\Controllers;

use App\Models\InpatientVisit;
use App\Models\LaboratoryOrder;
use App\Models\MedicalRecord;
use App\Models\OutpatientVisit;
use App\Models\Payment;
use App\Models\Prescription;
use App\Models\Registration;
use App\Models\Room;
use App\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function __construct(
        protected ReportService $reportService
    ) {}

    /**
     * Dashboard Eksekutif BI & Laporan Utama.
     */
    public function index(Request $request): View
    {
        $metrics = $this->reportService->getExecutiveMetrics();
        $charts = $this->reportService->getChartSeries();

        return view('modules.reports.index', compact('metrics', 'charts'));
    }

    /**
     * Laporan Pendaftaran Pasien & Kunjungan.
     */
    public function registrations(Request $request): View
    {
        $query = Registration::with(['patient', 'queue.department', 'queue.doctor']);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('registration_date', [$request->start_date.' 00:00:00', $request->end_date.' 23:59:59']);
        }

        if ($request->filled('service_type')) {
            $query->where('service_type', $request->service_type);
        }

        $registrations = $query->latest('registration_date')->paginate(20)->withQueryString();

        return view('modules.reports.registrations', compact('registrations'));
    }

    /**
     * Laporan Pelayanan Rawat Jalan Poliklinik.
     */
    public function outpatients(Request $request): View
    {
        $query = OutpatientVisit::with(['registration.patient', 'department', 'doctor']);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('visit_date', [$request->start_date.' 00:00:00', $request->end_date.' 23:59:59']);
        }

        $visits = $query->latest('visit_date')->paginate(20)->withQueryString();

        return view('modules.reports.outpatients', compact('visits'));
    }

    /**
     * Laporan Rawat Inap & Bed Occupancy Rate (BOR).
     */
    public function inpatients(Request $request): View
    {
        $query = InpatientVisit::with(['registration.patient', 'bed.room', 'doctor']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $visits = $query->latest('admission_date')->paginate(20)->withQueryString();
        $rooms = Room::with('beds')->get();

        return view('modules.reports.inpatients', compact('visits', 'rooms'));
    }

    /**
     * Laporan Rekam Medis & Diagnosa ICD-10.
     */
    public function emr(Request $request): View
    {
        $query = MedicalRecord::with(['patient', 'doctor', 'diagnoses']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('diagnoses', function ($q) use ($search) {
                $q->where('icd10_code', 'like', "%{$search}%")
                    ->orWhere('icd10_name', 'like', "%{$search}%");
            });
        }

        $records = $query->latest('record_date')->paginate(20)->withQueryString();

        return view('modules.reports.emr', compact('records'));
    }

    /**
     * Laporan Penggunaan & Penjualan Obat Farmasi.
     */
    public function pharmacy(Request $request): View
    {
        $query = Prescription::with(['patient', 'doctor', 'items.medicine']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $prescriptions = $query->latest('prescription_date')->paginate(20)->withQueryString();

        return view('modules.reports.pharmacy', compact('prescriptions'));
    }

    /**
     * Laporan Pengujian Laboratorium LIS.
     */
    public function laboratory(Request $request): View
    {
        $query = LaboratoryOrder::with(['patient', 'doctor', 'results.laboratoryTest']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest('order_date')->paginate(20)->withQueryString();

        return view('modules.reports.laboratory', compact('orders'));
    }

    /**
     * Laporan Keuangan & Pendapatan Kasir.
     */
    public function financial(Request $request): View
    {
        $query = Payment::with(['invoice.patient', 'cashier']);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('payment_date', [$request->start_date.' 00:00:00', $request->end_date.' 23:59:59']);
        }

        $payments = $query->latest('payment_date')->paginate(20)->withQueryString();
        $totalRevenue = $query->sum('amount_paid');

        return view('modules.reports.financial', compact('payments', 'totalRevenue'));
    }

    /**
     * Export Server-Side CSV Helper untuk berbagai jenis laporan.
     */
    public function exportCsv(Request $request, string $type)
    {
        $filename = "laporan_{$type}_".date('Ymd_His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($type) {
            $file = fopen('php://output', 'w');
            // Add UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            fputcsv($file, ['SIMRS Kencana Medika - Export Laporan '.strtoupper($type)]);
            fputcsv($file, ['Tanggal Cetak: '.date('d/m/Y H:i')]);
            fputcsv($file, []);

            switch ($type) {
                case 'financial':
                    fputcsv($file, ['No. Kuitansi', 'No. Invoice', 'Tanggal Transaksi', 'Nama Pasien', 'Metode Pembayaran', 'Jumlah Dibayar (Rp)']);
                    $payments = Payment::with('invoice.patient')->latest('payment_date')->take(1000)->get();
                    foreach ($payments as $p) {
                        fputcsv($file, [
                            $p->receipt_number,
                            $p->invoice->invoice_number ?? '-',
                            $p->payment_date ? $p->payment_date->format('d/m/Y H:i') : '-',
                            $p->invoice->patient->name ?? '-',
                            $p->payment_method,
                            $p->amount_paid,
                        ]);
                    }
                    break;

                case 'pharmacy':
                    fputcsv($file, ['No. Resep', 'Tanggal', 'Nama Pasien', 'No. RM', 'Dokter Pengirim', 'Jumlah Item', 'Status']);
                    $prescriptions = Prescription::with(['patient', 'doctor', 'items'])->latest('prescription_date')->take(1000)->get();
                    foreach ($prescriptions as $pr) {
                        fputcsv($file, [
                            $pr->prescription_number,
                            $pr->prescription_date ? $pr->prescription_date->format('d/m/Y H:i') : '-',
                            $pr->patient->name ?? '-',
                            $pr->patient->mr_number ?? '-',
                            $pr->doctor->full_name ?? '-',
                            $pr->items->count(),
                            $pr->status,
                        ]);
                    }
                    break;

                case 'laboratory':
                    fputcsv($file, ['No. Order Lab', 'Tanggal', 'Nama Pasien', 'No. RM', 'Dokter Pengirim', 'Jumlah Tes', 'Status']);
                    $orders = LaboratoryOrder::with(['patient', 'doctor', 'results'])->latest('order_date')->take(1000)->get();
                    foreach ($orders as $lo) {
                        fputcsv($file, [
                            $lo->order_number,
                            $lo->order_date ? $lo->order_date->format('d/m/Y H:i') : '-',
                            $lo->patient->name ?? '-',
                            $lo->patient->mr_number ?? '-',
                            $lo->doctor->full_name ?? '-',
                            $lo->results->count(),
                            $lo->status,
                        ]);
                    }
                    break;

                case 'outpatients':
                    fputcsv($file, ['No. Reg', 'Tanggal Kunjungan', 'Nama Pasien', 'No. RM', 'Poliklinik', 'Dokter DPJP', 'Status']);
                    $visits = OutpatientVisit::with(['registration.patient', 'department', 'doctor'])->latest('visit_date')->take(1000)->get();
                    foreach ($visits as $v) {
                        fputcsv($file, [
                            $v->registration->registration_number ?? '-',
                            $v->visit_date ? $v->visit_date->format('d/m/Y H:i') : '-',
                            $v->registration->patient->name ?? '-',
                            $v->registration->patient->mr_number ?? '-',
                            $v->department->name ?? '-',
                            $v->doctor->full_name ?? '-',
                            $v->status,
                        ]);
                    }
                    break;

                default:
                    fputcsv($file, ['No. Reg', 'Tanggal', 'Nama Pasien', 'No. RM', 'Layanan', 'Status']);
                    $regs = Registration::with('patient')->latest('registration_date')->take(1000)->get();
                    foreach ($regs as $r) {
                        fputcsv($file, [
                            $r->registration_number,
                            $r->registration_date ? $r->registration_date->format('d/m/Y H:i') : '-',
                            $r->patient->name ?? '-',
                            $r->patient->mr_number ?? '-',
                            $r->service_type,
                            $r->status,
                        ]);
                    }
                    break;
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}
