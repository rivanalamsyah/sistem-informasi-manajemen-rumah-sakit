<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Models\WarehouseItem;
use App\Models\WarehouseReceipt;
use App\Services\WarehouseService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WarehouseReceiptController extends Controller
{
    public function __construct(
        protected WarehouseService $warehouseService
    ) {}

    public function index(Request $request): View
    {
        $query = WarehouseReceipt::with(['warehouse', 'supplier', 'creator', 'items.item']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('receipt_number', 'like', "%{$search}%")
                ->orWhere('invoice_number', 'like', "%{$search}%");
        }

        $receipts = $query->latest('receipt_date')->paginate(15)->withQueryString();

        return view('modules.warehouse.receipts.index', compact('receipts'));
    }

    public function create(): View
    {
        $warehouses = Warehouse::where('is_active', true)->get();
        $suppliers = Supplier::where('is_active', true)->get();
        $items = WarehouseItem::where('is_active', true)->get();

        return view('modules.warehouse.receipts.create', compact('warehouses', 'suppliers', 'items'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'receipt_date' => ['required', 'date'],
            'warehouse_id' => ['required', 'exists:warehouses,id'],
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'invoice_number' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.warehouse_item_id' => ['required', 'exists:warehouse_items,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.purchase_price' => ['required', 'numeric', 'min:0'],
            'items.*.batch_number' => ['required', 'string'],
            'items.*.expired_date' => ['nullable', 'date'],
        ]);

        try {
            $receipt = $this->warehouseService->createReceipt($request->all());

            return redirect()->route('warehouse.receipts.show', $receipt)
                ->with('success', "Penerimaan barang {$receipt->receipt_number} berhasil diproses!");
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(WarehouseReceipt $receipt): View
    {
        $receipt->load(['warehouse', 'supplier', 'creator', 'items.item']);

        return view('modules.warehouse.receipts.show', compact('receipt'));
    }
}
