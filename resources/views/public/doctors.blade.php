@extends('layouts.public')

@section('title', 'Dokter & Jadwal Praktik — RSU Rajawali Citra')
@section('meta_description', 'Temukan dokter spesialis RSU Rajawali Citra. Cari berdasarkan spesialisasi dan lihat jadwal praktik. Spesialis penyakit dalam, anak, kandungan, jantung, bedah, saraf, dan lainnya.')
@section('og_title', 'Dokter & Jadwal Praktik — RSU Rajawali Citra')

@push('head')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@type": "ItemList",
  "name": "Dokter Spesialis RSU Rajawali Citra",
  "itemListElement": [
    @foreach ($doctors as $i => $doctor)
    {
      "@type": "ListItem",
      "position": {{ $i + 1 }},
      "item": {
        "@type": "Physician",
        "name": "{{ $doctor['name'] }}",
        "medicalSpecialty": "{{ $doctor['specialization'] }}",
        "url": "{{ route('doctors.detail', $doctor['slug']) }}"
      }
    }{{ !$loop->last ? ',' : '' }}
    @endforeach
  ]
}
</script>
@endpush

@section('content')

{{-- Page Hero --}}
<section class="page-hero" aria-label="Dokter dan Tenaga Medis">
    <div class="container-xl">
        <nav class="breadcrumb" aria-label="Breadcrumb" style="margin-bottom:1.5rem;">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <span aria-current="page">Dokter & Jadwal</span>
        </nav>
        <span class="section-label">Tim Medis</span>
        <h1 style="font-size:clamp(2rem,4vw,3rem);font-weight:900;color:var(--color-text-primary);margin-top:.75rem;margin-bottom:1rem;">Dokter & Tenaga Medis<br>Berpengalaman Kami</h1>
        <p style="font-size:1.0625rem;color:var(--color-text-secondary);max-width:600px;line-height:1.75;">Ditangani oleh dokter spesialis dan subspesialis pilihan yang berdedikasi tinggi dan berkomitmen memberikan pelayanan medis terbaik untuk Anda.</p>
    </div>
</section>

{{-- ═══ SECTION 2: DOCTOR SEARCH ═══ --}}
<section style="background:#fff;padding:2.5rem 0;border-bottom:1px solid var(--color-border);" aria-label="Cari Dokter">
    <div class="container-xl">
        <div style="background:var(--color-bg);border:1px solid var(--color-border);border-radius:var(--radius-xl);padding:2rem;">
            <h2 style="font-size:1.125rem;font-weight:700;color:var(--color-text-primary);margin-bottom:1.5rem;">Cari Dokter</h2>
            <div style="display:flex;gap:1rem;flex-wrap:wrap;">
                <div style="flex:1;min-width:200px;">
                    <label for="searchDoctor" style="display:block;font-size:.8125rem;font-weight:600;color:var(--color-text-secondary);margin-bottom:.5rem;">Nama Dokter</label>
                    <input type="text" id="searchDoctor" placeholder="cth. dr. Andi Prasetyo…"
                        style="width:100%;padding:.75rem 1rem;border:1.5px solid var(--color-border);border-radius:var(--radius-md);font-size:.9375rem;color:var(--color-text-primary);background:#fff;outline:none;transition:border-color .2s;"
                        onfocus="this.style.borderColor='var(--color-accent)'" onblur="this.style.borderColor='var(--color-border)'"
                        oninput="filterDoctors()" aria-controls="doctorGrid">
                </div>
                <div style="min-width:200px;">
                    <label for="filterSpec" style="display:block;font-size:.8125rem;font-weight:600;color:var(--color-text-secondary);margin-bottom:.5rem;">Spesialisasi</label>
                    <select id="filterSpec"
                        style="width:100%;padding:.75rem 1rem;border:1.5px solid var(--color-border);border-radius:var(--radius-md);font-size:.9375rem;color:var(--color-text-primary);background:#fff;outline:none;transition:border-color .2s;"
                        onfocus="this.style.borderColor='var(--color-accent)'" onblur="this.style.borderColor='var(--color-border)'"
                        onchange="filterDoctors()">
                        <option value="">Semua Spesialisasi</option>
                        <option>Spesialis Penyakit Dalam</option>
                        <option>Spesialis Obstetri & Ginekologi</option>
                        <option>Spesialis Bedah Umum</option>
                        <option>Spesialis Anak</option>
                        <option>Spesialis Jantung & Pembuluh Darah</option>
                        <option>Spesialis Saraf</option>
                    </select>
                </div>
                <div style="min-width:200px;">
                    <label for="filterDay" style="display:block;font-size:.8125rem;font-weight:600;color:var(--color-text-secondary);margin-bottom:.5rem;">Hari Praktik</label>
                    <select id="filterDay"
                        style="width:100%;padding:.75rem 1rem;border:1.5px solid var(--color-border);border-radius:var(--radius-md);font-size:.9375rem;color:var(--color-text-primary);background:#fff;outline:none;transition:border-color .2s;"
                        onfocus="this.style.borderColor='var(--color-accent)'" onblur="this.style.borderColor='var(--color-border)'"
                        onchange="filterDoctors()">
                        <option value="">Semua Hari</option>
                        <option>Senin</option>
                        <option>Selasa</option>
                        <option>Rabu</option>
                        <option>Kamis</option>
                        <option>Jumat</option>
                        <option>Sabtu</option>
                    </select>
                </div>
            </div>
            <div id="searchResults" style="font-size:.8125rem;color:var(--color-text-muted);margin-top:1rem;display:none;"></div>
        </div>
    </div>
