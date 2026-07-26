<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\LaboratoryTest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaboratoryTestController extends Controller
{
    public function index(Request $request): View
    {
        $query = LaboratoryTest::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%")
                ->orWhere('category', 'like', "%{$search}%");
        }

        $tests = $query->latest()->paginate(10)->withQueryString();

        return view('modules.master.laboratory-tests.index', compact('tests'));
    }

    public function create(): View
    {
        return view('modules.master.laboratory-tests.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:20', 'unique:laboratory_tests,code'],
            'name' => ['required', 'string', 'max:150'],
            'category' => ['required', 'string', 'max:50'],
            'unit' => ['nullable', 'string', 'max:30'],
            'reference_range_male' => ['nullable', 'string', 'max:100'],
            'reference_range_female' => ['nullable', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        LaboratoryTest::create($validated);

        return redirect()->route('master.laboratory-tests.index')
            ->with('success', 'Data Pemeriksaan Lab berhasil ditambahkan!');
    }

    public function show(LaboratoryTest $laboratoryTest): View
    {
        return view('modules.master.laboratory-tests.show', compact('laboratoryTest'));
    }

    public function edit(LaboratoryTest $laboratoryTest): View
    {
        return view('modules.master.laboratory-tests.edit', compact('laboratoryTest'));
    }

    public function update(Request $request, LaboratoryTest $laboratoryTest): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:20', 'unique:laboratory_tests,code,'.$laboratoryTest->id],
            'name' => ['required', 'string', 'max:150'],
            'category' => ['required', 'string', 'max:50'],
            'unit' => ['nullable', 'string', 'max:30'],
            'reference_range_male' => ['nullable', 'string', 'max:100'],
            'reference_range_female' => ['nullable', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $laboratoryTest->update($validated);

        return redirect()->route('master.laboratory-tests.index')
            ->with('success', 'Data Pemeriksaan Lab berhasil diperbarui!');
    }

    public function destroy(LaboratoryTest $laboratoryTest): RedirectResponse
    {
        $laboratoryTest->delete();

        return redirect()->route('master.laboratory-tests.index')
            ->with('success', 'Data Pemeriksaan Lab berhasil dihapus!');
    }
}
