@extends('layouts.public')

@section('title', $service['name'] . ' — RSU Rajawali Citra')
@section('meta_description', $service['name'] . ' di RSU Rajawali Citra, Bantul, Yogyakarta. ' . $service['short'])
@section('og_title', $service['name'] . ' — RSU Rajawali Citra')

@section('content')

@php
$colorMap = ['red'=>'#dc2626','blue'=>'#2563eb','green'=>'#16a34a','purple'=>'#7c3aed','cyan'=>'#0891b2','orange'=>'#d97706','teal'=>'#0f766e','pink'=>'#be185d'];
$clr = $colorMap[$service['color']] ?? '#2563eb';
@endphp

{{-- Page Hero --}}
<section class="page-hero" aria-label="{{ $service['name'] }}">
    <div class="container-xl">
        <nav class="breadcrumb mb-4" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <a href="{{ route('services') }}">Layanan</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <span aria-current="page">{{ $service['name'] }}</span>
        </nav>

        <div class="flex flex-col sm:flex-row items-start gap-4 sm:gap-6">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center shrink-0 border-2" style="background-color: {{ $clr }}15; border-color: {{ $clr }}25">
                <i data-lucide="{{ $service['icon'] }}" class="w-8 h-8" style="color: {{ $clr }}" aria-hidden="true"></i>
            </div>
            <div>
                <h1 class="text-2xl sm:text-4xl font-black text-slate-900 leading-tight mb-2">{{ $service['name'] }}</h1>
                <div class="flex flex-wrap gap-2.5 mb-3 text-xs">
                    <span class="inline-flex items-center gap-1.5 font-bold px-3 py-1 rounded-full" style="background-color: {{ $clr }}12; color: {{ $clr }}">
                        <i data-lucide="clock" class="w-3.5 h-3.5" aria-hidden="true"></i>
                        <span>{{ $service['hours'] }}</span>
                    </span>
                    <span class="inline-flex items-center gap-1.5 font-semibold text-slate-600 bg-white border border-slate-200 px-3 py-1 rounded-full">
                        <i data-lucide="map-pin" class="w-3.5 h-3.5 text-slate-400" aria-hidden="true"></i>
                        <span>{{ $service['location'] }}</span>
                    </span>
                </div>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed max-w-2xl">{{ $service['short'] }}</p>
            </div>
        </div>
    </div>
</section>

{{-- Main Content --}}
<section class="section bg-white" aria-label="Detail Layanan">
    <div class="container-xl">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">

            {{-- Left: Main Description --}}
            <article class="lg:col-span-8 space-y-6">
                <div>
                    <h2 class="text-lg sm:text-xl font-extrabold text-slate-900 mb-3 pb-2 border-b-2" style="border-bottom-color: {{ $clr }}">
                        Tentang Layanan Ini
                    </h2>
                    <p class="text-sm sm:text-base text-slate-600 leading-relaxed">{{ $service['description'] }}</p>
                </div>

                <div>
                    <h3 class="text-base sm:text-lg font-bold text-slate-900 mb-4">Fitur &amp; Layanan yang Tersedia</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach ($service['features'] as $feature)
                        <div class="flex items-center gap-3 p-3.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm font-medium text-slate-800">
                            <div class="w-6 h-6 rounded-full flex items-center justify-center shrink-0" style="background-color: {{ $clr }}15">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="{{ $clr }}" class="w-3.5 h-3.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            </div>
                            <span>{{ $feature }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- CTA Box --}}
                <div class="rounded-2xl p-6 text-center text-white space-y-4 shadow-md" style="background: linear-gradient(135deg, var(--color-primary) 0%, {{ $clr }} 100%)">
                    <h3 class="text-lg font-extrabold text-white">Butuh Layanan Ini?</h3>
                    <p class="text-xs sm:text-sm text-white/80 max-w-md mx-auto leading-relaxed">
                        Hubungi kami sekarang untuk informasi pendaftaran, atau langsung buat janji temu online.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center gap-3 pt-1">
                        <a href="{{ route('contact') }}#appointment" class="btn bg-white text-blue-900 hover:bg-slate-100 font-bold">
                            Buat Janji Temu
                        </a>
                        <a href="tel:+62274123456" class="btn btn-outline-white">
                            Telepon: +62 274-123-456
                        </a>
                    </div>
                </div>
            </article>

            {{-- Right Sidebar --}}
            <aside class="lg:col-span-4 space-y-4">
                <div class="card p-5 bg-white space-y-4">
                    <h3 class="text-xs font-extrabold text-slate-900 uppercase tracking-wider">Informasi Layanan</h3>
                    <div class="space-y-3.5 text-xs sm:text-sm">
                        <div class="flex gap-3 items-start">
                            <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0" style="background-color: {{ $clr }}12">
                                <i data-lucide="clock" class="w-4 h-4" style="color: {{ $clr }}" aria-hidden="true"></i>
                            </div>
                            <div>
                                <div class="text-[11px] font-bold text-slate-400">Jam Operasional</div>
                                <div class="font-bold text-slate-900">{{ $service['hours'] }}</div>
                            </div>
                        </div>
                        <div class="flex gap-3 items-start">
                            <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0" style="background-color: {{ $clr }}12">
                                <i data-lucide="map-pin" class="w-4 h-4" style="color: {{ $clr }}" aria-hidden="true"></i>
                            </div>
                            <div>
                                <div class="text-[11px] font-bold text-slate-400">Lokasi Gedung</div>
                                <div class="font-bold text-slate-900">{{ $service['location'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card p-5 bg-white space-y-3">
                    <h3 class="text-xs font-extrabold text-slate-900 uppercase tracking-wider">Hubungi RS</h3>
                    <a href="tel:+62274123456" class="btn btn-primary btn-sm w-full justify-center">
                        <i data-lucide="phone" class="w-4 h-4" aria-hidden="true"></i>
                        <span>+62 274-123-456</span>
                    </a>
                    <a href="https://wa.me/628213431353" target="_blank" rel="noopener" class="btn btn-outline btn-sm w-full justify-center">
                        <i data-lucide="message-square" class="w-4 h-4" aria-hidden="true"></i>
                        <span>WhatsApp CS</span>
                    </a>
                </div>

                <div class="card p-5 bg-white space-y-3">
                    <h3 class="text-xs font-extrabold text-slate-900 uppercase tracking-wider">Jaminan Diterima</h3>
                    <div class="space-y-2 text-xs text-slate-700">
                        @foreach (['BPJS Kesehatan','Asuransi Swasta / Korporat','Pasien Umum / Tunai'] as $j)
                        <div class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="#16a34a" class="w-4 h-4 shrink-0" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            <span>{{ $j }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>

        <div class="mt-10 pt-6 border-t border-slate-200">
            <a href="{{ route('services') }}" class="inline-flex items-center gap-2 text-xs sm:text-sm font-bold text-blue-900 hover:underline">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                <span>Kembali ke Semua Layanan</span>
            </a>
        </div>
    </div>
</section>

@endsection