</section>

{{-- ═══ SECTION 3: FEATURED DOCTORS ═══ --}}
<section class="section" style="background:var(--color-surface);" aria-label="Dokter Spesialis">
    <div class="container-xl">
        <div style="margin-bottom:2rem;">
            <span class="section-label">Dokter Spesialis</span>
            <h2 class="section-title">Tim Dokter Kami</h2>
        </div>
        <div id="doctorGrid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.5rem;" role="list">
            @php
            $colorMap = ['blue'=>'#2563eb','pink'=>'#be185d','green'=>'#16a34a','orange'=>'#d97706','red'=>'#dc2626','purple'=>'#7c3aed'];
            @endphp
            @foreach ($doctors as $doctor)
            @php $clr = $colorMap[$doctor['color']] ?? '#2563eb'; @endphp
            <article class="card"
                role="listitem"
                data-name="{{ strtolower($doctor['name']) }}"
                data-spec="{{ $doctor['specialization'] }}"
                data-days="{{ collect($doctor['schedule'])->pluck('day')->join(',') }}">
                <div style="padding:2rem;text-align:center;border-bottom:1px solid var(--color-border);">
                    <div style="width:80px;height:80px;border-radius:50%;background:{{ $clr }}15;display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;border:4px solid {{ $clr }}25;">
                        <span style="font-size:1.75rem;font-weight:900;color:{{ $clr }};">{{ $doctor['initials'] }}</span>
                    </div>
                    <h2 style="font-size:1rem;font-weight:800;color:var(--color-text-primary);margin-bottom:.375rem;">
                        <a href="{{ route('doctors.detail', $doctor['slug']) }}" style="text-decoration:none;color:inherit;">{{ $doctor['name'] }}</a>
                    </h2>
                    <p style="font-size:.875rem;font-weight:700;color:{{ $clr }};margin-bottom:.25rem;">{{ $doctor['specialization'] }}</p>
                    <p style="font-size:.8125rem;color:var(--color-text-muted);">{{ $doctor['polyclinic'] }}</p>
                    <span style="display:inline-flex;align-items:center;gap:.375rem;margin-top:.75rem;font-size:.75rem;font-weight:600;color:#16a34a;background:rgba(22,163,74,.1);padding:.3rem .75rem;border-radius:100px;">
                        <span style="width:6px;height:6px;border-radius:50%;background:#16a34a;" aria-hidden="true"></span>
                        {{ $doctor['experience'] }} Pengalaman
                    </span>
                </div>
                <div style="padding:1.25rem;">
                    <div style="font-size:.75rem;font-weight:700;color:var(--color-text-muted);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.75rem;">Jadwal Praktik</div>
                    <div style="display:flex;flex-direction:column;gap:.4rem;margin-bottom:1.25rem;">
                        @foreach ($doctor['schedule'] as $sched)
                        <div style="display:flex;justify-content:space-between;align-items:center;font-size:.8125rem;">
                            <span style="font-weight:600;color:var(--color-text-primary);">{{ $sched['day'] }}</span>
                            <span style="color:{{ $clr }};font-weight:600;background:{{ $clr }}10;padding:.2rem .625rem;border-radius:100px;">{{ $sched['time'] }}</span>
                        </div>
                        @endforeach
                    </div>
                    <a href="{{ route('doctors.detail', $doctor['slug']) }}" class="btn btn-primary btn-sm" style="width:100%;justify-content:center;">Lihat Profil Lengkap</a>
                </div>
            </article>
            @endforeach
        </div>
        {{-- Empty state --}}
        <div id="noResults" style="display:none;text-align:center;padding:4rem 2rem;">
            <i data-lucide="search-x" style="width:48px;height:48px;color:var(--color-text-muted);margin-bottom:1rem;" aria-hidden="true"></i>
            <h3 style="font-size:1.125rem;font-weight:700;color:var(--color-text-primary);margin-bottom:.5rem;">Dokter Tidak Ditemukan</h3>
            <p style="font-size:.875rem;color:var(--color-text-secondary);">Coba ubah kata kunci pencarian atau filter Anda.</p>
        </div>
    </div>
