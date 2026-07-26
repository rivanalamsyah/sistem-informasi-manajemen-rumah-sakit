@extends('layouts.admin')

@section('title', 'Detail User & Aktivitas')

@section('content')
    <x-page-header
        title="Detail Pengguna: {{ $user->name }}"
        subtitle="Biodata pengguna, peran hak akses, riwayat login, & log aktivitas."
        :breadcrumb="[
            ['label' => 'Manajemen User', 'url' => route('users.index')],
            ['label' => $user->username, 'url' => null]
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('users.edit', $user) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold rounded-xl shadow-xs transition">
                <i data-lucide="pencil" class="w-4 h-4"></i> Edit User
            </a>
            <a href="{{ route('users.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-xl border border-slate-200 transition">
                <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
            </a>
        </x-slot>
    </x-page-header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-5">
            <x-card class="p-6">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-16 h-16 rounded-2xl bg-teal-600 text-white flex items-center justify-center font-bold text-xl shadow-md">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">{{ $user->name }}</h2>
                        <p class="text-xs text-slate-500 font-mono">{{ $user->username }} · {{ $user->email }}</p>
                    </div>
                    <x-badge :type="$user->is_active ? 'Aktif' : 'Batal'" class="ml-auto">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</x-badge>
                </div>

                <dl class="grid grid-cols-2 sm:grid-cols-3 gap-4 text-xs bg-slate-50 p-4 rounded-xl mb-6">
                    <div>
                        <dt class="text-slate-500 font-medium mb-0.5">NIK Pegawai</dt>
                        <dd class="font-bold text-slate-800 font-mono">{{ $user->nik ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500 font-medium mb-0.5">Telepon</dt>
                        <dd class="font-bold text-slate-800">{{ $user->phone ?? '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-slate-500 font-medium mb-0.5">Terakhir Login</dt>
                        <dd class="font-bold text-teal-600">{{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Belum Pernah' }}</dd>
                    </div>
                </dl>

                <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Role & Peran Hak Akses</h3>
                <div class="flex flex-wrap gap-2 mb-6">
                    @forelse($user->roles as $r)
                        <span class="px-3 py-1 bg-indigo-50 text-indigo-700 border border-indigo-200 text-xs font-bold rounded-xl">{{ $r->name }}</span>
                    @empty
                        <span class="text-xs text-slate-400">Tidak ada role terpasang.</span>
                    @endforelse
                </div>

                {{-- Recent Login History --}}
                <h3 class="text-xs font-bold text-slate-700 uppercase tracking-wider mb-3">10 Riwayat Login Terakhir</h3>
                <x-table :headers="['Waktu Login', 'IP Address', 'Browser / User Agent', 'Status']">
                    @forelse($loginHistory as $lh)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-3 font-mono text-xs text-slate-700">{{ $lh->login_at ? $lh->login_at->format('d/m/Y H:i:s') : '-' }}</td>
                            <td class="px-6 py-3 font-mono text-xs text-teal-600">{{ $lh->ip_address ?? '127.0.0.1' }}</td>
                            <td class="px-6 py-3 text-xs text-slate-500 truncate max-w-xs">{{ $lh->user_agent ?? 'Web Browser' }}</td>
                            <td class="px-6 py-3"><x-badge type="Selesai">Sukses</x-badge></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <x-empty-state title="Belum Ada Riwayat Login" description="Tidak ada catatan login." icon="clock" />
                            </td>
                        </tr>
                    @endforelse
                </x-table>
            </x-card>
        </div>

        <div>
            <x-card title="Log Aktivitas Pengguna (Audit Trail)" icon="file-text" class="p-5 space-y-3">
                @forelse($activityLogs as $act)
                    <div class="p-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs space-y-1">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-teal-600">{{ $act->action }}</span>
                            <span class="text-[10px] text-slate-400 font-mono">{{ $act->created_at?->format('d/m H:i') }}</span>
                        </div>
                        <p class="text-slate-700 text-[11px]">{{ $act->description }}</p>
                    </div>
                @empty
                    <p class="text-xs text-slate-400">Belum ada aktivitas tercatat.</p>
                @endforelse
            </x-card>
        </div>
    </div>
@endsection
