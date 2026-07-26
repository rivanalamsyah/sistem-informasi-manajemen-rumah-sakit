@extends('layouts.admin')

@section('title', 'Manajemen User & Hak Akses')

@section('content')
    <x-page-header
        title="Manajemen User & Hak Akses Pengguna"
        subtitle="Pengelolaan akun pegawai, hak akses (roles & permissions), riwayat login, & audit trail aktivitas."
        :breadcrumb="[
            ['label' => 'Manajemen User', 'url' => null]
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('users.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold rounded-xl shadow-xs transition">
                <i data-lucide="user-plus" class="w-4 h-4"></i> Tambah User Baru
            </a>
        </x-slot>
    </x-page-header>

    {{-- Sub Navigation Tabs --}}
    <div class="flex items-center gap-2 border-b border-slate-200 pb-3 mb-6 overflow-x-auto">
        <a href="{{ route('users.index') }}" class="px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-bold flex items-center gap-2 shadow-xs">
            <i data-lucide="users" class="w-4 h-4"></i> Daftar User
        </a>
        <a href="{{ route('roles.index') }}" class="px-4 py-2 bg-white text-slate-700 hover:bg-slate-100 border border-slate-200 rounded-xl text-xs font-semibold flex items-center gap-2 transition">
            <i data-lucide="shield" class="w-4 h-4"></i> Role & Hak Akses
        </a>
        <a href="{{ route('roles.matrix') }}" class="px-4 py-2 bg-white text-slate-700 hover:bg-slate-100 border border-slate-200 rounded-xl text-xs font-semibold flex items-center gap-2 transition">
            <i data-lucide="grid" class="w-4 h-4"></i> Permission Matrix
        </a>
        <a href="{{ route('activities.login-history') }}" class="px-4 py-2 bg-white text-slate-700 hover:bg-slate-100 border border-slate-200 rounded-xl text-xs font-semibold flex items-center gap-2 transition">
            <i data-lucide="clock" class="w-4 h-4"></i> Riwayat Login
        </a>
        <a href="{{ route('activities.audit-trail') }}" class="px-4 py-2 bg-white text-slate-700 hover:bg-slate-100 border border-slate-200 rounded-xl text-xs font-semibold flex items-center gap-2 transition">
            <i data-lucide="file-text" class="w-4 h-4"></i> Audit Trail
        </a>
    </div>

    {{-- Metrics Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <x-card class="p-5">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Pengguna</span>
                    <h2 class="text-2xl font-black text-slate-900 mt-1">{{ number_format($metrics['totalUsers']) }}</h2>
                    <span class="text-[11px] text-slate-500 mt-0.5 block">Akun Terdaftar</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-600 flex items-center justify-center">
                    <i data-lucide="users" class="w-6 h-6"></i>
                </div>
            </div>
        </x-card>

        <x-card class="p-5">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">User Aktif</span>
                    <h2 class="text-2xl font-black text-emerald-600 mt-1">{{ number_format($metrics['activeUsers']) }}</h2>
                    <span class="text-[11px] text-emerald-600 mt-0.5 block">Dapat Akses Sistem</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <i data-lucide="check-circle" class="w-6 h-6"></i>
                </div>
            </div>
        </x-card>

        <x-card class="p-5">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">User Nonaktif</span>
                    <h2 class="text-2xl font-black text-rose-600 mt-1">{{ number_format($metrics['inactiveUsers']) }}</h2>
                    <span class="text-[11px] text-rose-600 mt-0.5 block">Akses Ditolak</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center">
                    <i data-lucide="x-circle" class="w-6 h-6"></i>
                </div>
            </div>
        </x-card>

        <x-card class="p-5">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Login Hari Ini</span>
                    <h2 class="text-2xl font-black text-sky-600 mt-1">{{ number_format($metrics['todayLogins']) }}</h2>
                    <span class="text-[11px] text-sky-600 mt-0.5 block">Sesi Pengguna</span>
                </div>
                <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center">
                    <i data-lucide="log-in" class="w-6 h-6"></i>
                </div>
            </div>
        </x-card>
    </div>

    {{-- Filter Bar --}}
    <x-card class="p-4 mb-6">
        <form method="GET" action="{{ route('users.index') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-5">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500"
                           placeholder="Cari nama, username, email, NIK...">
                </div>
            </div>
            <div class="sm:col-span-3">
                <select name="role" class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">-- Semua Role --</option>
                    @foreach($roles as $r)
                        <option value="{{ $r->name }}" {{ request('role') == $r->name ? 'selected' : '' }}>{{ $r->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-2">
                <select name="status" class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">-- Semua Status --</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <div class="sm:col-span-2 flex gap-2">
                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-semibold hover:bg-teal-700 transition flex items-center gap-1.5">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i> Filter
                </button>
                <a href="{{ route('users.index') }}" class="px-3 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold border border-slate-200 hover:bg-slate-200 transition">Reset</a>
            </div>
        </form>
    </x-card>

    <x-table :headers="['Pengguna', 'Username & NIK', 'Email', 'Role Hak Akses', 'Telepon', 'Status', 'Aksi']">
        @forelse($users as $usr)
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-teal-600 text-white flex items-center justify-center font-bold text-xs">
                            {{ strtoupper(substr($usr->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-bold text-slate-800 text-xs">{{ $usr->name }}</div>
                            <span class="text-[10px] text-slate-400">Terdaftar: {{ $usr->created_at?->format('d/m/Y') ?? '-' }}</span>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 font-mono text-xs text-slate-700">
                    <div class="font-bold text-teal-600">{{ $usr->username }}</div>
                    @if($usr->nik)<span class="text-[10px] text-slate-400">NIK: {{ $usr->nik }}</span>@endif
                </td>
                <td class="px-6 py-4 text-xs text-slate-600">{{ $usr->email }}</td>
                <td class="px-6 py-4">
                    <div class="flex flex-wrap gap-1">
                        @forelse($usr->roles as $role)
                            <span class="px-2 py-0.5 text-[10px] font-bold bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-full">{{ $role->name }}</span>
                        @empty
                            <span class="text-[11px] text-slate-400 font-italic">Staf Umum</span>
                        @endforelse
                    </div>
                </td>
                <td class="px-6 py-4 text-xs text-slate-600">{{ $usr->phone ?? '-' }}</td>
                <td class="px-6 py-4">
                    <x-badge :type="$usr->is_active ? 'Aktif' : 'Batal'">{{ $usr->is_active ? 'Aktif' : 'Nonaktif' }}</x-badge>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('users.show', $usr) }}" class="p-1.5 text-slate-400 hover:text-teal-600 hover:bg-teal-50 rounded-lg transition" title="Detail">
                            <i data-lucide="eye" class="w-4 h-4"></i>
                        </a>
                        <a href="{{ route('users.edit', $usr) }}" class="p-1.5 text-slate-400 hover:text-sky-600 hover:bg-sky-50 rounded-lg transition" title="Edit">
                            <i data-lucide="pencil" class="w-4 h-4"></i>
                        </a>
                        <form action="{{ route('users.toggle-active', $usr) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="p-1.5 text-slate-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition" title="Aktivasi/Nonaktifkan">
                                <i data-lucide="{{ $usr->is_active ? 'user-x' : 'user-check' }}" class="w-4 h-4"></i>
                            </button>
                        </form>
                        @if($usr->id !== auth()->id())
                            <form action="{{ route('users.destroy', $usr) }}" method="POST" class="inline" onsubmit="return confirm('Hapus akun pengguna {{ $usr->name }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Hapus">
                                    <i data-lucide="trash-2" class="w-4 h-4"></i>
                                </button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">
                    <x-empty-state title="Belum Ada Pengguna" description="Klik Tambah User Baru untuk menambahkan akun pengguna SIMRS." icon="users" />
                </td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-4">{{ $users->links() }}</div>
@endsection
