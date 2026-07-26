<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoomController extends Controller
{
    public function index(Request $request): View
    {
        $query = Room::withCount('beds');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%")
                    ->orWhere('building', 'like', "%{$search}%");
            });
        }

        $rooms = $query->latest()->paginate(10)->withQueryString();

        return view('modules.master.rooms.index', compact('rooms'));
    }

    public function create(): View
    {
        return view('modules.master.rooms.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:20', 'unique:rooms,code'],
            'name' => ['required', 'string', 'max:100'],
            'building' => ['required', 'string', 'max:50'],
            'floor' => ['required', 'string', 'max:20'],
            'room_type' => ['required', 'string', 'in:Rawat Inap,ICU,Isolasi,VIP,Operasi'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        Room::create($validated);

        return redirect()->route('master.rooms.index')
            ->with('success', 'Data Ruangan berhasil ditambahkan!');
    }

    public function show(Room $room): View
    {
        $room->load('beds');

        return view('modules.master.rooms.show', compact('room'));
    }

    public function edit(Room $room): View
    {
        return view('modules.master.rooms.edit', compact('room'));
    }

    public function update(Request $request, Room $room): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:20', 'unique:rooms,code,'.$room->id],
            'name' => ['required', 'string', 'max:100'],
            'building' => ['required', 'string', 'max:50'],
            'floor' => ['required', 'string', 'max:20'],
            'room_type' => ['required', 'string', 'in:Rawat Inap,ICU,Isolasi,VIP,Operasi'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $room->update($validated);

        return redirect()->route('master.rooms.index')
            ->with('success', 'Data Ruangan berhasil diperbarui!');
    }

    public function destroy(Room $room): RedirectResponse
    {
        $room->delete();

        return redirect()->route('master.rooms.index')
            ->with('success', 'Data Ruangan berhasil dihapus!');
    }
}
