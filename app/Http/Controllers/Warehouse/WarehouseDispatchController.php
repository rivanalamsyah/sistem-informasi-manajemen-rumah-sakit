<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use App\Models\WarehouseDispatch;
use App\Models\WarehouseItem;
use App\Services\WarehouseService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WarehouseDispatchController extends Controller
{
    public function __construct(
        protected WarehouseService $warehouseService
    ) {}

    public function index(Request $request): View
    {
        $query = WarehouseDispatch::with(['sourceWarehouse', 'creator', 'items.item']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('dispatch_number', 'like', "%{$search}%")
                ->orWhere('destination_name', 'like', "%{$search}%");
        }

        $dispatches = $query->latest('dispatch_date')->paginate(15)->withQueryString();

        return view('modules.warehouse.dispatches.index', compact('dispatches'));
    }

    public function create(): View
    {
        $warehouses = Warehouse::where('is_active', true)->get();
        $items = WarehouseItem::where('is_active', true)->get();

        return view('modules.warehouse.dispatches.create', compact('warehouses', 'items'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'dispatch_date' => ['required', 'date'],
            'source_warehouse_id' => ['required', 'exists:warehouses,id'],
            'destination_type' => ['required', 'string'],
            'destination_name' => ['required', 'string', 'max:100'],
            'notes' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.warehouse_item_id' => ['required', 'exists:warehouse_items,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
            'items.*.batch_number' => ['nullable', 'string'],
        ]);

        try {
            $dispatch = $this->warehouseService->createDispatch($request->all());

            return redirect()->route('warehouse.dispatches.show', $dispatch)
                ->with('success', "Pengeluaran barang {$dispatch->dispatch_number} berhasil diproses!");
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(WarehouseDispatch $dispatch): View
    {
        $dispatch->load(['sourceWarehouse', 'creator', 'items.item']);

        return view('modules.warehouse.dispatches.show', compact('dispatch'));
    }
}
