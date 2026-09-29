@extends('layouts.public')

@section('title', 'RSU Rajawali Citra — Rumah Sakit Umum Profesional')
@section('meta_description', 'RSU Rajawali Citra memberikan layanan kesehatan berkualitas, profesional, dan terpercaya di Bantul, Yogyakarta. IGD 24 Jam, 15+ Poliklinik Spesialis, Rawat Inap, Laboratorium, Radiologi.')
@section('og_title', 'RSU Rajawali Citra — Rumah Sakit Umum Profesional di Bantul, Yogyakarta')

@push('head')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "Hospital",
  "name": "RSU Rajawali Citra",
  "url": "{{ url('/') }}",
  "telephone": "+62274123456",
  "email": "info@rsurajawalicitra.co.id",
  "address": {
    "@@type": "PostalAddress",
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
     SECTION 1: HERO (Fluid & Responsive Split Grid)
═══════════════════════════════════════════════════════════════════════════ --}}
<section id="hero" class="relative pt-24 pb-16 lg:pt-32 lg:pb-24 bg-gradient-to-br from-blue-50/80 via-slate-50 to-cyan-50/60 overflow-hidden" aria-label="Beranda Utama RSU Rajawali Citra">
    {{-- Background decorations --}}
    <div aria-hidden="true" class="absolute -top-24 -right-24 w-96 h-96 bg-blue-500/5 rounded-full blur-3xl pointer-events-none"></div>
    <div aria-hidden="true" class="absolute -bottom-24 -left-24 w-96 h-96 bg-cyan-500/5 rounded-full blur-3xl pointer-events-none"></div>

    <div class="container-xl relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-center">
            {{-- Left Content --}}
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                {{-- Accreditation Badge --}}
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-emerald-600/10 border border-emerald-600/20 rounded-full">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-600 animate-pulse-dot" aria-hidden="true"></span>
                    <span class="text-xs font-extrabold text-emerald-800 uppercase tracking-wide">Terakreditasi KARS Paripurna — RS Tipe B</span>
                </div>

                <h1 class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-black text-slate-900 leading-[1.15] tracking-tight">
                    Layanan Kesehatan<br>
                    <span class="text-gradient">Terpercaya &amp; Profesional</span><br>
                    di Bantul, Yogyakarta
                </h1>

                <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                    RSU Rajawali Citra hadir melayani kebutuhan kesehatan Anda dan keluarga dengan tenaga medis berpengalaman, fasilitas modern, dan pelayanan humanis yang berpusat pada pasien.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3.5 pt-2">
                    <a href="{{ route('contact') }}#appointment" class="btn btn-primary btn-lg w-full sm:w-auto shadow-lg shadow-blue-900/20">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                        <span>Buat Janji Temu</span>
                    </a>
                    <a href="{{ route('doctors') }}" class="btn btn-outline btn-lg w-full sm:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span>Cari Dokter Spesialis</span>
                    </a>
                </div>

                {{-- Quick Stats Banner --}}
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-6 border-t border-slate-200/80">
                    @foreach ($stats as $stat)
                    <div class="text-center lg:text-left">
                        <div class="text-2xl lg:text-3xl font-black text-blue-900">{{ $stat['value'] }}</div>
                        <div class="text-xs text-slate-500 font-semibold mt-0.5">{{ $stat['label'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Right: Hospital Info Cards --}}
            <div class="lg:col-span-5 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 gap-4">
                {{-- Emergency Highlight Card --}}
                <div class="card p-6 bg-white border-red-200 shadow-md sm:col-span-2 lg:col-span-1">
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#dc2626" class="w-6 h-6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                        </div>
                        <div>
                            <div class="text-xs font-extrabold text-red-600 uppercase tracking-wider flex items-center gap-1.5">
                                <i data-lucide="siren" class="w-4 h-4" aria-hidden="true"></i> IGD Darurat 24 Jam
                            </div>
                            <div class="text-xl font-black text-slate-900">+62 274-123-456</div>
                        </div>
                    </div>
                    <a href="tel:+62274123456" class="btn btn-sm w-full justify-center bg-red-600 hover:bg-red-700 text-white border-red-600 shadow-sm">
                        Hubungi IGD Sekarang
                    </a>
                </div>

                {{-- Polyclinic Hours Card --}}
                <div class="card p-5 bg-white">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center shrink-0">
                            <i data-lucide="clock" class="w-5 h-5 text-blue-900" aria-hidden="true"></i>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-slate-400">Jam Poliklinik Rawat Jalan</div>
                            <div class="text-sm font-bold text-slate-900">Senin – Sabtu: 07.00 – 20.00 WIB</div>
                        </div>
                    </div>
                </div>

                {{-- WhatsApp Support Card --}}
                <div class="card p-5 bg-white">
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0">
                                <i data-lucide="message-square" class="w-5 h-5 text-emerald-600" aria-hidden="true"></i>
                            </div>
                            <div>
                                <div class="text-xs font-semibold text-slate-400">Layanan WhatsApp RS</div>
                                <div class="text-sm font-bold text-slate-900">0821-3431-3535</div>
                            </div>
                        </div>
                        <a href="https://wa.me/628213431353" target="_blank" rel="noopener" class="text-xs font-bold text-cyan-700 hover:text-cyan-800 underline underline-offset-2 shrink-0">
                            Chat &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════════════
     SECTION 2: QUICK ACCESS GRID
═══════════════════════════════════════════════════════════════════════════ --}}
<section class="bg-white py-8 border-y border-slate-200" aria-label="Akses Cepat Layanan">
    <div class="container-xl">
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
            <a href="{{ route('services.detail', 'instalasi-gawat-darurat') }}" class="flex flex-col items-center justify-center p-4 rounded-xl text-center bg-red-50/60 border border-red-100 hover:bg-red-100/70 transition group min-h-[96px]">
                <div class="w-11 h-11 bg-red-100 rounded-xl flex items-center justify-center mb-2 group-hover:scale-105 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="#dc2626" class="w-6 h-6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                </div>
                <span class="text-xs font-bold text-red-700">IGD 24 Jam</span>
            </a>

            <a href="{{ route('doctors') }}" class="flex flex-col items-center justify-center p-4 rounded-xl text-center bg-blue-50/60 border border-blue-100 hover:bg-blue-100/70 transition group min-h-[96px]">
                <div class="w-11 h-11 bg-blue-100 rounded-xl flex items-center justify-center mb-2 group-hover:scale-105 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="#1e3a5f" class="w-6 h-6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <span class="text-xs font-bold text-blue-900">Cari Dokter</span>
            </a>

            <a href="{{ route('services') }}" class="flex flex-col items-center justify-center p-4 rounded-xl text-center bg-cyan-50/60 border border-cyan-100 hover:bg-cyan-100/70 transition group min-h-[96px]">
                <div class="w-11 h-11 bg-cyan-100 rounded-xl flex items-center justify-center mb-2 group-hover:scale-105 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="#0891b2" class="w-6 h-6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>
                </div>
                <span class="text-xs font-bold text-cyan-700">Poliklinik</span>
            </a>

            <a href="{{ route('services.detail', 'medical-check-up') }}" class="flex flex-col items-center justify-center p-4 rounded-xl text-center bg-emerald-50/60 border border-emerald-100 hover:bg-emerald-100/70 transition group min-h-[96px]">
                <div class="w-11 h-11 bg-emerald-100 rounded-xl flex items-center justify-center mb-2 group-hover:scale-105 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="#16a34a" class="w-6 h-6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-xs font-bold text-emerald-700">Check-Up MCU</span>
            </a>

            <a href="{{ route('contact') }}" class="flex flex-col items-center justify-center p-4 rounded-xl text-center bg-purple-50/60 border border-purple-100 hover:bg-purple-100/70 transition group min-h-[96px]">
                <div class="w-11 h-11 bg-purple-100 rounded-xl flex items-center justify-center mb-2 group-hover:scale-105 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="#7c3aed" class="w-6 h-6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                </div>
                <span class="text-xs font-bold text-purple-700">Lokasi RS</span>
            </a>

            <a href="{{ route('contact') }}#appointment" class="flex flex-col items-center justify-center p-4 rounded-xl text-center bg-amber-50/60 border border-amber-100 hover:bg-amber-100/70 transition group min-h-[96px]">
                <div class="w-11 h-11 bg-amber-100 rounded-xl flex items-center justify-center mb-2 group-hover:scale-105 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="#d97706" class="w-6 h-6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                </div>
                <span class="text-xs font-bold text-amber-700">Buat Janji</span>
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════════════
     SECTION 3: MENGAPA MEMILIH RSU RAJAWALI CITRA
