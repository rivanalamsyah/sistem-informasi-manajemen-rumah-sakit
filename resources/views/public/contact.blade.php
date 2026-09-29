@extends('layouts.public')

@section('title', 'Kontak & Lokasi — RSU Rajawali Citra')
@section('meta_description', 'Hubungi RSU Rajawali Citra: telepon, WhatsApp, email, dan lokasi. IGD 24 jam: +62 274-123-456. Jl. Pleret No. KM 2.5, Bantul, Yogyakarta.')
@section('og_title', 'Kontak & Lokasi — RSU Rajawali Citra')

@push('head')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "ContactPage",
  "name": "Kontak RSU Rajawali Citra",
  "url": "{{ route('contact') }}",
  "mainEntity": {
    "@@type": "Hospital",
    "name": "RSU Rajawali Citra",
    "telephone": "+62274123456",
    "email": "info@rsurajawalicitra.co.id",
    "address": {
      "@@type": "PostalAddress",
      "streetAddress": "Jl. Pleret No. KM 2.5, Banjardadap, Potorono, Banguntapan",
      "addressLocality": "Bantul",
      "addressRegion": "DI Yogyakarta",
      "postalCode": "55196",
      "addressCountry": "ID"
    }
  }
}
</script>
@endpush

@section('content')

{{-- Page Hero --}}
<section class="page-hero" aria-label="Kontak dan Lokasi">
    <div class="container-xl">
        <nav class="breadcrumb mb-4" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <span aria-current="page">Kontak</span>
        </nav>
        <span class="section-label">Hubungi Kami</span>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 mt-2 mb-4 leading-tight">
            Kontak &amp; Lokasi<br>RSU Rajawali Citra
        </h1>
        <p class="text-base sm:text-lg text-slate-600 max-w-2xl leading-relaxed">
            Kami siap melayani setiap pertanyaan, kebutuhan informasi, dan keperluan medis Anda. Hubungi kami kapan saja.
        </p>
    </div>
</section>

{{-- ═══ SECTION 2: EMERGENCY CONTACT ═══ --}}
<section class="bg-red-50 border-b border-red-200 py-8" aria-label="Kontak Darurat">
    <div class="container-xl">
        <div class="text-center mb-6">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-red-100 text-red-900 rounded-full text-xs font-extrabold uppercase tracking-wide">
                <i data-lucide="siren" class="w-4 h-4" aria-hidden="true"></i> Kontak Darurat
            </span>
            <h2 class="text-xl sm:text-2xl font-extrabold text-red-900 mt-2">Untuk Kondisi Darurat Medis</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-3xl mx-auto">
            <a href="tel:+62274123456" class="flex items-center gap-4 bg-white border-2 border-red-200 hover:border-red-600 rounded-2xl p-5 no-underline transition shadow-sm hover:shadow-md">
                <div class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center text-white shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                </div>
                <div>
                    <div class="text-xs font-extrabold text-red-900 uppercase tracking-wider">IGD 24 Jam</div>
                    <div class="text-lg sm:text-xl font-black text-red-900">+62 274-123-456</div>
                </div>
            </a>

            <a href="https://wa.me/628213431353" target="_blank" rel="noopener" class="flex items-center gap-4 bg-white border-2 border-red-200 hover:border-red-600 rounded-2xl p-5 no-underline transition shadow-sm hover:shadow-md">
                <div class="w-12 h-12 bg-red-600 rounded-xl flex items-center justify-center text-white shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 01.778-.332 48.294 48.294 0 005.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>
                </div>
                <div>
                    <div class="text-xs font-extrabold text-red-900 uppercase tracking-wider">WhatsApp Emergency</div>
                    <div class="text-lg sm:text-xl font-black text-red-900">0821-3431-3535</div>
                </div>
            </a>
        </div>
    </div>
</section>

