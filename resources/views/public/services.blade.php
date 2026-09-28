@extends('layouts.public')

@section('title', 'Layanan Kesehatan RSU Rajawali Citra')
@section('meta_description', 'RSU Rajawali Citra menyediakan layanan kesehatan lengkap: IGD 24 Jam, Poliklinik Spesialis, Rawat Inap, Laboratorium, Radiologi, Farmasi, MCU, dan Kebidanan. Bantul, Yogyakarta.')
@section('og_title', 'Layanan Kesehatan — RSU Rajawali Citra')

@push('head')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
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
        <nav class="breadcrumb" aria-label="Breadcrumb" style="margin-bottom:1.5rem;">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <span aria-current="page">Layanan</span>
        </nav>
        <span class="section-label">Layanan Medis Kami</span>
        <h1 style="font-size:clamp(2rem,4vw,3rem);font-weight:900;color:var(--color-text-primary);margin-top:.75rem;margin-bottom:1rem;">Layanan Kesehatan<br>Komprehensif & Terpercaya</h1>
        <p style="font-size:1.0625rem;color:var(--color-text-secondary);max-width:600px;line-height:1.75;">Kami menyediakan rangkaian lengkap layanan medis untuk memenuhi setiap kebutuhan kesehatan Anda dan keluarga dengan standar pelayanan tertinggi.</p>
    </div>
</section>

{{-- ═══ SECTION 2: EMERGENCY HIGHLIGHT ═══ --}}
<section style="background:#fef2f2;border-bottom:1px solid #fecaca;padding:2rem 0;" aria-label="IGD Darurat">
    <div class="container-xl">
        <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1.5rem;">
            <div style="display:flex;align-items:center;gap:1.25rem;">
                <div style="width:56px;height:56px;background:#dc2626;border-radius:14px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#fff" width="28" height="28" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>
                </div>
                <div>
                    <div style="font-size:1.125rem;font-weight:800;color:#991b1b;display:flex;align-items:center;gap:.375rem;"><i data-lucide="siren" style="width:18px;height:18px;" aria-hidden="true"></i> Instalasi Gawat Darurat (IGD) — Siap 24 Jam</div>
                    <div style="font-size:.875rem;color:#b91c1c;margin-top:.125rem;">Untuk kondisi darurat, segera hubungi IGD kami atau datang langsung ke RS</div>
                </div>
            </div>
            <a href="tel:+62274123456" class="btn btn-lg" style="background:#dc2626;color:#fff;border-color:#dc2626;flex-shrink:0;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="20" height="20" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                Hubungi IGD: +62 274-123-456
            </a>
        </div>
    </div>
</section>

