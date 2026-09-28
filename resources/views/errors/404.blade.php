@extends('layouts.public')

@section('title', 'Halaman Tidak Ditemukan — RSU Rajawali Citra')
@section('meta_description', 'Halaman yang Anda cari tidak ditemukan di RSU Rajawali Citra.')

@section('content')
<section style="min-height:calc(100vh - 72px - 40px);display:flex;align-items:center;justify-content:center;padding:4rem 1rem;background:linear-gradient(135deg,#f0f4ff 0%,#e8f4fd 100%);" aria-label="Halaman Tidak Ditemukan">
    <div style="text-align:center;max-width:480px;">
        <div style="font-size:6rem;font-weight:900;color:var(--color-primary);opacity:.12;line-height:1;margin-bottom:-.5rem;" aria-hidden="true">404</div>
        <div style="width:80px;height:80px;border-radius:50%;background:rgba(30,58,95,.08);display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="var(--color-primary)" width="36" height="36" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/></svg>
        </div>
        <h1 style="font-size:1.75rem;font-weight:900;color:var(--color-text-primary);margin-bottom:.75rem;">Halaman Tidak Ditemukan</h1>
        <p style="font-size:1rem;color:var(--color-text-secondary);line-height:1.75;margin-bottom:2rem;">Maaf, halaman yang Anda cari tidak tersedia atau mungkin telah dipindahkan.</p>
        <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:1rem;">
            <a href="{{ route('home') }}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="18" height="18" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                Kembali ke Beranda
            </a>
            <a href="{{ route('contact') }}" class="btn btn-outline">Hubungi Kami</a>
        </div>
        <div style="margin-top:2.5rem;padding:1.25rem;background:rgba(220,38,38,.05);border:1px solid rgba(220,38,38,.15);border-radius:var(--radius-lg);">
            <p style="font-size:.8125rem;font-weight:700;color:#991b1b;margin-bottom:.25rem;"> Darurat Medis?</p>
            <p style="font-size:.8125rem;color:#b91c1c;">Hubungi IGD 24 Jam: <a href="tel:+62274123456" style="font-weight:700;color:#991b1b;">+62 274-123-456</a></p>
        </div>
    </div>
</section>
@endsection
