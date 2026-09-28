@extends('layouts.public')

@section('title', 'Tentang RSU Rajawali Citra')
@section('meta_description', 'Pelajari profil, sejarah, visi misi, nilai-nilai, akreditasi, dan komitmen RSU Rajawali Citra dalam memberikan pelayanan kesehatan terbaik di Bantul, Yogyakarta.')
@section('og_title', 'Tentang Kami — RSU Rajawali Citra')

@push('head')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "AboutPage",
  "name": "Tentang RSU Rajawali Citra",
  "description": "Profil, sejarah, visi, misi, dan akreditasi RSU Rajawali Citra",
  "url": "{{ route('about') }}",
  "breadcrumb": {
    "@type": "BreadcrumbList",
    "itemListElement": [
      {"@type":"ListItem","position":1,"name":"Beranda","item":"{{ route('home') }}"},
      {"@type":"ListItem","position":2,"name":"Tentang Kami","item":"{{ route('about') }}"}
    ]
  }
}
</script>
@endpush

@section('content')

{{-- Page Hero --}}
<section class="page-hero" aria-label="Tentang Kami">
    <div class="container-xl">
        <nav class="breadcrumb" aria-label="Breadcrumb" style="margin-bottom:1.5rem;">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <span aria-current="page">Tentang Kami</span>
        </nav>
        <span class="section-label">Tentang RSU Rajawali Citra</span>
        <h1 style="font-size:clamp(2rem,4vw,3rem);font-weight:900;color:var(--color-text-primary);margin-top:.75rem;margin-bottom:1rem;line-height:1.2;">Rumah Sakit yang Berdedikasi<br>untuk Kesehatan Anda</h1>
        <p style="font-size:1.0625rem;color:var(--color-text-secondary);max-width:600px;line-height:1.75;">RSU Rajawali Citra hadir sebagai mitra kesehatan terpercaya bagi masyarakat Bantul dan sekitarnya, dengan komitmen memberikan layanan medis berkualitas, humanis, dan terjangkau.</p>
    </div>
</section>

