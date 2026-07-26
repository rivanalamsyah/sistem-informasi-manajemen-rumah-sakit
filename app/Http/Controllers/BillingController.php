<?php

namespace App\Http\Controllers;

use App\Http\Requests\Billing\GenerateInvoiceRequest;
use App\Http\Requests\Billing\ProcessPaymentRequest;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\Registration;
use App\Services\BillingService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BillingController extends Controller
{
    public function __construct(
        protected BillingService $billingService
    ) {}

    /**
     * Dashboard & Daftar Tagihan Invoice Kasir.
     */
    public function index(Request $request): View
    {
        $metrics = $this->billingService->getMetrics();

        $query = Invoice::with(['patient', 'registration.queue.department', 'payments']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('invoice_number', 'like', "%{$search}%")
                    ->orWhereHas('patient', function ($pq) use ($search) {
                        $pq->where('name', 'like', "%{$search}%")
                            ->orWhere('mr_number', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $invoices = $query->latest('invoice_date')->paginate(15)->withQueryString();

        return view('modules.billing.index', compact('invoices', 'metrics'));
    }

    /**
     * Form Buat Tagihan Invoice Baru Pasien.
     */
    public function create(): View
    {
        $registrations = Registration::with(['patient', 'queue.department'])
            ->where('status', '!=', Registration::STATUS_CANCELLED)
            ->whereDoesntHave('invoice')
            ->latest('registration_date')
            ->take(50)
            ->get();

        return view('modules.billing.create', compact('registrations'));
    }

    /**
     * Generate Invoice Konsolidasi Otomatis dari Pelayanan.
     */
    public function store(GenerateInvoiceRequest $request): RedirectResponse
    {
        try {
            $registration = Registration::findOrFail($request->registration_id);
            $invoice = $this->billingService->generateInvoice($registration);

            return redirect()->route('billing.show', $invoice)
                ->with('success', "Invoice tagihan {$invoice->invoice_number} berhasil dibuat!");
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Detail Invoice Tagihan & Form Pelunasan Kasir.
     */
    public function show(Invoice $invoice): View
    {
        $invoice->load(['patient', 'registration.queue.department', 'items', 'payments.cashier']);

        return view('modules.billing.show', compact('invoice'));
    }

    /**
     * Memproses Pelunasan Pembayaran Kasir.
     */
    public function pay(ProcessPaymentRequest $request, Invoice $invoice): RedirectResponse
    {
        try {
            $payment = $this->billingService->processPayment($invoice, $request->validated());

            return redirect()->route('billing.show', $invoice)
                ->with('success', "Pembayaran tagihan {$invoice->invoice_number} BERHASIL! Kuitansi {$payment->receipt_number} diterbitkan.");
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Halaman Cetak Invoice & Kuitansi Pembayaran (A4 Ready).
     */
    public function print(Invoice $invoice): View
    {
        $invoice->load(['patient', 'registration.queue.department', 'items', 'payments.cashier']);

        return view('modules.billing.print', compact('invoice'));
    }

    /**
     * Form Pembatalan / Void Invoice.
     */
    public function edit(Invoice $invoice): View|RedirectResponse
    {
        if ($invoice->status === Invoice::STATUS_PAID) {
            return back()->with('error', 'Invoice yang sudah lunas tidak dapat dibatalkan!');
        }

        $invoice->load(['patient', 'registration.queue.department', 'items']);

        return view('modules.billing.edit', compact('invoice'));
    }

    /**
     * Proses Pembatalan / Void Invoice.
     */
    public function update(Request $request, Invoice $invoice): RedirectResponse
    {
        if ($invoice->status === Invoice::STATUS_PAID) {
            return back()->with('error', 'Invoice yang sudah lunas tidak dapat dibatalkan!');
        }

        $request->validate([
            'cancellation_reason' => ['required', 'string', 'min:5', 'max:255'],
        ]);

        $invoice->update([
            'status' => Invoice::STATUS_CANCELLED,
            'notes' => ($invoice->notes ? $invoice->notes."\n" : '').'[VOID]: '.$request->cancellation_reason,
        ]);

        return redirect()->route('billing.index')
            ->with('success', "Invoice {$invoice->invoice_number} berhasil dibatalkan (VOID).");
    }

    /**
     * Halaman Laporan Ringkasan Keuangan.
     */
    public function reports(): View
    {
        $metrics = $this->billingService->getMetrics();
        $recentPayments = Payment::with(['invoice.patient', 'cashier'])
            ->latest('payment_date')
            ->paginate(15);

        return view('modules.billing.reports', compact('metrics', 'recentPayments'));
    }
}
