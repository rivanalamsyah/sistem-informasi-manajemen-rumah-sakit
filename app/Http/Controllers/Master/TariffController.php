<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Tariff;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TariffController extends Controller
{
    public function index(Request $request): View
    {
        $query = Tariff::with('service');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('service', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('class')) {
            $query->where('class', $request->class);
        }

        $tariffs = $query->latest()->paginate(10)->withQueryString();

        return view('modules.master.tariffs.index', compact('tariffs'));
    }

    public function create(): View
    {
        $services = Service::where('is_active', true)->get();

        return view('modules.master.tariffs.create', compact('services'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'class' => ['required', 'string', 'in:Umum,VVIP,VIP,Kelas 1,Kelas 2,Kelas 3'],
            'amount' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        Tariff::create($validated);

        return redirect()->route('master.tariffs.index')
            ->with('success', 'Data Tarif Pelayanan berhasil ditambahkan!');
    }

    public function show(Tariff $tariff): View
    {
        $tariff->load('service');

        return view('modules.master.tariffs.show', compact('tariff'));
    }

    public function edit(Tariff $tariff): View
    {
        $services = Service::where('is_active', true)->get();

        return view('modules.master.tariffs.edit', compact('tariff', 'services'));
    }

    public function update(Request $request, Tariff $tariff): RedirectResponse
    {
        $validated = $request->validate([
            'service_id' => ['required', 'exists:services,id'],
            'class' => ['required', 'string', 'in:Umum,VVIP,VIP,Kelas 1,Kelas 2,Kelas 3'],
            'amount' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $tariff->update($validated);

        return redirect()->route('master.tariffs.index')
            ->with('success', 'Data Tarif Pelayanan berhasil diperbarui!');
    }

    public function destroy(Tariff $tariff): RedirectResponse
    {
        $tariff->delete();

        return redirect()->route('master.tariffs.index')
            ->with('success', 'Data Tarif Pelayanan berhasil dihapus!');
    }
}
