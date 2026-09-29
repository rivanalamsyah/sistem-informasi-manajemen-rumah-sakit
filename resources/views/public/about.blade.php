@extends('layouts.public')

@section('title', 'Tentang RSU Rajawali Citra')
@section('meta_description', 'Pelajari profil, sejarah, visi misi, nilai-nilai, akreditasi, dan komitmen RSU Rajawali Citra dalam memberikan pelayanan kesehatan terbaik di Bantul, Yogyakarta.')
@section('og_title', 'Tentang Kami — RSU Rajawali Citra')

@push('head')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "AboutPage",
  "name": "Tentang RSU Rajawali Citra",
  "description": "Profil, sejarah, visi, misi, dan akreditasi RSU Rajawali Citra",
  "url": "{{ route('about') }}",
  "breadcrumb": {
    "@@type": "BreadcrumbList",
    "itemListElement": [
      {"@@type":"ListItem","position":1,"name":"Beranda","item":"{{ route('home') }}"},
      {"@@type":"ListItem","position":2,"name":"Tentang Kami","item":"{{ route('about') }}"}
    ]
  }
}
</script>
@endpush

@section('content')

{{-- Page Hero --}}
<section class="page-hero" aria-label="Tentang Kami">
    <div class="container-xl">
        <nav class="breadcrumb mb-4" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <span aria-current="page">Tentang Kami</span>
        </nav>
        <span class="section-label">Tentang RSU Rajawali Citra</span>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 mt-2 mb-4 leading-tight">
            Rumah Sakit yang Berdedikasi<br>untuk Kesehatan Anda
        </h1>
        <p class="text-base sm:text-lg text-slate-600 max-w-2xl leading-relaxed">
            RSU Rajawali Citra hadir sebagai mitra kesehatan terpercaya bagi masyarakat Bantul dan sekitarnya, dengan komitmen memberikan layanan medis berkualitas, humanis, dan terjangkau.
        </p>
    </div>
</section>

{{-- ═══ SECTION 2: PROFIL RUMAH SAKIT ═══ --}}
<section class="section bg-white" aria-label="Profil Rumah Sakit">
    <div class="container-xl">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-center">
            <div class="lg:col-span-7 space-y-4">
                <span class="section-label">Profil Kami</span>
                <h2 class="section-title">RSU Rajawali Citra</h2>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
                    RSU Rajawali Citra adalah rumah sakit umum yang berlokasi di Bantul, Daerah Istimewa Yogyakarta. Berdiri dengan tekad kuat untuk menyediakan layanan kesehatan berkualitas, kami melayani masyarakat dengan pendekatan yang penuh empati dan profesionalisme tinggi.
                </p>
                <p class="text-sm sm:text-base text-slate-600 leading-relaxed pb-2">
                    Sebagai rumah sakit tipe B yang telah mendapatkan akreditasi dari Komisi Akreditasi Rumah Sakit (KARS), kami terus berkomitmen untuk menghadirkan pelayanan kesehatan yang aman, efektif, dan berpusat pada pasien.
                </p>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4 pt-4">
                    <div class="bg-blue-50/70 border border-blue-100 rounded-xl p-4 text-center sm:text-left">
                        <div class="text-2xl font-black text-blue-900">2003</div>
                        <div class="text-xs text-slate-600 font-medium mt-0.5">Tahun Berdiri</div>
                    </div>
                    <div class="bg-cyan-50/70 border border-cyan-100 rounded-xl p-4 text-center sm:text-left">
                        <div class="text-2xl font-black text-cyan-700">Tipe B</div>
                        <div class="text-xs text-slate-600 font-medium mt-0.5">Klasifikasi RS</div>
                    </div>
                    <div class="bg-emerald-50/70 border border-emerald-100 rounded-xl p-4 text-center sm:text-left">
                        <div class="text-2xl font-black text-emerald-700">120+</div>
                        <div class="text-xs text-slate-600 font-medium mt-0.5">Tempat Tidur</div>
                    </div>
                    <div class="bg-amber-50/70 border border-amber-100 rounded-xl p-4 text-center sm:text-left">
                        <div class="text-2xl font-black text-amber-700">50+</div>
                        <div class="text-xs text-slate-600 font-medium mt-0.5">Dokter Spesialis</div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-5 bg-gradient-to-br from-blue-900/5 to-cyan-700/10 rounded-2xl p-6 sm:p-8 border border-slate-200">
                <div class="flex items-center gap-3.5 mb-6">
                    <div class="w-12 h-12 bg-blue-900 rounded-xl flex items-center justify-center shrink-0 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" class="w-6 h-6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z"/></svg>
                    </div>
                    <div>
                        <div class="text-base font-extrabold text-slate-900">RSU Rajawali Citra</div>
                        <div class="text-xs text-slate-500">Rumah Sakit Umum — Bantul, DIY</div>
                    </div>
                </div>

                <div class="space-y-3.5 text-xs sm:text-sm">
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
                    <div class="flex flex-col sm:flex-row sm:items-start gap-1 sm:gap-3">
                        <span class="font-bold text-blue-900 sm:w-24 shrink-0">{{ $info['label'] }}</span>
                        <span class="text-slate-600">{{ $info['value'] }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══ SECTION 3: SEJARAH TIMELINE ═══ --}}