═══════════════════════════════════════════════════════════════════════════ --}}
<section class="section bg-white" aria-label="Keunggulan RSU Rajawali Citra">
    <div class="container-xl">
        <div class="text-center mb-12">
            <span class="section-label">Keunggulan Kami</span>
            <h2 class="section-title">Mengapa Memilih RSU Rajawali Citra?</h2>
            <p class="section-subtitle mx-auto">Kami hadir untuk memberikan pelayanan kesehatan terbaik dengan standar mutu tinggi, didukung fasilitas modern dan tenaga medis profesional.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
            $highlights = [
                ['icon'=>'shield-check','title'=>'Terakreditasi KARS Paripurna','desc'=>'Telah memperoleh akreditasi tertinggi dari Komisi Akreditasi Rumah Sakit (KARS), menjamin standar mutu dan keselamatan pasien.','color'=>'#16a34a'],
                ['icon'=>'users','title'=>'50+ Dokter Spesialis Berpengalaman','desc'=>'Tim dokter spesialis multidisiplin yang berpengalaman dan berdedikasi tinggi dalam menangani berbagai kondisi medis.','color'=>'#1e3a5f'],
                ['icon'=>'building-2','title'=>'Fasilitas Medis Modern','desc'=>'Dilengkapi peralatan diagnostik dan terapi terkini untuk mendukung proses diagnosis dan pengobatan yang akurat dan efektif.','color'=>'#0891b2'],
                ['icon'=>'clock','title'=>'Layanan 24 Jam IGD & Farmasi','desc'=>'IGD dan apotek beroperasi selama 24 jam penuh untuk memastikan pasien mendapat pertolongan kapan pun dibutuhkan.','color'=>'#d97706'],
                ['icon'=>'heart-pulse','title'=>'Pelayanan Humanis & Empati','desc'=>'Kami percaya bahwa penyembuhan terbaik lahir dari perpaduan kompetensi medis dan perhatian yang tulus kepada pasien.','color'=>'#dc2626'],
                ['icon'=>'credit-card','title'=>'Menerima BPJS & Asuransi','desc'=>'Melayani pasien BPJS Kesehatan, BPJS Ketenagakerjaan, dan berbagai asuransi kesehatan swasta untuk kemudahan akses.','color'=>'#7c3aed'],
            ];
            @endphp

            @foreach ($highlights as $h)
            <div class="card p-6 flex flex-col h-full">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4 shrink-0" style="background-color: {{ $h['color'] }}1a">
                    <i data-lucide="{{ $h['icon'] }}" class="w-6 h-6" style="color: {{ $h['color'] }}" aria-hidden="true"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-2">{{ $h['title'] }}</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed flex-1">{{ $h['desc'] }}</p>
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
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
            <div>
                <span class="section-label">Layanan Kami</span>
                <h2 class="section-title">Layanan Kesehatan Unggulan</h2>
                <p class="section-subtitle">Kami menyediakan layanan medis komprehensif untuk semua kebutuhan kesehatan Anda.</p>
            </div>
            <a href="{{ route('services') }}" class="btn btn-outline shrink-0 self-start md:self-auto">Lihat Semua Layanan &rarr;</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($services as $service)
            @php
            $colorMap = ['red'=>'#dc2626','blue'=>'#2563eb','green'=>'#16a34a','purple'=>'#7c3aed','cyan'=>'#0891b2','orange'=>'#d97706','teal'=>'#0f766e','pink'=>'#be185d'];
            $clr = $colorMap[$service['color']] ?? '#2563eb';
            @endphp
            <a href="{{ route('services.detail', $service['slug']) }}" class="card p-6 flex flex-col h-full text-left group no-underline">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4 shrink-0" style="background-color: {{ $clr }}1a">
                    <i data-lucide="{{ $service['icon'] }}" class="w-6 h-6" style="color: {{ $clr }}" aria-hidden="true"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-2 group-hover:text-blue-900 transition">{{ $service['name'] }}</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4 flex-1">{{ $service['short'] }}</p>
                <div class="text-xs font-bold inline-flex items-center gap-1 mt-auto" style="color: {{ $clr }}">
                    <span>Selengkapnya</span>
                    <span class="group-hover:translate-x-1 transition">&rarr;</span>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════════════
     SECTION 5: DOKTER UNGGULAN
