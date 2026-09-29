@extends('layouts.public')

@section('title', 'Informasi & Berita — RSU Rajawali Citra')
@section('meta_description', 'Pusat informasi RSU Rajawali Citra: berita terbaru, artikel kesehatan, pengumuman, dan panduan pasien. Tetap update dengan informasi kesehatan terkini.')
@section('og_title', 'Informasi & Berita — RSU Rajawali Citra')

@section('content')

{{-- Page Hero --}}
<section class="page-hero" aria-label="Pusat Informasi">
    <div class="container-xl">
        <nav class="breadcrumb mb-4" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <span aria-current="page">Informasi</span>
        </nav>
        <span class="section-label">Pusat Informasi</span>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 mt-2 mb-4 leading-tight">
            Informasi, Berita &amp;<br>Edukasi Kesehatan
        </h1>
        <p class="text-base sm:text-lg text-slate-600 max-w-2xl leading-relaxed">
            Temukan informasi terkini, artikel kesehatan bermanfaat, pengumuman, dan panduan pasien dari RSU Rajawali Citra.
        </p>
    </div>
</section>

{{-- KATEGORI --}}
<section class="bg-white py-6 border-b border-slate-200" aria-label="Kategori Informasi">
    <div class="container-xl">
        <div class="flex flex-wrap items-center justify-center gap-2.5">
            @php
            $categories = [
                ['label'=>'Semua Informasi','href'=>route('information'),'active'=>true],
                ['label'=>'Berita Terbaru','href'=>route('news'),'active'=>false],
                ['label'=>'Artikel Kesehatan','href'=>route('articles'),'active'=>false],
                ['label'=>'FAQ & Bantuan','href'=>route('faq'),'active'=>false],
            ];
            @endphp
            @foreach ($categories as $cat)
            <a href="{{ $cat['href'] }}"
               class="px-4 py-2 rounded-full text-xs font-extrabold no-underline transition {{ $cat['active'] ? 'bg-blue-900 text-white shadow-sm' : 'bg-slate-100 text-slate-700 hover:bg-slate-200 border border-slate-200' }}">
                {{ $cat['label'] }}
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- BERITA TERBARU --}}
<section class="section bg-white" aria-label="Berita Terbaru">
    <div class="container-xl">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
            <div>
                <span class="section-label">Berita</span>
                <h2 class="section-title">Berita Terbaru RS</h2>
            </div>
            <a href="{{ route('news') }}" class="btn btn-outline shrink-0 self-start md:self-auto">Semua Berita &rarr;</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @php $colorMap = ['blue'=>'#2563eb','green'=>'#16a34a','orange'=>'#d97706']; @endphp
            @foreach ($news as $item)
            @php $clr = $colorMap[$item['color']] ?? '#2563eb'; @endphp
            <article class="card flex flex-col h-full">
                <div class="p-4 border-b border-slate-100 flex items-center justify-between">
                    <span class="badge badge-{{ $item['color'] }}">{{ $item['category'] }}</span>
                    <time class="text-xs text-slate-400" datetime="{{ $item['date'] }}">{{ $item['date'] }}</time>
                </div>
                <div class="p-5 flex flex-col flex-1">
                    <h3 class="text-base font-bold text-slate-900 mb-2 leading-snug">
                        <a href="{{ route('news.detail', $item['slug']) }}" class="hover:text-blue-900 transition no-underline">
                            {{ $item['title'] }}
                        </a>
                    </h3>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed mb-4 flex-1">{{ $item['excerpt'] }}</p>
                    <a href="{{ route('news.detail', $item['slug']) }}" class="text-xs font-bold no-underline mt-auto" style="color: {{ $clr }}">
                        Baca Selengkapnya &rarr;
                    </a>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>

{{-- ARTIKEL KESEHATAN --}}
<section class="section section-alt" aria-label="Artikel Kesehatan">
    <div class="container-xl">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
            <div>
                <span class="section-label primary">Edukasi</span>
                <h2 class="section-title">Artikel Kesehatan Dokter</h2>
            </div>
            <a href="{{ route('articles') }}" class="btn btn-outline shrink-0 self-start md:self-auto">Semua Artikel &rarr;</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @php $colorMap = ['red'=>'#dc2626','blue'=>'#2563eb','green'=>'#16a34a','orange'=>'#d97706']; @endphp
            @foreach ($articles as $article)
            @php $clr = $colorMap[$article['color']] ?? '#2563eb'; @endphp
            <article class="card flex flex-col h-full overflow-hidden">
                <div class="p-4 border-b border-slate-100" style="background-color: {{ $clr }}0d">
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

{{-- FAQ --}}
<section class="section bg-white" aria-label="FAQ">
    <div class="container-xl">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-8">
            <div>
                <span class="section-label">FAQ</span>
                <h2 class="section-title">Pertanyaan Umum</h2>
            </div>
            <a href="{{ route('faq') }}" class="btn btn-outline shrink-0 self-start md:self-auto">Lihat Semua FAQ &rarr;</a>
        </div>

        <div class="max-w-3xl space-y-3" role="list">
            @foreach (array_slice($faqs, 0, 4) as $i => $faq)
            <div role="listitem" class="border border-slate-200 rounded-xl overflow-hidden bg-white shadow-sm">
                <button id="ifaq-btn-{{ $i }}" onclick="toggleIFaq({{ $i }})" aria-expanded="false" aria-controls="ifaq-panel-{{ $i }}" class="w-full flex items-center justify-between p-4 text-left bg-none border-none cursor-pointer gap-4 transition hover:bg-slate-50">
                    <span class="text-xs sm:text-sm font-bold text-slate-900 leading-snug">{{ $faq['q'] }}</span>
                    <svg id="ifaq-icon-{{ $i }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-slate-400 shrink-0 transition-transform duration-200" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                </button>
                <div id="ifaq-panel-{{ $i }}" role="region" aria-labelledby="ifaq-btn-{{ $i }}" class="hidden px-4 pb-4 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-3">{{ $faq['a'] }}</div>
            </div>
            @endforeach
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
    if (!panel) return;

    const isOpen = !panel.classList.contains('hidden');

    document.querySelectorAll('[id^="ifaq-panel-"]').forEach(function(p) { p.classList.add('hidden'); });
    document.querySelectorAll('[id^="ifaq-icon-"]').forEach(function(i) { i.style.transform = ''; });
    document.querySelectorAll('[id^="ifaq-btn-"]').forEach(function(b) { b.setAttribute('aria-expanded', 'false'); });

    if (!isOpen) {
        panel.classList.remove('hidden');
        if (icon) icon.style.transform = 'rotate(180deg)';
        if (btn) btn.setAttribute('aria-expanded', 'true');
    }
}
</script>
@endpush
