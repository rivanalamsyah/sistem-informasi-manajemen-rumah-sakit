@extends('layouts.public')

@section('title', 'RSU Rajawali Citra — Rumah Sakit Umum Profesional')
@section('meta_description', 'RSU Rajawali Citra memberikan layanan kesehatan berkualitas, profesional, dan terpercaya di Bantul, Yogyakarta. IGD 24 Jam, 15+ Poliklinik Spesialis, Rawat Inap, Laboratorium, Radiologi.')
@section('og_title', 'RSU Rajawali Citra — Rumah Sakit Umum Profesional di Bantul, Yogyakarta')

@push('head')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "Hospital",
  "name": "RSU Rajawali Citra",
  "url": "{{ url('/') }}",
  "telephone": "+62274123456",
  "email": "info@rsurajawalicitra.co.id",
  "address": {
    "@type": "PostalAddress",
    "streetAddress": "Jl. Pleret No. KM 2.5, Banjardadap, Potorono, Banguntapan",
    "addressLocality": "Bantul",
    "addressRegion": "DI Yogyakarta",
    "postalCode": "55196",
    "addressCountry": "ID"
  },
  "openingHours": "Mo-Su 00:00-24:00",
  "medicalSpecialty": ["Emergency", "Cardiology", "Pediatrics", "Obstetrics", "Surgery", "Internal Medicine", "Radiology", "Laboratory"]
}
</script>
@endpush

@section('content')

