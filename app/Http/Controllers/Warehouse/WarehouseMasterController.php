<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use App\Models\Warehouse;
use App\Models\WarehouseLocation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WarehouseMasterController extends Controller
{
    public function index(): View
    {
        $warehouses = Warehouse::with(['locations', 'stocks'])->latest()->get();

        return view('modules.warehouse.masters.index', compact('warehouses'));
    }

    public function storeWarehouse(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:20', 'unique:warehouses,code'],
            'name' => ['required', 'string', 'max:100'],
            'type' => ['required', 'string', 'max:50'],
            'location_description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        Warehouse::create($validated);

        return back()->with('success', 'Gudang baru berhasil ditambahkan!');
    }

    public function storeLocation(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'warehouse_id' => ['required', 'exists:warehouses,id'],
            'code' => ['required', 'string', 'max:20'],
            'name' => ['required', 'string', 'max:100'],
            'rack_number' => ['nullable', 'string', 'max:30'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        WarehouseLocation::create($validated);

        return back()->with('success', 'Lokasi / Rak gudang berhasil ditambahkan!');
    }
}
