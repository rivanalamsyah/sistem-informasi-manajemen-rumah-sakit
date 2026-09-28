@extends('layouts.public')

@section('title', 'Informasi & Berita — RSU Rajawali Citra')
@section('meta_description', 'Pusat informasi RSU Rajawali Citra: berita terbaru, artikel kesehatan, pengumuman, dan panduan pasien. Tetap update dengan informasi kesehatan terkini.')
@section('og_title', 'Informasi & Berita — RSU Rajawali Citra')

@section('content')

{{-- Page Hero --}}
<section class="page-hero" aria-label="Pusat Informasi">
    <div class="container-xl">
        <nav class="breadcrumb" aria-label="Breadcrumb" style="margin-bottom:1.5rem;">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <span aria-current="page">Informasi</span>
        </nav>
        <span class="section-label">Pusat Informasi</span>
        <h1 style="font-size:clamp(2rem,4vw,3rem);font-weight:900;color:var(--color-text-primary);margin-top:.75rem;margin-bottom:1rem;">Informasi, Berita &<br>Edukasi Kesehatan</h1>
        <p style="font-size:1.0625rem;color:var(--color-text-secondary);max-width:600px;line-height:1.75;">Temukan informasi terkini, artikel kesehatan bermanfaat, pengumuman, dan panduan pasien dari RSU Rajawali Citra.</p>
    </div>
</section>

{{-- ═══ INFO CATEGORIES ═══ --}}
<section style="background:#fff;padding:2.5rem 0;border-bottom:1px solid var(--color-border);" aria-label="Kategori Informasi">
    <div class="container-xl">
        <div style="display:flex;flex-wrap:wrap;gap:.75rem;justify-content:center;">
            @php
            $categories = [
                ['label'=>'Semua','href'=>route('information'),'active'=>true,'color'=>'var(--color-primary)'],
                ['label'=>'Berita','href'=>route('news'),'active'=>false,'color'=>'#2563eb'],
                ['label'=>'Artikel Kesehatan','href'=>route('articles'),'active'=>false,'color'=>'#16a34a'],
                ['label'=>'FAQ','href'=>route('faq'),'active'=>false,'color'=>'#d97706'],
            ];
            @endphp
            @foreach ($categories as $cat)
            <a href="{{ $cat['href'] }}"
               style="display:inline-flex;align-items:center;padding:.625rem 1.25rem;border-radius:100px;font-size:.875rem;font-weight:700;text-decoration:none;transition:all .2s;{{ $cat['active'] ? 'background:var(--color-primary);color:#fff;' : 'background:var(--color-bg);color:var(--color-text-secondary);border:1.5px solid var(--color-border);' }}"
               {{ $cat['active'] ? 'aria-current="page"' : '' }}>
                {{ $cat['label'] }}
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ BERITA TERBARU ═══ --}}
<section class="section" style="background:var(--color-surface);" aria-label="Berita Terbaru">
    <div class="container-xl">
        <div style="display:flex;align-items:flex-end;justify-content:space-between;gap:1.5rem;margin-bottom:2.5rem;flex-wrap:wrap;">
            <div>
                <span class="section-label">Berita</span>
                <h2 class="section-title" style="margin-bottom:.25rem;">Berita Terbaru</h2>
            </div>
            <a href="{{ route('news') }}" class="btn btn-outline" style="flex-shrink:0;">Semua Berita →</a>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.25rem;">
            @php $colorMap = ['blue'=>'#2563eb','green'=>'#16a34a','orange'=>'#d97706']; @endphp
            @foreach ($news as $item)
            @php $clr = $colorMap[$item['color']] ?? '#2563eb'; @endphp
            <article class="card">
                <div style="padding:1.125rem 1.5rem;border-bottom:1px solid var(--color-border);display:flex;align-items:center;justify-content:space-between;">
                    <span class="badge badge-{{ $item['color'] }}">{{ $item['category'] }}</span>
                    <time style="font-size:.75rem;color:var(--color-text-muted);" datetime="{{ $item['date'] }}">{{ $item['date'] }}</time>
                </div>
                <div style="padding:1.25rem 1.5rem;">
                    <h3 style="font-size:.9375rem;font-weight:700;color:var(--color-text-primary);margin-bottom:.625rem;line-height:1.4;">
                        <a href="{{ route('news.detail', $item['slug']) }}" style="text-decoration:none;color:inherit;">{{ $item['title'] }}</a>
                    </h3>
                    <p style="font-size:.8125rem;color:var(--color-text-secondary);line-height:1.6;margin-bottom:1rem;">{{ $item['excerpt'] }}</p>
                    <a href="{{ route('news.detail', $item['slug']) }}" style="font-size:.8125rem;font-weight:700;color:{{ $clr }};text-decoration:none;">Baca Selengkapnya →</a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ ARTIKEL KESEHATAN ═══ --}}
