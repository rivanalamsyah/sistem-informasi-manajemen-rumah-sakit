<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use App\Models\WarehouseItem;
use App\Models\WarehouseMutation;
use App\Services\WarehouseService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WarehouseMutationController extends Controller
{
    public function __construct(
        protected WarehouseService $warehouseService
    ) {}

    public function index(Request $request): View
    {
        $query = WarehouseMutation::with(['sourceWarehouse', 'targetWarehouse', 'creator', 'items.item']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('mutation_number', 'like', "%{$search}%");
        }

        $mutations = $query->latest('mutation_date')->paginate(15)->withQueryString();

        return view('modules.warehouse.mutations.index', compact('mutations'));
    }

    public function create(): View
    {
        $warehouses = Warehouse::where('is_active', true)->get();
        $items = WarehouseItem::where('is_active', true)->get();

        return view('modules.warehouse.mutations.create', compact('warehouses', 'items'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'mutation_date' => ['required', 'date'],
            'source_warehouse_id' => ['required', 'exists:warehouses,id', 'different:target_warehouse_id'],
            'target_warehouse_id' => ['required', 'exists:warehouses,id'],
            'notes' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.warehouse_item_id' => ['required', 'exists:warehouse_items,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        try {
            $mutation = $this->warehouseService->createMutation($request->all());

            return redirect()->route('warehouse.mutations.show', $mutation)
                ->with('success', "Mutasi barang {$mutation->mutation_number} berhasil diproses!");
        } catch (Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show(WarehouseMutation $mutation): View
    {
        $mutation->load(['sourceWarehouse', 'targetWarehouse', 'creator', 'items.item']);

        return view('modules.warehouse.mutations.show', compact('mutation'));
    }
}
