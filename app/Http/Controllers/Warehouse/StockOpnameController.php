<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\StockOpname;
use App\Models\Warehouse;
use App\Models\WarehouseItem;
use App\Services\WarehouseService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StockOpnameController extends Controller
{
    public function __construct(
        protected WarehouseService $warehouseService
    ) {}

    public function index(Request $request): View
    {
        $query = StockOpname::with(['warehouse', 'creator', 'items.item']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('opname_number', 'like', "%{$search}%");
        }

        $opnames = $query->latest('opname_date')->paginate(15)->withQueryString();

        return view('modules.warehouse.opnames.index', compact('opnames'));
    }

    public function create(): View
    {
        $warehouses = Warehouse::where('is_active', true)->get();
        $items = WarehouseItem::where('is_active', true)->get();

        return view('modules.warehouse.opnames.create', compact('warehouses', 'items'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'opname_date' => ['required', 'date'],
            'warehouse_id' => ['required', 'exists:warehouses,id'],
            'notes' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.warehouse_item_id' => ['required', 'exists:warehouse_items,id'],
            'items.*.physical_stock' => ['required', 'integer', 'min:0'],
        ]);

        try {
            $opname = $this->warehouseService->createOpname($request->all());

            return redirect()->route('warehouse.opnames.show', $opname)
                ->with('success', "Stock opname {$opname->opname_number} berhasil diproses dan stok telah disesuaikan!");
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(StockOpname $opname): View
    {
        $opname->load(['warehouse', 'creator', 'items.item']);

        return view('modules.warehouse.opnames.show', compact('opname'));
    }
}