{{-- ═══ SECTION 3: KONTAK CARDS ═══ --}}
<section class="section bg-white" aria-label="Informasi Kontak">
    <div class="container-xl">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
            $contacts = [
                ['type'=>'Telepon RS','value'=>'+62 274-123-456','sub'=>'Senin – Minggu, 07.00 – 21.00','icon'=>'phone','color'=>'#2563eb','href'=>'tel:+62274123456'],
                ['type'=>'WhatsApp CS','value'=>'0821-3431-3535','sub'=>'Respon cepat jam kerja','icon'=>'message-circle','color'=>'#16a34a','href'=>'https://wa.me/628213431353'],
                ['type'=>'Email Resmi','value'=>'info@rsurajawalicitra.co.id','sub'=>'Dibalas dalam 1x24 jam','icon'=>'mail','color'=>'#7c3aed','href'=>'mailto:info@rsurajawalicitra.co.id'],
                ['type'=>'Alamat Lokasi','value'=>'Jl. Pleret KM 2.5, Bantul','sub'=>'Banjardadap, Potorono','icon'=>'map-pin','color'=>'#0891b2','href'=>'https://maps.app.goo.gl/uasyyefyNzfUhqpZ8'],
            ];
            @endphp
            @foreach ($contacts as $contact)
            <a href="{{ $contact['href'] }}" {{ str_starts_with($contact['href'], 'http') ? 'target="_blank" rel="noopener"' : '' }} class="card p-6 flex items-start gap-4 no-underline group h-full">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0" style="background-color: {{ $contact['color'] }}15">
                    <i data-lucide="{{ $contact['icon'] }}" class="w-6 h-6" style="color: {{ $contact['color'] }}" aria-hidden="true"></i>
                </div>
                <div>
                    <div class="text-[11px] font-extrabold text-slate-400 uppercase tracking-wider mb-1">{{ $contact['type'] }}</div>
                    <div class="text-sm font-bold text-slate-900 group-hover:text-blue-900 transition">{{ $contact['value'] }}</div>
                    <div class="text-xs text-slate-500 mt-0.5">{{ $contact['sub'] }}</div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ SECTION 4: MAP & HOURS ═══ --}}
<section class="section section-alt" aria-label="Lokasi dan Jam Operasional">
    <div class="container-xl">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            {{-- Map --}}
            <div class="lg:col-span-7 space-y-4">
                <span class="section-label">Lokasi</span>
                <h2 class="section-title">Temukan Kami</h2>
                
                <div class="bg-white border border-slate-200 rounded-2xl overflow-hidden shadow-sm">
                    <div class="aspect-[16/9] w-full relative">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.440776147397!2d110.40773137366544!3d-7.848850977998022!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a56c4442f9a19%3A0x620bd0f866a31124!2sRajawali%20Citra%20General%20Hospital!5e0!3m2!1sen!2sid!4v1790655244706!5m2!1sen!2sid"
                            class="w-full h-full border-0"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="strict-origin-when-cross-origin"
                            title="Lokasi RSU Rajawali Citra di Google Maps"
                        ></iframe>
                    </div>
                    <div class="p-4 bg-slate-50 border-t border-slate-200 flex flex-col sm:flex-row items-center justify-between gap-3">
                        <div class="text-xs text-slate-600 font-medium">
                            <strong>RSU Rajawali Citra:</strong> Jl. Pleret KM 2.5, Potorono, Banguntapan, Bantul
                        </div>
                        <a href="https://maps.app.goo.gl/uasyyefyNzfUhqpZ8" target="_blank" rel="noopener" class="btn btn-primary btn-sm shrink-0">
                            <i data-lucide="map-pin" class="w-4 h-4" aria-hidden="true"></i>
                            <span>Buka di Aplikasi Google Maps</span>
                        </a>
                    </div>
                </div>

                <div class="bg-white border border-slate-200 rounded-xl p-5 space-y-2 text-xs sm:text-sm text-slate-600">
                    <h3 class="text-xs font-extrabold text-slate-900 uppercase tracking-wider mb-2">Petunjuk Akses Transportasi</h3>
                    <div class="flex gap-2"><span class="text-cyan-700 font-bold">•</span> Dari Kota Yogyakarta: ±15 menit via Jl. Wonosari</div>
                    <div class="flex gap-2"><span class="text-cyan-700 font-bold">•</span> Dari Bandara YIA: ±45 menit via Jl. Lingkar Selatan</div>
                    <div class="flex gap-2"><span class="text-cyan-700 font-bold">•</span> Tersedia lahan parkir luas kendaraan roda dua &amp; roda empat</div>
                </div>
            </div>

            {{-- Hours --}}
            <div class="lg:col-span-5 space-y-4">
                <span class="section-label primary">Jam Operasional</span>
                <h2 class="section-title">Jam Layanan RS</h2>
                <div class="bg-white border border-slate-200 rounded-2xl p-6 space-y-3.5 divide-y divide-slate-100">
                    @php
                    $hours = [
                        ['service'=>'IGD / Gawat Darurat','hours'=>'24 Jam / 7 Hari','note'=>'Emergency 24 Jam','color'=>'#dc2626'],
                        ['service'=>'Poliklinik Spesialis','hours'=>'07.00 – 20.00 WIB','note'=>'Senin – Sabtu','color'=>'#2563eb'],
                        ['service'=>'Pendaftaran Pasien','hours'=>'07.00 – 19.00 WIB','note'=>'Senin – Sabtu','color'=>'#16a34a'],
                        ['service'=>'Laboratorium Klinik','hours'=>'07.00 – 21.00 WIB','note'=>'24 Jam Emergency','color'=>'#7c3aed'],
                        ['service'=>'Radiologi & CT-Scan','hours'=>'07.00 – 21.00 WIB','note'=>'Senin – Sabtu','color'=>'#0891b2'],
                        ['service'=>'Apotek / Farmasi','hours'=>'07.00 – 22.00 WIB','note'=>'24 Jam Rawat Inap','color'=>'#d97706'],
                    ];
                    @endphp
                    @foreach ($hours as $h)
                    <div class="pt-3.5 first:pt-0 flex items-center justify-between gap-3 text-xs sm:text-sm">
                        <div>
                            <div class="font-bold text-slate-900">{{ $h['service'] }}</div>
                            <div class="text-[11px] text-slate-400">{{ $h['note'] }}</div>
                        </div>
                        <span class="font-bold px-2.5 py-1 rounded-full text-xs shrink-0" style="background-color: {{ $h['color'] }}12; color: {{ $h['color'] }}">
                            {{ $h['hours'] }}
                        </span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══ SECTION 5: APPOINTMENT FORM ═══ --}}
