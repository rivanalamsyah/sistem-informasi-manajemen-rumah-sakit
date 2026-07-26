<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\Supplier;
use App\Models\WarehouseItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WarehouseItemController extends Controller
{
    public function index(Request $request): View
    {
        $query = WarehouseItem::with(['supplier', 'medicine']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('barcode', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $items = $query->latest()->paginate(15)->withQueryString();

        return view('modules.warehouse.items.index', compact('items'));
    }

    public function create(): View
    {
        $suppliers = Supplier::where('is_active', true)->get();
        $medicines = Medicine::where('is_active', true)->get();

        return view('modules.warehouse.items.create', compact('suppliers', 'medicines'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:30', 'unique:warehouse_items,code'],
            'barcode' => ['nullable', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:150'],
            'category' => ['required', 'string', 'max:50'],
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'medicine_id' => ['nullable', 'exists:medicines,id'],
            'unit' => ['required', 'string', 'max:30'],
            'min_stock' => ['required', 'integer', 'min:0'],
            'max_stock' => ['required', 'integer', 'min:1'],
            'purchase_price' => ['required', 'numeric', 'min:0'],
            'sell_price' => ['required', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        WarehouseItem::create($validated);

        return redirect()->route('warehouse.items.index')
            ->with('success', 'Barang gudang berhasil ditambahkan!');
    }

    public function show(WarehouseItem $item): View
    {
        $item->load(['supplier', 'medicine', 'stocks.warehouse', 'movements.user']);

        return view('modules.warehouse.items.show', compact('item'));
    }

    public function edit(WarehouseItem $item): View
    {
        $suppliers = Supplier::where('is_active', true)->get();
        $medicines = Medicine::where('is_active', true)->get();

        return view('modules.warehouse.items.edit', compact('item', 'suppliers', 'medicines'));
    }

    public function update(Request $request, WarehouseItem $item): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:30', 'unique:warehouse_items,code,'.$item->id],
            'barcode' => ['nullable', 'string', 'max:50'],
            'name' => ['required', 'string', 'max:150'],
            'category' => ['required', 'string', 'max:50'],
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'medicine_id' => ['nullable', 'exists:medicines,id'],
            'unit' => ['required', 'string', 'max:30'],
            'min_stock' => ['required', 'integer', 'min:0'],
            'max_stock' => ['required', 'integer', 'min:1'],
            'purchase_price' => ['required', 'numeric', 'min:0'],
            'sell_price' => ['required', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $item->update($validated);

        return redirect()->route('warehouse.items.index')
            ->with('success', 'Barang gudang berhasil diperbarui!');
    }

    public function destroy(WarehouseItem $item): RedirectResponse
    {
        $item->delete();

        return redirect()->route('warehouse.items.index')
            ->with('success', 'Barang gudang berhasil dihapus!');
    }
}
