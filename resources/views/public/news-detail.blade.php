@extends('layouts.public')
@section('title', $news['title'] . ' — RSU Rajawali Citra')
@section('meta_description', $news['excerpt'])
@section('content')

@php $colorMap = ['blue'=>'#2563eb','green'=>'#16a34a','orange'=>'#d97706']; @endphp
@php $clr = $colorMap[$news['color']] ?? '#2563eb'; @endphp

<section class="page-hero">
    <div class="container-xl">
        <nav class="breadcrumb" aria-label="Breadcrumb" style="margin-bottom:1.5rem;">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <a href="{{ route('news') }}">Berita</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <span aria-current="page">Detail</span>
        </nav>
        <span class="badge badge-{{ $news['color'] }}" style="margin-bottom:1rem;">{{ $news['category'] }}</span>
        <h1 style="font-size:clamp(1.75rem,4vw,2.75rem);font-weight:900;color:var(--color-text-primary);margin-top:.5rem;margin-bottom:1rem;line-height:1.25;max-width:760px;">{{ $news['title'] }}</h1>
        <div style="display:flex;align-items:center;gap:1rem;flex-wrap:wrap;">
            <time style="font-size:.875rem;color:var(--color-text-muted);" datetime="{{ $news['date'] }}">{{ $news['date'] }}</time>
        </div>
    </div>
</section>

<section style="background:var(--color-surface);padding:3rem 0;">
    <div class="container-xl">
        <div style="display:grid;grid-template-columns:2fr 1fr;gap:3rem;align-items:start;flex-wrap:wrap;">
            <article>
                <div style="background:{{ $clr }}08;border:1px solid {{ $clr }}20;border-radius:var(--radius-lg);padding:1.5rem;margin-bottom:2rem;">
                    <p style="font-size:1rem;color:var(--color-text-secondary);line-height:1.8;font-style:italic;">{{ $news['excerpt'] }}</p>
                </div>
                <div style="font-size:.9375rem;color:var(--color-text-secondary);line-height:1.9;">
                    <p>{{ $news['excerpt'] }}</p>
                    <br>
                    <p>RSU Rajawali Citra terus berkomitmen untuk meningkatkan kualitas pelayanan dan memberikan informasi yang bermanfaat bagi masyarakat. Untuk informasi lebih lanjut, silakan hubungi kami melalui nomor telepon atau WhatsApp yang tersedia.</p>
                    <br>
                    <p>Kami mengundang seluruh masyarakat untuk terus memperhatikan kesehatan dan tidak ragu untuk berkunjung ke RSU Rajawali Citra untuk mendapatkan pelayanan medis terbaik.</p>
                </div>
                <div style="margin-top:2.5rem;padding-top:2rem;border-top:1px solid var(--color-border);">
                    <a href="{{ route('news') }}" style="display:inline-flex;align-items:center;gap:.5rem;font-size:.875rem;color:var(--color-primary);text-decoration:none;font-weight:600;">
                        ← Kembali ke Daftar Berita
                    </a>
                </div>
            </article>
            <aside>
                <div class="card" style="padding:1.5rem;margin-bottom:1.25rem;">
                    <h3 style="font-size:.875rem;font-weight:800;color:var(--color-text-primary);text-transform:uppercase;letter-spacing:.05em;margin-bottom:1rem;">Hubungi Kami</h3>
                    <div style="display:flex;flex-direction:column;gap:.75rem;">
                        <a href="tel:+62274123456" class="btn btn-primary btn-sm" style="justify-content:center;">Telepon RS</a>
                        <a href="https://wa.me/628213431353" target="_blank" rel="noopener" class="btn btn-outline btn-sm" style="justify-content:center;">WhatsApp</a>
                        <a href="{{ route('contact') }}#appointment" class="btn btn-accent btn-sm" style="justify-content:center;">Buat Janji Temu</a>
                    </div>
                </div>
                <div class="card" style="padding:1.5rem;">
                    <h3 style="font-size:.875rem;font-weight:800;color:var(--color-text-primary);text-transform:uppercase;letter-spacing:.05em;margin-bottom:1rem;">Menu Cepat</h3>
                    <nav>
                        <a href="{{ route('services') }}" class="footer-link" style="display:block;color:var(--color-text-secondary);text-decoration:none;padding:.375rem 0;font-size:.875rem;border-bottom:1px solid var(--color-border);">Layanan Kesehatan</a>
                        <a href="{{ route('doctors') }}" class="footer-link" style="display:block;color:var(--color-text-secondary);text-decoration:none;padding:.375rem 0;font-size:.875rem;border-bottom:1px solid var(--color-border);">Dokter & Jadwal</a>
                        <a href="{{ route('information') }}" class="footer-link" style="display:block;color:var(--color-text-secondary);text-decoration:none;padding:.375rem 0;font-size:.875rem;">Informasi & Berita</a>
                    </nav>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