<section class="section section-alt" aria-label="Artikel Kesehatan">
    <div class="container-xl">
        <div style="display:flex;align-items:flex-end;justify-content:space-between;gap:1.5rem;margin-bottom:2.5rem;flex-wrap:wrap;">
            <div>
                <span class="section-label primary">Edukasi</span>
                <h2 class="section-title" style="margin-bottom:.25rem;">Artikel Kesehatan</h2>
            </div>
            <a href="{{ route('articles') }}" class="btn btn-outline" style="flex-shrink:0;">Semua Artikel →</a>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:1.5rem;">
            @php $colorMap = ['red'=>'#dc2626','blue'=>'#2563eb','green'=>'#16a34a','orange'=>'#d97706']; @endphp
            @foreach ($articles as $article)
            @php $clr = $colorMap[$article['color']] ?? '#2563eb'; @endphp
            <article class="card" style="overflow:hidden;">
                <div style="background:{{ $clr }}10;padding:1.25rem 1.5rem;border-bottom:1px solid {{ $clr }}20;">
                    <span style="display:inline-flex;align-items:center;padding:.25rem .75rem;background:{{ $clr }}15;color:{{ $clr }};border-radius:100px;font-size:.6875rem;font-weight:700;text-transform:uppercase;letter-spacing:.04em;">{{ $article['category'] }}</span>
                </div>
                <div style="padding:1.5rem;">
                    <h3 style="font-size:1rem;font-weight:700;color:var(--color-text-primary);margin-bottom:.625rem;line-height:1.4;">
                        <a href="{{ route('articles.detail', $article['slug']) }}" style="text-decoration:none;color:inherit;">{{ $article['title'] }}</a>
                    </h3>
                    <p style="font-size:.875rem;color:var(--color-text-secondary);line-height:1.65;margin-bottom:1rem;">{{ $article['excerpt'] }}</p>
                    <div style="display:flex;align-items:center;justify-content:space-between;font-size:.75rem;color:var(--color-text-muted);">
                        <span>{{ $article['author'] }}</span>
                        <time datetime="{{ $article['date'] }}">{{ $article['date'] }}</time>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ FAQ ═══ --}}
<section class="section" style="background:var(--color-surface);" aria-label="FAQ">
    <div class="container-xl">
        <div style="display:flex;align-items:flex-end;justify-content:space-between;gap:1.5rem;margin-bottom:2.5rem;flex-wrap:wrap;">
            <div>
                <span class="section-label">FAQ</span>
                <h2 class="section-title" style="margin-bottom:.25rem;">Pertanyaan Umum</h2>
            </div>
            <a href="{{ route('faq') }}" class="btn btn-outline" style="flex-shrink:0;">Lihat Semua FAQ →</a>
        </div>
        <div style="max-width:760px;" role="list">
            @foreach (array_slice($faqs, 0, 4) as $i => $faq)
            <div role="listitem" style="border:1px solid var(--color-border);border-radius:var(--radius-md);margin-bottom:.75rem;overflow:hidden;background:#fff;">
                <button id="ifaq-btn-{{ $i }}" onclick="toggleIFaq({{ $i }})" aria-expanded="false" aria-controls="ifaq-panel-{{ $i }}" style="width:100%;display:flex;align-items:center;justify-content:space-between;padding:1.125rem 1.25rem;background:none;border:none;cursor:pointer;text-align:left;gap:1rem;">
                    <span style="font-size:.9375rem;font-weight:600;color:var(--color-text-primary);">{{ $faq['q'] }}</span>
                    <svg id="ifaq-icon-{{ $i }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:18px;height:18px;color:var(--color-text-muted);flex-shrink:0;transition:transform .3s;" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                </button>
                <div id="ifaq-panel-{{ $i }}" role="region" aria-labelledby="ifaq-btn-{{ $i }}" style="display:none;padding:0 1.25rem 1.125rem;font-size:.875rem;color:var(--color-text-secondary);line-height:1.7;">{{ $faq['a'] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ PANDUAN PASIEN ═══ --}}
