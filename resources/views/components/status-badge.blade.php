@props([
    'status' => 'default',
])

@php
    $dotColor = match ($status) {
        'success', 'Selesai', 'Lunas', 'Aktif', 'Kosong', 'Sembuh' => 'bg-emerald-500',
        'danger', 'Batal', 'Belum Lunas', 'Meninggal', 'Pemeliharaan' => 'bg-rose-500',
        'warning', 'Menunggu', 'Dipproses', 'Terisi', 'Checkout Medis' => 'bg-amber-500',
        'info', 'Dipanggil', 'Sedang Diperiksa', 'Diperiksa', 'Dibersihkan' => 'bg-sky-500',
        'primary', 'Rawat Jalan', 'Rawat Inap', 'IGD' => 'bg-indigo-500',
        default => 'bg-slate-400',
    };
@endphp

<x-badge :type="$status" {{ $attributes }}>
    <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $dotColor }}"></span>
    <span>{{ $slot->isEmpty() ? $status : $slot }}</span>
</x-badge>
