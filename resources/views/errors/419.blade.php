@extends('layouts.public')

@section('title', '419 — Sesi Halaman Kadaluarsa')

@section('content')
<section class="min-h-[calc(100vh-140px)] flex items-center justify-center py-16 px-4 bg-gradient-to-br from-blue-50/80 via-slate-50 to-cyan-50/60" aria-label="419 Page Expired">
    <div class="text-center max-w-md mx-auto space-y-4">
        <div class="text-7xl sm:text-8xl font-black text-blue-900/15 leading-none -mb-4 select-none" aria-hidden="true">419</div>

        <div class="w-20 h-20 rounded-full bg-blue-900/10 flex items-center justify-center mx-auto mb-2 text-blue-900">
            <i data-lucide="clock" class="w-10 h-10" aria-hidden="true"></i>
        </div>

        <h1 class="text-2xl sm:text-3xl font-black text-slate-900">Sesi Halaman Kadaluarsa</h1>
        <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
            Sesi pengiriman formulir Anda telah kadaluarsa karena terlalu lama tidak aktif. Silakan muat ulang halaman dan coba kembali.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-2">
            <button onclick="window.location.reload()" class="btn btn-primary w-full sm:w-auto">
                <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                <span>Muat Ulang Halaman</span>
            </button>
            <a href="{{ route('home') }}" class="btn btn-outline w-full sm:w-auto">Kembali ke Beranda</a>
        </div>
    </div>
</section>
@endsection
