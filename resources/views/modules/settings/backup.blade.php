@extends('layouts.admin')

@section('title', 'Backup & Restore Database')

@section('content')
    <x-page-header
        title="Backup & Restore System"
        subtitle="Pembuatan salinan cadangan (backup) database & media penyimpanan, serta riwayat arsip."
        :breadcrumb="[
            ['label' => 'Pengaturan', 'url' => route('settings.index')],
            ['label' => 'Backup & Restore', 'url' => null]
        ]"
    >
        <x-slot name="actions">
            <form action="{{ route('settings.backup.run') }}" method="POST" onsubmit="return confirm('Jalankan proses pembuatan backup database sekarang?')">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-xl shadow-xs transition">
                    <i data-lucide="database-backup" class="w-4 h-4"></i> Buat Backup Database Sekarang
                </button>
            </form>
        </x-slot>
    </x-page-header>

    <div class="space-y-6">
        <x-card class="p-6">
            <h3 class="text-sm font-bold text-slate-900 mb-4 flex items-center gap-2">
                <i data-lucide="history" class="w-4 h-4 text-emerald-600"></i> Riwayat File Backup Terdaftar ({{ $backups->total() }})
            </h3>

            <x-table :headers="['Nama File Backup', 'Tipe Backup', 'Ukuran File', 'Tanggal Dibuat', 'Status', 'Aksi']">
                @forelse($backups as $bk)
                    <tr class="hover:bg-slate-50/80 transition-colors">
                        <td class="px-6 py-3 font-mono font-bold text-slate-800 text-xs">{{ $bk->file_name }}</td>
                        <td class="px-6 py-3">
                            <span class="px-2 py-0.5 text-[11px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 rounded-full">{{ strtoupper($bk->backup_type) }}</span>
                        </td>
                        <td class="px-6 py-3 font-mono text-xs text-slate-600">{{ number_format($bk->file_size / 1024, 2) }} KB</td>
                        <td class="px-6 py-3 font-mono text-xs text-slate-500">{{ $bk->created_at ? $bk->created_at->format('d/m/Y H:i:s') : '-' }}</td>
                        <td class="px-6 py-3"><x-badge type="Selesai">Sukses</x-badge></td>
                        <td class="px-6 py-3">
                            <a href="{{ route('settings.backup.download', $bk) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 text-xs font-semibold rounded-lg border border-slate-200 transition">
                                <i data-lucide="download" class="w-3.5 h-3.5"></i> Unduh File
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <x-empty-state title="Belum Ada Backup" description="Klik tombol Buat Backup Database Sekarang untuk membuat arsip cadangan pertama." icon="database-backup" />
                        </td>
                    </tr>
                @endforelse
            </x-table>

            <div class="mt-4">{{ $backups->links() }}</div>
        </x-card>
    </div>
@endsection
