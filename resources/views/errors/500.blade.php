@extends('layouts.public')

@section('title', 'Terjadi Kesalahan Sistem — RSU Rajawali Citra')
@section('meta_description', 'Terjadi kesalahan internal pada sistem. Tim teknis kami sedang menangani masalah ini.')

@section('content')
<section style="min-height:calc(100vh - 72px - 40px);display:flex;align-items:center;justify-content:center;padding:4rem 1rem;background:linear-gradient(135deg,#f0f4ff 0%,#e8f4fd 100%);" aria-label="Kesalahan Server">
    <div style="text-align:center;max-width:480px;">
        <div style="font-size:6rem;font-weight:900;color:var(--color-primary);opacity:.12;line-height:1;margin-bottom:-.5rem;" aria-hidden="true">500</div>
        <div style="width:80px;height:80px;border-radius:50%;background:rgba(220,38,38,.08);display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
            <i data-lucide="server-crash" style="width:36px;height:36px;color:var(--color-danger);" aria-hidden="true"></i>
        </div>
        <h1 style="font-size:1.75rem;font-weight:900;color:var(--color-text-primary);margin-bottom:.75rem;">Terjadi Kesalahan Sistem</h1>
        <p style="font-size:1rem;color:var(--color-text-secondary);line-height:1.75;margin-bottom:2rem;">Maaf, server sedang mengalami gangguan sementara. Tim teknis kami telah dinotifikasi dan sedang melakukan penanganan.</p>
        <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:1rem;">
            <a href="{{ route('home') }}" class="btn btn-primary">
                <i data-lucide="home" style="width:18px;height:18px;" aria-hidden="true"></i>
                Kembali ke Beranda
            </a>
            <a href="{{ route('contact') }}" class="btn btn-outline">Hubungi Layanan Informasi</a>
        </div>
        <div style="margin-top:2.5rem;padding:1.25rem;background:rgba(220,38,38,.05);border:1px solid rgba(220,38,38,.15);border-radius:var(--radius-lg);">
            <p style="font-size:.8125rem;font-weight:700;color:#991b1b;margin-bottom:.25rem;"><i data-lucide="siren" style="width:14px;height:14px;display:inline-block;vertical-align:-2px;" aria-hidden="true"></i> Darurat Medis?</p>
            <p style="font-size:.8125rem;color:#b91c1c;">Hubungi IGD 24 Jam: <a href="tel:+62274123456" style="font-weight:700;color:#991b1b;">+62 274-123-456</a></p>
        </div>
    </div>
</section>
@endsection