{{-- ═══ SECTION 2: PROFIL RUMAH SAKIT ═══ --}}
<section class="section" style="background:var(--color-surface);" aria-label="Profil Rumah Sakit">
    <div class="container-xl">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:4rem;align-items:center;flex-wrap:wrap;">
            <div>
                <span class="section-label">Profil Kami</span>
                <h2 class="section-title" style="margin-bottom:1rem;">RSU Rajawali Citra</h2>
                <p style="font-size:1rem;color:var(--color-text-secondary);line-height:1.8;margin-bottom:1.5rem;">
                    RSU Rajawali Citra adalah rumah sakit umum yang berlokasi di Bantul, Daerah Istimewa Yogyakarta. Berdiri dengan tekad kuat untuk menyediakan layanan kesehatan berkualitas, kami melayani masyarakat dengan pendekatan yang penuh empati dan profesionalisme tinggi.
                </p>
                <p style="font-size:1rem;color:var(--color-text-secondary);line-height:1.8;margin-bottom:2rem;">
                    Sebagai rumah sakit tipe B yang telah mendapatkan akreditasi dari Komisi Akreditasi Rumah Sakit (KARS), kami terus berkomitmen untuk menghadirkan pelayanan kesehatan yang aman, efektif, dan berpusat pada pasien.
                </p>
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
                    <div style="background:rgba(30,58,95,.05);border-radius:var(--radius-md);padding:1.25rem;">
                        <div style="font-size:1.75rem;font-weight:900;color:var(--color-primary);">2003</div>
                        <div style="font-size:.875rem;color:var(--color-text-secondary);margin-top:.25rem;">Tahun Berdiri</div>
                    </div>
                    <div style="background:rgba(8,145,178,.05);border-radius:var(--radius-md);padding:1.25rem;">
                        <div style="font-size:1.75rem;font-weight:900;color:var(--color-accent);">Tipe B</div>
                        <div style="font-size:.875rem;color:var(--color-text-secondary);margin-top:.25rem;">Klasifikasi RS</div>
                    </div>
                    <div style="background:rgba(22,163,74,.05);border-radius:var(--radius-md);padding:1.25rem;">
                        <div style="font-size:1.75rem;font-weight:900;color:#16a34a;">120+</div>
                        <div style="font-size:.875rem;color:var(--color-text-secondary);margin-top:.25rem;">Tempat Tidur</div>
                    </div>
                    <div style="background:rgba(217,119,6,.05);border-radius:var(--radius-md);padding:1.25rem;">
                        <div style="font-size:1.75rem;font-weight:900;color:#d97706;">50+</div>
                        <div style="font-size:.875rem;color:var(--color-text-secondary);margin-top:.25rem;">Dokter Spesialis</div>
                    </div>
                </div>
            </div>
            <div style="background:linear-gradient(135deg,rgba(30,58,95,.04) 0%,rgba(8,145,178,.06) 100%);border-radius:var(--radius-xl);padding:2.5rem;border:1px solid var(--color-border);">
                <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem;">
                    <div style="width:56px;height:56px;background:var(--color-primary);border-radius:14px;display:flex;align-items:center;justify-content:center;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="#fff" width="28" height="28" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z"/></svg>
                    </div>
                    <div>
                        <div style="font-size:1.125rem;font-weight:800;color:var(--color-text-primary);">RSU Rajawali Citra</div>
                        <div style="font-size:.8125rem;color:var(--color-text-muted);">Rumah Sakit Umum — Bantul, DIY</div>
                    </div>
                </div>
                <div style="display:flex;flex-direction:column;gap:.875rem;">
                    @php
                    $infos = [
                        ['label'=>'Alamat','value'=>'Jl. Pleret No. KM 2.5, Banjardadap, Potorono, Banguntapan, Bantul, DIY 55196'],
                        ['label'=>'Telepon','value'=>'+62 274-123-456'],
                        ['label'=>'Email','value'=>'info@rsurajawalicitra.co.id'],
                        ['label'=>'Jam IGD','value'=>'24 Jam / 7 Hari'],
                        ['label'=>'Poliklinik','value'=>'Senin – Sabtu, 07.00 – 20.00 WIB'],
                    ];
                    @endphp
                    @foreach ($infos as $info)
                    <div style="display:flex;gap:.75rem;font-size:.875rem;">
                        <span style="font-weight:700;color:var(--color-primary);min-width:80px;flex-shrink:0;">{{ $info['label'] }}</span>
                        <span style="color:var(--color-text-secondary);">{{ $info['value'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══ SECTION 3: SEJARAH ═══ --}}
<section class="section section-alt" aria-label="Sejarah RSU Rajawali Citra">
    <div class="container-xl">
        <div style="text-align:center;margin-bottom:3rem;">
            <span class="section-label">Perjalanan Kami</span>
            <h2 class="section-title">Sejarah RSU Rajawali Citra</h2>
            <p class="section-subtitle" style="margin:0 auto;">Lebih dari dua dekade melayani dan tumbuh bersama masyarakat Bantul dan Yogyakarta.</p>
        </div>
        <div style="max-width:800px;margin:0 auto;position:relative;">
            <div style="position:absolute;left:50%;top:0;bottom:0;width:2px;background:var(--color-border);transform:translateX(-50%);z-index:0;" aria-hidden="true"></div>
            @php
            $milestones = [
                ['year'=>'2003','title'=>'Pendirian RSU Rajawali Citra','desc'=>'RSU Rajawali Citra resmi berdiri dan mulai beroperasi dengan kapasitas awal 40 tempat tidur, melayani masyarakat Bantul dan sekitarnya.'],
                ['year'=>'2008','title'=>'Ekspansi Layanan','desc'=>'Penambahan gedung baru dan berbagai poliklinik spesialis, serta peningkatan kapasitas tempat tidur menjadi 80 unit.'],
                ['year'=>'2013','title'=>'Akreditasi Pertama','desc'=>'RSU Rajawali Citra berhasil meraih akreditasi dari KARS untuk pertama kalinya, menandai pencapaian standar mutu pelayanan.'],
                ['year'=>'2018','title'=>'Modernisasi Fasilitas','desc'=>'Penambahan peralatan CT-Scan, laboratorium otomatis, dan sistem informasi manajemen rumah sakit terintegrasi.'],
                ['year'=>'2022','title'=>'Akreditasi Paripurna','desc'=>'Meraih status akreditasi paripurna (tertinggi) dari KARS, sebuah pengakuan atas standar pelayanan dan keselamatan pasien yang excellent.'],
                ['year'=>'2026','title'=>'RS Tipe B & Pengembangan Lanjutan','desc'=>'Resmi ditetapkan sebagai RS Tipe B dengan lebih dari 120 tempat tidur dan 50+ dokter spesialis, terus berkembang untuk pelayanan lebih baik.'],
            ];
            @endphp
            @foreach ($milestones as $i => $m)
            <div style="display:flex;gap:2rem;margin-bottom:2rem;align-items:flex-start;position:relative;z-index:1;flex-direction:{{ $i % 2 === 0 ? 'row' : 'row-reverse' }};">
                <div style="flex:1;{{ $i % 2 === 0 ? 'text-align:right;' : 'text-align:left;' }}">
                    <div style="background:var(--color-surface);border:1px solid var(--color-border);border-radius:var(--radius-md);padding:1.25rem;box-shadow:var(--shadow-sm);">
                        <div style="font-size:.75rem;font-weight:700;color:var(--color-accent);margin-bottom:.25rem;text-transform:uppercase;letter-spacing:.05em;">{{ $m['year'] }}</div>
                        <div style="font-size:.9375rem;font-weight:700;color:var(--color-text-primary);margin-bottom:.5rem;">{{ $m['title'] }}</div>
                        <div style="font-size:.8125rem;color:var(--color-text-secondary);line-height:1.65;">{{ $m['desc'] }}</div>
                    </div>
                </div>
                <div style="width:16px;height:16px;border-radius:50%;background:var(--color-primary);border:3px solid var(--color-surface);box-shadow:0 0 0 3px var(--color-primary);flex-shrink:0;margin-top:1rem;" aria-hidden="true"></div>
                <div style="flex:1;"></div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ SECTION 4: VISI & MISI ═══ --}}