</section>

{{-- ═══ SECTION 4: JADWAL MINGGUAN ═══ --}}
<section class="section section-alt" aria-label="Jadwal Praktik Mingguan">
    <div class="container-xl">
        <div style="text-align:center;margin-bottom:2.5rem;">
            <span class="section-label primary">Jadwal Lengkap</span>
            <h2 class="section-title">Jadwal Praktik Mingguan</h2>
            <p class="section-subtitle" style="margin:0 auto;">Tabel jadwal lengkap seluruh dokter spesialis RSU Rajawali Citra.</p>
        </div>
        <div style="background:var(--color-surface);border-radius:var(--radius-lg);border:1px solid var(--color-border);overflow:hidden;box-shadow:var(--shadow-sm);">
            <div style="overflow-x:auto;">
                <table style="width:100%;border-collapse:collapse;font-size:.875rem;">
                    <thead>
                        <tr style="background:var(--color-primary);color:#fff;">
                            <th style="padding:1rem 1.25rem;text-align:left;font-weight:700;font-size:.8125rem;white-space:nowrap;">Dokter</th>
                            <th style="padding:1rem 1.25rem;text-align:left;font-weight:700;font-size:.8125rem;white-space:nowrap;">Spesialisasi</th>
                            <th style="padding:1rem 1.25rem;text-align:center;font-weight:700;font-size:.8125rem;white-space:nowrap;">Senin</th>
                            <th style="padding:1rem 1.25rem;text-align:center;font-weight:700;font-size:.8125rem;white-space:nowrap;">Selasa</th>
                            <th style="padding:1rem 1.25rem;text-align:center;font-weight:700;font-size:.8125rem;white-space:nowrap;">Rabu</th>
                            <th style="padding:1rem 1.25rem;text-align:center;font-weight:700;font-size:.8125rem;white-space:nowrap;">Kamis</th>
                            <th style="padding:1rem 1.25rem;text-align:center;font-weight:700;font-size:.8125rem;white-space:nowrap;">Jumat</th>
                            <th style="padding:1rem 1.25rem;text-align:center;font-weight:700;font-size:.8125rem;white-space:nowrap;">Sabtu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($doctors as $i => $doctor)
                        @php
                        $scheduleByDay = collect($doctor['schedule'])->keyBy('day');
                        $days = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
                        @endphp
                        <tr style="border-bottom:1px solid var(--color-border);background:{{ $i % 2 === 0 ? '#fff' : '#fafbfc' }};">
                            <td style="padding:.875rem 1.25rem;white-space:nowrap;">
                                <a href="{{ route('doctors.detail', $doctor['slug']) }}" style="font-weight:700;color:var(--color-primary);text-decoration:none;">{{ $doctor['name'] }}</a>
                            </td>
                            <td style="padding:.875rem 1.25rem;color:var(--color-text-secondary);white-space:nowrap;font-size:.8125rem;">{{ $doctor['specialization'] }}</td>
                            @foreach ($days as $day)
                            <td style="padding:.875rem 1rem;text-align:center;">
                                @if (isset($scheduleByDay[$day]))
                                <span style="display:inline-block;font-size:.6875rem;font-weight:700;background:rgba(30,58,95,.08);color:var(--color-primary);padding:.25rem .625rem;border-radius:100px;white-space:nowrap;">{{ $scheduleByDay[$day]['time'] }}</span>
                                @else
                                <span style="color:var(--color-border);font-size:1.25rem;" aria-label="Tidak praktik">–</span>
                                @endif
                            </td>
                            @endforeach
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <p style="margin-top:1rem;font-size:.8125rem;color:var(--color-text-muted);text-align:center;">*Jadwal dapat berubah. Konfirmasi terbaru melalui telepon atau WhatsApp kami.</p>
    </div>