{{-- ═══ SECTION 3: ALL SERVICES ═══ --}}
<section class="section" style="background:var(--color-surface);" aria-label="Semua Layanan">
    <div class="container-xl">
        <div style="text-align:center;margin-bottom:3rem;">
            <span class="section-label">Layanan Utama</span>
            <h2 class="section-title">Pilihan Layanan Kesehatan</h2>
            <p class="section-subtitle" style="margin:0 auto;">Dari gawat darurat hingga pemeriksaan rutin, kami siap mendampingi perjalanan kesehatan Anda.</p>
        </div>

        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:1.5rem;">
            @php
            $colorMap = ['red'=>'#dc2626','blue'=>'#2563eb','green'=>'#16a34a','purple'=>'#7c3aed','cyan'=>'#0891b2','orange'=>'#d97706','teal'=>'#0f766e','pink'=>'#be185d'];
            @endphp
            @foreach ($services as $service)
            @php $clr = $colorMap[$service['color']] ?? '#2563eb'; @endphp
            <article class="card" style="overflow:hidden;">
                <div style="height:6px;background:{{ $clr }};"></div>
                <div style="padding:1.75rem;">
                    <div style="display:flex;align-items:flex-start;gap:1rem;margin-bottom:1.25rem;">
                        <div style="width:52px;height:52px;border-radius:12px;background:{{ $clr }}15;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <i data-lucide="{{ $service['icon'] }}" style="width:26px;height:26px;color:{{ $clr }};" aria-hidden="true"></i>
                        </div>
                        <div>
                            <h2 style="font-size:1rem;font-weight:800;color:var(--color-text-primary);margin-bottom:.25rem;">{{ $service['name'] }}</h2>
                            <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
                                <span style="font-size:.6875rem;font-weight:600;color:{{ $clr }};background:{{ $clr }}12;padding:.2rem .6rem;border-radius:100px;">{{ $service['hours'] }}</span>
                            </div>
                        </div>
                    </div>
                    <p style="font-size:.875rem;color:var(--color-text-secondary);line-height:1.7;margin-bottom:1.25rem;">{{ $service['short'] }}</p>
                    <ul style="list-style:none;display:flex;flex-direction:column;gap:.4rem;margin-bottom:1.5rem;">
                        @foreach (array_slice($service['features'], 0, 3) as $feat)
                        <li style="display:flex;align-items:center;gap:.5rem;font-size:.8125rem;color:var(--color-text-secondary);">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="{{ $clr }}" width="14" height="14" flex-shrink:0 aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                            {{ $feat }}
                        </li>
                        @endforeach
                    </ul>
                    <div style="display:flex;align-items:center;justify-content:space-between;padding-top:1rem;border-top:1px solid var(--color-border);">
                        <div style="font-size:.8125rem;color:var(--color-text-muted);">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" width="14" height="14" style="vertical-align:middle;margin-right:.25rem;" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                            {{ $service['location'] }}
                        </div>
                        <a href="{{ route('services.detail', $service['slug']) }}" style="font-size:.8125rem;font-weight:700;color:{{ $clr }};text-decoration:none;">Detail →</a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ SECTION 4: POLIKLINIK ═══ --}}
<section class="section section-alt" aria-label="Daftar Poliklinik">
    <div class="container-xl">
        <div style="text-align:center;margin-bottom:2.5rem;">
            <span class="section-label primary">Poliklinik</span>
            <h2 class="section-title">Poliklinik Spesialis</h2>
            <p class="section-subtitle" style="margin:0 auto;">Tersedia 15+ poliklinik spesialis dengan dokter berpengalaman siap melayani Anda.</p>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:1rem;">
            @php
            $polyclinics = [
                ['name'=>'Poli Umum','icon'=>'stethoscope','color'=>'#2563eb'],
                ['name'=>'Poli Anak','icon'=>'baby','color'=>'#f59e0b'],
                ['name'=>'Poli Kandungan','icon'=>'heart-pulse','color'=>'#be185d'],
                ['name'=>'Poli Jantung','icon'=>'heart','color'=>'#dc2626'],
                ['name'=>'Poli Bedah Umum','icon'=>'scissors','color'=>'#0891b2'],
                ['name'=>'Poli Saraf','icon'=>'brain','color'=>'#7c3aed'],
                ['name'=>'Poli Penyakit Dalam','icon'=>'activity','color'=>'#16a34a'],
                ['name'=>'Poli THT','icon'=>'ear','color'=>'#d97706'],
                ['name'=>'Poli Mata','icon'=>'eye','color'=>'#0891b2'],
                ['name'=>'Poli Kulit & Kelamin','icon'=>'sparkles','color'=>'#ec4899'],
                ['name'=>'Poli Ortopedi','icon'=>'bone','color'=>'#6366f1'],
                ['name'=>'Poli Gigi & Mulut','icon'=>'smile','color'=>'#14b8a6'],
                ['name'=>'Poli Jiwa','icon'=>'brain-circuit','color'=>'#a855f7'],
                ['name'=>'Poli Paru','icon'=>'wind','color'=>'#22d3ee'],
                ['name'=>'Poli Gizi Klinik','icon'=>'leaf','color'=>'#84cc16'],
            ];
            @endphp
            @foreach ($polyclinics as $poli)
            <div style="background:var(--color-surface);border:1px solid var(--color-border);border-radius:var(--radius-md);padding:1.25rem;display:flex;align-items:center;gap:.75rem;transition:box-shadow .2s;" onmouseover="this.style.boxShadow='var(--shadow-md)'" onmouseout="this.style.boxShadow=''">
                <div style="width:36px;height:36px;border-radius:8px;background:{{ $poli['color'] }}15;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i data-lucide="{{ $poli['icon'] }}" style="width:18px;height:18px;color:{{ $poli['color'] }};" aria-hidden="true"></i>
                </div>
                <span style="font-size:.875rem;font-weight:600;color:var(--color-text-primary);">{{ $poli['name'] }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ SECTION 5: JAM LAYANAN ═══ --}}
