<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Bed;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BedController extends Controller
{
    public function index(Request $request): View
    {
        $query = Bed::with('room');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('bed_number', 'like', "%{$search}%")
                ->orWhereHas('room', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $beds = $query->latest()->paginate(10)->withQueryString();
        $rooms = Room::where('is_active', true)->get();

        return view('modules.master.beds.index', compact('beds', 'rooms'));
    }

    public function create(): View
    {
        $rooms = Room::where('is_active', true)->get();

        return view('modules.master.beds.create', compact('rooms'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'room_id' => ['required', 'exists:rooms,id'],
            'bed_number' => ['required', 'string', 'max:20'],
            'class' => ['required', 'string', 'in:VVIP,VIP,Kelas 1,Kelas 2,Kelas 3'],
            'status' => ['required', 'string', 'in:Kosong,Terisi,Dibersihkan,Pemeliharaan'],
            'price_per_night' => ['required', 'numeric', 'min:0'],
        ]);

        Bed::create($validated);

        return redirect()->route('master.beds.index')
            ->with('success', 'Data Tempat Tidur (Bed) berhasil ditambahkan!');
    }

    public function show(Bed $bed): View
    {
        $bed->load(['room', 'inpatientVisits']);

        return view('modules.master.beds.show', compact('bed'));
    }

    public function edit(Bed $bed): View
    {
        $rooms = Room::where('is_active', true)->get();

        return view('modules.master.beds.edit', compact('bed', 'rooms'));
    }

    public function update(Request $request, Bed $bed): RedirectResponse
    {
        $validated = $request->validate([
            'room_id' => ['required', 'exists:rooms,id'],
            'bed_number' => ['required', 'string', 'max:20'],
            'class' => ['required', 'string', 'in:VVIP,VIP,Kelas 1,Kelas 2,Kelas 3'],
            'status' => ['required', 'string', 'in:Kosong,Terisi,Dibersihkan,Pemeliharaan'],
            'price_per_night' => ['required', 'numeric', 'min:0'],
        ]);

        $bed->update($validated);

        return redirect()->route('master.beds.index')
            ->with('success', 'Data Tempat Tidur (Bed) berhasil diperbarui!');
    }

    public function destroy(Bed $bed): RedirectResponse
    {
        $bed->delete();

        return redirect()->route('master.beds.index')
            ->with('success', 'Data Tempat Tidur (Bed) berhasil dihapus!');
    }
}