{{-- ═══════════════════════════════════════════════════════════════════════════
     SECTION 1: HERO
═══════════════════════════════════════════════════════════════════════════ --}}
<section id="hero" style="
    padding-top: 5rem;
    position: relative;
    overflow: hidden;
    background: linear-gradient(150deg, #f0f4ff 0%, #e8f4fd 40%, #f0f9ff 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
" aria-label="Beranda Utama RSU Rajawali Citra">
    {{-- Background decoration --}}
    <div aria-hidden="true" style="position:absolute;top:-10%;right:-5%;width:600px;height:600px;background:radial-gradient(circle,rgba(37,99,235,.06) 0%,transparent 70%);pointer-events:none;"></div>
    <div aria-hidden="true" style="position:absolute;bottom:-10%;left:-5%;width:500px;height:500px;background:radial-gradient(circle,rgba(8,145,178,.06) 0%,transparent 70%);pointer-events:none;"></div>

    <div class="container-xl" style="padding-top:3rem;padding-bottom:4rem;position:relative;z-index:1;">
        <div style="display:grid;grid-template-columns:1fr;gap:3rem;align-items:center;">
            {{-- Left Content --}}
            <div style="max-width:680px;">
                {{-- Trust badge --}}
                <div style="display:inline-flex;align-items:center;gap:.5rem;padding:.5rem 1rem;background:rgba(22,163,74,.1);border:1px solid rgba(22,163,74,.2);border-radius:100px;margin-bottom:1.5rem;">
                    <span style="width:8px;height:8px;border-radius:50%;background:#16a34a;display:inline-block;animation:pulse-dot 2s ease-in-out infinite;" aria-hidden="true"></span>
                    <span style="font-size:.75rem;font-weight:700;color:#15803d;letter-spacing:.04em;text-transform:uppercase;">Terakreditasi KARS Paripurna — RS Tipe B</span>
                </div>

                <h1 style="font-size:clamp(2rem,5vw,3.5rem);font-weight:900;color:var(--color-text-primary);line-height:1.15;margin-bottom:1.25rem;letter-spacing:-0.02em;">
                    Layanan Kesehatan<br>
                    <span class="text-gradient">Terpercaya & Profesional</span><br>
                    di Bantul, Yogyakarta
                </h1>

                <p style="font-size:1.0625rem;color:var(--color-text-secondary);line-height:1.75;margin-bottom:2rem;max-width:560px;">
                    RSU Rajawali Citra hadir melayani kebutuhan kesehatan Anda dan keluarga dengan tenaga medis berpengalaman, fasilitas modern, dan layanan yang penuh perhatian.
                </p>

                <div style="display:flex;flex-wrap:wrap;gap:1rem;margin-bottom:2.5rem;">
                    <a href="{{ route('contact') }}#appointment" class="btn btn-primary btn-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="20" height="20" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                        Buat Janji Temu
                    </a>
                    <a href="{{ route('doctors') }}" class="btn btn-outline btn-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="20" height="20" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Cari Dokter
                    </a>
                </div>

                {{-- Quick Stats --}}
                <div style="display:flex;flex-wrap:wrap;gap:1.5rem;">
                    @foreach ($stats as $stat)
                    <div style="text-align:center;">
                        <div style="font-size:1.5rem;font-weight:900;color:var(--color-primary);">{{ $stat['value'] }}</div>
                        <div style="font-size:.75rem;color:var(--color-text-muted);font-weight:500;margin-top:.125rem;">{{ $stat['label'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Right: Hospital Info Cards --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                <div class="card" style="padding:1.5rem;grid-column:span 2;">
                    <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:.75rem;">
                        <div style="width:40px;height:40px;background:rgba(220,38,38,.1);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#dc2626" width="20" height="20" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                        </div>
                        <div>
                            <div style="font-size:.8125rem;font-weight:700;color:var(--color-danger);display:flex;align-items:center;gap:.375rem;"><i data-lucide="siren" style="width:14px;height:14px;" aria-hidden="true"></i> IGD Darurat 24 Jam</div>
                            <div style="font-size:1.125rem;font-weight:900;color:var(--color-text-primary);">+62 274-123-456</div>
                        </div>
                    </div>
                    <a href="tel:+62274123456" class="btn btn-sm" style="width:100%;justify-content:center;background:#dc2626;color:#fff;border-color:#dc2626;">Hubungi Sekarang</a>
                </div>

                <div class="card" style="padding:1.25rem;">
                    <div style="font-size:.8125rem;font-weight:600;color:var(--color-text-muted);margin-bottom:.5rem;">Jam Poliklinik</div>
                    <div style="font-size:.9375rem;font-weight:700;color:var(--color-text-primary);">Sen–Sab</div>
                    <div style="font-size:.875rem;color:var(--color-accent);font-weight:600;">07.00 – 20.00</div>
                </div>

                <div class="card" style="padding:1.25rem;">
                    <div style="font-size:.8125rem;font-weight:600;color:var(--color-text-muted);margin-bottom:.5rem;">WhatsApp</div>
                    <div style="font-size:.9375rem;font-weight:700;color:var(--color-text-primary);">0821-3431-3535</div>
                    <a href="https://wa.me/628213431353" target="_blank" rel="noopener" style="font-size:.8125rem;color:var(--color-accent);font-weight:600;text-decoration:none;">Chat Sekarang →</a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════════════
     SECTION 2: HOSPITAL HIGHLIGHTS (Quick Access)
═══════════════════════════════════════════════════════════════════════════ --}}
<section style="background:#fff;padding:2.5rem 0;border-top:1px solid var(--color-border);border-bottom:1px solid var(--color-border);" aria-label="Akses Cepat">
    <div class="container-xl">
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:1rem;">
            <a href="{{ route('services.detail', 'instalasi-gawat-darurat') }}" style="display:flex;flex-direction:column;align-items:center;gap:.625rem;padding:1.25rem 1rem;border-radius:var(--radius-lg);text-decoration:none;background:rgba(220,38,38,.04);border:1.5px solid rgba(220,38,38,.12);transition:all .2s;" onmouseover="this.style.background='rgba(220,38,38,.08)'" onmouseout="this.style.background='rgba(220,38,38,.04)'">
                <div style="width:48px;height:48px;background:rgba(220,38,38,.1);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="#dc2626" width="24" height="24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                </div>
                <span style="font-size:.8125rem;font-weight:700;color:var(--color-danger);text-align:center;">IGD 24 Jam</span>
            </a>

            <a href="{{ route('doctors') }}" style="display:flex;flex-direction:column;align-items:center;gap:.625rem;padding:1.25rem 1rem;border-radius:var(--radius-lg);text-decoration:none;background:rgba(30,58,95,.04);border:1.5px solid rgba(30,58,95,.12);transition:all .2s;" onmouseover="this.style.background='rgba(30,58,95,.08)'" onmouseout="this.style.background='rgba(30,58,95,.04)'">
                <div style="width:48px;height:48px;background:rgba(30,58,95,.1);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="var(--color-primary)" width="24" height="24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <span style="font-size:.8125rem;font-weight:700;color:var(--color-primary);text-align:center;">Cari Dokter</span>
            </a>

            <a href="{{ route('services') }}" style="display:flex;flex-direction:column;align-items:center;gap:.625rem;padding:1.25rem 1rem;border-radius:var(--radius-lg);text-decoration:none;background:rgba(8,145,178,.04);border:1.5px solid rgba(8,145,178,.12);transition:all .2s;" onmouseover="this.style.background='rgba(8,145,178,.08)'" onmouseout="this.style.background='rgba(8,145,178,.04)'">
                <div style="width:48px;height:48px;background:rgba(8,145,178,.1);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="var(--color-accent)" width="24" height="24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>
                </div>
                <span style="font-size:.8125rem;font-weight:700;color:var(--color-accent);text-align:center;">Layanan</span>
            </a>

            <a href="{{ route('services.detail', 'medical-check-up') }}" style="display:flex;flex-direction:column;align-items:center;gap:.625rem;padding:1.25rem 1rem;border-radius:var(--radius-lg);text-decoration:none;background:rgba(22,163,74,.04);border:1.5px solid rgba(22,163,74,.12);transition:all .2s;" onmouseover="this.style.background='rgba(22,163,74,.08)'" onmouseout="this.style.background='rgba(22,163,74,.04)'">
                <div style="width:48px;height:48px;background:rgba(22,163,74,.1);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="#16a34a" width="24" height="24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span style="font-size:.8125rem;font-weight:700;color:#16a34a;text-align:center;">Medical Check-Up</span>
            </a>

            <a href="{{ route('contact') }}" style="display:flex;flex-direction:column;align-items:center;gap:.625rem;padding:1.25rem 1rem;border-radius:var(--radius-lg);text-decoration:none;background:rgba(124,58,237,.04);border:1.5px solid rgba(124,58,237,.12);transition:all .2s;" onmouseover="this.style.background='rgba(124,58,237,.08)'" onmouseout="this.style.background='rgba(124,58,237,.04)'">
                <div style="width:48px;height:48px;background:rgba(124,58,237,.1);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="#7c3aed" width="24" height="24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                </div>
                <span style="font-size:.8125rem;font-weight:700;color:#7c3aed;text-align:center;">Lokasi RS</span>
            </a>

            <a href="{{ route('contact') }}#appointment" style="display:flex;flex-direction:column;align-items:center;gap:.625rem;padding:1.25rem 1rem;border-radius:var(--radius-lg);text-decoration:none;background:rgba(217,119,6,.04);border:1.5px solid rgba(217,119,6,.12);transition:all .2s;" onmouseover="this.style.background='rgba(217,119,6,.08)'" onmouseout="this.style.background='rgba(217,119,6,.04)'">
                <div style="width:48px;height:48px;background:rgba(217,119,6,.1);border-radius:12px;display:flex;align-items:center;justify-content:center;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="#d97706" width="24" height="24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                </div>
                <span style="font-size:.8125rem;font-weight:700;color:#d97706;text-align:center;">Buat Janji</span>
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════════════
     SECTION 3: MENGAPA MEMILIH RSU RAJAWALI CITRA
═══════════════════════════════════════════════════════════════════════════ --}}
<section class="section" aria-label="Keunggulan RSU Rajawali Citra" style="background:var(--color-surface);">
    <div class="container-xl">
        <div style="text-align:center;margin-bottom:3rem;">
            <span class="section-label">Keunggulan Kami</span>
            <h2 class="section-title">Mengapa Memilih RSU Rajawali Citra?</h2>
            <p class="section-subtitle" style="margin:0 auto;">Kami hadir untuk memberikan pelayanan kesehatan terbaik dengan standar mutu tinggi, didukung fasilitas modern dan tenaga medis profesional.</p>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:1.5rem;">
            @php
            $highlights = [
                ['icon'=>'shield-check','title'=>'Terakreditasi KARS Paripurna','desc'=>'Telah memperoleh akreditasi tertinggi dari Komisi Akreditasi Rumah Sakit (KARS), menjamin standar mutu dan keselamatan pasien.','color'=>'#16a34a'],
                ['icon'=>'users','title'=>'50+ Dokter Spesialis Berpengalaman','desc'=>'Tim dokter spesialis multidisiplin yang berpengalaman dan berdedikasi tinggi dalam menangani berbagai kondisi medis.','color'=>'var(--color-primary)'],
                ['icon'=>'building-2','title'=>'Fasilitas Medis Modern','desc'=>'Dilengkapi peralatan diagnostik dan terapi terkini untuk mendukung proses diagnosis dan pengobatan yang akurat dan efektif.','color'=>'var(--color-accent)'],
                ['icon'=>'clock','title'=>'Layanan 24 Jam IGD & Farmasi','desc'=>'IGD dan apotek beroperasi selama 24 jam penuh untuk memastikan pasien mendapat pertolongan kapan pun dibutuhkan.','color'=>'#d97706'],
                ['icon'=>'heart-pulse','title'=>'Pelayanan Humanis & Empati','desc'=>'Kami percaya bahwa penyembuhan terbaik lahir dari perpaduan kompetensi medis dan perhatian yang tulus kepada pasien.','color'=>'#dc2626'],
                ['icon'=>'credit-card','title'=>'Menerima BPJS & Asuransi','desc'=>'Melayani pasien BPJS Kesehatan, BPJS Ketenagakerjaan, dan berbagai asuransi kesehatan swasta untuk kemudahan akses.','color'=>'#7c3aed'],
            ];
            @endphp

            @foreach ($highlights as $h)
            <div class="card" style="padding:1.75rem;">
                <div style="width:48px;height:48px;border-radius:12px;background:{{ $h['color'] }}1a;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;">
                    <i data-lucide="{{ $h['icon'] }}" style="width:24px;height:24px;color:{{ $h['color'] }};" aria-hidden="true"></i>
                </div>
                <h3 style="font-size:1rem;font-weight:700;color:var(--color-text-primary);margin-bottom:.5rem;">{{ $h['title'] }}</h3>
                <p style="font-size:.875rem;color:var(--color-text-secondary);line-height:1.65;">{{ $h['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════════════
     SECTION 4: LAYANAN UNGGULAN
═══════════════════════════════════════════════════════════════════════════ --}}
<section class="section section-alt" aria-label="Layanan Unggulan">
    <div class="container-xl">
        <div style="display:flex;align-items:flex-end;justify-content:space-between;gap:1.5rem;margin-bottom:2.5rem;flex-wrap:wrap;">
            <div>
                <span class="section-label">Layanan Kami</span>
                <h2 class="section-title" style="margin-bottom:.5rem;">Layanan Kesehatan Unggulan</h2>
                <p class="section-subtitle">Kami menyediakan layanan medis komprehensif untuk semua kebutuhan kesehatan Anda.</p>
            </div>
            <a href="{{ route('services') }}" class="btn btn-outline" style="flex-shrink:0;">Lihat Semua Layanan →</a>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:1.25rem;">
            @foreach ($services as $service)
            @php
            $colorMap = ['red'=>'#dc2626','blue'=>'#2563eb','green'=>'#16a34a','purple'=>'#7c3aed','cyan'=>'#0891b2','orange'=>'#d97706','teal'=>'#0f766e','pink'=>'#be185d'];
            $clr = $colorMap[$service['color']] ?? '#2563eb';
            @endphp
            <a href="{{ route('services.detail', $service['slug']) }}" class="card" style="padding:1.5rem;text-decoration:none;display:block;">
                <div style="width:48px;height:48px;border-radius:12px;background:{{ $clr }}1a;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;">
                    <i data-lucide="{{ $service['icon'] }}" style="width:24px;height:24px;color:{{ $clr }};" aria-hidden="true"></i>
                </div>
                <h3 style="font-size:.9375rem;font-weight:700;color:var(--color-text-primary);margin-bottom:.4rem;">{{ $service['name'] }}</h3>
                <p style="font-size:.8125rem;color:var(--color-text-secondary);line-height:1.6;margin-bottom:1rem;">{{ $service['short'] }}</p>
                <span style="font-size:.8125rem;font-weight:600;color:{{ $clr }};">Selengkapnya →</span>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════════════
     SECTION 5: DOKTER UNGGULAN
═══════════════════════════════════════════════════════════════════════════ --}}
<section class="section" aria-label="Dokter Spesialis Kami" style="background:var(--color-surface);">
    <div class="container-xl">
        <div style="display:flex;align-items:flex-end;justify-content:space-between;gap:1.5rem;margin-bottom:2.5rem;flex-wrap:wrap;">
            <div>
                <span class="section-label">Tim Dokter</span>
                <h2 class="section-title" style="margin-bottom:.5rem;">Dokter Spesialis Kami</h2>
                <p class="section-subtitle">Ditangani oleh dokter spesialis berpengalaman dan berdedikasi.</p>
            </div>
            <a href="{{ route('doctors') }}" class="btn btn-outline" style="flex-shrink:0;">Semua Dokter →</a>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:1.25rem;">
            @foreach (array_slice($doctors, 0, 4) as $doctor)
            @php
            $colorMap = ['blue'=>'#2563eb','pink'=>'#be185d','green'=>'#16a34a','orange'=>'#d97706','red'=>'#dc2626','purple'=>'#7c3aed'];
            $clr = $colorMap[$doctor['color']] ?? '#2563eb';
            @endphp
            <a href="{{ route('doctors.detail', $doctor['slug']) }}" class="card" style="padding:1.5rem;text-decoration:none;text-align:center;display:block;">
                <div style="width:72px;height:72px;border-radius:50%;background:{{ $clr }}1a;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;border:3px solid {{ $clr }}30;">
                    <span style="font-size:1.5rem;font-weight:800;color:{{ $clr }};">{{ $doctor['initials'] }}</span>
                </div>
                <h3 style="font-size:.9375rem;font-weight:700;color:var(--color-text-primary);margin-bottom:.25rem;">{{ $doctor['name'] }}</h3>
                <p style="font-size:.8125rem;color:{{ $clr }};font-weight:600;margin-bottom:.75rem;">{{ $doctor['specialization'] }}</p>
                <div style="font-size:.75rem;color:var(--color-text-muted);">{{ $doctor['polyclinic'] }}</div>
                <div style="margin-top:.75rem;padding-top:.75rem;border-top:1px solid var(--color-border);">
                    @foreach (array_slice($doctor['schedule'], 0, 2) as $sched)
                    <div style="font-size:.75rem;color:var(--color-text-secondary);">{{ $sched['day'] }}: {{ $sched['time'] }}</div>
                    @endforeach
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════════════
     SECTION 6: HOSPITAL FACTS / STATISTIK
