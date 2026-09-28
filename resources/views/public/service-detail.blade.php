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
        <nav class="breadcrumb" aria-label="Breadcrumb" style="margin-bottom:1.5rem;">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <a href="{{ route('services') }}">Layanan</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <span aria-current="page">{{ $service['name'] }}</span>
        </nav>
        <div style="display:flex;align-items:flex-start;gap:1.25rem;flex-wrap:wrap;">
            <div style="width:64px;height:64px;border-radius:16px;background:{{ $clr }}15;display:flex;align-items:center;justify-content:center;flex-shrink:0;border:2px solid {{ $clr }}25;">
                <i data-lucide="{{ $service['icon'] }}" style="width:32px;height:32px;color:{{ $clr }};" aria-hidden="true"></i>
            </div>
            <div>
                <h1 style="font-size:clamp(1.75rem,4vw,2.75rem);font-weight:900;color:var(--color-text-primary);margin-bottom:.625rem;line-height:1.2;">{{ $service['name'] }}</h1>
                <div style="display:flex;flex-wrap:wrap;gap:.75rem;margin-bottom:.875rem;">
                    <span style="display:inline-flex;align-items:center;gap:.375rem;font-size:.8125rem;font-weight:700;color:{{ $clr }};background:{{ $clr }}12;padding:.35rem .875rem;border-radius:100px;">
                        <i data-lucide="clock" style="width:14px;height:14px;" aria-hidden="true"></i>
                        {{ $service['hours'] }}
                    </span>
                    <span style="display:inline-flex;align-items:center;gap:.375rem;font-size:.8125rem;font-weight:700;color:var(--color-text-secondary);background:var(--color-bg);border:1px solid var(--color-border);padding:.35rem .875rem;border-radius:100px;">
                        <i data-lucide="map-pin" style="width:14px;height:14px;" aria-hidden="true"></i>
                        {{ $service['location'] }}
                    </span>
                </div>
                <p style="font-size:1.0625rem;color:var(--color-text-secondary);line-height:1.75;max-width:620px;">{{ $service['short'] }}</p>
            </div>
        </div>
    </div>
</section>

