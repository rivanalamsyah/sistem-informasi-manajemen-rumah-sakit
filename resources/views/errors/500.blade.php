@extends('layouts.public')

@section('title', 'Terjadi Kesalahan Sistem — RSU Rajawali Citra')
@section('meta_description', 'Terjadi kesalahan internal pada sistem. Tim teknis kami sedang menangani masalah ini.')

@section('content')
<section class="min-h-[calc(100vh-140px)] flex items-center justify-center py-16 px-4 bg-gradient-to-br from-blue-50/80 via-slate-50 to-cyan-50/60" aria-label="Kesalahan Server">
    <div class="text-center max-w-md mx-auto space-y-4">
        <div class="text-7xl sm:text-8xl font-black text-blue-900/15 leading-none -mb-4 select-none" aria-hidden="true">500</div>

        <div class="w-20 h-20 rounded-full bg-red-500/10 flex items-center justify-center mx-auto mb-2 text-red-600">
            <i data-lucide="server-crash" class="w-10 h-10" aria-hidden="true"></i>
        </div>

        <h1 class="text-2xl sm:text-3xl font-black text-slate-900">Terjadi Kesalahan Sistem</h1>
        <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
            Maaf, server sedang mengalami gangguan sementara. Tim teknis kami telah dinotifikasi dan sedang menangani masalah ini.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-2">
            <a href="{{ route('home') }}" class="btn btn-primary w-full sm:w-auto">
                <i data-lucide="home" class="w-4 h-4" aria-hidden="true"></i>
                <span>Kembali ke Beranda</span>
            </a>
            <a href="{{ route('contact') }}" class="btn btn-outline w-full sm:w-auto">Hubungi Informasi</a>
        </div>

        <div class="p-4 bg-red-50 border border-red-200 rounded-2xl text-xs space-y-1 text-center mt-6">
            <p class="font-extrabold text-red-900 flex items-center justify-center gap-1.5">
                <i data-lucide="siren" class="w-4 h-4 text-red-600" aria-hidden="true"></i> Darurat Medis?
            </p>
            <p class="text-red-700">Hubungi IGD 24 Jam: <a href="tel:+62274123456" class="font-bold underline">+62 274-123-456</a></p>
        </div>
    </div>
</section>
@endsection