═══════════════════════════════════════════════════════════════════════════ --}}
<section style="background:var(--color-primary);padding:4rem 0;" aria-label="Data Rumah Sakit">
    <div class="container-xl">
        <div style="text-align:center;margin-bottom:2.5rem;">
            <span class="section-label" style="background:rgba(255,255,255,.12);color:rgba(255,255,255,.9);">RSU Rajawali Citra dalam Angka</span>
            <h2 style="font-size:clamp(1.5rem,3vw,2.25rem);font-weight:800;color:#fff;margin-top:.5rem;">Bukti Komitmen Kami untuk Kesehatan Anda</h2>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:2rem;text-align:center;">
            @php
            $hospitalFacts = [
                ['value'=>'120+','label'=>'Tempat Tidur','sub'=>'VVIP, VIP, Kelas I–III'],
                ['value'=>'50+','label'=>'Dokter Spesialis','sub'=>'Multidisiplin ilmu'],
                ['value'=>'15+','label'=>'Poliklinik','sub'=>'Spesialis & subspesialis'],
                ['value'=>'24/7','label'=>'IGD Siap Melayani','sub'=>'Setiap hari tanpa henti'],
                ['value'=>'15rb+','label'=>'Pasien / Tahun','sub'=>'Rawat jalan & rawat inap'],
            ];
            @endphp
            @foreach ($hospitalFacts as $fact)
            <div>
                <div style="font-size:clamp(2rem,5vw,3rem);font-weight:900;color:#fff;line-height:1.1;">{{ $fact['value'] }}</div>
                <div style="font-size:.9375rem;font-weight:700;color:rgba(255,255,255,.9);margin-top:.25rem;">{{ $fact['label'] }}</div>
                <div style="font-size:.75rem;color:rgba(255,255,255,.6);margin-top:.25rem;">{{ $fact['sub'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════════════
     SECTION 7: JADWAL DOKTER (ringkasan)
═══════════════════════════════════════════════════════════════════════════ --}}
<section class="section section-alt" aria-label="Jadwal Dokter">
    <div class="container-xl">
        <div style="display:flex;align-items:flex-end;justify-content:space-between;gap:1.5rem;margin-bottom:2.5rem;flex-wrap:wrap;">
            <div>
                <span class="section-label primary">Jadwal Praktik</span>
                <h2 class="section-title" style="margin-bottom:.5rem;">Jadwal Dokter Hari Ini</h2>
                <p class="section-subtitle">Temukan dokter dan jadwal praktik yang sesuai dengan kebutuhan Anda.</p>
            </div>
            <a href="{{ route('doctors') }}" class="btn btn-primary" style="flex-shrink:0;">Lihat Semua Jadwal</a>
        </div>

        <div style="background:var(--color-surface);border-radius:var(--radius-lg);border:1px solid var(--color-border);overflow:hidden;box-shadow:var(--shadow-sm);">
            <div style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;font-size:.875rem;">
                    <thead>
                        <tr style="background:var(--color-primary);color:#fff;">
                            <th style="padding:.875rem 1.25rem;text-align:left;font-weight:600;font-size:.8125rem;white-space:nowrap;">Dokter</th>
                            <th style="padding:.875rem 1.25rem;text-align:left;font-weight:600;font-size:.8125rem;white-space:nowrap;">Spesialisasi</th>
                            <th style="padding:.875rem 1.25rem;text-align:left;font-weight:600;font-size:.8125rem;white-space:nowrap;">Poliklinik</th>
                            <th style="padding:.875rem 1.25rem;text-align:left;font-weight:600;font-size:.8125rem;white-space:nowrap;">Jadwal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($doctors as $i => $doctor)
                        <tr style="border-bottom:1px solid var(--color-border);background:{{ $i % 2 === 0 ? '#fff' : '#fafbfc' }};" onmouseover="this.style.background='rgba(30,58,95,.04)'" onmouseout="this.style.background='{{ $i % 2 === 0 ? '#fff' : '#fafbfc' }}'">
                            <td style="padding:.875rem 1.25rem;">
                                <a href="{{ route('doctors.detail', $doctor['slug']) }}" style="font-weight:700;color:var(--color-primary);text-decoration:none;">{{ $doctor['name'] }}</a>
                            </td>
                            <td style="padding:.875rem 1.25rem;color:var(--color-text-secondary);">{{ $doctor['specialization'] }}</td>
                            <td style="padding:.875rem 1.25rem;color:var(--color-text-secondary);">{{ $doctor['polyclinic'] }}</td>
                            <td style="padding:.875rem 1.25rem;">
                                @foreach ($doctor['schedule'] as $s)
                                <span style="display:inline-block;font-size:.75rem;background:rgba(30,58,95,.08);color:var(--color-primary);padding:.2rem .6rem;border-radius:100px;margin:.125rem;font-weight:600;">{{ $s['day'] }}: {{ $s['time'] }}</span>
                                @endforeach
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════════════
     SECTION 8: FASILITAS UNGGULAN
═══════════════════════════════════════════════════════════════════════════ --}}
<section class="section" aria-label="Fasilitas Rumah Sakit" style="background:var(--color-surface);">
    <div class="container-xl">
        <div style="text-align:center;margin-bottom:3rem;">
            <span class="section-label">Fasilitas</span>
            <h2 class="section-title">Fasilitas Rumah Sakit Modern</h2>
            <p class="section-subtitle" style="margin:0 auto;">Didukung oleh peralatan medis terkini dan fasilitas pendukung yang nyaman untuk pasien dan keluarga.</p>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:1.5rem;">
            @php
            $facilities = [
                ['title'=>'Ruang Operasi Modern','desc'=>'3 kamar operasi dilengkapi peralatan bedah terkini dan sistem sterilisasi standar internasional.','icon'=>'scissors','color'=>'#2563eb'],
                ['title'=>'Ruang ICU & NICU','desc'=>'Unit perawatan intensif dengan monitoring 24 jam dan ventilator untuk pasien kritis dewasa dan neonatal.','icon'=>'activity','color'=>'#dc2626'],
                ['title'=>'CT-Scan & Radiologi','desc'=>'Peralatan pencitraan diagnostik terbaru termasuk CT-Scan multislice dan X-Ray digital.','icon'=>'scan','color'=>'#0891b2'],
                ['title'=>'Laboratorium Klinik','desc'=>'Pemeriksaan laboratorium lengkap dengan sistem otomasi untuk hasil yang cepat dan akurat.','icon'=>'flask-conical','color'=>'#7c3aed'],
                ['title'=>'Apotek 24 Jam','desc'=>'Layanan farmasi lengkap dengan ketersediaan obat-obatan esensial dan dispensing resep elektronik.','icon'=>'pill','color'=>'#d97706'],
                ['title'=>'Ambulans & Transport','desc'=>'Armada ambulans siap 24 jam untuk kebutuhan transportasi medis darurat dan non-darurat.','icon'=>'truck-fast','color'=>'#16a34a'],
            ];
            @endphp
            @foreach ($facilities as $f)
            <div style="background:var(--color-bg);border:1px solid var(--color-border);border-radius:var(--radius-lg);padding:1.75rem;border-left:4px solid {{ $f['color'] }};">
                <div style="width:44px;height:44px;border-radius:10px;background:{{ $f['color'] }}15;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;">
                    <i data-lucide="{{ $f['icon'] }}" style="width:22px;height:22px;color:{{ $f['color'] }};" aria-hidden="true"></i>
                </div>
                <h3 style="font-size:1rem;font-weight:700;color:var(--color-text-primary);margin-bottom:.5rem;">{{ $f['title'] }}</h3>
                <p style="font-size:.8125rem;color:var(--color-text-secondary);line-height:1.65;">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════════════
     SECTION 9: POLIKLINIK
