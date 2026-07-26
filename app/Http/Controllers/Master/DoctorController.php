<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\StoreDoctorRequest;
use App\Http\Requests\Master\UpdateDoctorRequest;
use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DoctorController extends Controller
{
    public function index(Request $request): View
    {
        $query = Doctor::with('department');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sip', 'like', "%{$search}%")
                    ->orWhere('specialization', 'like', "%{$search}%");
            });
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $doctors = $query->latest()->paginate(10)->withQueryString();
        $departments = Department::where('is_active', true)->get();

        return view('modules.master.doctors.index', compact('doctors', 'departments'));
    }

    public function create(): View
    {
        $departments = Department::where('is_active', true)->get();

        return view('modules.master.doctors.create', compact('departments'));
    }

    public function store(StoreDoctorRequest $request): RedirectResponse
    {
        Doctor::create($request->validated());

        return redirect()->route('master.doctors.index')
            ->with('success', 'Data Dokter berhasil ditambahkan!');
    }

    public function show(Doctor $doctor): View
    {
        $doctor->load(['department', 'queues', 'outpatientVisits']);

        return view('modules.master.doctors.show', compact('doctor'));
    }

    public function edit(Doctor $doctor): View
    {
        $departments = Department::where('is_active', true)->get();

        return view('modules.master.doctors.edit', compact('doctor', 'departments'));
    }

    public function update(UpdateDoctorRequest $request, Doctor $doctor): RedirectResponse
    {
        $doctor->update($request->validated());

        return redirect()->route('master.doctors.index')
            ->with('success', 'Data Dokter berhasil diperbarui!');
    }

    public function destroy(Doctor $doctor): RedirectResponse
    {
        $doctor->delete();

        return redirect()->route('master.doctors.index')
            ->with('success', 'Data Dokter berhasil dihapus!');
    }
}
