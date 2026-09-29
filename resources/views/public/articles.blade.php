@extends('layouts.public')
@section('title', 'Artikel Kesehatan — RSU Rajawali Citra')
@section('meta_description', 'Artikel kesehatan dari para dokter spesialis RSU Rajawali Citra. Tips kesehatan, informasi penyakit, panduan hidup sehat, dan edukasi medis terpercaya.')
@section('content')

<section class="page-hero">
    <div class="container-xl">
        <nav class="breadcrumb mb-4" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <a href="{{ route('information') }}">Informasi</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <span aria-current="page">Artikel</span>
        </nav>
        <span class="section-label">Edukasi Kesehatan</span>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 mt-2 mb-4 leading-tight">
            Artikel &amp; Tips Kesehatan
        </h1>
        <p class="text-base sm:text-lg text-slate-600 max-w-2xl leading-relaxed">
            Ditulis oleh para dokter spesialis RSU Rajawali Citra untuk membantu Anda memahami kesehatan dengan lebih baik.
        </p>
    </div>
</section>

<section class="section bg-white">
    <div class="container-xl">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @php $colorMap = ['red'=>'#dc2626','blue'=>'#2563eb','green'=>'#16a34a','orange'=>'#d97706']; @endphp
            @foreach ($articles as $article)
            @php $clr = $colorMap[$article['color']] ?? '#2563eb'; @endphp
            <article class="card flex flex-col h-full overflow-hidden">
                <div class="p-4 border-b border-slate-100" style="background-color: {{ $clr }}0d">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-extrabold uppercase tracking-wide" style="background-color: {{ $clr }}1a; color: {{ $clr }}">
                        {{ $article['category'] }}
                    </span>
                </div>
                <div class="p-5 flex flex-col flex-1">
                    <h2 class="text-base font-bold text-slate-900 mb-2 leading-snug">
                        <a href="{{ route('articles.detail', $article['slug']) }}" class="hover:text-blue-900 transition no-underline">
                            {{ $article['title'] }}
                        </a>
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4 flex-1">{{ $article['excerpt'] }}</p>
                    <div class="flex items-center justify-between text-xs text-slate-400 mt-auto pt-3 border-t border-slate-100">
                        <span class="font-semibold">{{ $article['author'] }}</span>
                        <time datetime="{{ $article['date'] }}">{{ $article['date'] }}</time>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endsection