<section class="section section-alt" aria-label="Sejarah RSU Rajawali Citra">
    <div class="container-xl">
        <div class="text-center mb-12">
            <span class="section-label">Perjalanan Kami</span>
            <h2 class="section-title">Sejarah RSU Rajawali Citra</h2>
            <p class="section-subtitle mx-auto">Lebih dari dua dekade melayani dan tumbuh bersama masyarakat Bantul dan Yogyakarta.</p>
        </div>

        <div class="max-w-4xl mx-auto space-y-6">
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
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($milestones as $m)
                <div class="card p-6 bg-white flex flex-col h-full border-l-4 border-l-blue-900">
                    <div class="text-xs font-black text-cyan-700 uppercase tracking-widest mb-1">{{ $m['year'] }}</div>
                    <h3 class="text-base font-bold text-slate-900 mb-2">{{ $m['title'] }}</h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed flex-1">{{ $m['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ═══ SECTION 4: VISI & MISI ═══ --}}
<section class="section bg-white" aria-label="Visi dan Misi">
    <div class="container-xl">
        <div class="text-center mb-12">
            <span class="section-label primary">Visi &amp; Misi</span>
            <h2 class="section-title">Panduan Arah Kami</h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-stretch">
            {{-- Visi --}}
            <div class="bg-blue-900 rounded-2xl p-8 text-white flex flex-col justify-center shadow-lg">
                <div class="text-xs font-bold text-white/60 uppercase tracking-widest mb-3">Visi Rumah Sakit</div>
                <h3 class="text-xl sm:text-2xl font-black leading-snug mb-4">
                    "Menjadi Rumah Sakit Pilihan Utama yang Unggul, Terpercaya, dan Berdaya Saing di Wilayah Bantul dan DIY"
                </h3>
                <p class="text-sm text-white/80 leading-relaxed">
                    Kami bercita-cita menjadi pilihan utama masyarakat dalam mendapatkan layanan kesehatan yang berkualitas, aman, dan terjangkau melalui inovasi berkelanjutan.
                </p>
            </div>

            {{-- Misi --}}
            <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 sm:p-8">
                <div class="text-xs font-bold text-cyan-700 uppercase tracking-widest mb-4">Misi Rumah Sakit</div>
                <ul class="space-y-3.5">
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
                    <li class="flex items-start gap-3 text-xs sm:text-sm text-slate-700 leading-relaxed">
                        <span class="w-6 h-6 rounded-full bg-blue-900 text-white flex items-center justify-center text-xs font-black shrink-0 mt-0.5">
                            {{ $i+1 }}
                        </span>
                        <span>{{ $m }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

{{-- ═══ SECTION 5: CORE VALUES ═══ --}}
<section class="section section-alt" aria-label="Nilai-nilai Kami">
    <div class="container-xl">
        <div class="text-center mb-12">
            <span class="section-label">Nilai Kami</span>
            <h2 class="section-title">Core Values RSU Rajawali Citra</h2>
            <p class="section-subtitle mx-auto">Nilai-nilai yang menjadi landasan setiap tindakan dan keputusan kami dalam melayani pasien.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
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
            <div class="card p-6 bg-white border-t-4 text-center flex flex-col h-full" style="border-top-color: {{ $v['color'] }}">
                <div class="w-12 h-12 rounded-full flex items-center justify-center mx-auto mb-4 shrink-0" style="background-color: {{ $v['color'] }}15">
                    <i data-lucide="{{ $v['icon'] }}" class="w-6 h-6" style="color: {{ $v['color'] }}" aria-hidden="true"></i>
                </div>
                <h3 class="text-base font-extrabold text-slate-900 mb-2">{{ $v['title'] }}</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed flex-1">{{ $v['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ SECTION 6: SAMBUTAN DIREKTUR ═══ --}}
<section class="section bg-white" aria-label="Sambutan Direktur">
    <div class="container-xl">
        <div class="max-w-4xl mx-auto bg-slate-50 border border-slate-200 rounded-2xl p-6 sm:p-10 relative">
            <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
                <div class="w-20 h-20 rounded-full bg-blue-900 text-white flex items-center justify-center text-2xl font-black shrink-0 border-4 border-blue-100 shadow-md">
                    RC
                </div>
                <div class="space-y-4 text-center sm:text-left">
                    <blockquote class="text-base sm:text-lg text-slate-800 italic leading-relaxed">
                        "Kepercayaan masyarakat adalah amanah terbesar bagi kami. RSU Rajawali Citra berkomitmen untuk terus meningkatkan kualitas pelayanan kesehatan, menghadirkan tenaga medis yang kompeten, dan fasilitas yang modern. Kami percaya bahwa kesehatan adalah hak semua orang, dan kami hadir untuk memastikan setiap pasien mendapatkan pelayanan terbaik yang mereka layak dapatkan."
                    </blockquote>
                    <div>
                        <div class="text-base font-extrabold text-slate-900">Direksi RSU Rajawali Citra</div>
                        <div class="text-xs text-slate-500">Rumah Sakit Umum Rajawali Citra Bantul</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