</section>

{{-- ═══ SECTION 5: POLIKLINIK ═══ --}}
<section class="section" style="background:var(--color-surface);" aria-label="Daftar Poliklinik">
    <div class="container-xl">
        <div style="text-align:center;margin-bottom:2.5rem;">
            <span class="section-label">Poliklinik</span>
            <h2 class="section-title">Unit Poliklinik Spesialis</h2>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:1rem;">
            @php
            $polis = [
                'Poli Umum','Poli Anak','Poli Kandungan','Poli Jantung','Poli Bedah Umum',
                'Poli Saraf','Poli Penyakit Dalam','Poli THT','Poli Mata','Poli Kulit & Kelamin',
                'Poli Ortopedi','Poli Gigi & Mulut','Poli Jiwa','Poli Paru','Poli Gizi Klinik',
            ];
            @endphp
            @foreach ($polis as $poli)
            <div style="background:var(--color-bg);border:1px solid var(--color-border);border-radius:var(--radius-md);padding:1rem 1.125rem;display:flex;align-items:center;gap:.625rem;">
                <span style="width:8px;height:8px;border-radius:50%;background:var(--color-primary);flex-shrink:0;" aria-hidden="true"></span>
                <span style="font-size:.875rem;font-weight:500;color:var(--color-text-primary);">{{ $poli }}</span>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ SECTION 6: FAQ DOKTER ═══ --}}