═══════════════════════════════════════════════════════════════════════════ --}}
<section class="section section-alt" aria-label="Daftar Poliklinik">
    <div class="container-xl">
        <div style="text-align:center;margin-bottom:2.5rem;">
            <span class="section-label primary">Poliklinik</span>
            <h2 class="section-title">15+ Poliklinik Spesialis</h2>
            <p class="section-subtitle" style="margin:0 auto;">Tersedia poliklinik spesialis dan subspesialis untuk melayani berbagai kebutuhan kesehatan Anda.</p>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:.75rem;">
            @php
            $polyclinics = [
                'Poli Umum','Poli Anak','Poli Kandungan','Poli Jantung','Poli Bedah Umum',
                'Poli Saraf','Poli Penyakit Dalam','Poli THT','Poli Mata','Poli Kulit & Kelamin',
                'Poli Ortopedi','Poli Gigi & Mulut','Poli Jiwa','Poli Paru','Poli Gizi Klinik',
            ];
            @endphp
            @foreach ($polyclinics as $poli)
            <div style="background:var(--color-surface);border:1px solid var(--color-border);border-radius:var(--radius-md);padding:.875rem 1rem;display:flex;align-items:center;gap:.625rem;font-size:.875rem;font-weight:500;color:var(--color-text-primary);">
                <span style="width:8px;height:8px;border-radius:50%;background:var(--color-accent);flex-shrink:0;" aria-hidden="true"></span>
                {{ $poli }}
            </div>
            @endforeach
        </div>
        <div style="text-align:center;margin-top:2rem;">
            <a href="{{ route('services') }}" class="btn btn-primary">Lihat Semua Layanan</a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════════════
     SECTION 10: INFORMASI KESEHATAN (ARTIKEL)