═══════════════════════════════════════════════════════════════════════════ --}}
<section class="section bg-white" aria-label="Dokter Spesialis Kami">
    <div class="container-xl">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
            <div>
                <span class="section-label">Tim Dokter</span>
                <h2 class="section-title">Dokter Spesialis Kami</h2>
                <p class="section-subtitle">Ditangani oleh dokter spesialis berpengalaman dan berdedikasi tinggi.</p>
            </div>
            <a href="{{ route('doctors') }}" class="btn btn-outline shrink-0 self-start md:self-auto">Semua Dokter &rarr;</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach (array_slice($doctors, 0, 4) as $doctor)
            @php
            $colorMap = ['blue'=>'#2563eb','pink'=>'#be185d','green'=>'#16a34a','orange'=>'#d97706','red'=>'#dc2626','purple'=>'#7c3aed'];
            $clr = $colorMap[$doctor['color']] ?? '#2563eb';
            @endphp
            <a href="{{ route('doctors.detail', $doctor['slug']) }}" class="card p-6 text-center flex flex-col h-full group no-underline">
                <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4 border-4 shrink-0" style="background-color: {{ $clr }}1a; border-color: {{ $clr }}30">
                    <span class="text-2xl font-black" style="color: {{ $clr }}">{{ $doctor['initials'] }}</span>
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-1 group-hover:text-blue-900 transition">{{ $doctor['name'] }}</h3>
                <p class="text-xs font-bold mb-2" style="color: {{ $clr }}">{{ $doctor['specialization'] }}</p>
                <div class="text-xs text-slate-400 mb-4">{{ $doctor['polyclinic'] }}</div>
                
                <div class="mt-auto pt-3 border-t border-slate-100 text-xs text-slate-600 space-y-1">
                    @foreach (array_slice($doctor['schedule'], 0, 2) as $sched)
                    <div><span class="font-semibold">{{ $sched['day'] }}:</span> {{ $sched['time'] }}</div>
                    @endforeach
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════════════
     SECTION 6: STATISTIK & FAKTA RUMAH SAKIT
