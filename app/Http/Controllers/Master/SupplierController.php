<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupplierController extends Controller
{
    public function index(Request $request): View
    {
        $query = Supplier::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%")
                ->orWhere('contact_name', 'like', "%{$search}%");
        }

        $suppliers = $query->latest()->paginate(10)->withQueryString();

        return view('modules.master.suppliers.index', compact('suppliers'));
    }

    public function create(): View
    {
        return view('modules.master.suppliers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:20', 'unique:suppliers,code'],
            'name' => ['required', 'string', 'max:150'],
            'contact_name' => ['nullable', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:100'],
            'address' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        Supplier::create($validated);

        return redirect()->route('master.suppliers.index')
            ->with('success', 'Data Supplier berhasil ditambahkan!');
    }

    public function show(Supplier $supplier): View
    {
        return view('modules.master.suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier): View
    {
        return view('modules.master.suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:20', 'unique:suppliers,code,'.$supplier->id],
            'name' => ['required', 'string', 'max:150'],
            'contact_name' => ['nullable', 'string', 'max:100'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:100'],
            'address' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $supplier->update($validated);

        return redirect()->route('master.suppliers.index')
            ->with('success', 'Data Supplier berhasil diperbarui!');
    }

    public function destroy(Supplier $supplier): RedirectResponse
    {
        $supplier->delete();

        return redirect()->route('master.suppliers.index')
            ->with('success', 'Data Supplier berhasil dihapus!');
    }
}
