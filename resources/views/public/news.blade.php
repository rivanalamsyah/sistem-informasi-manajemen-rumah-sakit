@extends('layouts.public')
@section('title', 'Berita Terbaru — RSU Rajawali Citra')
@section('meta_description', 'Berita terkini dari RSU Rajawali Citra: pengumuman, informasi program layanan, kegiatan, dan perkembangan terbaru rumah sakit.')
@section('content')

<section class="page-hero">
    <div class="container-xl">
        <nav class="breadcrumb" aria-label="Breadcrumb" style="margin-bottom:1.5rem;">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <a href="{{ route('information') }}">Informasi</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <span aria-current="page">Berita</span>
        </nav>
        <span class="section-label">Berita Terbaru</span>
        <h1 style="font-size:clamp(2rem,4vw,3rem);font-weight:900;color:var(--color-text-primary);margin-top:.75rem;margin-bottom:1rem;">Berita & Pengumuman</h1>
        <p style="font-size:1.0625rem;color:var(--color-text-secondary);max-width:600px;line-height:1.75;">Informasi terkini seputar RSU Rajawali Citra, program layanan, dan kegiatan rumah sakit.</p>
    </div>
</section>

<section class="section" style="background:var(--color-surface);">
    <div class="container-xl">
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1.5rem;">
            @php $colorMap = ['blue'=>'#2563eb','green'=>'#16a34a','orange'=>'#d97706']; @endphp
            @foreach ($news as $item)
            @php $clr = $colorMap[$item['color']] ?? '#2563eb'; @endphp
            <article class="card">
                <div style="padding:1.125rem 1.5rem;border-bottom:1px solid var(--color-border);display:flex;align-items:center;justify-content:space-between;">
                    <span class="badge badge-{{ $item['color'] }}">{{ $item['category'] }}</span>
                    <time style="font-size:.75rem;color:var(--color-text-muted);" datetime="{{ $item['date'] }}">{{ $item['date'] }}</time>
                </div>
                <div style="padding:1.5rem;flex:1;">
                    <h2 style="font-size:1rem;font-weight:700;color:var(--color-text-primary);margin-bottom:.75rem;line-height:1.4;">
                        <a href="{{ route('news.detail', $item['slug']) }}" style="text-decoration:none;color:inherit;">{{ $item['title'] }}</a>
                    </h2>
                    <p style="font-size:.875rem;color:var(--color-text-secondary);line-height:1.7;margin-bottom:1.25rem;">{{ $item['excerpt'] }}</p>
                    <a href="{{ route('news.detail', $item['slug']) }}" style="font-size:.8125rem;font-weight:700;color:{{ $clr }};text-decoration:none;">Baca Selengkapnya →</a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endsection
