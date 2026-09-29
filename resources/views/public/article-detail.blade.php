@extends('layouts.public')
@section('title', $article['title'] . ' — RSU Rajawali Citra')
@section('meta_description', $article['excerpt'])
@section('content')

@php $colorMap = ['red'=>'#dc2626','blue'=>'#2563eb','green'=>'#16a34a','orange'=>'#d97706']; @endphp
@php $clr = $colorMap[$article['color']] ?? '#2563eb'; @endphp

<section class="page-hero">
    <div class="container-xl">
        <nav class="breadcrumb mb-4" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <a href="{{ route('articles') }}">Artikel</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <span aria-current="page">Detail</span>
        </nav>
        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-extrabold uppercase tracking-wide mb-3" style="background-color: {{ $clr }}15; color: {{ $clr }}">
            {{ $article['category'] }}
        </span>
        <h1 class="text-2xl sm:text-4xl font-black text-slate-900 leading-tight mb-3 max-w-3xl">{{ $article['title'] }}</h1>
        <div class="flex items-center gap-3 text-xs text-slate-400">
            <span class="inline-flex items-center gap-1.5 font-medium"><i data-lucide="user" class="w-3.5 h-3.5" aria-hidden="true"></i> {{ $article['author'] }}</span>
            <span>•</span>
            <time datetime="{{ $article['date'] }}">{{ $article['date'] }}</time>
        </div>
    </div>
</section>

<section class="section bg-white">
    <div class="container-xl">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            <article class="lg:col-span-8 space-y-6">
                <div class="p-5 rounded-2xl border text-sm italic leading-relaxed text-slate-700" style="background-color: {{ $clr }}08; border-color: {{ $clr }}20">
                    {{ $article['excerpt'] }}
                </div>
                <div class="text-sm sm:text-base text-slate-600 leading-relaxed space-y-4">
                    <p>{{ $article['content'] }}</p>
                    <h2 class="text-base sm:text-lg font-extrabold text-slate-900 pt-2">Penjelasan Medis &amp; Pencegahan</h2>
                    <p>Artikel ini disusun oleh tim dokter spesialis RSU Rajawali Citra untuk memberikan edukasi kesehatan yang akurat dan terpercaya. Informasi dalam artikel ini bersifat edukatif dan tidak menggantikan konsultasi medis langsung.</p>
                    <p>Jika Anda mengalami gejala atau kondisi yang dibahas dalam artikel ini, segera konsultasikan ke dokter untuk mendapatkan diagnosis dan penanganan medis yang tepat.</p>
                </div>

                {{-- Author Box --}}
                <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 flex items-center gap-3.5">
                    <div class="w-11 h-11 rounded-full flex items-center justify-center font-black text-sm shrink-0" style="background-color: {{ $clr }}15; color: {{ $clr }}">
                        {{ substr($article['author'], 3, 2) }}
                    </div>
                    <div>
                        <div class="text-sm font-extrabold text-slate-900">{{ $article['author'] }}</div>
                        <div class="text-xs text-slate-500">Dokter Spesialis — RSU Rajawali Citra</div>
                    </div>
                </div>

                <div class="pt-6 border-t border-slate-200">
                    <a href="{{ route('articles') }}" class="inline-flex items-center gap-2 text-xs sm:text-sm font-bold text-blue-900 hover:underline">
                        <span>&larr; Kembali ke Daftar Artikel</span>
                    </a>
                </div>
            </article>

            <aside class="lg:col-span-4 space-y-4">
                <div class="card p-5 space-y-3" style="background-color: {{ $clr }}06; border-color: {{ $clr }}20">
                    <h3 class="text-sm font-extrabold text-slate-900">Perlu Konsultasi Dokter?</h3>
                    <p class="text-xs text-slate-600 leading-relaxed">Jangan tunda kesehatan Anda. Buat janji temu dengan dokter spesialis kami.</p>
                    <a href="{{ route('contact') }}#appointment" class="btn btn-primary btn-sm w-full justify-center">Buat Janji Temu</a>
                    <a href="{{ route('doctors') }}" class="btn btn-outline btn-sm w-full justify-center">Cari Dokter</a>
                </div>
                <div class="card p-5 bg-white space-y-3">
                    <h3 class="text-xs font-extrabold text-slate-900 uppercase tracking-wider">Artikel Terkait</h3>
                    <nav class="space-y-2 text-xs font-semibold">
                        <a href="{{ route('articles') }}" class="block text-blue-900 hover:underline py-1 border-b border-slate-100">Lihat Semua Artikel &rarr;</a>
                        <a href="{{ route('information') }}" class="block text-cyan-700 hover:underline py-1">Pusat Informasi &rarr;</a>
                    </nav>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
