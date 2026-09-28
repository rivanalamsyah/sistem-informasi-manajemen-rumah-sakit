@extends('layouts.public')

@section('title', 'Akses Ditolak — RSU Rajawali Citra')
@section('meta_description', 'Anda tidak memiliki hak akses untuk membuka halaman ini.')

@section('content')
<section style="min-height:calc(100vh - 72px - 40px);display:flex;align-items:center;justify-content:center;padding:4rem 1rem;background:linear-gradient(135deg,#f0f4ff 0%,#e8f4fd 100%);" aria-label="Akses Ditolak">
    <div style="text-align:center;max-width:480px;">
        <div style="font-size:6rem;font-weight:900;color:var(--color-primary);opacity:.12;line-height:1;margin-bottom:-.5rem;" aria-hidden="true">403</div>
        <div style="width:80px;height:80px;border-radius:50%;background:rgba(217,119,6,.08);display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
            <i data-lucide="shield-alert" style="width:36px;height:36px;color:var(--color-warning);" aria-hidden="true"></i>
        </div>
        <h1 style="font-size:1.75rem;font-weight:900;color:var(--color-text-primary);margin-bottom:.75rem;">Akses Ditolak</h1>
        <p style="font-size:1rem;color:var(--color-text-secondary);line-height:1.75;margin-bottom:2rem;">Maaf, Anda tidak memiliki hak akses atau otorisasi yang diperlukan untuk membuka halaman ini.</p>
        <div style="display:flex;flex-wrap:wrap;justify-content:center;gap:1rem;">
            <a href="{{ route('home') }}" class="btn btn-primary">
                <i data-lucide="home" style="width:18px;height:18px;" aria-hidden="true"></i>
                Kembali ke Beranda
            </a>
            <a href="{{ route('login') }}" class="btn btn-outline">Login Staf</a>
        </div>
    </div>
</section>
@endsection