<section class="section" style="background:var(--color-surface);" aria-label="Visi dan Misi">
    <div class="container-xl">
        <div style="text-align:center;margin-bottom:3rem;">
            <span class="section-label primary">Visi & Misi</span>
            <h2 class="section-title">Panduan Arah Kami</h2>
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem;flex-wrap:wrap;">
            <div style="background:var(--color-primary);border-radius:var(--radius-xl);padding:2.5rem;color:#fff;">
                <div style="font-size:.75rem;font-weight:700;color:rgba(255,255,255,.6);text-transform:uppercase;letter-spacing:.08em;margin-bottom:1rem;">Visi</div>
                <h3 style="font-size:1.375rem;font-weight:800;line-height:1.4;margin-bottom:1rem;">"Menjadi Rumah Sakit Pilihan Utama yang Unggul, Terpercaya, dan Berdaya Saing di Wilayah Bantul dan DIY"</h3>
                <p style="font-size:.875rem;color:rgba(255,255,255,.75);line-height:1.7;">Kami bercita-cita menjadi pilihan utama masyarakat dalam mendapatkan layanan kesehatan yang berkualitas, aman, dan terjangkau.</p>
            </div>
            <div style="background:var(--color-bg);border:1px solid var(--color-border);border-radius:var(--radius-xl);padding:2.5rem;">
                <div style="font-size:.75rem;font-weight:700;color:var(--color-accent);text-transform:uppercase;letter-spacing:.08em;margin-bottom:1rem;">Misi</div>
                <ul style="list-style:none;display:flex;flex-direction:column;gap:1rem;">
                    @php
                    $missions = [
                        'Memberikan pelayanan kesehatan yang berkualitas, aman, dan berpusat pada pasien dengan standar medis terkini.',
                        'Meningkatkan kompetensi sumber daya manusia melalui pendidikan, pelatihan, dan pengembangan berkelanjutan.',
                        'Mengembangkan fasilitas dan teknologi medis terkini untuk mendukung diagnosa dan terapi yang optimal.',
                        'Membangun kemitraan strategis dengan institusi kesehatan, pemerintah, dan masyarakat.',
                        'Mengelola sumber daya secara efisien dan akuntabel untuk keberlanjutan organisasi.',
                    ];
                    @endphp
                    @foreach ($missions as $i => $m)
                    <li style="display:flex;gap:.75rem;align-items:flex-start;font-size:.875rem;color:var(--color-text-secondary);line-height:1.65;">
                        <span style="width:24px;height:24px;border-radius:50%;background:var(--color-primary);color:#fff;display:flex;align-items:center;justify-content:center;font-size:.6875rem;font-weight:800;flex-shrink:0;margin-top:.1rem;">{{ $i+1 }}</span>
                        {{ $m }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- ═══ SECTION 5: NILAI / CORE VALUES ═══ --}}
