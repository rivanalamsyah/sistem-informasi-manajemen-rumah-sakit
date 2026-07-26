<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreMedicineRequest;
use App\Http\Requests\Master\UpdateMedicineRequest;
use App\Models\Medicine;
use App\Models\MedicineCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MedicineController extends Controller
{
    public function index(Request $request): View
    {
        $query = Medicine::with(['category', 'stocks']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('generic_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $medicines = $query->latest()->paginate(10)->withQueryString();
        $categories = MedicineCategory::all();

        return view('modules.master.medicines.index', compact('medicines', 'categories'));
    }

    public function create(): View
    {
        $categories = MedicineCategory::all();

        return view('modules.master.medicines.create', compact('categories'));
    }

    public function store(StoreMedicineRequest $request): RedirectResponse
    {
        Medicine::create($request->validated());

        return redirect()->route('master.medicines.index')
            ->with('success', 'Data Obat/Alkes berhasil ditambahkan!');
    }

    public function show(Medicine $medicine): View
    {
        $medicine->load(['category', 'stocks']);

        return view('modules.master.medicines.show', compact('medicine'));
    }

    public function edit(Medicine $medicine): View
    {
        $categories = MedicineCategory::all();

        return view('modules.master.medicines.edit', compact('medicine', 'categories'));
    }

    public function update(UpdateMedicineRequest $request, Medicine $medicine): RedirectResponse
    {
        $medicine->update($request->validated());

        return redirect()->route('master.medicines.index')
            ->with('success', 'Data Obat/Alkes berhasil diperbarui!');
    }

    public function destroy(Medicine $medicine): RedirectResponse
    {
        $medicine->delete();

        return redirect()->route('master.medicines.index')
            ->with('success', 'Data Obat/Alkes berhasil dihapus!');
    }
}
