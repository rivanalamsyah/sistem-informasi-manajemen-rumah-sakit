<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\MedicineCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MedicineCategoryController extends Controller
{
    public function index(Request $request): View
    {
        $query = MedicineCategory::withCount('medicines');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        $categories = $query->latest()->paginate(10)->withQueryString();

        return view('modules.master.medicine-categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('modules.master.medicine-categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:medicine_categories,name'],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        MedicineCategory::create($validated);

        return redirect()->route('master.medicine-categories.index')
            ->with('success', 'Kategori Obat berhasil ditambahkan!');
    }

    public function show(MedicineCategory $medicineCategory): View
    {
        $medicineCategory->load('medicines');

        return view('modules.master.medicine-categories.show', compact('medicineCategory'));
    }

    public function edit(MedicineCategory $medicineCategory): View
    {
        return view('modules.master.medicine-categories.edit', compact('medicineCategory'));
    }

    public function update(Request $request, MedicineCategory $medicineCategory): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', 'unique:medicine_categories,name,'.$medicineCategory->id],
            'description' => ['nullable', 'string', 'max:255'],
        ]);

        $medicineCategory->update($validated);

        return redirect()->route('master.medicine-categories.index')
            ->with('success', 'Kategori Obat berhasil diperbarui!');
    }

    public function destroy(MedicineCategory $medicineCategory): RedirectResponse
    {
        $medicineCategory->delete();

        return redirect()->route('master.medicine-categories.index')
            ->with('success', 'Kategori Obat berhasil dihapus!');
    }
}
