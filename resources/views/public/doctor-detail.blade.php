@extends('layouts.public')

@section('title', $doctor['name'] . ' — ' . $doctor['specialization'])
@section('meta_description', 'Profil ' . $doctor['name'] . ', ' . $doctor['specialization'] . ' di RSU Rajawali Citra. Jadwal praktik, layanan, dan informasi konsultasi.')
@section('og_title', $doctor['name'] . ' — RSU Rajawali Citra')

@push('head')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "Physician",
  "name": "{{ $doctor['name'] }}",
  "medicalSpecialty": "{{ $doctor['specialization'] }}",
  "worksFor": {
    "@type": "Hospital",
    "name": "RSU Rajawali Citra",
    "url": "{{ route('home') }}"
  },
  "url": "{{ url()->current() }}"
}
</script>
@endpush

@section('content')

@php
$colorMap = ['blue'=>'#2563eb','pink'=>'#be185d','green'=>'#16a34a','orange'=>'#d97706','red'=>'#dc2626','purple'=>'#7c3aed'];
$clr = $colorMap[$doctor['color']] ?? '#2563eb';
@endphp

{{-- Page Hero --}}
<section class="page-hero" aria-label="Profil Dokter" style="padding-bottom:3rem;">
    <div class="container-xl">
        <nav class="breadcrumb" aria-label="Breadcrumb" style="margin-bottom:1.5rem;">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <a href="{{ route('doctors') }}">Dokter & Jadwal</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <span aria-current="page">{{ $doctor['name'] }}</span>
        </nav>
    </div>
</section>