{{-- Main Content --}}
<section style="background:var(--color-surface);padding:3rem 0;" aria-label="Detail Layanan">
    <div class="container-xl">
        <div style="display:grid;grid-template-columns:2fr 1fr;gap:3rem;align-items:start;flex-wrap:wrap;">

            {{-- Left: Description --}}
            <article>
                <h2 style="font-size:1.25rem;font-weight:800;color:var(--color-text-primary);margin-bottom:1.25rem;padding-bottom:.875rem;border-bottom:2px solid {{ $clr }};">Tentang Layanan Ini</h2>
                <p style="font-size:1rem;color:var(--color-text-secondary);line-height:1.85;margin-bottom:2rem;">{{ $service['description'] }}</p>

                <h3 style="font-size:1.0625rem;font-weight:800;color:var(--color-text-primary);margin-bottom:1rem;">Fitur & Layanan yang Tersedia</h3>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;margin-bottom:2.5rem;">
                    @foreach ($service['features'] as $feature)
                    <div style="display:flex;align-items:center;gap:.625rem;padding:1rem 1.125rem;background:var(--color-bg);border:1px solid var(--color-border);border-radius:var(--radius-md);">
                        <div style="width:24px;height:24px;border-radius:50%;background:{{ $clr }}15;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="{{ $clr }}" width="12" height="12" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        </div>
                        <span style="font-size:.875rem;color:var(--color-text-primary);font-weight:500;">{{ $feature }}</span>
                    </div>
                    @endforeach
                </div>

                {{-- CTA --}}
                <div style="background:linear-gradient(135deg,var(--color-primary) 0%,{{ $clr }} 100%);border-radius:var(--radius-xl);padding:2rem;text-align:center;">
                    <h3 style="font-size:1rem;font-weight:800;color:#fff;margin-bottom:.5rem;">Butuh Layanan Ini?</h3>
                    <p style="font-size:.875rem;color:rgba(255,255,255,.8);margin-bottom:1.25rem;">Hubungi kami sekarang untuk informasi lebih lanjut atau buat janji temu.</p>
                    <div style="display:flex;flex-wrap:wrap;gap:.75rem;justify-content:center;">
                        <a href="{{ route('contact') }}#appointment" class="btn" style="background:#fff;color:var(--color-primary);">Buat Janji Temu</a>
                        <a href="tel:+62274123456" class="btn btn-outline-white">Telepon: +62 274-123-456</a>
                    </div>
                </div>
            </article>

            {{-- Right: Info Sidebar --}}
            <aside>
                <div class="card" style="padding:1.5rem;margin-bottom:1.25rem;">
                    <h3 style="font-size:.875rem;font-weight:800;color:var(--color-text-primary);text-transform:uppercase;letter-spacing:.05em;margin-bottom:1rem;">Informasi Layanan</h3>
                    <div style="display:flex;flex-direction:column;gap:1rem;">
                        <div style="display:flex;gap:.75rem;align-items:flex-start;">
                            <div style="width:36px;height:36px;border-radius:8px;background:{{ $clr }}12;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i data-lucide="clock" style="width:18px;height:18px;color:{{ $clr }};" aria-hidden="true"></i>
                            </div>
                            <div>
                                <div style="font-size:.75rem;font-weight:700;color:var(--color-text-muted);margin-bottom:.125rem;">Jam Operasional</div>
                                <div style="font-size:.9rem;font-weight:600;color:var(--color-text-primary);">{{ $service['hours'] }}</div>
                            </div>
                        </div>
                        <div style="display:flex;gap:.75rem;align-items:flex-start;">
                            <div style="width:36px;height:36px;border-radius:8px;background:{{ $clr }}12;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i data-lucide="map-pin" style="width:18px;height:18px;color:{{ $clr }};" aria-hidden="true"></i>
                            </div>
                            <div>
                                <div style="font-size:.75rem;font-weight:700;color:var(--color-text-muted);margin-bottom:.125rem;">Lokasi</div>
                                <div style="font-size:.9rem;font-weight:600;color:var(--color-text-primary);">{{ $service['location'] }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card" style="padding:1.5rem;margin-bottom:1.25rem;">
                    <h3 style="font-size:.875rem;font-weight:800;color:var(--color-text-primary);text-transform:uppercase;letter-spacing:.05em;margin-bottom:1rem;">Hubungi Kami</h3>
                    <div style="display:flex;flex-direction:column;gap:.75rem;">
                        <a href="tel:+62274123456" class="btn btn-primary btn-sm" style="justify-content:center;">
                            <i data-lucide="phone" style="width:16px;height:16px;" aria-hidden="true"></i>
                            +62 274-123-456
                        </a>
                        <a href="https://wa.me/628213431353" target="_blank" rel="noopener" class="btn btn-outline btn-sm" style="justify-content:center;">
                            <i data-lucide="message-circle" style="width:16px;height:16px;" aria-hidden="true"></i>
                            WhatsApp
                        </a>
                    </div>
                </div>

                <div class="card" style="padding:1.5rem;">
                    <h3 style="font-size:.875rem;font-weight:800;color:var(--color-text-primary);text-transform:uppercase;letter-spacing:.05em;margin-bottom:1rem;">Jaminan Diterima</h3>
                    <div style="display:flex;flex-direction:column;gap:.5rem;">
                        @foreach (['BPJS Kesehatan','Asuransi Swasta','Umum / Tunai'] as $j)
                        <div style="display:flex;align-items:center;gap:.5rem;font-size:.875rem;color:var(--color-text-secondary);">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="#16a34a" width="14" height="14" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            {{ $j }}
                        </div>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>

        <div style="margin-top:2.5rem;padding-top:2.5rem;border-top:1px solid var(--color-border);">
            <a href="{{ route('services') }}" style="display:inline-flex;align-items:center;gap:.5rem;font-size:.875rem;color:var(--color-primary);text-decoration:none;font-weight:600;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="18" height="18" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                Kembali ke Semua Layanan
            </a>
        </div>
    </div>
</section>

@endsection
