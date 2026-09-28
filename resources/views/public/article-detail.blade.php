@extends('layouts.public')
@section('title', $article['title'] . ' — RSU Rajawali Citra')
@section('meta_description', $article['excerpt'])
@section('content')

@php $colorMap = ['red'=>'#dc2626','blue'=>'#2563eb','green'=>'#16a34a','orange'=>'#d97706']; @endphp
@php $clr = $colorMap[$article['color']] ?? '#2563eb'; @endphp

<section class="page-hero">
    <div class="container-xl">
        <nav class="breadcrumb" aria-label="Breadcrumb" style="margin-bottom:1.5rem;">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <a href="{{ route('articles') }}">Artikel</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <span aria-current="page">Detail</span>
        </nav>
        <span style="display:inline-flex;padding:.3rem .875rem;background:{{ $clr }}15;color:{{ $clr }};border-radius:100px;font-size:.75rem;font-weight:700;text-transform:uppercase;letter-spacing:.04em;margin-bottom:1rem;">{{ $article['category'] }}</span>
        <h1 style="font-size:clamp(1.75rem,4vw,2.75rem);font-weight:900;color:var(--color-text-primary);margin-top:.5rem;margin-bottom:1rem;line-height:1.25;max-width:760px;">{{ $article['title'] }}</h1>
        <div style="display:flex;align-items:center;gap:1rem;flex-wrap:wrap;font-size:.875rem;color:var(--color-text-muted);">
            <span style="display:inline-flex;align-items:center;gap:.375rem;"><i data-lucide="user" style="width:14px;height:14px;" aria-hidden="true"></i> {{ $article['author'] }}</span>
            <span>•</span>
            <time datetime="{{ $article['date'] }}">{{ $article['date'] }}</time>
        </div>
    </div>
</section>

<section style="background:var(--color-surface);padding:3rem 0;">
    <div class="container-xl">
        <div style="display:grid;grid-template-columns:2fr 1fr;gap:3rem;align-items:start;flex-wrap:wrap;">
            <article>
                <div style="background:{{ $clr }}08;border:1px solid {{ $clr }}20;border-radius:var(--radius-lg);padding:1.5rem;margin-bottom:2rem;">
                    <p style="font-size:1rem;color:var(--color-text-secondary);line-height:1.8;font-style:italic;">{{ $article['excerpt'] }}</p>
                </div>
                <div style="font-size:.9375rem;color:var(--color-text-secondary);line-height:1.9;">
                    <p>{{ $article['excerpt'] }}</p>
                    <br>
                    <h2 style="font-size:1.125rem;font-weight:800;color:var(--color-text-primary);margin:1.5rem 0 .75rem;">Penjelasan Medis</h2>
                    <p>Artikel ini disusun oleh tim dokter spesialis RSU Rajawali Citra untuk memberikan edukasi kesehatan yang akurat dan terpercaya. Informasi dalam artikel ini bersifat edukatif dan tidak menggantikan konsultasi medis langsung.</p>
                    <br>
                    <p>Jika Anda mengalami gejala atau kondisi yang dibahas dalam artikel ini, segera konsultasikan ke dokter untuk mendapatkan diagnosis dan penanganan yang tepat.</p>
                </div>
                <div style="background:rgba(30,58,95,.04);border:1px solid var(--color-border);border-radius:var(--radius-lg);padding:1.5rem;margin-top:2rem;">
                    <div style="display:flex;gap:.75rem;align-items:center;margin-bottom:.75rem;">
                        <div style="width:40px;height:40px;border-radius:50%;background:{{ $clr }}15;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <span style="font-size:.875rem;font-weight:800;color:{{ $clr }};">{{ substr($article['author'], 3, 2) }}</span>
                        </div>
                        <div>
                            <div style="font-size:.875rem;font-weight:700;color:var(--color-text-primary);">{{ $article['author'] }}</div>
                            <div style="font-size:.75rem;color:var(--color-text-muted);">Dokter Spesialis RSU Rajawali Citra</div>
                        </div>
                    </div>
                </div>
                <div style="margin-top:2.5rem;padding-top:2rem;border-top:1px solid var(--color-border);">
                    <a href="{{ route('articles') }}" style="display:inline-flex;align-items:center;gap:.5rem;font-size:.875rem;color:var(--color-primary);text-decoration:none;font-weight:600;">
                        ← Kembali ke Daftar Artikel
                    </a>
                </div>
            </article>
            <aside>
                <div class="card" style="padding:1.5rem;margin-bottom:1.25rem;background:{{ $clr }}06;border-color:{{ $clr }}25;">
                    <h3 style="font-size:.875rem;font-weight:800;color:var(--color-text-primary);margin-bottom:.5rem;">Perlu Konsultasi Dokter?</h3>
                    <p style="font-size:.8125rem;color:var(--color-text-secondary);line-height:1.65;margin-bottom:1rem;">Jangan tunda kesehatan Anda. Buat janji temu dengan dokter spesialis kami.</p>
                    <a href="{{ route('contact') }}#appointment" class="btn btn-primary btn-sm" style="width:100%;justify-content:center;margin-bottom:.75rem;">Buat Janji Temu</a>
                    <a href="{{ route('doctors') }}" class="btn btn-outline btn-sm" style="width:100%;justify-content:center;">Cari Dokter</a>
                </div>
                <div class="card" style="padding:1.5rem;">
                    <h3 style="font-size:.875rem;font-weight:800;color:var(--color-text-primary);text-transform:uppercase;letter-spacing:.05em;margin-bottom:1rem;">Artikel Terkait</h3>
                    <nav>
                        <a href="{{ route('articles') }}" style="display:block;color:var(--color-primary);text-decoration:none;font-size:.875rem;font-weight:600;padding:.375rem 0;border-bottom:1px solid var(--color-border);">Lihat Semua Artikel →</a>
                        <a href="{{ route('information') }}" style="display:block;color:var(--color-accent);text-decoration:none;font-size:.875rem;font-weight:600;padding:.375rem 0;">Pusat Informasi →</a>
                    </nav>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
