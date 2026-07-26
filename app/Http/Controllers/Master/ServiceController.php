<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(Request $request): View
    {
        $query = Service::with('department');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('code', 'like', "%{$search}%");
        }

        $services = $query->latest()->paginate(10)->withQueryString();

        return view('modules.master.services.index', compact('services'));
    }

    public function create(): View
    {
        $departments = Department::where('is_active', true)->get();

        return view('modules.master.services.create', compact('departments'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:20', 'unique:services,code'],
            'name' => ['required', 'string', 'max:150'],
            'category' => ['required', 'string', 'max:50'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        Service::create($validated);

        return redirect()->route('master.services.index')
            ->with('success', 'Data Tindakan Medis berhasil ditambahkan!');
    }

    public function show(Service $service): View
    {
        $service->load(['department', 'tariffs']);

        return view('modules.master.services.show', compact('service'));
    }

    public function edit(Service $service): View
    {
        $departments = Department::where('is_active', true)->get();

        return view('modules.master.services.edit', compact('service', 'departments'));
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:20', 'unique:services,code,'.$service->id],
            'name' => ['required', 'string', 'max:150'],
            'category' => ['required', 'string', 'max:50'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $service->update($validated);

        return redirect()->route('master.services.index')
            ->with('success', 'Data Tindakan Medis berhasil diperbarui!');
    }

    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();

        return redirect()->route('master.services.index')
            ->with('success', 'Data Tindakan Medis berhasil dihapus!');
    }
}