<section class="section section-alt" aria-label="Nilai-nilai Kami">
    <div class="container-xl">
        <div style="text-align:center;margin-bottom:3rem;">
            <span class="section-label">Nilai Kami</span>
            <h2 class="section-title">Core Values RSU Rajawali Citra</h2>
            <p class="section-subtitle" style="margin:0 auto;">Nilai-nilai yang menjadi landasan setiap tindakan dan keputusan kami dalam melayani pasien.</p>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1.5rem;">
            @php
            $values = [
                ['title'=>'Integritas','desc'=>'Jujur, transparan, dan dapat dipercaya dalam setiap aspek pelayanan.','icon'=>'shield-check','color'=>'#2563eb'],
                ['title'=>'Profesionalisme','desc'=>'Bertindak dengan kompetensi tinggi, etika, dan tanggung jawab profesional.','icon'=>'award','color'=>'#7c3aed'],
                ['title'=>'Empati','desc'=>'Memahami dan merespons kebutuhan serta perasaan pasien dan keluarga.','icon'=>'heart','color'=>'#dc2626'],
                ['title'=>'Inovasi','desc'=>'Terus berinovasi dalam layanan dan teknologi untuk hasil terbaik bagi pasien.','icon'=>'lightbulb','color'=>'#d97706'],
                ['title'=>'Kolaborasi','desc'=>'Bekerja sama dalam tim multidisiplin demi kebaikan pasien.','icon'=>'users','color'=>'#16a34a'],
                ['title'=>'Keselamatan','desc'=>'Mengutamakan keselamatan pasien, staf, dan lingkungan di atas segalanya.','icon'=>'shield','color'=>'#0891b2'],
            ];
            @endphp
            @foreach ($values as $v)
            <div style="background:var(--color-surface);border-radius:var(--radius-lg);padding:1.75rem;text-align:center;border:1px solid var(--color-border);border-top:4px solid {{ $v['color'] }};">
                <div style="width:56px;height:56px;border-radius:50%;background:{{ $v['color'] }}15;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                    <i data-lucide="{{ $v['icon'] }}" style="width:26px;height:26px;color:{{ $v['color'] }};" aria-hidden="true"></i>
                </div>
                <h3 style="font-size:1rem;font-weight:800;color:var(--color-text-primary);margin-bottom:.5rem;">{{ $v['title'] }}</h3>
                <p style="font-size:.8125rem;color:var(--color-text-secondary);line-height:1.65;">{{ $v['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ SECTION 6: SAMBUTAN DIREKTUR ═══ --}}
<section class="section" style="background:var(--color-surface);" aria-label="Sambutan Direktur">
    <div class="container-xl">
        <div style="max-width:860px;margin:0 auto;">
            <div style="background:linear-gradient(135deg,rgba(30,58,95,.04) 0%,rgba(8,145,178,.06) 100%);border-radius:var(--radius-xl);padding:3rem;border:1px solid var(--color-border);position:relative;">
                <div style="position:absolute;top:2rem;left:2rem;font-size:5rem;line-height:1;color:var(--color-primary);opacity:.08;font-family:Georgia,serif;pointer-events:none;" aria-hidden="true">"</div>
                <div style="display:flex;gap:2rem;align-items:flex-start;flex-wrap:wrap;">
                    <div style="width:90px;height:90px;border-radius:50%;background:var(--color-primary);display:flex;align-items:center;justify-content:center;flex-shrink:0;border:4px solid rgba(30,58,95,.15);">
                        <span style="font-size:2rem;font-weight:900;color:#fff;">DR</span>
                    </div>
                    <div style="flex:1;">
                        <blockquote style="font-size:1.0625rem;color:var(--color-text-primary);line-height:1.85;margin-bottom:1.5rem;font-style:italic;">
                            "Kepercayaan masyarakat adalah amanah terbesar bagi kami. RSU Rajawali Citra berkomitmen untuk terus meningkatkan kualitas pelayanan kesehatan, menghadirkan tenaga medis yang kompeten, dan fasilitas yang modern. Kami percaya bahwa kesehatan adalah hak semua orang, dan kami hadir untuk memastikan setiap pasien mendapatkan pelayanan terbaik yang mereka layak dapatkan."
                        </blockquote>
                        <div>
                            <div style="font-size:1rem;font-weight:800;color:var(--color-text-primary);">[Nama Direktur Utama]</div>
                            <div style="font-size:.8125rem;color:var(--color-text-muted);">Direktur Utama RSU Rajawali Citra</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══ SECTION 7: AKREDITASI & SERTIFIKASI ═══ --}}
<section class="section section-alt" aria-label="Akreditasi dan Sertifikasi">
    <div class="container-xl">
        <div style="text-align:center;margin-bottom:3rem;">
            <span class="section-label">Pengakuan</span>
            <h2 class="section-title">Akreditasi & Sertifikasi</h2>
            <p class="section-subtitle" style="margin:0 auto;">Pengakuan resmi atas standar mutu dan keselamatan pelayanan RSU Rajawali Citra.</p>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:1.5rem;">
            @php
            $accreds = [
                ['name'=>'Akreditasi KARS Paripurna','desc'=>'Status akreditasi tertinggi dari Komisi Akreditasi Rumah Sakit (KARS) Indonesia.','icon'=>'shield-check','color'=>'#16a34a','year'=>'2022'],
                ['name'=>'Izin Operasional Kemenkes','desc'=>'Surat izin operasional resmi dari Kementerian Kesehatan Republik Indonesia.','icon'=>'file-check','color'=>'#2563eb','year'=>'2003'],
                ['name'=>'Provider BPJS Kesehatan','desc'=>'Terdaftar sebagai fasilitas kesehatan mitra resmi BPJS Kesehatan.','icon'=>'heart-pulse','color'=>'#0891b2','year'=>'2014'],
                ['name'=>'Standar Manajemen Mutu','desc'=>'Penerapan sistem manajemen mutu layanan kesehatan sesuai standar nasional.','icon'=>'badge-check','color'=>'#7c3aed','year'=>'2020'],
            ];
            @endphp
            @foreach ($accreds as $acc)
            <div class="card" style="padding:1.75rem;">
                <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1rem;">
                    <div style="width:48px;height:48px;border-radius:12px;background:{{ $acc['color'] }}15;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i data-lucide="{{ $acc['icon'] }}" style="width:24px;height:24px;color:{{ $acc['color'] }};" aria-hidden="true"></i>
                    </div>
                    <span style="font-size:.6875rem;font-weight:700;color:{{ $acc['color'] }};background:{{ $acc['color'] }}12;padding:.25rem .625rem;border-radius:100px;">Sejak {{ $acc['year'] }}</span>
                </div>
                <h3 style="font-size:.9375rem;font-weight:700;color:var(--color-text-primary);margin-bottom:.5rem;">{{ $acc['name'] }}</h3>
                <p style="font-size:.8125rem;color:var(--color-text-secondary);line-height:1.65;">{{ $acc['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ SECTION 8: STRUKTUR ORGANISASI ═══ --}}
<section class="section" style="background:var(--color-surface);" aria-label="Struktur Organisasi">
    <div class="container-xl">
        <div style="text-align:center;margin-bottom:3rem;">
            <span class="section-label primary">Kepemimpinan</span>
            <h2 class="section-title">Struktur Organisasi</h2>
            <p class="section-subtitle" style="margin:0 auto;">Tim manajemen RSU Rajawali Citra yang berdedikasi dalam mengelola rumah sakit secara profesional.</p>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1.5rem;max-width:900px;margin:0 auto;">
            @php
            $leaders = [
                ['role'=>'Direktur Utama','name'=>'[Nama Direktur Utama]','icon'=>'user-check','color'=>'#1e3a5f'],
                ['role'=>'Direktur Medis','name'=>'[Nama Direktur Medis]','icon'=>'stethoscope','color'=>'#2563eb'],
                ['role'=>'Direktur Umum & Keuangan','name'=>'[Nama Direktur Umum]','icon'=>'briefcase','color'=>'#0891b2'],
                ['role'=>'Kepala Bidang Keperawatan','name'=>'[Nama Kepala Bid. Kep.]','icon'=>'heart-pulse','color'=>'#16a34a'],
                ['role'=>'Kepala Instalasi Farmasi','name'=>'[Nama Kepala Farmasi]','icon'=>'pill','color'=>'#d97706'],
                ['role'=>'Kepala Lab. Klinik','name'=>'[Nama Kepala Lab.]','icon'=>'flask-conical','color'=>'#7c3aed'],
            ];
            @endphp
            @foreach ($leaders as $l)
            <div style="background:var(--color-bg);border:1px solid var(--color-border);border-radius:var(--radius-lg);padding:1.5rem;text-align:center;">
                <div style="width:60px;height:60px;border-radius:50%;background:{{ $l['color'] }}15;border:3px solid {{ $l['color'] }}30;display:flex;align-items:center;justify-content:center;margin:0 auto .75rem;">
                    <i data-lucide="{{ $l['icon'] }}" style="width:26px;height:26px;color:{{ $l['color'] }};" aria-hidden="true"></i>
                </div>
                <div style="font-size:.6875rem;font-weight:700;color:{{ $l['color'] }};text-transform:uppercase;letter-spacing:.04em;margin-bottom:.375rem;">{{ $l['role'] }}</div>
                <div style="font-size:.875rem;font-weight:600;color:var(--color-text-primary);">{{ $l['name'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ SECTION 9: PRESTASI ═══ --}}
<section class="section section-alt" aria-label="Prestasi dan Penghargaan">
    <div class="container-xl">
        <div style="text-align:center;margin-bottom:3rem;">
            <span class="section-label">Penghargaan</span>
            <h2 class="section-title">Prestasi & Penghargaan</h2>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:1.25rem;">
            @php
            $awards = [
                ['title'=>'Akreditasi KARS Paripurna','year'=>'2022','org'=>'Komisi Akreditasi Rumah Sakit','color'=>'#16a34a'],
                ['title'=>'RS Tipe B Terakreditasi','year'=>'2020','org'=>'Kementerian Kesehatan RI','color'=>'#2563eb'],
                ['title'=>'Penghargaan Pelayanan Prima','year'=>'2019','org'=>'Dinas Kesehatan Kab. Bantul','color'=>'#d97706'],
                ['title'=>'Provider BPJS Terbaik','year'=>'2021','org'=>'BPJS Kesehatan DIY','color'=>'#0891b2'],
            ];
            @endphp
            @foreach ($awards as $aw)
            <div style="background:var(--color-surface);border-radius:var(--radius-lg);padding:1.5rem;border:1px solid var(--color-border);display:flex;gap:1rem;align-items:flex-start;">
                <div style="width:48px;height:48px;border-radius:12px;background:{{ $aw['color'] }}15;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i data-lucide="trophy" style="width:22px;height:22px;color:{{ $aw['color'] }};" aria-hidden="true"></i>
                </div>
                <div>
                    <div style="font-size:.9375rem;font-weight:700;color:var(--color-text-primary);margin-bottom:.25rem;">{{ $aw['title'] }}</div>
                    <div style="font-size:.8125rem;color:var(--color-text-secondary);">{{ $aw['org'] }}</div>
                    <span style="font-size:.75rem;font-weight:700;color:{{ $aw['color'] }};margin-top:.375rem;display:inline-block;">{{ $aw['year'] }}</span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ SECTION 10: KOMITMEN MUTU & KESELAMATAN ═══ --}}
<section style="background:var(--color-primary);padding:4.5rem 0;" aria-label="Komitmen Mutu dan Keselamatan">
    <div class="container-xl">
        <div style="text-align:center;margin-bottom:3rem;">
            <span class="section-label" style="background:rgba(255,255,255,.12);color:rgba(255,255,255,.9);">Komitmen Kami</span>
            <h2 style="font-size:clamp(1.5rem,3vw,2.25rem);font-weight:800;color:#fff;margin-top:.75rem;margin-bottom:.75rem;">Mutu & Keselamatan Pasien</h2>
            <p style="font-size:1rem;color:rgba(255,255,255,.75);max-width:560px;margin:0 auto;line-height:1.7;">Standar keselamatan pasien adalah prioritas absolut kami dalam setiap aspek pelayanan.</p>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1.5rem;">
            @php
            $commitments = [
                ['title'=>'Zero Medication Error','desc'=>'Program verifikasi resep berlapis untuk mencegah kesalahan pemberian obat.','icon'=>'check-circle'],
                ['title'=>'Patient Safety Protocol','desc'=>'Penerapan protokol keselamatan pasien WHO sesuai standar internasional.','icon'=>'shield'],
                ['title'=>'Infection Control','desc'=>'Program pencegahan dan pengendalian infeksi yang ketat di seluruh area RS.','icon'=>'filter'],
                ['title'=>'Clinical Audit','desc'=>'Audit klinis rutin untuk memastikan kualitas pelayanan medis yang optimal.','icon'=>'clipboard-check'],
            ];
            @endphp
            @foreach ($commitments as $c)
            <div style="background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.15);border-radius:var(--radius-lg);padding:1.75rem;text-align:center;">
                <div style="width:52px;height:52px;border-radius:12px;background:rgba(255,255,255,.1);display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">
                    <i data-lucide="{{ $c['icon'] }}" style="width:26px;height:26px;color:#fff;" aria-hidden="true"></i>
                </div>
                <h3 style="font-size:1rem;font-weight:700;color:#fff;margin-bottom:.5rem;">{{ $c['title'] }}</h3>
                <p style="font-size:.8125rem;color:rgba(255,255,255,.7);line-height:1.65;">{{ $c['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ SECTION 11: LOKASI ═══ --}}
<section class="section" style="background:var(--color-surface);" aria-label="Lokasi Rumah Sakit">
    <div class="container-xl">
        <div style="text-align:center;margin-bottom:2.5rem;">
            <span class="section-label primary">Lokasi</span>
            <h2 class="section-title">Temukan Kami</h2>
        </div>
        <div style="background:var(--color-bg);border:1px solid var(--color-border);border-radius:var(--radius-xl);overflow:hidden;">
            <div style="aspect-ratio:16/6;background:linear-gradient(135deg,rgba(30,58,95,.08) 0%,rgba(8,145,178,.08) 100%);display:flex;align-items:center;justify-content:center;border-bottom:1px solid var(--color-border);">
                <div style="text-align:center;">
                    <i data-lucide="map-pin" style="width:48px;height:48px;color:var(--color-accent);margin-bottom:1rem;" aria-hidden="true"></i>
                    <p style="font-size:.875rem;color:var(--color-text-muted);">Peta interaktif akan ditampilkan di sini<br><a href="https://maps.google.com/?q=RSU+Rajawali+Citra+Bantul" target="_blank" rel="noopener" style="color:var(--color-accent);font-weight:600;">Buka di Google Maps →</a></p>
                </div>
            </div>
            <div style="padding:2rem;display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1.5rem;">
                <div style="display:flex;gap:.75rem;">
                    <i data-lucide="map-pin" style="width:20px;height:20px;color:var(--color-accent);flex-shrink:0;margin-top:2px;" aria-hidden="true"></i>
                    <div>
                        <div style="font-size:.8125rem;font-weight:700;color:var(--color-text-primary);margin-bottom:.25rem;">Alamat</div>
                        <div style="font-size:.8125rem;color:var(--color-text-secondary);">Jl. Pleret No. KM 2.5, Banjardadap, Potorono, Banguntapan, Bantul, DIY 55196</div>
                    </div>
                </div>
                <div style="display:flex;gap:.75rem;">
                    <i data-lucide="clock" style="width:20px;height:20px;color:var(--color-accent);flex-shrink:0;margin-top:2px;" aria-hidden="true"></i>
                    <div>
                        <div style="font-size:.8125rem;font-weight:700;color:var(--color-text-primary);margin-bottom:.25rem;">Jam Operasional</div>
                        <div style="font-size:.8125rem;color:var(--color-text-secondary);">IGD: 24 Jam / 7 Hari<br>Poliklinik: Sen–Sab 07.00–20.00</div>
                    </div>
                </div>
                <div style="display:flex;gap:.75rem;">
                    <i data-lucide="phone" style="width:20px;height:20px;color:var(--color-accent);flex-shrink:0;margin-top:2px;" aria-hidden="true"></i>
                    <div>
                        <div style="font-size:.8125rem;font-weight:700;color:var(--color-text-primary);margin-bottom:.25rem;">Telepon</div>
                        <div style="font-size:.8125rem;color:var(--color-text-secondary);"><a href="tel:+62274123456" style="color:var(--color-accent);">+62 274-123-456</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══ SECTION 12: CTA ═══ --}}
<section style="background:linear-gradient(135deg,var(--color-primary) 0%,var(--color-accent) 100%);padding:4rem 0;" aria-label="Hubungi Kami">
    <div class="container-xl" style="text-align:center;">
        <h2 style="font-size:clamp(1.5rem,3vw,2.25rem);font-weight:800;color:#fff;margin-bottom:1rem;">Siap Melayani Kesehatan Anda</h2>
        <p style="font-size:1rem;color:rgba(255,255,255,.8);max-width:480px;margin:0 auto 2rem;line-height:1.7;">Jangan tunggu sampai sakit parah. Jadwalkan pemeriksaan kesehatan Anda sekarang.</p>
        <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:1rem;">
            <a href="{{ route('contact') }}#appointment" class="btn btn-lg" style="background:#fff;color:var(--color-primary);">Buat Janji Temu</a>
            <a href="{{ route('services') }}" class="btn btn-outline-white btn-lg">Lihat Layanan Kami</a>
        </div>
    </div>
</section>

@endsection
