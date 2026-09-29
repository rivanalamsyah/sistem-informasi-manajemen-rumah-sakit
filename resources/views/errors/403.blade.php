@extends('layouts.public')

@section('title', 'Akses Ditolak — RSU Rajawali Citra')
@section('meta_description', 'Anda tidak memiliki hak akses untuk membuka halaman ini.')

@section('content')
<section class="min-h-[calc(100vh-140px)] flex items-center justify-center py-16 px-4 bg-gradient-to-br from-blue-50/80 via-slate-50 to-cyan-50/60" aria-label="Akses Ditolak">
    <div class="text-center max-w-md mx-auto space-y-4">
        <div class="text-7xl sm:text-8xl font-black text-blue-900/15 leading-none -mb-4 select-none" aria-hidden="true">403</div>

        <div class="w-20 h-20 rounded-full bg-amber-500/10 flex items-center justify-center mx-auto mb-2 text-amber-600">
            <i data-lucide="shield-alert" class="w-10 h-10" aria-hidden="true"></i>
        </div>

        <h1 class="text-2xl sm:text-3xl font-black text-slate-900">Akses Ditolak</h1>
        <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
            Maaf, Anda tidak memiliki hak akses atau otorisasi yang diperlukan untuk membuka halaman ini.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-2">
            <a href="{{ route('home') }}" class="btn btn-primary w-full sm:w-auto">
                <i data-lucide="home" class="w-4 h-4" aria-hidden="true"></i>
                <span>Kembali ke Beranda</span>
            </a>
            <a href="{{ route('login') }}" class="btn btn-outline w-full sm:w-auto">Login Staf</a>
        </div>
    </div>
</section>
@endsection
