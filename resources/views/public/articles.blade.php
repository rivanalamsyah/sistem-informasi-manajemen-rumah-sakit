@extends('layouts.public')
@section('title', 'Artikel Kesehatan — RSU Rajawali Citra')
@section('meta_description', 'Artikel kesehatan dari para dokter spesialis RSU Rajawali Citra. Tips kesehatan, informasi penyakit, panduan hidup sehat, dan edukasi medis terpercaya.')
@section('content')

<section class="page-hero">
    <div class="container-xl">
        <nav class="breadcrumb" aria-label="Breadcrumb" style="margin-bottom:1.5rem;">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <a href="{{ route('information') }}">Informasi</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <span aria-current="page">Artikel</span>
        </nav>
        <span class="section-label">Edukasi Kesehatan</span>
        <h1 style="font-size:clamp(2rem,4vw,3rem);font-weight:900;color:var(--color-text-primary);margin-top:.75rem;margin-bottom:1rem;">Artikel & Tips Kesehatan</h1>
        <p style="font-size:1.0625rem;color:var(--color-text-secondary);max-width:600px;line-height:1.75;">Ditulis oleh para dokter spesialis RSU Rajawali Citra untuk membantu Anda memahami kesehatan dengan lebih baik.</p>
    </div>
</section>

<section class="section" style="background:var(--color-surface);">
    <div class="container-xl">
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1.5rem;">
            @php $colorMap = ['red'=>'#dc2626','blue'=>'#2563eb','green'=>'#16a34a','orange'=>'#d97706']; @endphp
            @foreach ($articles as $article)
            @php $clr = $colorMap[$article['color']] ?? '#2563eb'; @endphp
            <article class="card" style="overflow:hidden;">
                <div style="background:{{ $clr }}10;padding:1.25rem 1.5rem;border-bottom:1px solid {{ $clr }}20;">
                    <span style="display:inline-flex;padding:.25rem .75rem;background:{{ $clr }}15;color:{{ $clr }};border-radius:100px;font-size:.6875rem;font-weight:700;text-transform:uppercase;letter-spacing:.04em;">{{ $article['category'] }}</span>
                </div>
                <div style="padding:1.5rem;">
                    <h2 style="font-size:1rem;font-weight:700;color:var(--color-text-primary);margin-bottom:.625rem;line-height:1.4;">
                        <a href="{{ route('articles.detail', $article['slug']) }}" style="text-decoration:none;color:inherit;">{{ $article['title'] }}</a>
                    </h2>
                    <p style="font-size:.875rem;color:var(--color-text-secondary);line-height:1.7;margin-bottom:1.25rem;">{{ $article['excerpt'] }}</p>
                    <div style="display:flex;align-items:center;justify-content:space-between;font-size:.75rem;color:var(--color-text-muted);padding-top:.875rem;border-top:1px solid var(--color-border);">
                        <span style="font-weight:600;">{{ $article['author'] }}</span>
                        <time datetime="{{ $article['date'] }}">{{ $article['date'] }}</time>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endsection