═══════════════════════════════════════════════════════════════════════════ --}}
<section class="section" aria-label="Artikel Kesehatan" style="background:var(--color-surface);">
    <div class="container-xl">
        <div style="display:flex;align-items:flex-end;justify-content:space-between;gap:1.5rem;margin-bottom:2.5rem;flex-wrap:wrap;">
            <div>
                <span class="section-label">Edukasi Kesehatan</span>
                <h2 class="section-title" style="margin-bottom:.5rem;">Artikel & Informasi Kesehatan</h2>
                <p class="section-subtitle">Tips dan informasi kesehatan dari para dokter spesialis kami.</p>
            </div>
            <a href="{{ route('articles') }}" class="btn btn-outline" style="flex-shrink:0;">Semua Artikel →</a>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.5rem;">
            @php
            $colorMap = ['red'=>'#dc2626','blue'=>'#2563eb','green'=>'#16a34a','orange'=>'#d97706'];
            @endphp
            @foreach ($articles as $article)
            @php $clr = $colorMap[$article['color']] ?? '#2563eb'; @endphp
            <article class="card" style="text-decoration:none;overflow:hidden;">
                <div style="background:{{ $clr }}12;padding:1.5rem;border-bottom:1px solid {{ $clr }}20;">
                    <span style="display:inline-flex;align-items:center;padding:.25rem .75rem;background:{{ $clr }}15;color:{{ $clr }};border-radius:100px;font-size:.6875rem;font-weight:700;text-transform:uppercase;letter-spacing:.04em;">{{ $article['category'] }}</span>
                </div>
                <div style="padding:1.5rem;">
                    <h3 style="font-size:1rem;font-weight:700;color:var(--color-text-primary);margin-bottom:.625rem;line-height:1.4;">
                        <a href="{{ route('articles.detail', $article['slug']) }}" style="text-decoration:none;color:inherit;">{{ $article['title'] }}</a>
                    </h3>
                    <p style="font-size:.875rem;color:var(--color-text-secondary);line-height:1.65;margin-bottom:1rem;">{{ $article['excerpt'] }}</p>
                    <div style="display:flex;align-items:center;justify-content:space-between;font-size:.75rem;color:var(--color-text-muted);">
                        <span>{{ $article['author'] }}</span>
                        <span>{{ $article['date'] }}</span>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════════════
     SECTION 11: BERITA & PENGUMUMAN