═══════════════════════════════════════════════════════════════════════════ --}}
<section class="bg-blue-900 py-12 lg:py-16 text-white" aria-label="Data Rumah Sakit">
    <div class="container-xl">
        <div class="text-center mb-10">
            <span class="section-label bg-white/10 text-white/90">RSU Rajawali Citra dalam Angka</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-white mt-2">Bukti Komitmen Kami untuk Kesehatan Anda</h2>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6 lg:gap-8 text-center">
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
            <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                <div class="text-3xl sm:text-4xl font-black text-white leading-tight">{{ $fact['value'] }}</div>
                <div class="text-sm font-bold text-white/90 mt-1">{{ $fact['label'] }}</div>
                <div class="text-xs text-white/60 mt-0.5">{{ $fact['sub'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════════════
     SECTION 7: JADWAL DOKTER TABEL RESPONSIVE
═══════════════════════════════════════════════════════════════════════════ --}}
<section class="section section-alt" aria-label="Jadwal Dokter">
    <div class="container-xl">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
            <div>
                <span class="section-label primary">Jadwal Praktik</span>
                <h2 class="section-title">Jadwal Dokter Hari Ini</h2>
                <p class="section-subtitle">Temukan dokter dan jadwal praktik yang sesuai dengan kebutuhan Anda.</p>
            </div>
            <a href="{{ route('doctors') }}" class="btn btn-primary shrink-0 self-start md:self-auto">Lihat Semua Jadwal</a>
        </div>

        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm border-collapse">
                    <thead>
                        <tr class="bg-blue-900 text-white">
                            <th class="py-3.5 px-5 font-bold text-xs whitespace-nowrap">Dokter</th>
                            <th class="py-3.5 px-5 font-bold text-xs whitespace-nowrap">Spesialisasi</th>
                            <th class="py-3.5 px-5 font-bold text-xs whitespace-nowrap">Poliklinik</th>
                            <th class="py-3.5 px-5 font-bold text-xs whitespace-nowrap">Jadwal Praktik</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($doctors as $i => $doctor)
                        <tr class="{{ $i % 2 === 0 ? 'bg-white' : 'bg-slate-50/50' }} hover:bg-blue-50/50 transition">
                            <td class="py-3.5 px-5">
                                <a href="{{ route('doctors.detail', $doctor['slug']) }}" class="font-bold text-blue-900 hover:underline">
                                    {{ $doctor['name'] }}
                                </a>
                            </td>
                            <td class="py-3.5 px-5 text-slate-600">{{ $doctor['specialization'] }}</td>
                            <td class="py-3.5 px-5 text-slate-600">{{ $doctor['polyclinic'] }}</td>
                            <td class="py-3.5 px-5">
                                <div class="flex flex-wrap gap-1.5">
                                    @foreach ($doctor['schedule'] as $s)
                                    <span class="text-xs bg-blue-100/70 text-blue-900 px-2.5 py-0.5 rounded-full font-semibold whitespace-nowrap">
                                        {{ $s['day'] }}: {{ $s['time'] }}
                                    </span>
                                    @endforeach
                                </div>
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
<section class="section bg-white" aria-label="Fasilitas Rumah Sakit">
    <div class="container-xl">
        <div class="text-center mb-12">
            <span class="section-label">Fasilitas</span>
            <h2 class="section-title">Fasilitas Rumah Sakit Modern</h2>
            <p class="section-subtitle mx-auto">Didukung oleh peralatan medis terkini dan fasilitas pendukung yang nyaman untuk pasien dan keluarga.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
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
            <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 border-l-4 flex flex-col h-full" style="border-left-color: {{ $f['color'] }}">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center mb-4 shrink-0" style="background-color: {{ $f['color'] }}1a">
                    <i data-lucide="{{ $f['icon'] }}" class="w-5 h-5" style="color: {{ $f['color'] }}" aria-hidden="true"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-2">{{ $f['title'] }}</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed flex-1">{{ $f['desc'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════════════
     SECTION 9: DAFTAR POLIKLINIK
═══════════════════════════════════════════════════════════════════════════ --}}
<section class="section section-alt" aria-label="Daftar Poliklinik">
    <div class="container-xl">
        <div class="text-center mb-10">
            <span class="section-label primary">Poliklinik</span>
            <h2 class="section-title">15+ Poliklinik Spesialis</h2>
            <p class="section-subtitle mx-auto">Tersedia poliklinik spesialis dan subspesialis untuk melayani berbagai kebutuhan kesehatan Anda.</p>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
            @php
            $polyclinics = [
                'Poli Umum','Poli Anak','Poli Kandungan','Poli Jantung','Poli Bedah Umum',
                'Poli Saraf','Poli Penyakit Dalam','Poli THT','Poli Mata','Poli Kulit & Kelamin',
                'Poli Ortopedi','Poli Gigi & Mulut','Poli Jiwa','Poli Paru','Poli Gizi Klinik',
            ];
            @endphp
            @foreach ($polyclinics as $poli)
            <div class="bg-white border border-slate-200 rounded-xl p-3.5 flex items-center gap-2.5 text-xs font-semibold text-slate-800 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-cyan-600 shrink-0" aria-hidden="true"></span>
                <span class="truncate">{{ $poli }}</span>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-8">
            <a href="{{ route('services') }}" class="btn btn-primary">Lihat Semua Layanan</a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════════════
     SECTION 10: ARTIKEL KESEHATAN
═══════════════════════════════════════════════════════════════════════════ --}}
<section class="section bg-white" aria-label="Artikel Kesehatan">
    <div class="container-xl">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
            <div>
                <span class="section-label">Edukasi Kesehatan</span>
                <h2 class="section-title">Artikel &amp; Informasi Kesehatan</h2>
                <p class="section-subtitle">Tips dan informasi kesehatan dari para dokter spesialis kami.</p>
            </div>
            <a href="{{ route('articles') }}" class="btn btn-outline shrink-0 self-start md:self-auto">Semua Artikel &rarr;</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
            $colorMap = ['red'=>'#dc2626','blue'=>'#2563eb','green'=>'#16a34a','orange'=>'#d97706'];
            @endphp
            @foreach ($articles as $article)
            @php $clr = $colorMap[$article['color']] ?? '#2563eb'; @endphp
            <article class="card flex flex-col h-full overflow-hidden">
                <div class="p-5 border-b border-slate-100" style="background-color: {{ $clr }}0d">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-extrabold uppercase tracking-wide" style="background-color: {{ $clr }}1a; color: {{ $clr }}">
                        {{ $article['category'] }}
                    </span>
                </div>
                <div class="p-5 flex flex-col flex-1">
                    <h3 class="text-base font-bold text-slate-900 mb-2 leading-snug">
                        <a href="{{ route('articles.detail', $article['slug']) }}" class="hover:text-blue-900 transition no-underline">
                            {{ $article['title'] }}
                        </a>
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4 flex-1">{{ $article['excerpt'] }}</p>
                    <div class="flex items-center justify-between text-xs text-slate-400 mt-auto pt-3 border-t border-slate-100">
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
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
            <div>
                <span class="section-label primary">Berita &amp; Pengumuman</span>
                <h2 class="section-title">Berita Terbaru</h2>
                <p class="section-subtitle">Informasi terkini seputar RSU Rajawali Citra dan program layanan kami.</p>
            </div>
            <a href="{{ route('news') }}" class="btn btn-outline shrink-0 self-start md:self-auto">Semua Berita &rarr;</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
            $colorMap = ['blue'=>'#2563eb','green'=>'#16a34a','orange'=>'#d97706'];
            @endphp
            @foreach ($news as $item)
            @php $clr = $colorMap[$item['color']] ?? '#2563eb'; @endphp
            <article class="card flex flex-col h-full">
                <div class="p-4 border-b border-slate-100 flex items-center justify-between">
                    <span class="badge badge-{{ $item['color'] }}">{{ $item['category'] }}</span>
                    <time class="text-xs text-slate-400" datetime="{{ $item['date'] }}">{{ $item['date'] }}</time>
                </div>
                <div class="p-5 flex-1 flex flex-col">
                    <h3 class="text-base font-bold text-slate-900 mb-2 leading-snug">
                        <a href="{{ route('news.detail', $item['slug']) }}" class="hover:text-blue-900 transition no-underline">
                            {{ $item['title'] }}
                        </a>
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4 flex-1">{{ $item['excerpt'] }}</p>
                </div>
                <div class="p-4 border-t border-slate-100 mt-auto">
                    <a href="{{ route('news.detail', $item['slug']) }}" class="text-xs font-bold no-underline" style="color: {{ $clr }}">
                        Baca Selengkapnya &rarr;
                    </a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════════════
     SECTION 12: TESTIMONI PASIEN
