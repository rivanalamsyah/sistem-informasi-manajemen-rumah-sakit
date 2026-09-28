@extends('layouts.public')

@section('title', 'Kontak & Lokasi — RSU Rajawali Citra')
@section('meta_description', 'Hubungi RSU Rajawali Citra: telepon, WhatsApp, email, dan lokasi. IGD 24 jam: +62 274-123-456. Jl. Pleret No. KM 2.5, Bantul, Yogyakarta.')
@section('og_title', 'Kontak & Lokasi — RSU Rajawali Citra')

@push('head')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "ContactPage",
  "name": "Kontak RSU Rajawali Citra",
  "url": "{{ route('contact') }}",
  "mainEntity": {
    "@type": "Hospital",
    "name": "RSU Rajawali Citra",
    "telephone": "+62274123456",
    "email": "info@rsurajawalicitra.co.id",
    "address": {
      "@type": "PostalAddress",
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
        <nav class="breadcrumb" aria-label="Breadcrumb" style="margin-bottom:1.5rem;">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <span aria-current="page">Kontak</span>
        </nav>
        <span class="section-label">Hubungi Kami</span>
        <h1 style="font-size:clamp(2rem,4vw,3rem);font-weight:900;color:var(--color-text-primary);margin-top:.75rem;margin-bottom:1rem;">Kontak & Lokasi<br>RSU Rajawali Citra</h1>
        <p style="font-size:1.0625rem;color:var(--color-text-secondary);max-width:600px;line-height:1.75;">Kami siap melayani setiap pertanyaan, kebutuhan informasi, dan keperluan medis Anda. Hubungi kami kapan saja.</p>
    </div>
</section>

{{-- ═══ SECTION 2: EMERGENCY CONTACT ═══ --}}
<section style="background:#fef2f2;border-bottom:1px solid #fecaca;padding:2.5rem 0;" aria-label="Kontak Darurat">
    <div class="container-xl">
        <div style="text-align:center;margin-bottom:1.5rem;">
            <span class="section-label" style="background:rgba(220,38,38,.1);color:#991b1b;"><i data-lucide="siren" style="width:14px;height:14px;display:inline-block;vertical-align:-2px;" aria-hidden="true"></i> Kontak Darurat</span>
            <h2 style="font-size:1.5rem;font-weight:800;color:#991b1b;margin-top:.5rem;">Untuk Kondisi Darurat</h2>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1.25rem;max-width:860px;margin:0 auto;">
            <a href="tel:+62274123456" style="display:flex;align-items:center;gap:1rem;background:#fff;border:2px solid #fecaca;border-radius:var(--radius-lg);padding:1.25rem 1.5rem;text-decoration:none;transition:all .2s;" onmouseover="this.style.borderColor='#dc2626';this.style.boxShadow='0 4px 20px rgba(220,38,38,.12)'" onmouseout="this.style.borderColor='#fecaca';this.style.boxShadow=''">
                <div style="width:48px;height:48px;background:#dc2626;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#fff" width="24" height="24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                </div>
                <div>
                    <div style="font-size:.75rem;font-weight:700;color:#991b1b;text-transform:uppercase;letter-spacing:.05em;">IGD 24 Jam</div>
                    <div style="font-size:1.125rem;font-weight:900;color:#991b1b;">+62 274-123-456</div>
                </div>
            </a>
            <a href="https://wa.me/628213431353" target="_blank" rel="noopener" style="display:flex;align-items:center;gap:1rem;background:#fff;border:2px solid #fecaca;border-radius:var(--radius-lg);padding:1.25rem 1.5rem;text-decoration:none;transition:all .2s;" onmouseover="this.style.borderColor='#dc2626';this.style.boxShadow='0 4px 20px rgba(220,38,38,.12)'" onmouseout="this.style.borderColor='#fecaca';this.style.boxShadow=''">
                <div style="width:48px;height:48px;background:#dc2626;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#fff" width="24" height="24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 01.778-.332 48.294 48.294 0 005.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>
                </div>
                <div>
                    <div style="font-size:.75rem;font-weight:700;color:#991b1b;text-transform:uppercase;letter-spacing:.05em;">WhatsApp Darurat</div>
                    <div style="font-size:1.125rem;font-weight:900;color:#991b1b;">0821-3431-3535</div>
                </div>
            </a>
        </div>
    </div>
</section>

{{-- ═══ SECTION 3: ALL CONTACT INFO ═══ --}}
<section class="section" style="background:var(--color-surface);" aria-label="Informasi Kontak">
    <div class="container-xl">
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:1.5rem;margin-bottom:3rem;">
            @php
            $contacts = [
                ['type'=>'Telepon','value'=>'+62 274-123-456','sub'=>'Senin – Minggu, 07.00 – 21.00','icon'=>'phone','color'=>'#2563eb','href'=>'tel:+62274123456'],
                ['type'=>'WhatsApp','value'=>'0821-3431-3535','sub'=>'Respon cepat dalam jam kerja','icon'=>'message-circle','color'=>'#16a34a','href'=>'https://wa.me/628213431353'],
                ['type'=>'Email','value'=>'info@rsurajawalicitra.co.id','sub'=>'Dibalas dalam 1x24 jam','icon'=>'mail','color'=>'#7c3aed','href'=>'mailto:info@rsurajawalicitra.co.id'],
                ['type'=>'Fax','value'=>'+62 274-123-457','sub'=>'Untuk keperluan administratif','icon'=>'printer','color'=>'#d97706','href'=>'#'],
            ];
            @endphp
            @foreach ($contacts as $contact)
            <a href="{{ $contact['href'] }}" {{ str_starts_with($contact['href'], 'https') ? 'target="_blank" rel="noopener"' : '' }} class="card" style="padding:1.5rem;text-decoration:none;display:flex;gap:1rem;align-items:flex-start;">
                <div style="width:48px;height:48px;border-radius:12px;background:{{ $contact['color'] }}15;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i data-lucide="{{ $contact['icon'] }}" style="width:24px;height:24px;color:{{ $contact['color'] }};" aria-hidden="true"></i>
                </div>
                <div>
                    <div style="font-size:.75rem;font-weight:700;color:var(--color-text-muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.25rem;">{{ $contact['type'] }}</div>
                    <div style="font-size:.9375rem;font-weight:700;color:var(--color-text-primary);">{{ $contact['value'] }}</div>
                    <div style="font-size:.75rem;color:var(--color-text-muted);margin-top:.125rem;">{{ $contact['sub'] }}</div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ SECTION 4: LOKASI & JAM OPERASIONAL ═══ --}}
