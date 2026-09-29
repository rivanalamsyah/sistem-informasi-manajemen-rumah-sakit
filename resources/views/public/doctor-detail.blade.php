@extends('layouts.public')

@section('title', $doctor['name'] . ' — ' . $doctor['specialization'])
@section('meta_description', 'Profil ' . $doctor['name'] . ', ' . $doctor['specialization'] . ' di RSU Rajawali Citra. Jadwal praktik, layanan, dan informasi konsultasi.')
@section('og_title', $doctor['name'] . ' — RSU Rajawali Citra')

@push('head')
<script type="application/ld+json">
{
  "@context": "https://schema.org",
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
<section class="page-hero pb-8 lg:pb-12" aria-label="Profil Dokter">
    <div class="container-xl">
        <nav class="breadcrumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <a href="{{ route('doctors') }}">Dokter &amp; Jadwal</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <span aria-current="page">{{ $doctor['name'] }}</span>
        </nav>
    </div>
</section>

<section class="section bg-white" aria-label="Profil Dokter Detail">
    <div class="container-xl">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">

            {{-- Sidebar Avatar & Schedule --}}
            <aside class="lg:col-span-4 space-y-6">
                {{-- Profile Card --}}
                <div class="card p-6 text-center">
                    <div class="w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-4 border-4 shadow-sm shrink-0" style="background-color: {{ $clr }}15; border-color: {{ $clr }}25">
                        <span class="text-3xl font-black" style="color: {{ $clr }}">{{ $doctor['initials'] }}</span>
                    </div>
                    <h1 class="text-lg font-extrabold text-slate-900 mb-1 leading-snug">{{ $doctor['name'] }}</h1>
                    <p class="text-xs sm:text-sm font-bold mb-1" style="color: {{ $clr }}">{{ $doctor['specialization'] }}</p>
                    <p class="text-xs text-slate-400 mb-4">{{ $doctor['polyclinic'] }}</p>

                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-100 mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#16a34a" class="w-4 h-4" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>{{ $doctor['experience'] }} Pengalaman</span>
                    </span>

                    <div class="space-y-2.5">
                        <a href="{{ route('contact') }}#appointment" class="btn btn-primary w-full justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>
                            <span>Buat Janji Temu</span>
                        </a>
                        <a href="https://wa.me/628213431353" target="_blank" rel="noopener" class="btn btn-outline w-full justify-center">
                            <span>WhatsApp CS</span>
                        </a>
                    </div>
                </div>

                {{-- Schedule Card --}}
                <div class="card p-6 bg-white space-y-4">
                    <h3 class="text-xs font-extrabold text-slate-900 uppercase tracking-wider">Jadwal Praktik</h3>
                    <div class="space-y-2 text-xs sm:text-sm">
                        @foreach ($doctor['schedule'] as $sched)
                        <div class="flex items-center justify-between p-2.5 rounded-xl bg-slate-50 border border-slate-100">
                            <span class="font-bold text-slate-900">{{ $sched['day'] }}</span>
                            <span class="font-bold" style="color: {{ $clr }}">{{ $sched['time'] }}</span>
                        </div>
                        @endforeach
                    </div>
                    <p class="text-[11px] text-slate-400 leading-relaxed">*Jadwal dapat berubah sewaktu-waktu. Harap konfirmasi sebelum datang.</p>
                </div>
            </aside>

            {{-- Main Content --}}
            <main class="lg:col-span-8 space-y-8">
                {{-- Education --}}
                <div class="space-y-4">
                    <h2 class="text-lg sm:text-xl font-extrabold text-slate-900 pb-2 border-b-2" style="border-bottom-color: {{ $clr }}">
                        Pendidikan &amp; Kualifikasi Medis
                    </h2>
                    <ul class="space-y-2.5 text-xs sm:text-sm text-slate-700">
                        @foreach ($doctor['education'] as $edu)
                        <li class="flex items-start gap-3">
                            <div class="w-6 h-6 rounded-full flex items-center justify-center shrink-0 mt-0.5" style="background-color: {{ $clr }}15">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="{{ $clr }}" class="w-3.5 h-3.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.636 50.636 0 00-2.658-.813A59.906 59.906 0 0112 3.493a59.903 59.903 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"/></svg>
                            </div>
                            <span class="font-medium">{{ $edu }}</span>
                        </li>
                        @endforeach
                    </ul>
                </div>

                {{-- Services --}}
                <div class="space-y-4">
                    <h2 class="text-lg sm:text-xl font-extrabold text-slate-900 pb-2 border-b-2" style="border-bottom-color: {{ $clr }}">
                        Layanan &amp; Bidang Keahlian
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach ($doctor['services'] as $service)
                        <div class="flex items-center gap-3 p-3.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm font-medium text-slate-800">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="{{ $clr }}" class="w-4 h-4 shrink-0" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            <span>{{ $service }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Polyclinic Summary --}}
                <div class="rounded-2xl p-6 border border-slate-200" style="background-color: {{ $clr }}08">
                    <h3 class="text-sm font-bold text-slate-900 mb-3">Informasi Poliklinik Praktik</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs sm:text-sm">
                        <div>
                            <span class="text-[11px] font-bold uppercase tracking-wider block mb-1" style="color: {{ $clr }}">Poliklinik</span>
                            <span class="font-bold text-slate-900">{{ $doctor['polyclinic'] }}</span>
                        </div>
                        <div>
                            <span class="text-[11px] font-bold uppercase tracking-wider block mb-1" style="color: {{ $clr }}">Pengalaman Kerja</span>
                            <span class="font-bold text-slate-900">{{ $doctor['experience'] }}</span>
                        </div>
                    </div>
                </div>

                {{-- CTA Box --}}
                <div class="rounded-2xl p-6 text-center text-white space-y-4 shadow-md" style="background: linear-gradient(135deg, var(--color-primary) 0%, {{ $clr }} 100%)">
                    <h3 class="text-lg font-extrabold text-white">Konsultasikan Kesehatan Anda</h3>
                    <p class="text-xs sm:text-sm text-white/80 max-w-md mx-auto leading-relaxed">
                        Buat janji temu dengan {{ $doctor['name'] }} sekarang.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center gap-3 pt-1">
                        <a href="{{ route('contact') }}#appointment" class="btn bg-white text-blue-900 hover:bg-slate-100 font-bold">
                            Buat Janji Temu
                        </a>
                        <a href="tel:+62274123456" class="btn btn-outline-white">
                            Telepon RS
                        </a>
                    </div>
                </div>
            </main>
        </div>

        <div class="mt-10 pt-6 border-t border-slate-200">
            <a href="{{ route('doctors') }}" class="inline-flex items-center gap-2 text-xs sm:text-sm font-bold text-blue-900 hover:underline">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/></svg>
                <span>Kembali ke Daftar Dokter</span>
            </a>
        </div>
    </div>
</section>

@endsection
