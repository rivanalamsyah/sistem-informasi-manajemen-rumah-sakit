@extends('layouts.public')
@section('title', 'FAQ — RSU Rajawali Citra')
@section('meta_description', 'Jawaban atas pertanyaan yang sering diajukan seputar layanan RSU Rajawali Citra: pendaftaran, BPJS, rawat inap, jadwal dokter, dan prosedur medis.')
@section('og_title', 'FAQ — RSU Rajawali Citra')

@section('content')
<section class="page-hero" aria-label="FAQ">
    <div class="container-xl">
        <nav class="breadcrumb mb-4" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <a href="{{ route('information') }}">Informasi</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <span aria-current="page">FAQ</span>
        </nav>
        <span class="section-label">FAQ</span>
        <h1 class="text-3xl sm:text-4xl lg:text-5xl font-black text-slate-900 mt-2 mb-4 leading-tight">
            Pertanyaan yang Sering<br>Diajukan (FAQ)
        </h1>
        <p class="text-base sm:text-lg text-slate-600 max-w-2xl leading-relaxed">
            Temukan jawaban atas pertanyaan umum seputar layanan, prosedur pendaftaran, BPJS, dan fasilitas RSU Rajawali Citra.
        </p>
    </div>
</section>

<section class="section bg-white" aria-label="Daftar FAQ">
    <div class="container-xl">
        <div class="max-w-4xl mx-auto space-y-10">
            @php
            $faqGroups = [
                ['group'=>'Pendaftaran & Kunjungan','faqs'=>[
                    ['q'=>'Bagaimana cara mendaftar sebagai pasien baru?','a'=>'Anda dapat mendaftar langsung di loket pendaftaran RSU Rajawali Citra dengan membawa KTP/identitas diri. Untuk pasien BPJS, siapkan juga kartu BPJS dan surat rujukan dari faskes tingkat pertama.'],
                    ['q'=>'Apakah diperlukan janji temu sebelum berkunjung?','a'=>'Untuk poliklinik spesialis, sangat disarankan membuat janji temu terlebih dahulu untuk mengurangi waktu tunggu. Anda dapat menghubungi kami via telepon atau WhatsApp.'],
                    ['q'=>'Apa yang perlu saya bawa saat kunjungan pertama?','a'=>'Bawa KTP atau identitas diri, kartu jaminan kesehatan (BPJS/asuransi), surat rujukan (jika ada), dan hasil pemeriksaan sebelumnya (jika ada) untuk membantu dokter dalam diagnosa.'],
                ]],
                ['group'=>'BPJS & Asuransi','faqs'=>[
                    ['q'=>'Apakah RSU Rajawali Citra menerima BPJS Kesehatan?','a'=>'Ya, RSU Rajawali Citra adalah fasilitas kesehatan mitra resmi BPJS Kesehatan. Kami melayani pasien BPJS untuk layanan rawat jalan, rawat inap, IGD, dan berbagai layanan lainnya.'],
                    ['q'=>'Apa persyaratan untuk berobat menggunakan BPJS?','a'=>'Untuk rawat jalan, diperlukan surat rujukan dari puskesmas/klinik faskes tingkat pertama, kartu BPJS aktif, dan KTP. Untuk IGD darurat, Anda tidak memerlukan surat rujukan.'],
                    ['q'=>'Asuransi swasta apa saja yang diterima?','a'=>'Kami menerima berbagai asuransi swasta termasuk Mandiri Inhealth, Allianz, AXA Mandiri, Prudential, BNI Life, dan lainnya. Hubungi kami untuk konfirmasi kerjasama asuransi spesifik.'],
                ]],
                ['group'=>'Rawat Inap','faqs'=>[
                    ['q'=>'Apa saja kelas kamar rawat inap yang tersedia?','a'=>'Kami menyediakan berbagai pilihan kamar: VVIP (1 tempat tidur, kamar mandi dalam, AC, TV, sofa), VIP, Kelas I, Kelas II, dan Kelas III. Pilihan kamar disesuaikan dengan jaminan kesehatan atau kemampuan finansial pasien.'],
                    ['q'=>'Apakah ada pembatasan jam kunjungan pasien rawat inap?','a'=>'Jam kunjungan pasien rawat inap adalah pukul 11.00–13.00 dan 17.00–19.00 WIB setiap hari. Pengunjung diharapkan mematuhi tata tertib rumah sakit demi kenyamanan pasien.'],
                    ['q'=>'Bagaimana prosedur pulang pasien rawat inap?','a'=>'Dokter akan memberikan persetujuan pulang setelah kondisi pasien dinilai cukup baik. Proses administrasi pulang dilakukan di kasir, termasuk penyelesaian tagihan dan penerimaan resep pulang.'],
                ]],
                ['group'=>'Layanan Medis','faqs'=>[
                    ['q'=>'Apakah ada layanan konsultasi dokter secara online?','a'=>'Saat ini kami menyediakan konsultasi via WhatsApp untuk pertanyaan umum. Untuk konsultasi medis yang lebih detail, kami menganjurkan kunjungan langsung ke poliklinik.'],
                    ['q'=>'Berapa lama proses pemeriksaan di laboratorium?','a'=>'Sebagian besar hasil laboratorium rutin selesai dalam 1–3 jam. Pemeriksaan khusus seperti kultur bakteri dapat memakan waktu 3–7 hari kerja.'],
                ]],
            ];
            @endphp

            @foreach ($faqGroups as $gi => $group)
            <div class="space-y-4">
                <h2 class="text-base sm:text-lg font-extrabold text-blue-900 px-4 py-2 bg-blue-50/80 rounded-xl border-l-4 border-blue-900">
                    {{ $group['group'] }}
                </h2>
                <div class="space-y-3" role="list">
                    @foreach ($group['faqs'] as $i => $faq)
                    @php $uid = $gi . '_' . $i; @endphp
                    <div role="listitem" class="border border-slate-200 rounded-xl overflow-hidden bg-white shadow-sm">
                        <button id="faq-btn-{{ $uid }}" onclick="toggleGroupFaq('{{ $uid }}')" aria-expanded="false" aria-controls="faq-panel-{{ $uid }}" class="w-full flex items-center justify-between p-4 text-left bg-none border-none cursor-pointer gap-4 transition hover:bg-slate-50">
                            <span class="text-xs sm:text-sm font-bold text-slate-900 leading-snug">{{ $faq['q'] }}</span>
                            <svg id="faq-icon-{{ $uid }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 text-slate-400 shrink-0 transition-transform duration-200" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                        </button>
                        <div id="faq-panel-{{ $uid }}" role="region" aria-labelledby="faq-btn-{{ $uid }}" class="hidden px-4 pb-4 text-xs sm:text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-3">{{ $faq['a'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach

            <div class="text-center p-8 bg-slate-50 border border-slate-200 rounded-2xl space-y-3">
                <p class="text-base font-bold text-slate-900">Tidak menemukan jawaban yang Anda cari?</p>
                <p class="text-xs sm:text-sm text-slate-600">Hubungi kami langsung dan tim layanan kami siap membantu Anda.</p>
                <div class="flex flex-col sm:flex-row justify-center gap-3 pt-2">
                    <a href="{{ route('contact') }}" class="btn btn-primary">Hubungi Kami</a>
                    <a href="https://wa.me/628213431353" target="_blank" rel="noopener" class="btn btn-outline">WhatsApp CS</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
function toggleGroupFaq(uid) {
    const panel = document.getElementById('faq-panel-' + uid);
    const icon  = document.getElementById('faq-icon-' + uid);
    const btn   = document.getElementById('faq-btn-' + uid);
    if (!panel) return;

    const isOpen = !panel.classList.contains('hidden');
    if (!isOpen) {
        panel.classList.remove('hidden');
        if (icon) icon.style.transform = 'rotate(180deg)';
        if (btn) btn.setAttribute('aria-expanded', 'true');
    } else {
        panel.classList.add('hidden');
        if (icon) icon.style.transform = '';
        if (btn) btn.setAttribute('aria-expanded', 'false');
    }
}
</script>
@endpush
