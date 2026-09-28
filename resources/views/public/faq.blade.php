@extends('layouts.public')
@section('title', 'FAQ — RSU Rajawali Citra')
@section('meta_description', 'Jawaban atas pertanyaan yang sering diajukan seputar layanan RSU Rajawali Citra: pendaftaran, BPJS, rawat inap, jadwal dokter, dan prosedur medis.')
@section('og_title', 'FAQ — RSU Rajawali Citra')

@section('content')
<section class="page-hero" aria-label="FAQ">
    <div class="container-xl">
        <nav class="breadcrumb" aria-label="Breadcrumb" style="margin-bottom:1.5rem;">
            <a href="{{ route('home') }}">Beranda</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <a href="{{ route('information') }}">Informasi</a>
            <span class="breadcrumb-sep" aria-hidden="true">›</span>
            <span aria-current="page">FAQ</span>
        </nav>
        <span class="section-label">FAQ</span>
        <h1 style="font-size:clamp(2rem,4vw,3rem);font-weight:900;color:var(--color-text-primary);margin-top:.75rem;margin-bottom:1rem;">Pertanyaan yang Sering<br>Diajukan</h1>
        <p style="font-size:1.0625rem;color:var(--color-text-secondary);max-width:600px;line-height:1.75;">Temukan jawaban atas pertanyaan umum seputar layanan, prosedur, dan fasilitas RSU Rajawali Citra.</p>
    </div>
</section>

<section class="section" style="background:var(--color-surface);" aria-label="Daftar FAQ">
    <div class="container-xl">
        <div style="max-width:800px;margin:0 auto;">
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
            <div style="margin-bottom:2.5rem;">
                <h2 style="font-size:1.0625rem;font-weight:800;color:var(--color-primary);margin-bottom:1rem;padding:.625rem 1rem;background:rgba(30,58,95,.05);border-radius:var(--radius-md);border-left:4px solid var(--color-primary);">{{ $group['group'] }}</h2>
                <div role="list">
                    @foreach ($group['faqs'] as $i => $faq)
                    @php $uid = $gi . '_' . $i; @endphp
                    <div role="listitem" style="border:1px solid var(--color-border);border-radius:var(--radius-md);margin-bottom:.75rem;overflow:hidden;background:#fff;">
                        <button id="faq-btn-{{ $uid }}" onclick="toggleGroupFaq('{{ $uid }}')" aria-expanded="false" aria-controls="faq-panel-{{ $uid }}" style="width:100%;display:flex;align-items:center;justify-content:space-between;padding:1.125rem 1.25rem;background:none;border:none;cursor:pointer;text-align:left;gap:1rem;">
                            <span style="font-size:.9375rem;font-weight:600;color:var(--color-text-primary);">{{ $faq['q'] }}</span>
                            <svg id="faq-icon-{{ $uid }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:18px;height:18px;color:var(--color-text-muted);flex-shrink:0;transition:transform .3s;" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                        </button>
                        <div id="faq-panel-{{ $uid }}" role="region" aria-labelledby="faq-btn-{{ $uid }}" style="display:none;padding:0 1.25rem 1.125rem;font-size:.875rem;color:var(--color-text-secondary);line-height:1.7;">{{ $faq['a'] }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach

            <div style="text-align:center;padding:2rem;background:rgba(30,58,95,.04);border-radius:var(--radius-xl);border:1px solid var(--color-border);">
                <p style="font-size:1rem;font-weight:600;color:var(--color-text-primary);margin-bottom:.5rem;">Tidak menemukan jawaban yang Anda cari?</p>
                <p style="font-size:.875rem;color:var(--color-text-secondary);margin-bottom:1.5rem;">Hubungi kami langsung dan tim kami siap membantu Anda.</p>
                <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:.75rem;">
                    <a href="{{ route('contact') }}" class="btn btn-primary">Hubungi Kami</a>
                    <a href="https://wa.me/628213431353" target="_blank" rel="noopener" class="btn btn-outline">WhatsApp</a>
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
    const isOpen = panel.style.display === 'block';
    if (!isOpen) {
        panel.style.display = 'block';
        icon.style.transform = 'rotate(180deg)';
        btn.setAttribute('aria-expanded', 'true');
    } else {
        panel.style.display = 'none';
        icon.style.transform = '';
        btn.setAttribute('aria-expanded', 'false');
    }
}
</script>
@endpush
