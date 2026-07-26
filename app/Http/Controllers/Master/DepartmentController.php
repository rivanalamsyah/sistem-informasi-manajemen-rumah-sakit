<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreDepartmentRequest;
use App\Http\Requests\Master\UpdateDepartmentRequest;
use App\Models\Department;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Department::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $departments = $query->latest()->paginate(10)->withQueryString();

        return view('modules.master.departments.index', compact('departments'));
    }

    public function create(): View
    {
        return view('modules.master.departments.create');
    }

    public function store(StoreDepartmentRequest $request): RedirectResponse
    {
        Department::create($request->validated());

        return redirect()->route('master.departments.index')
            ->with('success', 'Data Poliklinik berhasil ditambahkan!');
    }

    public function show(Department $department): View
    {
        $department->load(['doctors', 'services']);

        return view('modules.master.departments.show', compact('department'));
    }

    public function edit(Department $department): View
    {
        return view('modules.master.departments.edit', compact('department'));
    }

    public function update(UpdateDepartmentRequest $request, Department $department): RedirectResponse
    {
        $department->update($request->validated());

        return redirect()->route('master.departments.index')
            ->with('success', 'Data Poliklinik berhasil diperbarui!');
    }

    public function destroy(Department $department): RedirectResponse
    {
        $department->delete();

        return redirect()->route('master.departments.index')
            ->with('success', 'Data Poliklinik berhasil dihapus!');
    }
}