<section class="section section-alt" aria-label="Panduan Pasien">
    <div class="container-xl">
        <div style="text-align:center;margin-bottom:2.5rem;">
            <span class="section-label primary">Panduan</span>
            <h2 class="section-title">Panduan untuk Pasien</h2>
            <p class="section-subtitle" style="margin:0 auto;">Informasi penting yang perlu Anda ketahui sebelum dan selama kunjungan ke RSU Rajawali Citra.</p>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:1.25rem;">
            @php
            $guides = [
                ['title'=>'Prosedur Pendaftaran Pasien','desc'=>'Panduan lengkap cara mendaftar sebagai pasien baru maupun kunjungan ulang.','icon'=>'clipboard-list','color'=>'#2563eb'],
                ['title'=>'Hak & Kewajiban Pasien','desc'=>'Informasi hak-hak yang Anda miliki sebagai pasien dan kewajiban yang perlu dipenuhi.','icon'=>'scale','color'=>'#16a34a'],
                ['title'=>'Prosedur Rawat Inap','desc'=>'Tata cara dan persiapan yang diperlukan untuk proses rawat inap.','icon'=>'bed-double','color'=>'#d97706'],
                ['title'=>'Panduan Penggunaan BPJS','desc'=>'Cara menggunakan kartu BPJS Kesehatan di RSU Rajawali Citra.','icon'=>'credit-card','color'=>'#7c3aed'],
                ['title'=>'Cara Mengambil Hasil Lab','desc'=>'Prosedur pengambilan hasil pemeriksaan laboratorium dan radiologi.','icon'=>'flask-conical','color'=>'#0891b2'],
                ['title'=>'Panduan Pelayanan Farmasi','desc'=>'Cara menebus resep dan informasi layanan apotek rumah sakit.','icon'=>'pill','color'=>'#dc2626'],
            ];
            @endphp
            @foreach ($guides as $g)
            <div style="background:var(--color-surface);border:1px solid var(--color-border);border-radius:var(--radius-lg);padding:1.5rem;display:flex;gap:1rem;align-items:flex-start;">
                <div style="width:44px;height:44px;border-radius:10px;background:{{ $g['color'] }}15;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <i data-lucide="{{ $g['icon'] }}" style="width:22px;height:22px;color:{{ $g['color'] }};" aria-hidden="true"></i>
                </div>
                <div>
                    <h3 style="font-size:.9375rem;font-weight:700;color:var(--color-text-primary);margin-bottom:.375rem;">{{ $g['title'] }}</h3>
                    <p style="font-size:.8125rem;color:var(--color-text-secondary);line-height:1.6;">{{ $g['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══ CTA ═══ --}}
<section style="background:linear-gradient(135deg,var(--color-primary) 0%,var(--color-accent) 100%);padding:4rem 0;" aria-label="Hubungi Kami">
    <div class="container-xl" style="text-align:center;">
        <h2 style="font-size:clamp(1.5rem,3vw,2.25rem);font-weight:800;color:#fff;margin-bottom:1rem;">Ada Pertanyaan Lebih Lanjut?</h2>
        <p style="font-size:1rem;color:rgba(255,255,255,.8);max-width:480px;margin:0 auto 2rem;line-height:1.7;">Tim kami siap membantu Anda. Hubungi kami melalui telepon, WhatsApp, atau kunjungi langsung rumah sakit kami.</p>
        <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:1rem;">
            <a href="{{ route('contact') }}" class="btn btn-lg" style="background:#fff;color:var(--color-primary);">Hubungi Kami</a>
            <a href="{{ route('faq') }}" class="btn btn-outline-white btn-lg">Lihat FAQ Lengkap</a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
function toggleIFaq(index) {
    const panel = document.getElementById('ifaq-panel-' + index);
    const icon  = document.getElementById('ifaq-icon-' + index);
    const btn   = document.getElementById('ifaq-btn-' + index);
    const isOpen = panel.style.display === 'block';
    document.querySelectorAll('[id^="ifaq-panel-"]').forEach(function(p) { p.style.display = 'none'; });
    document.querySelectorAll('[id^="ifaq-icon-"]').forEach(function(i) { i.style.transform = ''; });
    document.querySelectorAll('[id^="ifaq-btn-"]').forEach(function(b) { b.setAttribute('aria-expanded', 'false'); });
    if (!isOpen) {
        panel.style.display = 'block';
        icon.style.transform = 'rotate(180deg)';
        btn.setAttribute('aria-expanded', 'true');
    }
}
</script>
@endpush
