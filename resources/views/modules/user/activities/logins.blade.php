@extends('layouts.admin')

@section('title', 'Riwayat Login Pengguna')

@section('content')
    <x-page-header
        title="Riwayat Sesi Login Pengguna"
        subtitle="Log histori sesi masuk & keluar seluruh pengguna SIMRS beserta IP Address & Browser."
        :breadcrumb="[
            ['label' => 'Manajemen User', 'url' => route('users.index')],
            ['label' => 'Riwayat Login', 'url' => null]
        ]"
    />

    <x-card class="p-4 mb-6">
        <form method="GET" action="{{ route('activities.login-history') }}" class="grid grid-cols-1 sm:grid-cols-12 gap-3">
            <div class="sm:col-span-6">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="search" class="w-4 h-4"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="w-full pl-9 pr-3 py-2 bg-slate-50 border border-slate-200 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-teal-500"
                           placeholder="Cari pengguna atau IP Address...">
                </div>
            </div>
            <div class="sm:col-span-2 flex gap-2">
                <button type="submit" class="px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-semibold hover:bg-teal-700 transition flex items-center gap-1.5">
                    <i data-lucide="filter" class="w-3.5 h-3.5"></i> Filter
                </button>
                <a href="{{ route('activities.login-history') }}" class="px-3 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-semibold border border-slate-200 hover:bg-slate-200 transition">Reset</a>
            </div>
        </form>
    </x-card>

    <x-table :headers="['Waktu Login', 'Waktu Logout', 'Pengguna / User', 'IP Address', 'Browser & Device', 'Status Login']">
        @forelse($logins as $log)
            <tr class="hover:bg-slate-50/80 transition-colors">
                <td class="px-6 py-4 font-mono text-xs text-slate-700">{{ $log->login_at ? $log->login_at->format('d/m/Y H:i:s') : '-' }}</td>
                <td class="px-6 py-4 font-mono text-xs text-slate-500">{{ $log->logout_at ? $log->logout_at->format('d/m/Y H:i:s') : 'Masih Aktif' }}</td>
                <td class="px-6 py-4 font-bold text-slate-800 text-xs">{{ $log->user->name ?? '-' }}</td>
                <td class="px-6 py-4 font-mono text-xs text-teal-600">{{ $log->ip_address ?? '127.0.0.1' }}</td>
                <td class="px-6 py-4 text-xs text-slate-600 truncate max-w-xs">{{ $log->user_agent ?? 'Web Browser' }}</td>
                <td class="px-6 py-4"><x-badge type="Selesai">Sukses</x-badge></td>
            </tr>
        @empty
            <tr>
                <td colspan="6">
                    <x-empty-state title="Belum Ada Histori Login" description="Tidak ada catatan histori login." icon="clock" />
                </td>
            </tr>
        @endforelse
    </x-table>

    <div class="mt-4">{{ $logins->links() }}</div>
@endsection