<section id="appointment" class="section bg-white" aria-label="Form Buat Janji">
    <div class="container-xl">
        <div class="max-w-3xl mx-auto bg-slate-50 border border-slate-200 rounded-2xl p-6 sm:p-10 shadow-sm">
            <div class="text-center mb-8">
                <span class="section-label">Pendaftaran Online</span>
                <h2 class="section-title">Buat Janji Temu Dokter</h2>
                <p class="section-subtitle mx-auto">Isi formulir berikut untuk menjadwalkan kunjungan Anda.</p>
            </div>

            <form action="{{ route('contact') }}" method="POST" class="space-y-4" onsubmit="event.preventDefault(); alert('Terima kasih! Permintaan janji temu Anda telah diterima. Tim RS kami akan menghubungi Anda.');">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="name" class="block text-xs font-bold text-slate-700 mb-1">Nama Lengkap Pasien *</label>
                        <input type="text" name="name" id="name" required placeholder="Masukkan nama lengkap" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-600 transition">
                    </div>
                    <div>
                        <label for="phone" class="block text-xs font-bold text-slate-700 mb-1">Nomor WhatsApp / Telepon *</label>
                        <input type="tel" name="phone" id="phone" required placeholder="08xxxxxxxxxx" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-600 transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="polyclinic" class="block text-xs font-bold text-slate-700 mb-1">Pilih Poliklinik *</label>
                        <select name="polyclinic" id="polyclinic" required class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-cyan-600 transition">
                            <option value="">-- Pilih Poliklinik --</option>
                            <option>Poli Penyakit Dalam</option>
                            <option>Poli Kebidanan &amp; Kandungan</option>
                            <option>Poli Bedah Umum</option>
                            <option>Poli Anak</option>
                            <option>Poli Jantung &amp; Pembuluh Darah</option>
                            <option>Poli Saraf</option>
                            <option>Poli Umum / MCU</option>
                        </select>
                    </div>
                    <div>
                        <label for="date" class="block text-xs font-bold text-slate-700 mb-1">Rencana Tanggal Kunjungan *</label>
                        <input type="date" name="date" id="date" required class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-cyan-600 transition">
                    </div>
                </div>

                <div>
                    <label for="notes" class="block text-xs font-bold text-slate-700 mb-1">Keluhan / Catatan Tambahan</label>
                    <textarea name="notes" id="notes" rows="3" placeholder="Tuliskan keluhan medis singkat atau pertanyaan Anda…" class="w-full px-3.5 py-2.5 bg-white border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-600 transition"></textarea>
                </div>

                <div class="pt-2">
                    <button type="submit" class="btn btn-primary btn-lg w-full justify-center">
                        Kirim Permintaan Janji Temu
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection
