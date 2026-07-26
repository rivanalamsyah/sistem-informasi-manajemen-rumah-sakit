@props([
    'type' => 'default',
])

@php
    $colorClass = match ($type) {
        'success', 'Selesai', 'Lunas', 'Aktif', 'Kosong', 'Sembuh' => 'bg-emerald-50 text-emerald-700 border-emerald-200/60',
        'danger', 'Batal', 'Belum Lunas', 'Meninggal', 'Pemeliharaan' => 'bg-rose-50 text-rose-700 border-rose-200/60',
        'warning', 'Menunggu', 'Dipproses', 'Terisi', 'Checkout Medis' => 'bg-amber-50 text-amber-700 border-amber-200/60',
        'info', 'Dipanggil', 'Sedang Diperiksa', 'Diperiksa', 'Dibersihkan' => 'bg-sky-50 text-sky-700 border-sky-200/60',
        'primary', 'Rawat Jalan', 'Rawat Inap', 'IGD' => 'bg-indigo-50 text-indigo-700 border-indigo-200/60',
        default => 'bg-slate-100 text-slate-700 border-slate-200/60',
    };
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium border {$colorClass}"]) }}>
    {{ $slot }}
</span>