<section class="section section-alt" aria-label="Lokasi dan Jam Operasional">
    <div class="container-xl">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:3rem;align-items:start;flex-wrap:wrap;">
            {{-- Map --}}
            <div>
                <span class="section-label">Lokasi</span>
                <h2 class="section-title" style="margin-bottom:1.5rem;">Temukan Kami</h2>
                <div style="background:var(--color-surface);border:1px solid var(--color-border);border-radius:var(--radius-xl);overflow:hidden;">
                    <div style="aspect-ratio:4/3;background:linear-gradient(135deg,rgba(30,58,95,.06) 0%,rgba(8,145,178,.08) 100%);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:1rem;">
                        <i data-lucide="map-pin" style="width:56px;height:56px;color:var(--color-primary);" aria-hidden="true"></i>
                        <div style="text-align:center;">
                            <div style="font-size:1rem;font-weight:700;color:var(--color-text-primary);margin-bottom:.5rem;">RSU Rajawali Citra</div>
                            <div style="font-size:.875rem;color:var(--color-text-secondary);max-width:280px;line-height:1.6;margin-bottom:1rem;">Jl. Pleret No. KM 2.5, Banjardadap, Potorono, Banguntapan, Bantul, DIY 55196</div>
                            <a href="https://maps.google.com/?q=RSU+Rajawali+Citra+Bantul+Yogyakarta" target="_blank" rel="noopener" class="btn btn-primary btn-sm">
                                <i data-lucide="map" style="width:16px;height:16px;" aria-hidden="true"></i>
                                Buka di Google Maps
                            </a>
                        </div>
                    </div>
                </div>
                <div style="margin-top:1.25rem;padding:1.25rem;background:var(--color-surface);border:1px solid var(--color-border);border-radius:var(--radius-lg);">
                    <h3 style="font-size:.875rem;font-weight:700;color:var(--color-text-primary);margin-bottom:.75rem;">Petunjuk Akses</h3>
                    <ul style="list-style:none;display:flex;flex-direction:column;gap:.5rem;font-size:.8125rem;color:var(--color-text-secondary);">
                        <li style="display:flex;gap:.5rem;"><span style="color:var(--color-accent);">•</span> Dari Kota Yogyakarta: ±15 menit via Jl. Wonosari</li>
                        <li style="display:flex;gap:.5rem;"><span style="color:var(--color-accent);">•</span> Dari Bandara YIA: ±45 menit via Jl. Lingkar Selatan</li>
                        <li style="display:flex;gap:.5rem;"><span style="color:var(--color-accent);">•</span> Tersedia lahan parkir roda dua dan roda empat</li>
                        <li style="display:flex;gap:.5rem;"><span style="color:var(--color-accent);">•</span> Dapat diakses via Trans Jogja koridor 1A</li>
                    </ul>
                </div>
            </div>

            {{-- Hours --}}
            <div>
                <span class="section-label primary">Jam Operasional</span>
                <h2 class="section-title" style="margin-bottom:1.5rem;">Jam Layanan</h2>
                <div style="display:flex;flex-direction:column;gap:1rem;">
                    @php
                    $hours = [
                        ['service'=>'IGD / Gawat Darurat','hours'=>'24 Jam / 7 Hari','note'=>'Tidak pernah tutup','color'=>'#dc2626'],
                        ['service'=>'Poliklinik Spesialis','hours'=>'07.00 – 20.00','note'=>'Senin – Sabtu','color'=>'#2563eb'],
                        ['service'=>'Pendaftaran Pasien','hours'=>'07.00 – 19.00','note'=>'Senin – Sabtu','color'=>'#16a34a'],
                        ['service'=>'Laboratorium','hours'=>'07.00 – 21.00','note'=>'24 Jam untuk emergency','color'=>'#7c3aed'],
                        ['service'=>'Radiologi','hours'=>'07.00 – 21.00','note'=>'Senin – Sabtu','color'=>'#0891b2'],
                        ['service'=>'Apotek / Farmasi','hours'=>'07.00 – 22.00','note'=>'24 Jam untuk ranap','color'=>'#d97706'],
                        ['service'=>'Kasir & Administrasi','hours'=>'07.00 – 21.00','note'=>'Senin – Sabtu','color'=>'#16a34a'],
                        ['service'=>'Kunjungan Pasien Ranap','hours'=>'11.00 – 13.00 & 17.00 – 19.00','note'=>'Setiap hari','color'=>'#d97706'],
                    ];
                    @endphp
                    @foreach ($hours as $h)
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:.875rem 1.125rem;background:var(--color-surface);border:1px solid var(--color-border);border-radius:var(--radius-md);border-left:4px solid {{ $h['color'] }};">
                        <div>
                            <div style="font-size:.875rem;font-weight:700;color:var(--color-text-primary);">{{ $h['service'] }}</div>
                            <div style="font-size:.75rem;color:var(--color-text-muted);">{{ $h['note'] }}</div>
                        </div>
                        <div style="font-size:.875rem;font-weight:800;color:{{ $h['color'] }};text-align:right;white-space:nowrap;">{{ $h['hours'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══ SECTION 5: FORM KONTAK / JANJI TEMU ═══ --}}
<section id="appointment" class="section" style="background:var(--color-surface);" aria-label="Formulir Janji Temu">
    <div class="container-xl">
        <div style="display:grid;grid-template-columns:1fr 1.5fr;gap:3rem;align-items:start;flex-wrap:wrap;">
            <div>
                <span class="section-label">Formulir</span>
                <h2 class="section-title" style="margin-bottom:1rem;">Buat Janji Temu</h2>
                <p style="font-size:1rem;color:var(--color-text-secondary);line-height:1.8;margin-bottom:2rem;">Isi formulir ini untuk membuat janji temu atau mengirimkan pertanyaan. Tim kami akan segera menghubungi Anda dalam 1x24 jam.</p>
                <div style="display:flex;flex-direction:column;gap:1rem;">
                    <div style="display:flex;gap:.75rem;align-items:center;font-size:.875rem;color:var(--color-text-secondary);">
                        <div style="width:32px;height:32px;border-radius:50%;background:rgba(22,163,74,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="#16a34a" width="16" height="16" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        </div>
                        Konfirmasi cepat via WhatsApp atau telepon
                    </div>
                    <div style="display:flex;gap:.75rem;align-items:center;font-size:.875rem;color:var(--color-text-secondary);">
                        <div style="width:32px;height:32px;border-radius:50%;background:rgba(22,163,74,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="#16a34a" width="16" height="16" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        </div>
                        Dibalas dalam 1×24 jam kerja
                    </div>
                    <div style="display:flex;gap:.75rem;align-items:center;font-size:.875rem;color:var(--color-text-secondary);">
                        <div style="width:32px;height:32px;border-radius:50%;background:rgba(22,163,74,.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="#16a34a" width="16" height="16" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        </div>
                        Bebas pilih dokter dan jadwal yang tersedia
                    </div>
                </div>
            </div>

            {{-- Form --}}
            <div class="card" style="padding:2rem;">
                <h3 style="font-size:1.0625rem;font-weight:800;color:var(--color-text-primary);margin-bottom:1.5rem;">Formulir Janji Temu / Pertanyaan</h3>
                <form id="contactForm" onsubmit="submitForm(event)" novalidate>
                    @csrf
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;margin-bottom:1rem;">
                        <div>
                            <label for="nama" style="display:block;font-size:.8125rem;font-weight:600;color:var(--color-text-secondary);margin-bottom:.5rem;">Nama Lengkap <span style="color:#dc2626;" aria-hidden="true">*</span></label>
                            <input type="text" id="nama" name="nama" required placeholder="Nama Anda"
                                style="width:100%;padding:.75rem 1rem;border:1.5px solid var(--color-border);border-radius:var(--radius-md);font-size:.9375rem;background:#fff;transition:border-color .2s;outline:none;"
                                onfocus="this.style.borderColor='var(--color-accent)'" onblur="this.style.borderColor='var(--color-border)'"
                                aria-required="true">
                        </div>
                        <div>
                            <label for="telepon" style="display:block;font-size:.8125rem;font-weight:600;color:var(--color-text-secondary);margin-bottom:.5rem;">Nomor Telepon <span style="color:#dc2626;" aria-hidden="true">*</span></label>
                            <input type="tel" id="telepon" name="telepon" required placeholder="0812-xxxx-xxxx"
                                style="width:100%;padding:.75rem 1rem;border:1.5px solid var(--color-border);border-radius:var(--radius-md);font-size:.9375rem;background:#fff;transition:border-color .2s;outline:none;"
                                onfocus="this.style.borderColor='var(--color-accent)'" onblur="this.style.borderColor='var(--color-border)'"
                                aria-required="true">
                        </div>
                    </div>
                    <div style="margin-bottom:1rem;">
                        <label for="email" style="display:block;font-size:.8125rem;font-weight:600;color:var(--color-text-secondary);margin-bottom:.5rem;">Email</label>
                        <input type="email" id="email" name="email" placeholder="email@contoh.com"
                            style="width:100%;padding:.75rem 1rem;border:1.5px solid var(--color-border);border-radius:var(--radius-md);font-size:.9375rem;background:#fff;transition:border-color .2s;outline:none;"
                            onfocus="this.style.borderColor='var(--color-accent)'" onblur="this.style.borderColor='var(--color-border)'">
                    </div>
                    <div style="margin-bottom:1rem;">
                        <label for="jenis" style="display:block;font-size:.8125rem;font-weight:600;color:var(--color-text-secondary);margin-bottom:.5rem;">Jenis Permintaan</label>
                        <select id="jenis" name="jenis"
                            style="width:100%;padding:.75rem 1rem;border:1.5px solid var(--color-border);border-radius:var(--radius-md);font-size:.9375rem;background:#fff;transition:border-color .2s;outline:none;"
                            onfocus="this.style.borderColor='var(--color-accent)'" onblur="this.style.borderColor='var(--color-border)'">
                            <option value="">Pilih Jenis Permintaan</option>
                            <option>Janji Temu Dokter Spesialis</option>
                            <option>Informasi Layanan</option>
                            <option>Medical Check-Up</option>
                            <option>Rawat Inap & Kelas Kamar</option>
                            <option>Informasi BPJS</option>
                            <option>Lainnya</option>
                        </select>
                    </div>
                    <div style="margin-bottom:1rem;">
                        <label for="dokter" style="display:block;font-size:.8125rem;font-weight:600;color:var(--color-text-secondary);margin-bottom:.5rem;">Dokter yang Dituju (jika ada)</label>
                        <select id="dokter" name="dokter"
                            style="width:100%;padding:.75rem 1rem;border:1.5px solid var(--color-border);border-radius:var(--radius-md);font-size:.9375rem;background:#fff;transition:border-color .2s;outline:none;"
                            onfocus="this.style.borderColor='var(--color-accent)'" onblur="this.style.borderColor='var(--color-border)'">
                            <option value="">Pilih Dokter (opsional)</option>
                            <option>dr. Andi Prasetyo, Sp.PD</option>
                            <option>dr. Siti Rahayu, Sp.OG</option>
                            <option>dr. Budi Santoso, Sp.B</option>
                            <option>dr. Maya Dewi, Sp.A</option>
                            <option>dr. Ahmad Fauzi, Sp.JP</option>
                            <option>dr. Indah Lestari, Sp.S</option>
                        </select>
                    </div>
                    <div style="margin-bottom:1.5rem;">
                        <label for="pesan" style="display:block;font-size:.8125rem;font-weight:600;color:var(--color-text-secondary);margin-bottom:.5rem;">Pesan / Keluhan <span style="color:#dc2626;" aria-hidden="true">*</span></label>
                        <textarea id="pesan" name="pesan" required rows="4" placeholder="Tuliskan pertanyaan, keluhan, atau kebutuhan Anda di sini…"
                            style="width:100%;padding:.75rem 1rem;border:1.5px solid var(--color-border);border-radius:var(--radius-md);font-size:.9375rem;background:#fff;transition:border-color .2s;outline:none;resize:vertical;font-family:inherit;"
                            onfocus="this.style.borderColor='var(--color-accent)'" onblur="this.style.borderColor='var(--color-border)'"
                            aria-required="true"></textarea>
                    </div>
                    <div id="formAlert" style="display:none;padding:.875rem 1rem;border-radius:var(--radius-md);margin-bottom:1rem;font-size:.875rem;" role="alert" aria-live="polite"></div>
                    <button type="submit" id="submitBtn" class="btn btn-primary btn-lg" style="width:100%;justify-content:center;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="20" height="20" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg>
                        Kirim Permintaan
                    </button>
                    <p style="font-size:.75rem;color:var(--color-text-muted);text-align:center;margin-top:.875rem;">Dengan mengirim formulir ini, Anda menyetujui <a href="#" style="color:var(--color-accent);">kebijakan privasi</a> kami.</p>
                </form>
            </div>
        </div>
    </div>
</section>

{{-- ═══ SECTION 6: DEPARTEMEN KONTAK ═══ --}}
<section class="section section-alt" aria-label="Kontak Per Departemen">
    <div class="container-xl">
        <div style="text-align:center;margin-bottom:2.5rem;">
            <span class="section-label primary">Departemen</span>
            <h2 class="section-title">Hubungi Departemen Langsung</h2>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:1.25rem;">
            @php
            $departments = [
                ['name'=>'IGD / Gawat Darurat','ext'=>'100','color'=>'#dc2626','icon'=>'ambulance'],
                ['name'=>'Poliklinik & Pendaftaran','ext'=>'101','color'=>'#2563eb','icon'=>'stethoscope'],
                ['name'=>'Rawat Inap','ext'=>'102','color'=>'#16a34a','icon'=>'bed-double'],
                ['name'=>'Laboratorium Klinik','ext'=>'103','color'=>'#7c3aed','icon'=>'flask-conical'],
                ['name'=>'Radiologi','ext'=>'104','color'=>'#0891b2','icon'=>'scan'],
                ['name'=>'Farmasi / Apotek','ext'=>'105','color'=>'#d97706','icon'=>'pill'],
                ['name'=>'Kasir & Billing','ext'=>'106','color'=>'#16a34a','icon'=>'credit-card'],
                ['name'=>'Humas & Informasi','ext'=>'107','color'=>'var(--color-primary)','icon'=>'info'],
            ];
            @endphp
            @foreach ($departments as $dept)
            <div style="background:var(--color-surface);border:1px solid var(--color-border);border-radius:var(--radius-lg);padding:1.25rem;display:flex;gap:.875rem;align-items:center;">
                <div style="width:44px;height:44px;border-radius:10px;background:{{ $dept['color'] }}15;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i data-lucide="{{ $dept['icon'] }}" style="width:22px;height:22px;color:{{ $dept['color'] }};" aria-hidden="true"></i>
                </div>
                <div>
                    <div style="font-size:.875rem;font-weight:700;color:var(--color-text-primary);">{{ $dept['name'] }}</div>
                    <div style="font-size:.8125rem;color:var(--color-text-muted);">Ext. {{ $dept['ext'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ SECTION 7: FAQ KONTAK ═══ --}}
<section class="section" style="background:var(--color-surface);" aria-label="FAQ Kontak">
    <div class="container-xl">
        <div style="text-align:center;margin-bottom:2.5rem;">
            <span class="section-label">FAQ</span>
            <h2 class="section-title">Pertanyaan Seputar Kontak & Kunjungan</h2>
        </div>
        <div style="max-width:760px;margin:0 auto;" role="list">
            @php
            $contactFaqs = [
                ['q'=>'Apakah bisa datang tanpa janji ke poliklinik?','a'=>'Untuk layanan rawat jalan, pasien dapat datang langsung ke loket pendaftaran tanpa janji temu sebelumnya. Namun untuk mengurangi waktu tunggu, kami sarankan membuat janji terlebih dahulu.'],
                ['q'=>'Berapa jam sebelumnya harus konfirmasi kedatangan?','a'=>'Jika sudah membuat janji temu, disarankan konfirmasi ulang melalui telepon atau WhatsApp setidaknya 1 hari sebelum jadwal kunjungan.'],
                ['q'=>'Apakah ada layanan antar-jemput pasien?','a'=>'Saat ini RSU Rajawali Citra menyediakan layanan ambulans untuk kebutuhan medis darurat. Untuk informasi layanan antar-jemput khusus, silakan hubungi kami.'],
                ['q'=>'Bagaimana cara mendapatkan informasi tarif layanan?','a'=>'Informasi tarif layanan dapat diperoleh melalui bagian administrasi kami di loket, atau menghubungi kami via telepon dan WhatsApp. Kami transparan dalam hal biaya layanan.'],
            ];
            @endphp
            @foreach ($contactFaqs as $i => $faq)
            <div role="listitem" style="border:1px solid var(--color-border);border-radius:var(--radius-md);margin-bottom:.75rem;overflow:hidden;background:#fff;">
                <button id="cfaq-btn-{{ $i }}" onclick="toggleCFaq({{ $i }})" aria-expanded="false" aria-controls="cfaq-panel-{{ $i }}" style="width:100%;display:flex;align-items:center;justify-content:space-between;padding:1.125rem 1.25rem;background:none;border:none;cursor:pointer;text-align:left;gap:1rem;">
                    <span style="font-size:.9375rem;font-weight:600;color:var(--color-text-primary);">{{ $faq['q'] }}</span>
                    <svg id="cfaq-icon-{{ $i }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:18px;height:18px;color:var(--color-text-muted);flex-shrink:0;transition:transform .3s;" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                </button>
                <div id="cfaq-panel-{{ $i }}" role="region" aria-labelledby="cfaq-btn-{{ $i }}" style="display:none;padding:0 1.25rem 1.125rem;font-size:.875rem;color:var(--color-text-secondary);line-height:1.7;">{{ $faq['a'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
function submitForm(e) {
    e.preventDefault();
    const btn = document.getElementById('submitBtn');
    const alert = document.getElementById('formAlert');
    const nama = document.getElementById('nama').value.trim();
    const tel  = document.getElementById('telepon').value.trim();
    const msg  = document.getElementById('pesan').value.trim();

    if (!nama || !tel || !msg) {
        alert.style.display = 'block';
        alert.style.background = '#fef2f2';
        alert.style.color = '#991b1b';
        alert.style.border = '1px solid #fecaca';
        alert.innerHTML = 'Silakan lengkapi semua kolom yang wajib diisi (*)';
        return;
    }

    btn.disabled = true;
    btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="20" height="20" style="animation:spin 1s linear infinite;"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99"/></svg> Mengirim...';

    setTimeout(function() {
        alert.style.display = 'block';
        alert.style.background = '#f0fdf4';
        alert.style.color = '#15803d';
        alert.style.border = '1px solid #bbf7d0';
        alert.innerHTML = 'Pesan Anda telah terkirim! Tim kami akan menghubungi Anda segera. <br><small style="color:#16a34a;">Untuk respons lebih cepat, hubungi kami via WhatsApp: <a href="https://wa.me/628213431353" style="color:#16a34a;font-weight:700;">0821-3431-3535</a></small>';
        document.getElementById('contactForm').reset();
        btn.disabled = false;
        btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="20" height="20"><path stroke-linecap="round" stroke-linejoin="round" d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5"/></svg> Kirim Permintaan';
        alert.scrollIntoView({behavior:'smooth',block:'nearest'});
    }, 1500);
}

function toggleCFaq(index) {
    const panel = document.getElementById('cfaq-panel-' + index);
    const icon  = document.getElementById('cfaq-icon-' + index);
    const btn   = document.getElementById('cfaq-btn-' + index);
    const isOpen = panel.style.display === 'block';
    document.querySelectorAll('[id^="cfaq-panel-"]').forEach(function(p) { p.style.display = 'none'; });
    document.querySelectorAll('[id^="cfaq-icon-"]').forEach(function(i) { i.style.transform = ''; });
    document.querySelectorAll('[id^="cfaq-btn-"]').forEach(function(b) { b.setAttribute('aria-expanded', 'false'); });
    if (!isOpen) {
        panel.style.display = 'block';
        icon.style.transform = 'rotate(180deg)';
        btn.setAttribute('aria-expanded', 'true');
    }
}
</script>
@endpush
