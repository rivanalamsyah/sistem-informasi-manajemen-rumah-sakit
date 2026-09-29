@extends('layouts.public')

@section('title', 'Halaman Tidak Ditemukan — RSU Rajawali Citra')
@section('meta_description', 'Halaman yang Anda cari tidak ditemukan di RSU Rajawali Citra.')

@section('content')
<section class="min-h-[calc(100vh-140px)] flex items-center justify-center py-16 px-4 bg-gradient-to-br from-blue-50/80 via-slate-50 to-cyan-50/60" aria-label="Halaman Tidak Ditemukan">
    <div class="text-center max-w-md mx-auto space-y-4">
        <div class="text-7xl sm:text-8xl font-black text-blue-900/15 leading-none -mb-4 select-none" aria-hidden="true">404</div>
        
        <div class="w-20 h-20 rounded-full bg-blue-900/10 flex items-center justify-center mx-auto mb-2 text-blue-900">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
            </svg>
        </div>

        <h1 class="text-2xl sm:text-3xl font-black text-slate-900">Halaman Tidak Ditemukan</h1>
        <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
            Maaf, halaman yang Anda cari tidak tersedia, telah dipindahkan, atau alamat URL yang Anda masukkan salah.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-3 pt-2">
            <a href="{{ route('home') }}" class="btn btn-primary w-full sm:w-auto">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                </svg>
                <span>Kembali ke Beranda</span>
            </a>
            <a href="{{ route('contact') }}" class="btn btn-outline w-full sm:w-auto">Hubungi Kami</a>
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