═══════════════════════════════════════════════════════════════════════════ --}}
<section class="section bg-white" aria-label="Testimoni Pasien">
    <div class="container-xl">
        <div class="text-center mb-12">
            <span class="section-label">Testimoni</span>
            <h2 class="section-title">Apa Kata Pasien Kami</h2>
            <p class="section-subtitle mx-auto">Kepercayaan pasien adalah motivasi terbesar kami untuk terus meningkatkan kualitas pelayanan.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
            $testimonials = [
                ['name'=>'Ibu Ratna Wulandari','role'=>'Pasien Poliklinik Anak','text'=>'Dokter anak di sini sangat sabar dan teliti menangani anak saya. Pelayanannya ramah dan tidak membuat anak takut. Fasilitas ruang tunggu juga nyaman.','initials'=>'RW','color'=>'#2563eb'],
                ['name'=>'Bapak Hendra Kusuma','role'=>'Pasien Rawat Inap','text'=>'Saya dirawat selama 5 hari di sini. Perawat sangat perhatian dan cepat tanggap. Kamar bersih dan nyaman. Dokternya pun rutin visite setiap hari.','initials'=>'HK','color'=>'#16a34a'],
                ['name'=>'Ibu Sri Wahyuni','role'=>'Pasien Kebidanan','text'=>'Terima kasih RSU Rajawali Citra atas pelayanannya yang luar biasa saat persalinan. Proses melahirkan berjalan lancar berkat dukungan tim dokter dan bidan.','initials'=>'SW','color'=>'#be185d'],
            ];
            @endphp
            @foreach ($testimonials as $t)
            <figure class="bg-slate-50 border border-slate-200 rounded-2xl p-6 flex flex-col h-full m-0">
                <div class="flex gap-1 text-amber-400 mb-3" aria-label="5 dari 5 bintang">
                    <i data-lucide="star" class="w-4 h-4 fill-amber-400 text-amber-400" aria-hidden="true"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-amber-400 text-amber-400" aria-hidden="true"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-amber-400 text-amber-400" aria-hidden="true"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-amber-400 text-amber-400" aria-hidden="true"></i>
                    <i data-lucide="star" class="w-4 h-4 fill-amber-400 text-amber-400" aria-hidden="true"></i>
                </div>
                <blockquote class="text-xs sm:text-sm text-slate-700 leading-relaxed italic mb-6 flex-1">"{{ $t['text'] }}"</blockquote>
                <figcaption class="flex items-center gap-3 mt-auto pt-4 border-t border-slate-200">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-extrabold text-sm shrink-0" style="background-color: {{ $t['color'] }}20; color: {{ $t['color'] }}">
                        {{ $t['initials'] }}
                    </div>
                    <div>
                        <div class="text-sm font-bold text-slate-900">{{ $t['name'] }}</div>
                        <div class="text-xs text-slate-500">{{ $t['role'] }}</div>
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
<section class="bg-slate-100 py-10 border-y border-slate-200" aria-label="Akreditasi dan Kepercayaan">
    <div class="container-xl">
        <div class="text-center mb-6">
            <h2 class="text-sm font-bold text-slate-600 uppercase tracking-widest">Dipercaya &amp; Diakui Institusi Resmi</h2>
        </div>
        <div class="flex flex-wrap justify-center gap-4 sm:gap-6 items-center">
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
            <div class="flex items-center gap-3 bg-white border border-slate-200 rounded-xl p-3 px-4 shadow-sm">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0" style="background-color: {{ $acc['color'] }}15">
                    <i data-lucide="{{ $acc['icon'] }}" class="w-4 h-4" style="color: {{ $acc['color'] }}" aria-hidden="true"></i>
                </div>
                <div>
                    <div class="text-xs font-black text-slate-900">{{ $acc['label'] }}</div>
                    <div class="text-[11px] text-slate-500 font-medium">{{ $acc['sub'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════════════
     SECTION 14: FAQ ACCORDION
═══════════════════════════════════════════════════════════════════════════ --}}
<section class="section bg-white" aria-label="Pertanyaan Umum">
    <div class="container-xl">
        <div class="text-center mb-10">
            <span class="section-label primary">FAQ</span>
            <h2 class="section-title">Pertanyaan yang Sering Diajukan</h2>
            <p class="section-subtitle mx-auto">Temukan jawaban atas pertanyaan umum seputar layanan RSU Rajawali Citra.</p>
        </div>

        <div class="max-w-3xl mx-auto space-y-3" role="list">
            @foreach ($faqs as $i => $faq)
            <div role="listitem" class="border border-slate-200 rounded-xl overflow-hidden bg-white shadow-sm">
                <button
                    id="faq-btn-{{ $i }}"
                    onclick="toggleFaq({{ $i }})"
                    aria-expanded="false"
                    aria-controls="faq-panel-{{ $i }}"
                    class="w-full flex items-center justify-between p-4 sm:p-5 text-left bg-none border-none cursor-pointer gap-4 transition hover:bg-slate-50">
                    <span class="text-sm font-bold text-slate-900 leading-snug">{{ $faq['q'] }}</span>
                    <svg id="faq-icon-{{ $i }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-slate-400 shrink-0 transition-transform duration-200" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                    </svg>
                </button>
                <div id="faq-panel-{{ $i }}" role="region" aria-labelledby="faq-btn-{{ $i }}" class="hidden px-4 sm:px-5 pb-5 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                    {{ $faq['a'] }}
                </div>
            </div>
            @endforeach
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('faq') }}" class="btn btn-outline">Lihat Semua FAQ &rarr;</a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════════════════════════════
     SECTION 15: CTA APPOINTMENT BANNER
