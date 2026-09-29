@extends('layouts.public')
@section('title', 'Berita Terbaru — RSU Rajawali Citra')
@section('meta_description', 'Berita terkini dari RSU Rajawali Citra: pengumuman, informasi program layanan, kegiatan, dan perkembangan terbaru rumah sakit.')
@section('content')

<section class="page-hero">
    <div class="container-xl">
        <nav class="breadcrumb mb-4" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <a href="{{ route('information') }}">Informasi</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <span aria-current="page">Berita</span>
        </nav>
        <span class="section-label">Berita Terbaru</span>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 mt-2 mb-4 leading-tight">
            Berita &amp; Pengumuman RS
        </h1>
        <p class="text-base sm:text-lg text-slate-600 max-w-2xl leading-relaxed">
            Informasi terkini seputar RSU Rajawali Citra, program layanan, dan kegiatan rumah sakit.
        </p>
    </div>
</section>

<section class="section bg-white">
    <div class="container-xl">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @php $colorMap = ['blue'=>'#2563eb','green'=>'#16a34a','orange'=>'#d97706']; @endphp
            @foreach ($news as $item)
            @php $clr = $colorMap[$item['color']] ?? '#2563eb'; @endphp
            <article class="card flex flex-col h-full">
                <div class="p-4 border-b border-slate-100 flex items-center justify-between">
                    <span class="badge badge-{{ $item['color'] }}">{{ $item['category'] }}</span>
                    <time class="text-xs text-slate-400" datetime="{{ $item['date'] }}">{{ $item['date'] }}</time>
                </div>
                <div class="p-5 flex flex-col flex-1">
                    <h2 class="text-base font-bold text-slate-900 mb-2 leading-snug">
                        <a href="{{ route('news.detail', $item['slug']) }}" class="hover:text-blue-900 transition no-underline">
                            {{ $item['title'] }}
                        </a>
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4 flex-1">{{ $item['excerpt'] }}</p>
                    <a href="{{ route('news.detail', $item['slug']) }}" class="text-xs font-bold no-underline mt-auto" style="color: {{ $clr }}">
                        Baca Selengkapnya &rarr;
                    </a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endsection
