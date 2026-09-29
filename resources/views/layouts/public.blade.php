<!DOCTYPE html>
<html lang="id" class="scroll-smooth light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    {{-- SEO --}}
    <title>@yield('title', 'RSU Rajawali Citra') | Rumah Sakit Umum Profesional di Bantul, Yogyakarta</title>
    <meta name="description" content="@yield('meta_description', 'RSU Rajawali Citra memberikan pelayanan kesehatan berkualitas, profesional, dan terpercaya di Bantul, Yogyakarta. Tersedia IGD 24 jam, 15+ Poliklinik Spesialis, Rawat Inap, Laboratorium, dan Radiologi.')">
    <meta name="keywords" content="@yield('meta_keywords', 'RSU Rajawali Citra, rumah sakit Bantul, rumah sakit Yogyakarta, dokter spesialis, IGD 24 jam, poliklinik, rawat inap')">
    <link rel="canonical" href="@yield('canonical', url()->current())">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="RSU Rajawali Citra">
    <meta property="og:title" content="@yield('og_title', 'RSU Rajawali Citra — Rumah Sakit Umum Profesional')">
    <meta property="og:description" content="@yield('og_description', 'Pelayanan kesehatan berkualitas, profesional, dan terpercaya di Bantul, Yogyakarta.')">
    <meta property="og:url" content="{{ url()->current() }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', 'RSU Rajawali Citra')">
    <meta name="twitter:description" content="@yield('og_description', 'Pelayanan kesehatan berkualitas di Bantul, Yogyakarta.')">

    {{-- Favicon --}}
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    <link rel="icon" type="image/x-icon" href="/favicon.ico">
    <link rel="manifest" href="/site.webmanifest">

    {{-- Fonts: Inter & Playfair Display --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@600;700;800&display=swap" rel="stylesheet">

    {{-- Icons --}}
    <script src="https://unpkg.com/lucide@latest" defer></script>

    {{-- Tailwind CSS & Assets --}}
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        colors: {
                            primary: { DEFAULT: '#1e3a5f', dark: '#152d4a', light: '#2563eb' },
                            accent: { DEFAULT: '#0891b2', light: '#06b6d4' }
                        }
                    }
                }
            }
        </script>
    @endif

    {{-- Design Tokens & Global CSS --}}
    <style>
        :root {
            --color-primary: #1e3a5f;
            --color-primary-dark: #152d4a;
            --color-primary-light: #2563eb;
            --color-accent: #0891b2;
            --color-accent-light: #06b6d4;
            --color-success: #16a34a;
            --color-warning: #d97706;
            --color-danger: #dc2626;
            --color-bg: #f8fafc;
            --color-surface: #ffffff;
            --color-border: #e2e8f0;
            --color-text-primary: #0f172a;
            --color-text-secondary: #475569;
            --color-text-muted: #94a3b8;

            --font-sans: 'Inter', ui-sans-serif, system-ui, sans-serif;
            --font-display: 'Playfair Display', Georgia, serif;

            --radius-sm: 0.375rem;
            --radius-md: 0.75rem;
            --radius-lg: 1.25rem;
            --radius-xl: 2rem;

            --shadow-sm: 0 1px 3px rgba(15,23,42,0.06), 0 1px 2px rgba(15,23,42,0.04);
            --shadow-md: 0 4px 16px rgba(15,23,42,0.08), 0 2px 4px rgba(15,23,42,0.05);
            --shadow-lg: 0 10px 40px rgba(15,23,42,0.1), 0 4px 8px rgba(15,23,42,0.06);
            --shadow-xl: 0 20px 60px rgba(15,23,42,0.12), 0 8px 16px rgba(15,23,42,0.08);
        }

        *, *::before, *::after { box-sizing: border-box; }
        html, body {
            overflow-x: hidden;
            background-color: var(--color-bg);
            color: var(--color-text-primary);
            font-family: var(--font-sans);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* Skip link */
        .skip-link {
            position: absolute;
            left: -9999px;
            top: auto;
            width: 1px;
            height: 1px;
            overflow: hidden;
        }
        .skip-link:focus {
            position: fixed;
            top: 1rem;
            left: 1rem;
            width: auto;
            height: auto;
            padding: 0.75rem 1.5rem;
            background: var(--color-primary);
            color: #fff;
            border-radius: var(--radius-md);
            z-index: 10000;
            font-weight: 600;
            text-decoration: none;
            box-shadow: var(--shadow-lg);
        }

        :focus-visible {
            outline: 2px solid var(--color-accent);
            outline-offset: 2px;
        }

        /* Container System */
        .container-xl {
            width: 100%;
            max-width: 1280px;
            margin-left: auto;
            margin-right: auto;
            padding-left: 1rem;
            padding-right: 1rem;
        }
        @media (min-width: 480px) { .container-xl { padding-left: 1.25rem; padding-right: 1.25rem; } }
        @media (min-width: 640px) { .container-xl { padding-left: 1.5rem; padding-right: 1.5rem; } }
        @media (min-width: 1024px) { .container-xl { padding-left: 2rem; padding-right: 2rem; } }

        /* Typography Scale */
        .display { font-family: var(--font-display); font-size: clamp(2.25rem, 5vw, 4rem); font-weight: 700; line-height: 1.15; }
        .h1 { font-size: clamp(1.75rem, 4vw, 3rem); font-weight: 800; line-height: 1.2; }
        .h2 { font-size: clamp(1.375rem, 3vw, 2.25rem); font-weight: 700; line-height: 1.25; }
        .h3 { font-size: clamp(1.125rem, 2vw, 1.5rem); font-weight: 700; line-height: 1.3; }
        .h4 { font-size: 1.125rem; font-weight: 600; line-height: 1.4; }

        /* Section Layout System */
        .section { padding-top: 3.5rem; padding-bottom: 3.5rem; }
        @media (min-width: 768px) { .section { padding-top: 4.5rem; padding-bottom: 4.5rem; } }
        @media (min-width: 1024px) { .section { padding-top: 5.5rem; padding-bottom: 5.5rem; } }

        .section-alt { background-color: #f0f4ff; }
        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.375rem 1rem;
            background: rgba(8,145,178,0.1);
            color: var(--color-accent);
            border-radius: 100px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            margin-bottom: 0.875rem;
        }
        .section-label.primary {
            background: rgba(30,58,95,0.08);
            color: var(--color-primary);
        }
        .section-title {
            font-size: clamp(1.375rem, 3vw, 2.25rem);
            font-weight: 800;
            color: var(--color-text-primary);
            line-height: 1.25;
            margin-bottom: 0.75rem;
        }
        .section-subtitle {
            font-size: 0.9375rem;
            color: var(--color-text-secondary);
            max-width: 640px;
            line-height: 1.7;
        }
        @media (min-width: 768px) { .section-subtitle { font-size: 1.0625rem; } }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.6875rem 1.5rem;
            min-height: 44px;
            border-radius: var(--radius-md);
            font-size: 0.875rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            border: 2px solid transparent;
            white-space: nowrap;
        }
        .btn-primary {
            background: var(--color-primary);
            color: #fff;
            box-shadow: 0 4px 15px rgba(30,58,95,0.25);
        }
        .btn-primary:hover {
            background: var(--color-primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(30,58,95,0.35);
            color: #fff;
        }
        .btn-accent {
            background: var(--color-accent);
            color: #fff;
            box-shadow: 0 4px 15px rgba(8,145,178,0.25);
        }
        .btn-accent:hover {
            background: #0e7490;
            transform: translateY(-1px);
            color: #fff;
        }
        .btn-outline {
            background: transparent;
            color: var(--color-primary);
            border-color: var(--color-primary);
        }
        .btn-outline:hover {
            background: var(--color-primary);
            color: #fff;
        }
        .btn-outline-white {
            background: transparent;
            color: #fff;
            border-color: rgba(255,255,255,0.7);
        }
        .btn-outline-white:hover {
            background: rgba(255,255,255,0.15);
            color: #fff;
        }
        .btn-lg { padding: 0.875rem 2rem; min-height: 50px; font-size: 0.9375rem; }
        .btn-sm { padding: 0.4375rem 1.125rem; min-height: 38px; font-size: 0.8125rem; }

        /* Cards */
        .card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
        }
        .card:hover { transform: translateY(-3px); box-shadow: var(--shadow-lg); border-color: rgba(30,58,95,0.2); }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 100px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .badge-blue   { background: #eff6ff; color: #1d4ed8; }
        .badge-green  { background: #f0fdf4; color: #15803d; }
        .badge-red    { background: #fef2f2; color: #b91c1c; }
        .badge-orange { background: #fff7ed; color: #c2410c; }
        .badge-purple { background: #faf5ff; color: #7e22ce; }
        .badge-teal   { background: #f0fdfa; color: #0f766e; }
        .badge-cyan   { background: #ecfeff; color: #0e7490; }

        /* ─── DYNAMIC ISLAND GLASSMORPHISM NAVBAR ─── */
        .navbar-wrapper {
            position: fixed;
            top: 0.75rem;
            left: 0;
            right: 0;
            z-index: 1000;
            display: flex;
            justify-content: center;
            padding-left: 0.75rem;
            padding-right: 0.75rem;
            pointer-events: none;
        }
        @media (min-width: 640px) {
            .navbar-wrapper { top: 1rem; padding-left: 1rem; padding-right: 1rem; }
        }

        .navbar {
            pointer-events: auto;
            width: 100%;
            max-width: 1180px;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(226, 232, 240, 0.9);
            border-radius: 9999px;
            box-shadow: 0 8px 32px rgba(15, 23, 42, 0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.98);
            border-color: rgba(30, 58, 95, 0.18);
            box-shadow: 0 14px 40px rgba(15, 23, 42, 0.14);
        }

        .navbar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 60px;
            padding: 0 0.875rem 0 1.125rem;
        }
        @media (min-width: 640px) {
            .navbar-inner { height: 66px; padding: 0 1.25rem 0 1.5rem; }
        }

        .nav-logo {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            text-decoration: none;
            flex-shrink: 0;
        }
        .nav-logo-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 3px 10px rgba(30,58,95,0.25);
        }
        @media (min-width: 640px) {
            .nav-logo-icon { width: 44px; height: 44px; border-radius: 12px; }
        }
        .nav-logo-title {
            font-size: 0.9375rem;
            font-weight: 800;
            color: var(--color-primary);
            line-height: 1.2;
            letter-spacing: -0.01em;
        }
        .nav-logo-subtitle {
            font-size: 0.6875rem;
            color: var(--color-text-muted);
            font-weight: 600;
        }

        .nav-links {
            display: none;
            align-items: center;
            gap: 0.25rem;
            list-style: none;
        }
        @media (min-width: 1024px) {
            .nav-links { display: flex; }
        }

        .nav-link {
            display: inline-flex;
            align-items: center;
            padding: 0.4375rem 0.875rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--color-text-secondary);
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            white-space: nowrap;
        }
        .nav-link:hover {
            color: var(--color-primary);
            background: rgba(30,58,95,0.06);
        }
        .nav-link.active {
            color: var(--color-primary);
            background: linear-gradient(135deg, rgba(30,58,95,0.08) 0%, rgba(37,99,235,0.12) 100%);
            font-weight: 700;
            box-shadow: inset 0 0 0 1.5px rgba(30,58,95,0.15);
        }

        .nav-cta {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            flex-shrink: 0;
        }

        .nav-emergency {
            display: none;
            align-items: center;
            gap: 0.4rem;
            padding: 0.4375rem 0.875rem;
            background: rgba(220,38,38,0.08);
            color: var(--color-danger);
            border: 1px solid rgba(220,38,38,0.2);
            border-radius: 9999px;
            font-size: 0.8125rem;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s;
        }
        .nav-emergency:hover { background: rgba(220,38,38,0.15); color: var(--color-danger); }
        @media (min-width: 640px) { .nav-emergency { display: inline-flex; } }

        .hamburger {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            width: 44px;
            height: 44px;
            padding: 0;
            background: transparent;
            border: none;
            border-radius: 9999px;
            cursor: pointer;
            transition: background 0.2s;
        }
        .hamburger:hover { background: rgba(30,58,95,0.06); }
        @media (min-width: 1024px) { .hamburger { display: none; } }

        .hamburger span {
            display: block;
            width: 20px;
            height: 2px;
            background: var(--color-primary);
            border-radius: 2px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            margin: 2px 0;
        }
        .hamburger.open span:nth-child(1) { transform: translateY(6px) rotate(45deg); }
        .hamburger.open span:nth-child(2) { opacity: 0; transform: scaleX(0); }
        .hamburger.open span:nth-child(3) { transform: translateY(-6px) rotate(-45deg); }

        /* Mobile Navigation Overlay Drawer */
        .mobile-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.4);
            backdrop-filter: blur(4px);
            z-index: 998;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
        .mobile-overlay.open {
            opacity: 1;
            pointer-events: auto;
        }

        .mobile-drawer {
            position: fixed;
            top: 0;
            right: 0;
            bottom: 0;
            width: 100%;
            max-width: 340px;
            background: #ffffff;
            z-index: 999;
            box-shadow: -10px 0 40px rgba(15, 23, 42, 0.15);
            display: flex;
            flex-direction: column;
            transform: translateX(100%);
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .mobile-drawer.open {
            transform: translateX(0);
        }

        .mobile-drawer-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--color-border);
        }
        .mobile-drawer-body {
            flex: 1;
            overflow-y: auto;
            padding: 1.25rem 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 0.375rem;
        }
        .mobile-drawer-footer {
            padding: 1.25rem 1.5rem;
            border-top: 1px solid var(--color-border);
            background: #f8fafc;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .mobile-nav-item {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            padding: 0.875rem 1rem;
            color: var(--color-text-primary);
            text-decoration: none;
            font-size: 0.9375rem;
            font-weight: 600;
            border-radius: var(--radius-md);
            transition: all 0.2s;
            min-height: 48px;
        }
        .mobile-nav-item:hover, .mobile-nav-item.active {
            background: rgba(30,58,95,0.06);
            color: var(--color-primary);
        }
        .mobile-nav-item.active {
            background: linear-gradient(135deg, rgba(30,58,95,0.08) 0%, rgba(37,99,235,0.12) 100%);
            border-left: 3px solid var(--color-primary);
        }

        /* ─── Breadcrumb & Page Hero ─── */
        .breadcrumb {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.375rem;
            font-size: 0.8125rem;
            color: var(--color-text-muted);
        }
        .breadcrumb a { color: var(--color-text-secondary); text-decoration: none; transition: color 0.2s; }
        .breadcrumb a:hover { color: var(--color-primary); }
        .breadcrumb-sep { color: var(--color-border); }

        .page-hero {
            padding-top: 7.5rem;
            padding-bottom: 3.5rem;
            background: radial-gradient(circle at 50% 0%, rgba(37,99,235,0.08) 0%, rgba(240,244,255,0.7) 45%, #f8fafc 100%);
            border-bottom: 1px solid var(--color-border);
            position: relative;
            overflow: hidden;
        }
        @media (min-width: 768px) {
            .page-hero { padding-top: 8.5rem; padding-bottom: 4.5rem; }
        }

        /* ─── Footer ─── */
        .footer {
            background: var(--color-primary);
            color: rgba(255,255,255,0.75);
        }
        .footer-main { padding: 4rem 0 3rem; }
        .footer-brand-name { font-size: 1.125rem; font-weight: 800; color: #fff; }
        .footer-desc { font-size: 0.875rem; line-height: 1.7; margin-top: 0.75rem; }
        .footer-heading { font-size: 0.75rem; font-weight: 700; color: #fff; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 1rem; }
        .footer-link { display: block; font-size: 0.875rem; color: rgba(255,255,255,0.7); text-decoration: none; padding: 0.25rem 0; transition: color 0.2s; }
        .footer-link:hover { color: #fff; }
        .footer-divider { border: none; border-top: 1px solid rgba(255,255,255,0.12); margin: 0; }
        .footer-bottom { padding: 1.5rem 0; font-size: 0.8125rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.75rem; }
        .footer-accreditation-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255,255,255,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            padding: 0.375rem 0.75rem;
            border-radius: var(--radius-sm);
            font-size: 0.75rem;
            font-weight: 600;
            color: rgba(255,255,255,0.85);
        }

        .text-gradient {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 50%, var(--color-accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.4; transform: scale(0.9); }
        }
        .animate-pulse-dot { animation: pulse-dot 2s ease-in-out infinite; }
    </style>

    @stack('head')
</head>
<body class="bg-slate-50 text-slate-900 antialiased selection:bg-cyan-500 selection:text-white">
    {{-- Skip Navigation --}}
    <a href="#main-content" class="skip-link">Lewati ke konten utama</a>

    {{-- ═══════════════════════════════════════════════════════════════
         NAVBAR (Dynamic Island Glassmorphism)
    ═══════════════════════════════════════════════════════════════ --}}
    <div class="navbar-wrapper">
        <header class="navbar" id="navbar" role="banner">
            <div class="navbar-inner">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="nav-logo" aria-label="RSU Rajawali Citra — Beranda">
                    <div class="nav-logo-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="#fff" class="w-6 h-6" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                        </svg>
                    </div>
                    <div>
                        <div class="nav-logo-title">RSU Rajawali Citra</div>
                        <div class="nav-logo-subtitle">Bantul, DI Yogyakarta</div>
                    </div>
                </a>

                {{-- Desktop Navigation --}}
                <nav aria-label="Navigasi Utama">
                    <ul class="nav-links" role="list">
                        <li>
                            <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">
                                Tentang Kami
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('services') }}" class="nav-link {{ request()->routeIs('services*') ? 'active' : '' }}">
                                Layanan
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('doctors') }}" class="nav-link {{ request()->routeIs('doctors*') ? 'active' : '' }}">
                                Dokter & Jadwal
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('information') }}" class="nav-link {{ request()->routeIs('information*') || request()->routeIs('news*') || request()->routeIs('articles*') || request()->routeIs('faq') ? 'active' : '' }}">
                                Informasi
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">
                                Kontak
                            </a>
                        </li>
                    </ul>
                </nav>

                {{-- Desktop CTA & Hamburger --}}
                <div class="nav-cta">
                    <a href="tel:+62274123456" class="nav-emergency" aria-label="Hubungi IGD 24 Jam">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                        </svg>
                        <span>IGD 24 Jam</span>
                    </a>

                    <a href="{{ route('contact') }}#appointment" class="btn btn-primary btn-sm hidden sm:inline-flex">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                        </svg>
                        <span>Buat Janji</span>
                    </a>

                    @auth
                        <a href="{{ route('dashboard') }}" class="btn btn-outline btn-sm hidden md:inline-flex">Dashboard</a>
                    @endauth

                    <button class="hamburger" id="hamburgerBtn" aria-label="Buka menu navigasi" aria-expanded="false" aria-controls="mobileDrawer">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>
        </header>
    </div>

    {{-- Mobile Menu Backdrop & Drawer --}}
    <div class="mobile-overlay" id="mobileOverlay"></div>
    <aside class="mobile-drawer" id="mobileDrawer" aria-label="Menu Mobile" role="dialog" aria-modal="true">
        <div class="mobile-drawer-header">
            <div class="flex items-center gap-2.5">
                <div class="w-9 h-9 rounded-xl bg-blue-900 flex items-center justify-center text-white font-bold">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="#fff" class="w-5 h-5" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                </div>
                <div>
                    <div class="text-sm font-extrabold text-slate-900 leading-tight">RSU Rajawali Citra</div>
                    <div class="text-[11px] text-slate-500 font-medium">Menu Navigasi</div>
                </div>
            </div>
            <button id="closeDrawerBtn" class="w-9 h-9 flex items-center justify-center rounded-full text-slate-500 hover:text-slate-800 hover:bg-slate-100 transition" aria-label="Tutup menu">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div class="mobile-drawer-body">
            <a href="{{ route('home') }}" class="mobile-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" class="w-5 h-5 text-blue-900" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                Beranda
            </a>
            <a href="{{ route('about') }}" class="mobile-nav-item {{ request()->routeIs('about') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" class="w-5 h-5 text-blue-900" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z"/></svg>
                Tentang Kami
            </a>
            <a href="{{ route('services') }}" class="mobile-nav-item {{ request()->routeIs('services*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" class="w-5 h-5 text-blue-900" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>
                Layanan Kesehatan
            </a>
            <a href="{{ route('doctors') }}" class="mobile-nav-item {{ request()->routeIs('doctors*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" class="w-5 h-5 text-blue-900" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Dokter & Jadwal Praktik
            </a>
            <a href="{{ route('information') }}" class="mobile-nav-item {{ request()->routeIs('information*') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" class="w-5 h-5 text-blue-900" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/></svg>
                Informasi & Berita
            </a>
            <a href="{{ route('contact') }}" class="mobile-nav-item {{ request()->routeIs('contact') ? 'active' : '' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" class="w-5 h-5 text-blue-900" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                Kontak & Lokasi
            </a>
        </div>

        <div class="mobile-drawer-footer">
            <a href="tel:+62274123456" class="btn btn-primary btn-lg w-full bg-red-600 hover:bg-red-700 border-red-600 shadow-md flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                </svg>
                <span>Hubungi IGD 24 Jam</span>
            </a>
            <a href="{{ route('contact') }}#appointment" class="btn btn-outline btn-lg w-full flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                </svg>
                <span>Buat Janji Temu</span>
            </a>
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-accent btn-lg w-full text-center">
                    Dashboard SIMRS
                </a>
            @endauth
        </div>
    </aside>

    {{-- Main Content --}}
    <main id="main-content" tabindex="-1">
        @yield('content')
    </main>

    {{-- ═══════════════════════════════════════════════════════════════
         FOOTER
    ═══════════════════════════════════════════════════════════════ --}}
    <footer class="footer" role="contentinfo">
        <div class="footer-main">
            <div class="container-xl">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-12 mb-12">
                    {{-- Brand --}}
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-white/15 rounded-xl flex items-center justify-center shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="#fff" class="w-6 h-6" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                                </svg>
                            </div>
                            <span class="footer-brand-name">RSU Rajawali Citra</span>
                        </div>
                        <p class="footer-desc">Rumah Sakit Umum yang berdedikasi memberikan pelayanan kesehatan berkualitas, profesional, dan terpercaya untuk masyarakat Bantul dan Yogyakarta.</p>
                        <div class="flex flex-wrap gap-2 mt-5">
                            <span class="footer-accreditation-badge">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"/></svg>
                                Terakreditasi KARS
                            </span>
                            <span class="footer-accreditation-badge">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-3.5 h-3.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                                RS Tipe B
                            </span>
                        </div>
                    </div>

                    {{-- Menu Cepat --}}
                    <div>
                        <h3 class="footer-heading">Menu Cepat</h3>
                        <nav aria-label="Footer Navigation">
                            <a href="{{ route('home') }}" class="footer-link">Beranda Utama</a>
                            <a href="{{ route('about') }}" class="footer-link">Tentang Kami</a>
                            <a href="{{ route('services') }}" class="footer-link">Layanan Kesehatan</a>
                            <a href="{{ route('doctors') }}" class="footer-link">Dokter & Jadwal</a>
                            <a href="{{ route('information') }}" class="footer-link">Informasi & Berita</a>
                            <a href="{{ route('contact') }}" class="footer-link">Kontak & Lokasi</a>
                        </nav>
                    </div>

                    {{-- Layanan Utama --}}
                    <div>
                        <h3 class="footer-heading">Layanan Utama</h3>
                        <nav aria-label="Layanan Navigation">
                            <a href="{{ route('services.detail', 'instalasi-gawat-darurat') }}" class="footer-link">IGD 24 Jam</a>
                            <a href="{{ route('services.detail', 'rawat-jalan-poliklinik') }}" class="footer-link">Poliklinik Spesialis</a>
                            <a href="{{ route('services.detail', 'rawat-inap') }}" class="footer-link">Rawat Inap</a>
                            <a href="{{ route('services.detail', 'laboratorium-klinik') }}" class="footer-link">Laboratorium</a>
                            <a href="{{ route('services.detail', 'radiologi-imaging') }}" class="footer-link">Radiologi & Imaging</a>
                            <a href="{{ route('services.detail', 'medical-check-up') }}" class="footer-link">Medical Check-Up</a>
                        </nav>
                    </div>

                    {{-- Kontak --}}
                    <div>
                        <h3 class="footer-heading">Hubungi Kami</h3>
                        <div class="flex flex-col gap-3 text-xs text-white/80">
                            <div class="flex items-start gap-2.5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" class="w-4 h-4 shrink-0 mt-0.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                                <span>Jl. Pleret No. KM 2.5, Banjardadap, Potorono, Banguntapan, Bantul, DIY 55196</span>
                            </div>
                            <a href="tel:+62274123456" class="flex items-center gap-2.5 footer-link">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" class="w-4 h-4 shrink-0" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                                <span>+62 274-123-456</span>
                            </a>
                            <a href="https://wa.me/628213431353" target="_blank" rel="noopener" class="flex items-center gap-2.5 footer-link">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" class="w-4 h-4 shrink-0" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 01.778-.332 48.294 48.294 0 005.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>
                                <span>WhatsApp: 0821-3431-3535</span>
                            </a>
                            <a href="mailto:info@rsurajawalicitra.co.id" class="flex items-center gap-2.5 footer-link">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" class="w-4 h-4 shrink-0" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                                <span>info@rsurajawalicitra.co.id</span>
                            </a>
                        </div>
                    </div>
                </div>

                <hr class="footer-divider">

                <div class="footer-bottom">
                    <p>&copy; {{ date('Y') }} RSU Rajawali Citra. Hak Cipta Dilindungi Undang-Undang.</p>
                    <div class="flex items-center gap-6 flex-wrap">
                        <a href="{{ route('faq') }}" class="footer-link py-0">FAQ & Bantuan</a>
                        <a href="{{ route('contact') }}" class="footer-link py-0">Lokasi & Kontak</a>
                        @auth
                            <a href="{{ route('dashboard') }}" class="footer-link py-0">Portal SIMRS</a>
                        @else
                            <a href="{{ route('login') }}" class="footer-link py-0">Login Staf</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </footer>

    {{-- ═══════════════════════════════════════════════════════════════
         SCRIPTS
    ═══════════════════════════════════════════════════════════════ --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') { lucide.createIcons(); }

            // Navbar scroll effect
            const navbar = document.getElementById('navbar');
            if (navbar) {
                window.addEventListener('scroll', function() {
                    if (window.scrollY > 40) {
                        navbar.classList.add('scrolled');
                    } else {
                        navbar.classList.remove('scrolled');
                    }
                }, { passive: true });
            }

            // Mobile menu drawer toggle
            const hamburgerBtn  = document.getElementById('hamburgerBtn');
            const closeDrawerBtn= document.getElementById('closeDrawerBtn');
            const mobileOverlay = document.getElementById('mobileOverlay');
            const mobileDrawer  = document.getElementById('mobileDrawer');

            function openMenu() {
                if (!mobileDrawer) return;
                hamburgerBtn.classList.add('open');
                hamburgerBtn.setAttribute('aria-expanded', 'true');
                mobileOverlay.classList.add('open');
                mobileDrawer.classList.add('open');
                document.body.style.overflow = 'hidden';
            }

            function closeMenu() {
                if (!mobileDrawer) return;
                hamburgerBtn.classList.remove('open');
                hamburgerBtn.setAttribute('aria-expanded', 'false');
                mobileOverlay.classList.remove('open');
                mobileDrawer.classList.remove('open');
                document.body.style.overflow = '';
            }

            if (hamburgerBtn) {
                hamburgerBtn.addEventListener('click', function() {
                    if (mobileDrawer.classList.contains('open')) {
                        closeMenu();
                    } else {
                        openMenu();
                    }
                });
            }

            if (closeDrawerBtn) closeDrawerBtn.addEventListener('click', closeMenu);
            if (mobileOverlay) mobileOverlay.addEventListener('click', closeMenu);

            // Close menu on link click inside drawer
            if (mobileDrawer) {
                mobileDrawer.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', closeMenu);
                });
            }

            // Close on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && mobileDrawer && mobileDrawer.classList.contains('open')) {
                    closeMenu();
                    hamburgerBtn.focus();
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