═══════════════════════════════════════════════════════════════════════════ --}}
<section class="bg-gradient-to-r from-blue-900 via-blue-800 to-cyan-700 py-16 lg:py-20 text-white relative overflow-hidden" aria-label="Hubungi Kami">
    <div aria-hidden="true" class="absolute -top-20 -right-20 w-80 h-80 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>
    <div aria-hidden="true" class="absolute -bottom-20 -left-20 w-80 h-80 bg-white/5 rounded-full blur-2xl pointer-events-none"></div>

    <div class="container-xl relative z-10 text-center">
        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-black text-white mb-4 leading-tight">
            Butuh Bantuan Medis?<br>Kami Siap Melayani Anda
        </h2>
        <p class="text-sm sm:text-base text-white/80 max-w-xl mx-auto mb-8 leading-relaxed">
            Jangan tunda kesehatan Anda. Hubungi kami sekarang atau buat janji temu dengan dokter spesialis pilihan Anda secara online.
        </p>

        <div class="flex flex-col sm:flex-row items-center justify-center gap-3.5 mb-10">
            <a href="{{ route('contact') }}#appointment" class="btn btn-lg w-full sm:w-auto bg-white text-blue-900 hover:bg-slate-100 font-extrabold shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                <span>Buat Janji Temu</span>
            </a>
            <a href="{{ route('doctors') }}" class="btn btn-outline-white btn-lg w-full sm:w-auto">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>Cari Dokter</span>
            </a>
            <a href="tel:+62274123456" class="btn btn-lg w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white border-red-600 shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                <span>IGD 24 Jam</span>
            </a>
        </div>

        <div class="flex flex-wrap items-center justify-center gap-6 sm:gap-10 text-xs text-white/80">
            <div class="flex items-center gap-2">
                <i data-lucide="phone" class="w-4 h-4" aria-hidden="true"></i>
                <span class="font-semibold">+62 274-123-456</span>
            </div>
            <div class="flex items-center gap-2">
                <i data-lucide="message-square" class="w-4 h-4" aria-hidden="true"></i>
                <span class="font-semibold">0821-3431-3535</span>
            </div>
            <div class="flex items-center gap-2">
                <i data-lucide="mail" class="w-4 h-4" aria-hidden="true"></i>
                <span class="font-semibold">info@rsurajawalicitra.co.id</span>
            </div>
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
    if (!panel) return;

    const isOpen = !panel.classList.contains('hidden');

    // Close all FAQs
    document.querySelectorAll('[id^="faq-panel-"]').forEach(function(p) { p.classList.add('hidden'); });
    document.querySelectorAll('[id^="faq-icon-"]').forEach(function(i) { i.style.transform = ''; });
    document.querySelectorAll('[id^="faq-btn-"]').forEach(function(b) { b.setAttribute('aria-expanded', 'false'); });

    if (!isOpen) {
        panel.classList.remove('hidden');
        if (icon) icon.style.transform = 'rotate(180deg)';
        if (btn) btn.setAttribute('aria-expanded', 'true');
    }
}
</script>
@endpush
