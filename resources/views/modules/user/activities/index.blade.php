@extends('layouts.admin')

@section('title', 'Audit Trail Log Aktivitas System')

@section('content')
    <x-page-header
        title="Audit Trail Log Aktivitas Sistem"
        subtitle="Catatan jejak audit (Audit Trail) seluruh perubahan data, aksi user, & transaksi di SIMRS."
        :breadcrumb="[
            ['label' => 'Manajemen User', 'url' => route('users.index')],
            ['label' => 'Audit Trail', 'url' => null]
        ]"
    />

    <x-card class="p-4 mb-6">
        <form method="GET" action="{{ route('activities.audit-trail') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-6">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500"
                           placeholder="Cari kata kunci deskripsi, aksi, atau user...">
                </div>
            </div>
            <div class="sm:col-span-3">
                <select name="module" class="w-full py-2 px-3 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500">
                    <option value="">-- Semua Modul --</option>
                    @foreach(['Manajemen User','Gudang','Farmasi','Billing','Pengaturan','Authentication','Profil'] as $m)
                        <option value="{{ $m }}" {{ request('module') == $m ? 'selected' : '' }}>{{ $m }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sm:col-span-3 flex gap-2">
                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-semibold hover:bg-teal-700 transition flex items-center gap-1.5">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i> Filter Logs
                </button>
                <a href="{{ route('activities.audit-trail') }}" class="px-3 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold border border-slate-200 hover:bg-slate-200 transition">Reset</a>
            </div>
        </form>
    </x-card>

    <x-table :headers="['Waktu', 'Pengguna / User', 'Modul', 'Aksi', 'Deskripsi Aktivitas', 'IP Address']">
        @forelse($activities as $act)
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-4 font-mono text-xs text-slate-500">{{ $act->created_at ? $act->created_at->format('d/m/Y H:i:s') : '-' }}</td>
                <td class="px-6 py-4 font-bold text-slate-800 text-xs">{{ $act->user->name ?? 'Sistem Automatic' }}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-0.5 text-[11px] font-bold bg-teal-50 text-teal-700 border border-teal-200 rounded-full">{{ $act->module }}</span>
                </td>
                <td class="px-6 py-4 font-bold text-indigo-600 text-xs font-mono">{{ $act->action }}</td>
                <td class="px-6 py-4 text-xs text-slate-700 max-w-md">{{ $act->description }}</td>
                <td class="px-6 py-4 font-mono text-xs text-slate-500">{{ $act->ip_address ?? '127.0.0.1' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6">
                    <x-empty-state title="Belum Ada Log Aktivitas" description="Audit trail belum mencatat aktivitas." icon="file-text" />
                </td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-4">{{ $activities->links() }}</div>
@endsection
