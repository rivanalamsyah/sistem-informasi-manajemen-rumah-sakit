@extends('layouts.public')

@section('title', '429 — Terlalu Banyak Permintaan')

@section('content')
<section class="min-h-[calc(100vh-140px)] flex items-center justify-center py-16 px-4 bg-gradient-to-br from-blue-50/80 via-slate-50 to-cyan-50/60" aria-label="429 Too Many Requests">
    <div class="text-center max-w-md mx-auto space-y-4">
        <div class="text-7xl sm:text-8xl font-black text-rose-900/15 leading-none -mb-4 select-none" aria-hidden="true">429</div>

        <div class="w-20 h-20 rounded-full bg-rose-500/10 flex items-center justify-center mx-auto mb-2 text-rose-600">
            <i data-lucide="zap-off" class="w-10 h-10" aria-hidden="true"></i>
        </div>

        <h1 class="text-2xl sm:text-3xl font-black text-slate-900">Terlalu Banyak Permintaan</h1>
        <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
            Sistem mendeteksi terlalu banyak permintaan dari perangkat Anda dalam waktu singkat. Silakan tunggu beberapa saat sebelum mencoba kembali.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-2">
            <a href="{{ route('home') }}" class="btn btn-primary w-full sm:w-auto">Kembali ke Beranda</a>
        </div>
    </div>
</section>
@endsection