<section style="background:var(--color-surface);padding:3rem 0;" aria-label="Profil Dokter">
    <div class="container-xl">
        <div style="display:grid;grid-template-columns:1fr 2fr;gap:3rem;align-items:start;flex-wrap:wrap;">

            {{-- Sidebar --}}
            <aside>
                {{-- Photo / Avatar --}}
                <div class="card" style="padding:2.5rem;text-align:center;margin-bottom:1.5rem;">
                    <div style="width:120px;height:120px;border-radius:50%;background:{{ $clr }}15;display:flex;align-items:center;justify-content:center;margin:0 auto 1.25rem;border:5px solid {{ $clr }}25;">
                        <span style="font-size:2.5rem;font-weight:900;color:{{ $clr }};">{{ $doctor['initials'] }}</span>
                    </div>
                    <h1 style="font-size:1.125rem;font-weight:800;color:var(--color-text-primary);margin-bottom:.375rem;">{{ $doctor['name'] }}</h1>
                    <p style="font-size:.9375rem;font-weight:700;color:{{ $clr }};margin-bottom:.5rem;">{{ $doctor['specialization'] }}</p>
                    <p style="font-size:.8125rem;color:var(--color-text-muted);margin-bottom:1.5rem;">{{ $doctor['polyclinic'] }}</p>
                    <span style="display:inline-flex;align-items:center;gap:.375rem;font-size:.8125rem;font-weight:700;color:#16a34a;background:rgba(22,163,74,.1);padding:.4rem 1rem;border-radius:100px;margin-bottom:1.5rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#16a34a" width="14" height="14" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $doctor['experience'] }} Pengalaman
                    </span>
                    <a href="{{ route('contact') }}#appointment" class="btn btn-primary" style="width:100%;justify-content:center;margin-bottom:.75rem;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="18" height="18" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                        Buat Janji Temu
                    </a>
                    <a href="https://wa.me/628213431353" target="_blank" rel="noopener" class="btn btn-outline" style="width:100%;justify-content:center;">WhatsApp</a>
                </div>

                {{-- Schedule Card --}}
                <div class="card" style="padding:1.5rem;">
                    <h3 style="font-size:.875rem;font-weight:800;color:var(--color-text-primary);text-transform:uppercase;letter-spacing:.05em;margin-bottom:1rem;">Jadwal Praktik</h3>
                    <div style="display:flex;flex-direction:column;gap:.625rem;">
                        @foreach ($doctor['schedule'] as $sched)
                        <div style="display:flex;justify-content:space-between;align-items:center;padding:.625rem .875rem;background:{{ $clr }}08;border-radius:var(--radius-md);">
                            <span style="font-size:.875rem;font-weight:700;color:var(--color-text-primary);">{{ $sched['day'] }}</span>
                            <span style="font-size:.875rem;font-weight:600;color:{{ $clr }};">{{ $sched['time'] }}</span>
                        </div>
                        @endforeach
                    </div>
                    <p style="font-size:.75rem;color:var(--color-text-muted);margin-top:1rem;line-height:1.6;">*Jadwal dapat berubah sewaktu-waktu. Konfirmasi ke kami sebelum berkunjung.</p>
                </div>
            </aside>

            {{-- Main Content --}}
            <main>
                {{-- Education --}}
                <div style="margin-bottom:2rem;">
                    <h2 style="font-size:1.125rem;font-weight:800;color:var(--color-text-primary);margin-bottom:1rem;padding-bottom:.75rem;border-bottom:2px solid {{ $clr }};">Pendidikan & Kualifikasi</h2>
                    <ul style="list-style:none;display:flex;flex-direction:column;gap:.75rem;">
                        @foreach ($doctor['education'] as $edu)
                        <li style="display:flex;align-items:flex-start;gap:.75rem;font-size:.9375rem;color:var(--color-text-secondary);">
                            <div style="width:24px;height:24px;border-radius:50%;background:{{ $clr }}15;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:.1rem;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="{{ $clr }}" width="12" height="12" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.636 50.636 0 00-2.658-.813A59.906 59.906 0 0112 3.493a59.903 59.903 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/></svg>
                            </div>
                            {{ $edu }}
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Services --}}
                <div style="margin-bottom:2rem;">
                    <h2 style="font-size:1.125rem;font-weight:800;color:var(--color-text-primary);margin-bottom:1rem;padding-bottom:.75rem;border-bottom:2px solid {{ $clr }};">Layanan & Bidang Keahlian</h2>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;">
                        @foreach ($doctor['services'] as $service)
                        <div style="display:flex;align-items:center;gap:.625rem;padding:.875rem 1rem;background:var(--color-bg);border:1px solid var(--color-border);border-radius:var(--radius-md);">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="{{ $clr }}" width="16" height="16" flex-shrink:0 aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            <span style="font-size:.875rem;color:var(--color-text-primary);font-weight:500;">{{ $service }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Polyclinic Info --}}
                <div style="background:{{ $clr }}08;border:1.5px solid {{ $clr }}25;border-radius:var(--radius-lg);padding:1.5rem;margin-bottom:2rem;">
                    <h3 style="font-size:1rem;font-weight:700;color:var(--color-text-primary);margin-bottom:.75rem;">Informasi Poliklinik</h3>
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                        <div>
                            <span style="font-size:.75rem;font-weight:700;color:{{ $clr }};text-transform:uppercase;letter-spacing:.05em;display:block;margin-bottom:.25rem;">Poliklinik</span>
                            <span style="font-size:.9375rem;font-weight:600;color:var(--color-text-primary);">{{ $doctor['polyclinic'] }}</span>
                        </div>
                        <div>
                            <span style="font-size:.75rem;font-weight:700;color:{{ $clr }};text-transform:uppercase;letter-spacing:.05em;display:block;margin-bottom:.25rem;">Pengalaman</span>
                            <span style="font-size:.9375rem;font-weight:600;color:var(--color-text-primary);">{{ $doctor['experience'] }}</span>
                        </div>
                    </div>
                </div>

                {{-- CTA --}}
                <div style="background:linear-gradient(135deg,var(--color-primary) 0%,{{ $clr }} 100%);border-radius:var(--radius-xl);padding:2rem;text-align:center;">
                    <h3 style="font-size:1.125rem;font-weight:800;color:#fff;margin-bottom:.625rem;">Konsultasikan Kesehatan Anda</h3>
                    <p style="font-size:.875rem;color:rgba(255,255,255,.8);margin-bottom:1.5rem;">Buat janji temu dengan {{ $doctor['name'] }} sekarang</p>
                    <div style="display:flex;flex-wrap:wrap;gap:.75rem;justify-content:center;">
                        <a href="{{ route('contact') }}#appointment" class="btn btn-lg" style="background:#fff;color:var(--color-primary);">Buat Janji Temu</a>
                        <a href="tel:+62274123456" class="btn btn-outline-white">Telepon RS</a>
                    </div>
                </div>
            </main>
        </div>

        <div style="margin-top:2.5rem;padding-top:2.5rem;border-top:1px solid var(--color-border);">
            <a href="{{ route('doctors') }}" style="display:inline-flex;align-items:center;gap:.5rem;font-size:.875rem;color:var(--color-primary);text-decoration:none;font-weight:600;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="18" height="18" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                Kembali ke Daftar Dokter
            </a>
        </div>
    </div>
</section>

@endsection
