@extends('layouts.admin')

@section('title', 'Role & Hak Akses (Permissions)')

@section('content')
    <x-page-header
        title="Role & Hak Akses Pengguna (Spatie RBAC)"
        subtitle="Manajemen peran (Roles) & wewenang akses modul (Permissions) rumah sakit."
        :breadcrumb="[
            ['label' => 'Manajemen User', 'url' => route('users.index')],
            ['label' => 'Role & Permission', 'url' => null]
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('roles.matrix') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-xs transition">
                <i data-lucide="grid" class="w-4 h-4"></i> Buka Permission Matrix
            </a>
        </x-slot>
    </x-page-header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                @foreach($roles as $r)
                    <x-card class="p-5 flex flex-col justify-between">
                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                                    <i data-lucide="shield" class="w-4 h-4 text-indigo-600"></i> {{ $r->name }}
                                </h3>
                                <span class="px-2 py-0.5 bg-slate-100 text-slate-600 text-[10px] font-bold rounded-full">{{ $r->users->count() }} User</span>
                            </div>
                            <p class="text-xs text-slate-500 mb-3">{{ $r->description ?? 'Peran hak akses standar sistem' }}</p>

                            <div class="flex flex-wrap gap-1 mb-4">
                                @forelse($r->permissions->take(6) as $perm)
                                    <span class="px-2 py-0.5 bg-slate-100 text-slate-700 text-[10px] rounded-md font-mono">{{ $perm->name }}</span>
                                @empty
                                    <span class="text-[11px] text-slate-400">Belum ada permission terpasang.</span>
                                @endforelse
                                @if($r->permissions->count() > 6)
                                    <span class="px-2 py-0.5 bg-indigo-50 text-indigo-700 text-[10px] font-bold rounded-md">+{{ $r->permissions->count() - 6 }} lainnya</span>
                                @endif
                            </div>
                        </div>

                        <div class="border-t border-slate-100 pt-3 flex justify-between items-center text-xs">
                            <a href="{{ route('roles.matrix') }}" class="text-indigo-600 font-bold hover:underline">Kelola Permission ➔</a>
                            @if($r->name !== 'Super Admin')
                                <form action="{{ route('roles.destroy', $r) }}" method="POST" onsubmit="return confirm('Hapus role {{ $r->name }}?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-rose-600 font-semibold hover:underline">Hapus</button>
                                </form>
                            @endif
                        </div>
                    </x-card>
                @endforeach
            </div>
        </div>

        <div>
            <x-card title="Tambah Role Baru" icon="plus-circle" class="p-5">
                <form method="POST" action="{{ route('roles.store') }}" class="space-y-4">
                    @csrf
                    <x-form-input name="name" label="Nama Role Baru" placeholder="Contoh: Kepala Farmasi / Kasir RS" required />
                    <x-form-input name="description" label="Deskripsi Wewenang" placeholder="Penjelasan tugas role..." />

                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5">Pilih Permission Awal</label>
                        <div class="max-h-48 overflow-y-auto space-y-1.5 border border-slate-200 rounded-xl p-3 bg-slate-50">
                            @foreach($permissions as $group => $groupPerms)
                                <div class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mt-2 first:mt-0">{{ $group }}</div>
                                @foreach($groupPerms as $perm)
                                    <label class="flex items-center gap-2 text-xs text-slate-700 cursor-pointer">
                                        <input type="checkbox" name="permissions[]" value="{{ $perm->id }}" class="rounded text-teal-600">
                                        <span>{{ $perm->name }}</span>
                                    </label>
                                @endforeach
                            @endforeach
                        </div>
                    </div>

                    <button type="submit" class="w-full py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs rounded-xl shadow-xs transition">
                        Simpan Role Baru
                    </button>
                </form>
            </x-card>
        </div>
    </div>
@endsection
