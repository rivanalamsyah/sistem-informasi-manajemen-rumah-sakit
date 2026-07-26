@extends('layouts.admin')

@section('title', 'Permission Matrix (Grid Matriks Hak Akses)')

@section('content')
    <x-page-header
        title="Permission Matrix (Matriks Hak Akses)"
        subtitle="Matriks tabel silang pengatur wewenang hak akses (Permissions) untuk setiap Role di SIMRS."
        :breadcrumb="[
            ['label' => 'Manajemen User', 'url' => route('users.index')],
            ['label' => 'Role & Permission', 'url' => route('roles.index')],
            ['label' => 'Permission Matrix', 'url' => null]
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('roles.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Daftar Role
            </a>
        </x-slot>
    </x-page-header>

    <form method="POST" action="{{ route('roles.update-matrix') }}">
        @csrf
        <x-card class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs border-collapse border border-slate-200">
                    <thead>
                        <tr class="bg-slate-900 text-white">
                            <th class="p-3 font-bold border border-slate-800">Modul & Permission</th>
                            @foreach($roles as $r)
                                <th class="p-3 font-bold text-center border border-slate-800 min-w-28">
                                    {{ $r->name }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($groupedPermissions as $group => $perms)
                            <tr class="bg-slate-100 font-bold text-slate-700">
                                <td colspan="{{ $roles->count() + 1 }}" class="p-2.5 px-4 border border-slate-200 uppercase tracking-wider text-[11px]">
                                    <i data-lucide="folder" class="w-3.5 h-3.5 inline mr-1 text-teal-600"></i> {{ $group }}
                                </td>
                            </tr>
                            @foreach($perms as $p)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="p-2.5 px-4 font-mono text-slate-800 border border-slate-200">
                                        {{ $p->name }}
                                    </td>
                                    @foreach($roles as $r)
                                        @php
                                            $hasPerm = $r->permissions->contains($p->id);
                                        @endphp
                                        <td class="p-2.5 text-center border border-slate-200">
                                            <input type="checkbox" name="matrix[{{ $r->id }}][]" value="{{ $p->id }}"
                                                   class="rounded text-teal-600 focus:ring-teal-500 w-4 h-4 cursor-pointer"
                                                   {{ $hasPerm ? 'checked' : '' }}>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </x-card>

        <x-action-bar>
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl shadow-xs transition">
                <i data-lucide="save" class="w-4 h-4"></i> Simpan Seluruh Matriks Permission
            </button>
        </x-action-bar>
    </form>
@endsection