<section class="section" style="background:var(--color-surface);" aria-label="Jam Operasional">
    <div class="container-xl">
        <div style="text-align:center;margin-bottom:2.5rem;">
            <span class="section-label">Jam Operasional</span>
            <h2 class="section-title">Jam Layanan Kami</h2>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:1.25rem;max-width:900px;margin:0 auto;">
            @php
            $hours = [
                ['name'=>'IGD / Gawat Darurat','time'=>'24 Jam / 7 Hari','note'=>'Tidak pernah tutup','color'=>'#dc2626','icon'=>'ambulance'],
                ['name'=>'Poliklinik Spesialis','time'=>'07.00 – 20.00','note'=>'Senin – Sabtu','color'=>'#2563eb','icon'=>'stethoscope'],
                ['name'=>'Laboratorium Klinik','time'=>'07.00 – 21.00','note'=>'Reguler (24 jam untuk emergency)','color'=>'#7c3aed','icon'=>'flask-conical'],
                ['name'=>'Radiologi','time'=>'07.00 – 21.00','note'=>'Senin – Sabtu','color'=>'#0891b2','icon'=>'scan'],
                ['name'=>'Apotek / Farmasi','time'=>'07.00 – 22.00','note'=>'24 Jam untuk pasien rawat inap','color'=>'#d97706','icon'=>'pill'],
                ['name'=>'Kasir & Administrasi','time'=>'07.00 – 21.00','note'=>'Senin – Sabtu','color'=>'#16a34a','icon'=>'credit-card'],
            ];
            @endphp
            @foreach ($hours as $h)
            <div style="background:var(--color-bg);border:1px solid var(--color-border);border-radius:var(--radius-lg);padding:1.5rem;display:flex;gap:1rem;align-items:flex-start;">
                <div style="width:44px;height:44px;border-radius:10px;background:{{ $h['color'] }}15;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i data-lucide="{{ $h['icon'] }}" style="width:22px;height:22px;color:{{ $h['color'] }};" aria-hidden="true"></i>
                </div>
                <div>
                    <div style="font-size:.875rem;font-weight:700;color:var(--color-text-primary);margin-bottom:.25rem;">{{ $h['name'] }}</div>
                    <div style="font-size:1rem;font-weight:800;color:{{ $h['color'] }};">{{ $h['time'] }}</div>
                    <div style="font-size:.75rem;color:var(--color-text-muted);margin-top:.125rem;">{{ $h['note'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ SECTION 6: ASURANSI & JAMINAN ═══ --}}
<section class="section section-alt" aria-label="Asuransi dan Jaminan Kesehatan">
    <div class="container-xl">
        <div style="text-align:center;margin-bottom:2.5rem;">
            <span class="section-label">Jaminan Kesehatan</span>
            <h2 class="section-title">Kami Menerima</h2>
            <p class="section-subtitle" style="margin:0 auto;">RSU Rajawali Citra bekerja sama dengan berbagai penjamin kesehatan untuk kemudahan akses layanan.</p>
        </div>
        <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:1rem;">
            @php
            $insurance = ['BPJS Kesehatan','BPJS Ketenagakerjaan','Mandiri Inhealth','Allianz Health','Aetna','AXA Mandiri','Prudential','BNI Life','Jiwasraya','Umum / Tunai','Kartu Kredit / Debit'];
            @endphp
            @foreach ($insurance as $ins)
            <div style="background:var(--color-surface);border:1px solid var(--color-border);border-radius:var(--radius-md);padding:.75rem 1.25rem;font-size:.875rem;font-weight:600;color:var(--color-text-primary);display:flex;align-items:center;gap:.5rem;">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="#16a34a" width="14" height="14" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                {{ $ins }}
            </div>
            @endforeach
        </div>
        <p style="text-align:center;margin-top:1.5rem;font-size:.8125rem;color:var(--color-text-muted);">*Untuk informasi lebih detail tentang cakupan jaminan, silakan hubungi bagian administrasi kami.</p>
    </div>
</section>

{{-- ═══ SECTION 7: MEDICAL CHECK UP ═══ --}}
<section class="section" style="background:var(--color-surface);" aria-label="Medical Check Up">
    <div class="container-xl">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:3rem;align-items:center;flex-wrap:wrap;">
            <div>
                <span class="section-label primary">MCU</span>
                <h2 class="section-title" style="margin-bottom:1rem;">Program Medical Check-Up</h2>
                <p style="font-size:1rem;color:var(--color-text-secondary);line-height:1.8;margin-bottom:1.5rem;">Deteksi dini adalah kunci kesehatan yang optimal. Kami menyediakan berbagai paket medical check-up yang komprehensif untuk individu, korporat, dan instansi pemerintah.</p>
                <a href="{{ route('services.detail', 'medical-check-up') }}" class="btn btn-primary">Lihat Paket MCU</a>
            </div>
            <div style="display:flex;flex-direction:column;gap:1rem;">
                @php
                $mcuPackages = [
                    ['name'=>'Paket MCU Basic','desc'=>'Pemeriksaan dasar untuk monitoring kesehatan rutin.','color'=>'#2563eb'],
                    ['name'=>'Paket MCU Komprehensif','desc'=>'Pemeriksaan lengkap termasuk jantung, paru, dan organ dalam.','color'=>'#16a34a'],
                    ['name'=>'Paket MCU Korporat','desc'=>'Paket khusus untuk karyawan perusahaan dengan harga terjangkau.','color'=>'#d97706'],
                    ['name'=>'Paket MCU Pre-Employment','desc'=>'Pemeriksaan untuk calon karyawan dan instansi pemerintah.','color'=>'#7c3aed'],
                ];
                @endphp
                @foreach ($mcuPackages as $pkg)
                <div style="background:var(--color-bg);border:1px solid var(--color-border);border-radius:var(--radius-md);padding:1.125rem 1.25rem;display:flex;gap:.875rem;align-items:center;">
                    <div style="width:10px;height:10px;border-radius:50%;background:{{ $pkg['color'] }};flex-shrink:0;" aria-hidden="true"></div>
                    <div>
                        <div style="font-size:.9375rem;font-weight:700;color:var(--color-text-primary);">{{ $pkg['name'] }}</div>
                        <div style="font-size:.8125rem;color:var(--color-text-secondary);">{{ $pkg['desc'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ═══ SECTION 8: FAQ LAYANAN ═══ --}}
<section class="section section-alt" aria-label="FAQ Layanan">
    <div class="container-xl">
        <div style="text-align:center;margin-bottom:2.5rem;">
            <span class="section-label">FAQ Layanan</span>
            <h2 class="section-title">Pertanyaan Seputar Layanan</h2>
        </div>
        <div style="max-width:760px;margin:0 auto;" role="list">
            @php
            $serviceFaqs = [
                ['q'=>'Bagaimana cara mendaftar ke poliklinik spesialis?','a'=>'Anda dapat mendaftar melalui loket pendaftaran langsung, atau menghubungi kami via telepon/WhatsApp. Untuk pasien BPJS, pastikan membawa surat rujukan dari faskes tingkat pertama.'],
                ['q'=>'Apakah diperlukan janji temu untuk kunjungan poliklinik?','a'=>'Untuk poliklinik spesialis, disarankan membuat janji temu terlebih dahulu untuk menghindari waktu tunggu yang lama. Namun pasien umum dapat datang langsung sesuai jam operasional.'],
                ['q'=>'Berapa lama hasil laboratorium keluar?','a'=>'Sebagian besar pemeriksaan laboratorium umum selesai dalam 1–3 jam. Untuk pemeriksaan khusus atau kultur, mungkin memerlukan waktu 1–7 hari.'],
                ['q'=>'Apakah RSU Rajawali Citra menyediakan layanan rawat inap?','a'=>'Ya, kami menyediakan fasilitas rawat inap dengan berbagai pilihan kelas: VVIP, VIP, Kelas I, II, dan III. Tersedia lebih dari 120 tempat tidur dengan monitoring 24 jam.'],
                ['q'=>'Bagaimana prosedur rujukan ke dokter spesialis?','a'=>'Pasien dengan jaminan BPJS perlu membawa surat rujukan dari puskesmas atau klinik. Pasien umum dapat langsung datang ke poliklinik spesialis tanpa rujukan.'],
            ];
            @endphp
            @foreach ($serviceFaqs as $i => $faq)
            <div role="listitem" style="border:1px solid var(--color-border);border-radius:var(--radius-md);margin-bottom:.75rem;overflow:hidden;background:#fff;">
                <button id="sfaq-btn-{{ $i }}" onclick="toggleSFaq({{ $i }})" aria-expanded="false" aria-controls="sfaq-panel-{{ $i }}" style="width:100%;display:flex;align-items:center;justify-content:space-between;padding:1.125rem 1.25rem;background:none;border:none;cursor:pointer;text-align:left;gap:1rem;">
                    <span style="font-size:.9375rem;font-weight:600;color:var(--color-text-primary);">{{ $faq['q'] }}</span>
                    <svg id="sfaq-icon-{{ $i }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:18px;height:18px;color:var(--color-text-muted);flex-shrink:0;transition:transform .3s;" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                </button>
                <div id="sfaq-panel-{{ $i }}" role="region" aria-labelledby="sfaq-btn-{{ $i }}" style="display:none;padding:0 1.25rem 1.125rem;font-size:.875rem;color:var(--color-text-secondary);line-height:1.7;">{{ $faq['a'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ SECTION 9: CTA ═══ --}}
<section style="background:linear-gradient(135deg,var(--color-primary) 0%,var(--color-accent) 100%);padding:4rem 0;" aria-label="Buat Janji">
    <div class="container-xl" style="text-align:center;">
        <h2 style="font-size:clamp(1.5rem,3vw,2.25rem);font-weight:800;color:#fff;margin-bottom:1rem;">Siap Mendapatkan Perawatan Terbaik?</h2>
        <p style="font-size:1rem;color:rgba(255,255,255,.8);max-width:480px;margin:0 auto 2rem;line-height:1.7;">Hubungi kami sekarang untuk informasi lebih lanjut atau buat janji temu dengan dokter spesialis pilihan Anda.</p>
        <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:1rem;">
            <a href="{{ route('contact') }}#appointment" class="btn btn-lg" style="background:#fff;color:var(--color-primary);">Buat Janji Temu</a>
            <a href="{{ route('doctors') }}" class="btn btn-outline-white btn-lg">Cari Dokter Spesialis</a>
            <a href="tel:+62274123456" class="btn btn-lg" style="background:#dc2626;color:#fff;border-color:#dc2626;">IGD 24 Jam</a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
function toggleSFaq(index) {
    const panel = document.getElementById('sfaq-panel-' + index);
    const icon  = document.getElementById('sfaq-icon-' + index);
    const btn   = document.getElementById('sfaq-btn-' + index);
    const isOpen = panel.style.display === 'block';
    document.querySelectorAll('[id^="sfaq-panel-"]').forEach(function(p) { p.style.display = 'none'; });
    document.querySelectorAll('[id^="sfaq-icon-"]').forEach(function(i) { i.style.transform = ''; });
    document.querySelectorAll('[id^="sfaq-btn-"]').forEach(function(b) { b.setAttribute('aria-expanded', 'false'); });
    if (!isOpen) {
        panel.style.display = 'block';
        icon.style.transform = 'rotate(180deg)';
        btn.setAttribute('aria-expanded', 'true');
    }
}
</script>
@endpush