═══════════════════════════════════════════════════════════════════════════ --}}
<section class="section section-alt" aria-label="Berita Terbaru">
    <div class="container-xl">
        <div style="display:flex;align-items:flex-end;justify-content:space-between;gap:1.5rem;margin-bottom:2.5rem;flex-wrap:wrap;">
            <div>
                <span class="section-label primary">Berita & Pengumuman</span>
                <h2 class="section-title" style="margin-bottom:.5rem;">Berita Terbaru</h2>
                <p class="section-subtitle">Informasi terkini seputar RSU Rajawali Citra dan program layanan kami.</p>
            </div>
            <a href="{{ route('news') }}" class="btn btn-outline" style="flex-shrink:0;">Semua Berita →</a>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.25rem;">
            @php
            $colorMap = ['blue'=>'#2563eb','green'=>'#16a34a','orange'=>'#d97706'];
            @endphp
            @foreach ($news as $item)
            @php $clr = $colorMap[$item['color']] ?? '#2563eb'; @endphp
            <article class="card" style="display:flex;flex-direction:column;">
                <div style="padding:1.25rem 1.5rem;border-bottom:1px solid var(--color-border);display:flex;align-items:center;justify-content:space-between;">
                    <span class="badge badge-{{ $item['color'] }}">{{ $item['category'] }}</span>
                    <time style="font-size:.75rem;color:var(--color-text-muted);" datetime="{{ $item['date'] }}">{{ $item['date'] }}</time>
                </div>
                <div style="padding:1.25rem 1.5rem;flex:1;">
                    <h3 style="font-size:.9375rem;font-weight:700;color:var(--color-text-primary);margin-bottom:.625rem;line-height:1.4;">
                        <a href="{{ route('news.detail', $item['slug']) }}" style="text-decoration:none;color:inherit;">{{ $item['title'] }}</a>
                    </h3>
                    <p style="font-size:.8125rem;color:var(--color-text-secondary);line-height:1.6;">{{ $item['excerpt'] }}</p>
                </div>
                <div style="padding:.875rem 1.5rem;border-top:1px solid var(--color-border);">
                    <a href="{{ route('news.detail', $item['slug']) }}" style="font-size:.8125rem;font-weight:600;color:{{ $clr }};text-decoration:none;">Baca Selengkapnya →</a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════════════
     SECTION 12: TESTIMONI PASIEN
═══════════════════════════════════════════════════════════════════════════ --}}
<section class="section" aria-label="Testimoni Pasien" style="background:var(--color-surface);">
    <div class="container-xl">
        <div style="text-align:center;margin-bottom:3rem;">
            <span class="section-label">Testimoni</span>
            <h2 class="section-title">Apa Kata Pasien Kami</h2>
            <p class="section-subtitle" style="margin:0 auto;">Kepercayaan pasien adalah motivasi terbesar kami untuk terus meningkatkan kualitas pelayanan.</p>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.5rem;">
            @php
            $testimonials = [
                ['name'=>'Ibu Ratna Wulandari','role'=>'Pasien Poliklinik Anak','text'=>'Dokter anak di sini sangat sabar dan teliti menangani anak saya. Pelayanannya ramah dan tidak membuat anak takut. Fasilitas ruang tunggu juga nyaman.','initials'=>'RW','color'=>'#2563eb'],
                ['name'=>'Bapak Hendra Kusuma','role'=>'Pasien Rawat Inap','text'=>'Saya dirawat selama 5 hari di sini. Perawat sangat perhatian dan cepat tanggap. Kamar bersih dan nyaman. Dokternya pun rutin visite setiap hari.','initials'=>'HK','color'=>'#16a34a'],
                ['name'=>'Ibu Sri Wahyuni','role'=>'Pasien Kebidanan','text'=>'Terima kasih RSU Rajawali Citra atas pelayanannya yang luar biasa saat persalinan. Proses melahirkan berjalan lancar berkat dukungan tim dokter dan bidan.','initials'=>'SW','color'=>'#be185d'],
            ];
            @endphp
            @foreach ($testimonials as $t)
            <figure style="background:var(--color-bg);border:1px solid var(--color-border);border-radius:var(--radius-lg);padding:1.75rem;margin:0;">
                <div style="display:flex;gap:.25rem;color:#f59e0b;margin-bottom:1rem;" aria-label="5 dari 5 bintang">
                    <i data-lucide="star" style="width:16px;height:16px;fill:#f59e0b;color:#f59e0b;" aria-hidden="true"></i>
                    <i data-lucide="star" style="width:16px;height:16px;fill:#f59e0b;color:#f59e0b;" aria-hidden="true"></i>
                    <i data-lucide="star" style="width:16px;height:16px;fill:#f59e0b;color:#f59e0b;" aria-hidden="true"></i>
                    <i data-lucide="star" style="width:16px;height:16px;fill:#f59e0b;color:#f59e0b;" aria-hidden="true"></i>
                    <i data-lucide="star" style="width:16px;height:16px;fill:#f59e0b;color:#f59e0b;" aria-hidden="true"></i>
                </div>
                <blockquote style="font-size:.9rem;color:var(--color-text-primary);line-height:1.7;margin-bottom:1.25rem;font-style:italic;">"{{ $t['text'] }}"</blockquote>
                <figcaption style="display:flex;align-items:center;gap:.75rem;">
                    <div style="width:42px;height:42px;border-radius:50%;background:{{ $t['color'] }}20;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <span style="font-size:.875rem;font-weight:800;color:{{ $t['color'] }};">{{ $t['initials'] }}</span>
                    </div>
                    <div>
                        <div style="font-size:.875rem;font-weight:700;color:var(--color-text-primary);">{{ $t['name'] }}</div>
                        <div style="font-size:.75rem;color:var(--color-text-muted);">{{ $t['role'] }}</div>
                    </div>
                </figcaption>
            </figure>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════════════
     SECTION 13: AKREDITASI & KEPERCAYAAN
═══════════════════════════════════════════════════════════════════════════ --}}
<section style="background:#f0f4ff;padding:3rem 0;border-top:1px solid var(--color-border);border-bottom:1px solid var(--color-border);" aria-label="Akreditasi dan Kepercayaan">
    <div class="container-xl">
        <div style="text-align:center;margin-bottom:2rem;">
            <h2 style="font-size:1.125rem;font-weight:700;color:var(--color-text-primary);">Dipercaya & Diakui</h2>
        </div>
        <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:1.5rem;align-items:center;">
            @php
            $accreditations = [
                ['label'=>'KARS','sub'=>'Terakreditasi Paripurna','icon'=>'shield-check','color'=>'#16a34a'],
                ['label'=>'BPJS','sub'=>'Provider Kesehatan','icon'=>'heart-pulse','color'=>'#2563eb'],
                ['label'=>'Kemenkes RI','sub'=>'Izin Operasional Resmi','icon'=>'building-2','color'=>'#0891b2'],
                ['label'=>'ISO 9001','sub'=>'Sistem Manajemen Mutu','icon'=>'badge-check','color'=>'#7c3aed'],
                ['label'=>'SATUSEHAT','sub'=>'Integrasi Data Nasional','icon'=>'database','color'=>'#d97706'],
            ];
            @endphp
            @foreach ($accreditations as $acc)
            <div style="display:flex;align-items:center;gap:.75rem;background:#fff;border:1px solid var(--color-border);border-radius:var(--radius-md);padding:.875rem 1.25rem;box-shadow:var(--shadow-sm);">
                <div style="width:36px;height:36px;border-radius:8px;background:{{ $acc['color'] }}15;display:flex;align-items:center;justify-content:center;">
                    <i data-lucide="{{ $acc['icon'] }}" style="width:18px;height:18px;color:{{ $acc['color'] }};" aria-hidden="true"></i>
                </div>
                <div>
                    <div style="font-size:.875rem;font-weight:800;color:var(--color-text-primary);">{{ $acc['label'] }}</div>
                    <div style="font-size:.6875rem;color:var(--color-text-muted);">{{ $acc['sub'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════════════
     SECTION 14: FAQ
═══════════════════════════════════════════════════════════════════════════ --}}
<section class="section" aria-label="Pertanyaan Umum" style="background:var(--color-surface);">
    <div class="container-xl">
        <div style="text-align:center;margin-bottom:2.5rem;">
            <span class="section-label primary">FAQ</span>
            <h2 class="section-title">Pertanyaan yang Sering Diajukan</h2>
            <p class="section-subtitle" style="margin:0 auto;">Temukan jawaban atas pertanyaan umum seputar layanan RSU Rajawali Citra.</p>
        </div>

        <div style="max-width:760px;margin:0 auto;" role="list">
            @foreach ($faqs as $i => $faq)
            <div role="listitem" style="border:1px solid var(--color-border);border-radius:var(--radius-md);margin-bottom:.75rem;overflow:hidden;background:#fff;">
                <button
                    id="faq-btn-{{ $i }}"
                    onclick="toggleFaq({{ $i }})"
                    aria-expanded="false"
                    aria-controls="faq-panel-{{ $i }}"
                    style="width:100%;display:flex;align-items:center;justify-content:space-between;padding:1.125rem 1.25rem;background:none;border:none;cursor:pointer;text-align:left;gap:1rem;">
                    <span style="font-size:.9375rem;font-weight:600;color:var(--color-text-primary);">{{ $faq['q'] }}</span>
                    <svg id="faq-icon-{{ $i }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:18px;height:18px;color:var(--color-text-muted);flex-shrink:0;transition:transform .3s;" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                    </svg>
                </button>
                <div id="faq-panel-{{ $i }}" role="region" aria-labelledby="faq-btn-{{ $i }}" style="display:none;padding:0 1.25rem 1.125rem;font-size:.875rem;color:var(--color-text-secondary);line-height:1.7;">
                    {{ $faq['a'] }}
                </div>
            </div>
            @endforeach
        </div>

        <div style="text-align:center;margin-top:2rem;">
            <a href="{{ route('faq') }}" class="btn btn-outline">Lihat Semua FAQ</a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════════════
     SECTION 15: CTA APPOINTMENT
═══════════════════════════════════════════════════════════════════════════ --}}
<section style="background:linear-gradient(135deg,var(--color-primary) 0%,#1e4d8c 60%,var(--color-accent) 100%);padding:5rem 0;position:relative;overflow:hidden;" aria-label="Hubungi Kami">
    <div aria-hidden="true" style="position:absolute;top:-20%;right:-10%;width:500px;height:500px;background:rgba(255,255,255,.03);border-radius:50%;pointer-events:none;"></div>
    <div aria-hidden="true" style="position:absolute;bottom:-20%;left:-5%;width:400px;height:400px;background:rgba(255,255,255,.03);border-radius:50%;pointer-events:none;"></div>

    <div class="container-xl" style="position:relative;z-index:1;text-align:center;">
        <h2 style="font-size:clamp(1.75rem,4vw,2.75rem);font-weight:900;color:#fff;margin-bottom:1rem;line-height:1.2;">Butuh Bantuan Medis?<br>Kami Siap Melayani Anda</h2>
        <p style="font-size:1.0625rem;color:rgba(255,255,255,.8);max-width:540px;margin:0 auto 2.5rem;line-height:1.7;">Jangan tunda kesehatan Anda. Hubungi kami sekarang atau buat janji temu dengan dokter spesialis pilihan Anda.</p>

        <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:1rem;margin-bottom:2.5rem;">
            <a href="{{ route('contact') }}#appointment" class="btn btn-lg" style="background:#fff;color:var(--color-primary);box-shadow:0 8px 30px rgba(0,0,0,.2);">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="20" height="20" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                Buat Janji Temu
            </a>
            <a href="{{ route('doctors') }}" class="btn btn-outline-white btn-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="20" height="20" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Cari Dokter Spesialis
            </a>
            <a href="tel:+62274123456" class="btn btn-lg" style="background:#dc2626;color:#fff;border-color:#dc2626;box-shadow:0 8px 30px rgba(220,38,38,.4);">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="20" height="20" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                IGD 24 Jam
            </a>
        </div>

        <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:2.5rem;">
            @php
            $contacts = [
                ['label'=>'Telepon','value'=>'+62 274-123-456','icon'=>'phone'],
                ['label'=>'WhatsApp','value'=>'0821-3431-3535','icon'=>'message-circle'],
                ['label'=>'Email','value'=>'info@rsurajawalicitra.co.id','icon'=>'mail'],
            ];
            @endphp
            @foreach ($contacts as $c)
            <div style="display:flex;align-items:center;gap:.625rem;color:rgba(255,255,255,.85);">
                <i data-lucide="{{ $c['icon'] }}" style="width:18px;height:18px;" aria-hidden="true"></i>
                <div>
                    <div style="font-size:.6875rem;color:rgba(255,255,255,.5);font-weight:600;text-transform:uppercase;letter-spacing:.05em;">{{ $c['label'] }}</div>
                    <div style="font-size:.875rem;font-weight:600;">{{ $c['value'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
function toggleFaq(index) {
    const panel = document.getElementById('faq-panel-' + index);
    const icon  = document.getElementById('faq-icon-' + index);
    const btn   = document.getElementById('faq-btn-' + index);
    const isOpen = panel.style.display === 'block';

    // Close all
    document.querySelectorAll('[id^="faq-panel-"]').forEach(function(p) { p.style.display = 'none'; });
    document.querySelectorAll('[id^="faq-icon-"]').forEach(function(i) { i.style.transform = ''; });
    document.querySelectorAll('[id^="faq-btn-"]').forEach(function(b) { b.setAttribute('aria-expanded', 'false'); });

    if (!isOpen) {
        panel.style.display = 'block';
        icon.style.transform = 'rotate(180deg)';
        btn.setAttribute('aria-expanded', 'true');
    }
}
</script>
@endpush
