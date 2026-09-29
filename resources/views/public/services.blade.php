@extends('layouts.public')

@section('title', 'Layanan Kesehatan RSU Rajawali Citra')
@section('meta_description', 'RSU Rajawali Citra menyediakan layanan kesehatan lengkap: IGD 24 Jam, Poliklinik Spesialis, Rawat Inap, Laboratorium, Radiologi, Farmasi, MCU, dan Kebidanan. Bantul, Yogyakarta.')
@section('og_title', 'Layanan Kesehatan — RSU Rajawali Citra')

@push('head')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "MedicalOrganization",
  "name": "RSU Rajawali Citra",
  "medicalSpecialty": [
    "Emergency","Cardiology","Pediatrics","Obstetrics","Surgery","InternalMedicine","Radiology","Laboratory"
  ]
}
</script>
@endpush

@section('content')

{{-- Page Hero --}}
<section class="page-hero" aria-label="Layanan Kesehatan">
    <div class="container-xl">
        <nav class="breadcrumb mb-4" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <span aria-current="page">Layanan</span>
        </nav>
        <span class="section-label">Layanan Medis Kami</span>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 mt-2 mb-4 leading-tight">
            Layanan Kesehatan<br>Komprehensif &amp; Terpercaya
        </h1>
        <p class="text-base sm:text-lg text-slate-600 max-w-2xl leading-relaxed">
            Kami menyediakan rangkaian lengkap layanan medis untuk memenuhi setiap kebutuhan kesehatan Anda dan keluarga dengan standar pelayanan tertinggi.
        </p>
    </div>
</section>

{{-- ═══ SECTION 2: EMERGENCY HIGHLIGHT ═══ --}}
<section class="bg-red-50 border-b border-red-200 py-6" aria-label="IGD Darurat">
    <div class="container-xl">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center shrink-0 text-white shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                </div>
                <div>
                    <div class="text-base font-extrabold text-red-900 flex items-center gap-1.5 justify-center sm:justify-start">
                        <i data-lucide="siren" class="w-4 h-4" aria-hidden="true"></i> Instalasi Gawat Darurat (IGD) — Siap 24 Jam
                    </div>
                    <div class="text-xs sm:text-sm text-red-700 mt-0.5">Untuk kondisi darurat medis, segera hubungi tim IGD kami atau datang langsung ke RS</div>
                </div>
            </div>
            <a href="tel:+62274123456" class="btn btn-lg bg-red-600 hover:bg-red-700 text-white border-red-600 shadow-md shrink-0 w-full sm:w-auto">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                <span>IGD: +62 274-123-456</span>
            </a>
        </div>
    </div>
</section>

{{-- ═══ SECTION 3: ALL SERVICES ═══ --}}
<section class="section bg-white" aria-label="Semua Layanan">
    <div class="container-xl">
        <div class="text-center mb-12">
            <span class="section-label">Layanan Utama</span>
            <h2 class="section-title">Pilihan Layanan Kesehatan</h2>
            <p class="section-subtitle mx-auto">Dari gawat darurat hingga pemeriksaan rutin, kami siap mendampingi perjalanan kesehatan Anda.</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @php
            $colorMap = ['red'=>'#dc2626','blue'=>'#2563eb','green'=>'#16a34a','purple'=>'#7c3aed','cyan'=>'#0891b2','orange'=>'#d97706','teal'=>'#0f766e','pink'=>'#be185d'];
            @endphp
            @foreach ($services as $service)
            @php $clr = $colorMap[$service['color']] ?? '#2563eb'; @endphp
            <article class="card flex flex-col h-full overflow-hidden">
                <div class="h-1.5" style="background-color: {{ $clr }}"></div>
                <div class="p-6 flex flex-col flex-1">
                    <div class="flex items-start gap-3.5 mb-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0" style="background-color: {{ $clr }}15">
                            <i data-lucide="{{ $service['icon'] }}" class="w-6 h-6" style="color: {{ $clr }}" aria-hidden="true"></i>
                        </div>
                        <div>
                            <h2 class="text-base font-extrabold text-slate-900 leading-snug mb-1">{{ $service['name'] }}</h2>
                            <span class="text-[11px] font-bold px-2 py-0.5 rounded-full" style="background-color: {{ $clr }}12; color: {{ $clr }}">
                                {{ $service['hours'] }}
                            </span>
                        </div>
                    </div>

                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4 flex-1">{{ $service['short'] }}</p>

                    <ul class="space-y-1.5 mb-5 text-xs text-slate-600">
                        @foreach (array_slice($service['features'], 0, 3) as $feat)
                        <li class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="{{ $clr }}" class="w-3.5 h-3.5 shrink-0" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            <span>{{ $feat }}</span>
                        </li>
                        @endforeach
                    </ul>

                    <div class="flex items-center justify-between pt-3 border-t border-slate-100 text-xs mt-auto">
                        <span class="text-slate-400 font-medium truncate max-w-[180px]">{{ $service['location'] }}</span>
                        <a href="{{ route('services.detail', $service['slug']) }}" class="font-bold no-underline hover:underline" style="color: {{ $clr }}">
                            Detail &rarr;
                        </a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ SECTION 4: DAFTAR POLIKLINIK ═══ --}}
<section class="section section-alt" aria-label="Daftar Poliklinik">
    <div class="container-xl">
        <div class="text-center mb-10">
            <span class="section-label primary">Poliklinik</span>
            <h2 class="section-title">Poliklinik Spesialis &amp; Subspesialis</h2>
            <p class="section-subtitle mx-auto">Tersedia 15+ poliklinik spesialis dengan dokter berpengalaman siap melayani Anda.</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3">
            @php
            $polyclinics = [
                'Poli Penyakit Dalam','Poli Kebidanan & Kandungan','Poli Bedah Umum','Poli Anak','Poli Jantung & Pembuluh Darah',
                'Poli Saraf','Poli THT-KL','Poli Mata','Poli Kulit & Kelamin','Poli Ortopedi',
                'Poli Gigi & Mulut','Poli Jiwa','Poli Paru','Poli Gizi Klinik','Poli Umum / MCU',
            ];
            @endphp
            @foreach ($polyclinics as $poli)
            <div class="bg-white border border-slate-200 rounded-xl p-3.5 flex items-center gap-2 text-xs font-semibold text-slate-800 shadow-sm">
                <span class="w-2 h-2 rounded-full bg-blue-900 shrink-0" aria-hidden="true"></span>
                <span class="truncate">{{ $poli }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