<section class="section section-alt" aria-label="FAQ Dokter">
    <div class="container-xl">
        <div style="text-align:center;margin-bottom:2.5rem;">
            <span class="section-label">FAQ</span>
            <h2 class="section-title">Pertanyaan Seputar Dokter & Jadwal</h2>
        </div>
        <div style="max-width:760px;margin:0 auto;" role="list">
            @php
            $doctorFaqs = [
                ['q'=>'Bagaimana cara memilih dokter yang tepat untuk kondisi saya?','a'=>'Anda dapat berkonsultasi dengan bagian informasi kami, atau berkunjung ke poli umum terlebih dahulu untuk mendapatkan rekomendasi dokter spesialis yang sesuai dengan kondisi kesehatan Anda.'],
                ['q'=>'Apakah jadwal dokter dapat berubah?','a'=>'Jadwal praktik dapat berubah sewaktu-waktu karena kepentingan dinas atau kondisi tertentu. Kami sarankan untuk mengonfirmasi jadwal terbaru melalui telepon atau WhatsApp sebelum berkunjung.'],
                ['q'=>'Apakah dokter spesialis melayani pasien tanpa rujukan?','a'=>'Untuk pasien umum (bayar mandiri atau asuransi swasta), dokter spesialis dapat melayani tanpa surat rujukan. Untuk pasien BPJS Kesehatan, diperlukan surat rujukan dari faskes tingkat pertama.'],
                ['q'=>'Bagaimana cara membuat janji dengan dokter tertentu?','a'=>'Anda dapat membuat janji temu melalui telepon ke +62 274-123-456, WhatsApp ke 0821-3431-3535, atau mengisi formulir di halaman Kontak kami.'],
            ];
            @endphp
            @foreach ($doctorFaqs as $i => $faq)
            <div role="listitem" style="border:1px solid var(--color-border);border-radius:var(--radius-md);margin-bottom:.75rem;overflow:hidden;background:#fff;">
                <button id="dfaq-btn-{{ $i }}" onclick="toggleDFaq({{ $i }})" aria-expanded="false" aria-controls="dfaq-panel-{{ $i }}" style="width:100%;display:flex;align-items:center;justify-content:space-between;padding:1.125rem 1.25rem;background:none;border:none;cursor:pointer;text-align:left;gap:1rem;">
                    <span style="font-size:.9375rem;font-weight:600;color:var(--color-text-primary);">{{ $faq['q'] }}</span>
                    <svg id="dfaq-icon-{{ $i }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:18px;height:18px;color:var(--color-text-muted);flex-shrink:0;transition:transform .3s;" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                </button>
                <div id="dfaq-panel-{{ $i }}" role="region" aria-labelledby="dfaq-btn-{{ $i }}" style="display:none;padding:0 1.25rem 1.125rem;font-size:.875rem;color:var(--color-text-secondary);line-height:1.7;">{{ $faq['a'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ SECTION 7: CTA ═══ --}}
<section style="background:linear-gradient(135deg,var(--color-primary) 0%,var(--color-accent) 100%);padding:4rem 0;" aria-label="Buat Janji dengan Dokter">
    <div class="container-xl" style="text-align:center;">
        <h2 style="font-size:clamp(1.5rem,3vw,2.25rem);font-weight:800;color:#fff;margin-bottom:1rem;">Jadwalkan Konsultasi dengan Dokter Kami</h2>
        <p style="font-size:1rem;color:rgba(255,255,255,.8);max-width:480px;margin:0 auto 2rem;line-height:1.7;">Kami siap membantu Anda mendapatkan layanan dari dokter spesialis terbaik sesuai kebutuhan kesehatan Anda.</p>
        <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:1rem;">
            <a href="{{ route('contact') }}#appointment" class="btn btn-lg" style="background:#fff;color:var(--color-primary);">Buat Janji Temu Sekarang</a>
            <a href="https://wa.me/628213431353" target="_blank" rel="noopener" class="btn btn-outline-white btn-lg">WhatsApp Kami</a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
function filterDoctors() {
    const search = document.getElementById('searchDoctor').value.toLowerCase();
    const spec   = document.getElementById('filterSpec').value;
    const day    = document.getElementById('filterDay').value;
    const cards  = document.querySelectorAll('#doctorGrid article');
    let visible  = 0;
    cards.forEach(function(card) {
        const name  = card.dataset.name || '';
        const cSpec = card.dataset.spec || '';
        const cDays = card.dataset.days || '';
        const matchSearch = !search || name.includes(search);
        const matchSpec   = !spec   || cSpec === spec;
        const matchDay    = !day    || cDays.includes(day);
        if (matchSearch && matchSpec && matchDay) {
            card.style.display = '';
            visible++;
        } else {
            card.style.display = 'none';
        }
    });
    const noResults = document.getElementById('noResults');
    const resultsEl = document.getElementById('searchResults');
    noResults.style.display = visible === 0 ? 'block' : 'none';
    if (search || spec || day) {
        resultsEl.style.display = 'block';
        resultsEl.textContent = 'Menampilkan ' + visible + ' dokter';
    } else {
        resultsEl.style.display = 'none';
    }
}

function toggleDFaq(index) {
    const panel = document.getElementById('dfaq-panel-' + index);
    const icon  = document.getElementById('dfaq-icon-' + index);
    const btn   = document.getElementById('dfaq-btn-' + index);
    const isOpen = panel.style.display === 'block';
    document.querySelectorAll('[id^="dfaq-panel-"]').forEach(function(p) { p.style.display = 'none'; });
    document.querySelectorAll('[id^="dfaq-icon-"]').forEach(function(i) { i.style.transform = ''; });
    document.querySelectorAll('[id^="dfaq-btn-"]').forEach(function(b) { b.setAttribute('aria-expanded', 'false'); });
    if (!isOpen) {
        panel.style.display = 'block';
        icon.style.transform = 'rotate(180deg)';
        btn.setAttribute('aria-expanded', 'true');
    }
}
</script>
@endpush
