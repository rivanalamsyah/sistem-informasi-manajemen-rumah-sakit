@extends('layouts.public')
@section('title', $news['title'] . ' — RSU Rajawali Citra')
@section('meta_description', $news['excerpt'])
@section('content')

@php $colorMap = ['blue'=>'#2563eb','green'=>'#16a34a','orange'=>'#d97706']; @endphp
@php $clr = $colorMap[$news['color']] ?? '#2563eb'; @endphp

<section class="page-hero">
    <div class="container-xl">
        <nav class="breadcrumb mb-4" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <a href="{{ route('news') }}">Berita</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <span aria-current="page">Detail</span>
        </nav>
        <span class="badge badge-{{ $news['color'] }} mb-3">{{ $news['category'] }}</span>
        <h1 class="text-2xl sm:text-4xl font-black text-slate-900 leading-tight mb-3 max-w-3xl">{{ $news['title'] }}</h1>
        <div class="flex items-center gap-3 text-xs text-slate-400">
            <time datetime="{{ $news['date'] }}">{{ $news['date'] }}</time>
        </div>
    </div>
</section>

<section class="section bg-white">
    <div class="container-xl">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            <article class="lg:col-span-8 space-y-6">
                <div class="p-5 rounded-2xl border text-sm italic leading-relaxed text-slate-700" style="background-color: {{ $clr }}08; border-color: {{ $clr }}20">
                    {{ $news['excerpt'] }}
                </div>
                <div class="text-sm sm:text-base text-slate-600 leading-relaxed space-y-4">
                    <p>{{ $news['content'] }}</p>
                    <p>RSU Rajawali Citra terus berkomitmen untuk meningkatkan kualitas pelayanan dan memberikan informasi yang bermanfaat bagi masyarakat. Untuk informasi lebih lanjut, silakan hubungi kami melalui nomor telepon atau WhatsApp yang tersedia.</p>
                    <p>Kami mengundang seluruh masyarakat untuk terus memperhatikan kesehatan dan tidak ragu untuk berkunjung ke RSU Rajawali Citra untuk mendapatkan pelayanan medis terbaik.</p>
                </div>
                <div class="pt-6 border-t border-slate-200">
                    <a href="{{ route('news') }}" class="inline-flex items-center gap-2 text-xs sm:text-sm font-bold text-blue-900 hover:underline">
                        <span>&larr; Kembali ke Daftar Berita</span>
                    </a>
                </div>
            </article>

            <aside class="lg:col-span-4 space-y-4">
                <div class="card p-5 bg-white space-y-3">
                    <h3 class="text-xs font-extrabold text-slate-900 uppercase tracking-wider">Hubungi RS</h3>
                    <a href="tel:+62274123456" class="btn btn-primary btn-sm w-full justify-center">Telepon RS</a>
                    <a href="https://wa.me/628213431353" target="_blank" rel="noopener" class="btn btn-outline btn-sm w-full justify-center">WhatsApp CS</a>
                    <a href="{{ route('contact') }}#appointment" class="btn btn-accent btn-sm w-full justify-center">Buat Janji Temu</a>
                </div>
                <div class="card p-5 bg-white space-y-3">
                    <h3 class="text-xs font-extrabold text-slate-900 uppercase tracking-wider">Menu Cepat</h3>
                    <nav class="space-y-2 text-xs font-semibold">
                        <a href="{{ route('services') }}" class="block text-slate-700 hover:text-blue-900 py-1 border-b border-slate-100">Layanan Kesehatan &rarr;</a>
                        <a href="{{ route('doctors') }}" class="block text-slate-700 hover:text-blue-900 py-1 border-b border-slate-100">Dokter &amp; Jadwal &rarr;</a>
                        <a href="{{ route('information') }}" class="block text-slate-700 hover:text-blue-900 py-1">Pusat Informasi &rarr;</a>
                    </nav>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
