<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

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

    {{-- Fonts: Inter (Readable, Professional) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    {{-- Icons --}}
    <script src="https://unpkg.com/lucide@latest" defer></script>

    {{-- Vite / CSS --}}
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    {{-- Design Tokens & Global Styles --}}
    <style>
        :root {
            /* ─── Color Tokens ─── */
            --color-primary:       #1e3a5f;   /* Deep Navy */
            --color-primary-dark:  #152d4a;
            --color-primary-light: #2563eb;   /* Healthcare Blue */
            --color-accent:        #0891b2;   /* Teal */
            --color-accent-light:  #06b6d4;
            --color-success:       #16a34a;
            --color-warning:       #d97706;
            --color-danger:        #dc2626;
            --color-bg:            #f8fafc;   /* Soft White */
            --color-surface:       #ffffff;
            --color-border:        #e2e8f0;
            --color-text-primary:  #0f172a;
            --color-text-secondary:#475569;
            --color-text-muted:    #94a3b8;

            /* ─── Typography ─── */
            --font-sans:    'Inter', ui-sans-serif, system-ui, -apple-system, sans-serif;
            --font-display: 'Playfair Display', Georgia, serif;

            /* ─── Spacing ─── */
            --section-py: 5rem;

            /* ─── Border Radius ─── */
            --radius-sm:  0.375rem;
            --radius-md:  0.75rem;
            --radius-lg:  1.25rem;
            --radius-xl:  2rem;

            /* ─── Shadows ─── */
            --shadow-sm:  0 1px 3px rgba(0,0,0,.06), 0 1px 2px rgba(0,0,0,.04);
            --shadow-md:  0 4px 16px rgba(0,0,0,.08), 0 2px 4px rgba(0,0,0,.05);
            --shadow-lg:  0 10px 40px rgba(0,0,0,.1), 0 4px 8px rgba(0,0,0,.06);
            --shadow-xl:  0 20px 60px rgba(0,0,0,.12), 0 8px 16px rgba(0,0,0,.08);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        body {
            font-family: var(--font-sans);
            color: var(--color-text-primary);
            background-color: var(--color-bg);
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* ─── Skip link for accessibility ─── */
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
        }

        /* ─── Focus visible ─── */
        :focus-visible {
            outline: 2px solid var(--color-accent);
            outline-offset: 2px;
            border-radius: 2px;
        }

        /* ─── Typography Scale ─── */
        .display { font-family: var(--font-display); font-size: clamp(2.5rem, 5vw, 4rem); font-weight: 700; line-height: 1.15; }
        .h1 { font-size: clamp(2rem, 4vw, 3rem); font-weight: 800; line-height: 1.2; }
        .h2 { font-size: clamp(1.5rem, 3vw, 2.25rem); font-weight: 700; line-height: 1.25; }
        .h3 { font-size: clamp(1.125rem, 2vw, 1.5rem); font-weight: 700; line-height: 1.3; }
        .h4 { font-size: 1.125rem; font-weight: 600; line-height: 1.4; }
        .body-lg { font-size: 1.0625rem; line-height: 1.7; }
        .body { font-size: 0.9375rem; line-height: 1.7; }
        .body-sm { font-size: 0.875rem; line-height: 1.65; }
        .caption { font-size: 0.8125rem; line-height: 1.5; }
        .label { font-size: 0.75rem; font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; }

        /* ─── Buttons ─── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.75rem;
            border-radius: var(--radius-md);
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
            border: 2px solid transparent;
            white-space: nowrap;
        }
        .btn-primary {
            background: var(--color-primary);
            color: #fff;
            box-shadow: 0 4px 15px rgba(30,58,95,.3);
        }
        .btn-primary:hover {
            background: var(--color-primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(30,58,95,.4);
            color: #fff;
        }
        .btn-accent {
            background: var(--color-accent);
            color: #fff;
            box-shadow: 0 4px 15px rgba(8,145,178,.3);
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
            border-color: rgba(255,255,255,.7);
        }
        .btn-outline-white:hover {
            background: rgba(255,255,255,.15);
            color: #fff;
        }
        .btn-lg { padding: 1rem 2.25rem; font-size: 1rem; }
        .btn-sm { padding: 0.5rem 1.25rem; font-size: 0.8125rem; }

        /* ─── Cards ─── */
        .card {
            background: var(--color-surface);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .card:hover { transform: translateY(-3px); box-shadow: var(--shadow-lg); }

        /* ─── Section Styles ─── */
        .section { padding: var(--section-py) 0; }
        .section-alt { background-color: #f0f4ff; }
        .section-dark { background: var(--color-primary); color: #fff; }
        .container-xl { max-width: 1200px; margin: 0 auto; padding: 0 1.5rem; }
        @media (min-width: 640px) { .container-xl { padding: 0 2rem; } }
        @media (min-width: 1024px) { .container-xl { padding: 0 2.5rem; } }

        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.375rem 1rem;
            background: rgba(8,145,178,.1);
            color: var(--color-accent);
            border-radius: 100px;
            font-size: 0.75rem;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }
        .section-label.primary {
            background: rgba(30,58,95,.08);
            color: var(--color-primary);
        }
        .section-title {
            font-size: clamp(1.5rem, 3vw, 2.25rem);
            font-weight: 800;
            color: var(--color-text-primary);
            line-height: 1.25;
            margin-bottom: 1rem;
        }
        .section-subtitle {
            font-size: 1rem;
            color: var(--color-text-secondary);
            max-width: 600px;
            line-height: 1.7;
        }

        /* ─── Badge ─── */
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
        .badge-pink   { background: #fdf2f8; color: #be185d; }

        /* ─── Dynamic Island Navbar ─── */
        .navbar {
            position: fixed;
            top: 1rem;
            left: 50%;
            transform: translateX(-50%);
            width: calc(100% - 2.5rem);
            max-width: 1140px;
            z-index: 1000;
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(226, 232, 240, 0.85);
            border-radius: 9999px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .navbar.scrolled {
            background: rgba(255, 255, 255, 0.96);
            border-color: rgba(30, 58, 95, 0.15);
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.12);
        }
        .navbar-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 68px;
            padding: 0 1.25rem 0 1.5rem;
        }
        .nav-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
            flex-shrink: 0;
        }
        .nav-logo-icon {
            width: 48px;
            height: 48px;
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .nav-logo-icon svg { width: 26px; height: 26px; stroke: #fff; }
        .nav-links {
            display: flex;
            align-items: center;
            gap: 0.375rem;
            list-style: none;
        }
        .nav-link {
            display: inline-flex;
            align-items: center;
            gap: 0.375rem;
            padding: 0.5rem 1rem;
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
            background: rgba(30,58,95,.06);
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
            gap: 0.75rem;
            flex-shrink: 0;
        }
        .nav-emergency {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            background: rgba(220,38,38,.08);
            color: var(--color-danger);
            border-radius: var(--radius-sm);
            font-size: 0.8125rem;
            font-weight: 700;
            text-decoration: none;
            transition: background 0.2s;
        }
        .nav-emergency:hover { background: rgba(220,38,38,.15); color: var(--color-danger); }
        .nav-emergency svg { width: 16px; height: 16px; }

        /* Hamburger */
        .hamburger {
            display: none;
            flex-direction: column;
            gap: 5px;
            cursor: pointer;
            padding: 0.5rem;
            background: none;
            border: none;
            border-radius: var(--radius-sm);
        }
        .hamburger span {
            display: block;
            width: 22px;
            height: 2px;
            background: var(--color-primary);
            border-radius: 2px;
            transition: all 0.3s ease;
        }
        .hamburger.open span:nth-child(1) { transform: translateY(7px) rotate(45deg); }
        .hamburger.open span:nth-child(2) { opacity: 0; }
        .hamburger.open span:nth-child(3) { transform: translateY(-7px) rotate(-45deg); }

        /* Mobile Menu */
        .mobile-menu {
            display: none;
            position: fixed;
            top: 72px;
            left: 0;
            right: 0;
            bottom: 0;
            background: #fff;
            z-index: 999;
            overflow-y: auto;
            padding: 1.5rem;
            transform: translateX(-100%);
            transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .mobile-menu.open {
            display: block;
            transform: translateX(0);
        }
        .mobile-nav-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 1rem;
            color: var(--color-text-primary);
            text-decoration: none;
            font-size: 1.0625rem;
            font-weight: 500;
            border-radius: var(--radius-md);
            transition: background 0.2s;
        }
        .mobile-nav-link:hover, .mobile-nav-link.active {
            background: rgba(30,58,95,.06);
            color: var(--color-primary);
        }
        .mobile-nav-link svg { width: 20px; height: 20px; flex-shrink: 0; }
        .mobile-nav-divider {
            height: 1px;
            background: var(--color-border);
            margin: 0.75rem 0;
        }
        .mobile-nav-actions {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            padding-top: 1rem;
        }

        /* ─── Footer ─── */
        .footer {
            background: var(--color-primary);
            color: rgba(255,255,255,.75);
        }
        .footer-main { padding: 4rem 0 3rem; }
        .footer-brand-name { font-size: 1.125rem; font-weight: 800; color: #fff; }
        .footer-desc { font-size: 0.875rem; line-height: 1.7; margin-top: 0.75rem; }
        .footer-heading { font-size: 0.75rem; font-weight: 700; color: #fff; text-transform: uppercase; letter-spacing: 0.08em; margin-bottom: 1rem; }
        .footer-link { display: block; font-size: 0.875rem; color: rgba(255,255,255,.65); text-decoration: none; padding: 0.25rem 0; transition: color 0.2s; }
        .footer-link:hover { color: #fff; }
        .footer-divider { border: none; border-top: 1px solid rgba(255,255,255,.1); }
        .footer-bottom { padding: 1.5rem 0; font-size: 0.8125rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 0.5rem; }
        .footer-accreditation-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255,255,255,.1);
            border: 1px solid rgba(255,255,255,.2);
            padding: 0.375rem 0.75rem;
            border-radius: var(--radius-sm);
            font-size: 0.75rem;
            font-weight: 600;
            color: rgba(255,255,255,.85);
        }

        /* ─── Emergency Bar ─── */
        .emergency-bar {
            background: var(--color-danger);
            color: #fff;
            text-align: center;
            padding: 0.375rem 1rem;
            font-size: 0.8125rem;
            font-weight: 600;
        }
        .emergency-bar a { color: #fff; }

        /* ─── Breadcrumb ─── */
        .breadcrumb {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 0.375rem;
            font-size: 0.8125rem;
            color: var(--color-text-muted);
        }
        .breadcrumb a { color: var(--color-text-secondary); text-decoration: none; }
        .breadcrumb a:hover { color: var(--color-primary); }
        .breadcrumb-sep { color: var(--color-border); }

        /* ─── Page Hero ─── */
        .page-hero {
            padding: 8rem 0 4rem;
            background: radial-gradient(circle at 50% 0%, rgba(37,99,235,0.08) 0%, rgba(240,244,255,0.7) 45%, #f8fafc 100%);
            border-bottom: 1px solid var(--color-border);
            position: relative;
            overflow: hidden;
        }
        .page-hero::before {
            content: '';
            position: absolute;
            top: -20%;
            right: -10%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(8,145,178,0.06) 0%, transparent 70%);
            pointer-events: none;
        }

        /* ─── Animations ─── */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; }
            50%       { opacity: 0.4; }
        }
        .animate-fade-in-up { animation: fadeInUp 0.6s ease forwards; }
        .animate-pulse-dot  { animation: pulse-dot 2s ease-in-out infinite; }

        /* ─── Responsive ─── */
        @media (max-width: 1023px) {
            .nav-links, .nav-cta .btn { display: none; }
            .hamburger { display: flex; }
            .nav-emergency { display: none; }
        }
        @media (min-width: 1024px) {
            .hamburger, .mobile-menu { display: none !important; }
        }

        /* Utility */
        .text-gradient {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 50%, var(--color-accent) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .divider { border: none; border-top: 1px solid var(--color-border); margin: 0; }
        img { max-width: 100%; height: auto; }
        a { color: inherit; }
    </style>

    {{-- Additional head content --}}
    @stack('head')
</head>
<body>
    {{-- Skip Navigation --}}
    <a href="#main-content" class="skip-link">Lewati ke konten utama</a>

    {{-- ═══════════════════════════════════════════════════════════════
         NAVBAR (Dynamic Island Glassmorphism)
    ═══════════════════════════════════════════════════════════════ --}}
    <header class="navbar" id="navbar" role="banner">
        <div class="navbar-inner">
            {{-- Logo --}}
            <a href="{{ route('home') }}" class="nav-logo" aria-label="RSU Rajawali Citra — Beranda">
                <img src="{{ asset('logo.png') }}" alt="RSU Rajawali Citra" style="height:48px;width:auto;object-fit:contain;" onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                <div class="nav-logo-icon" style="display:none;" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                    </svg>
                </div>
            </a>

            {{-- Desktop Navigation --}}
            <nav aria-label="Navigasi Utama">
                <ul class="nav-links" role="list">
                    <li>
                        <a href="{{ route('about') }}"
                           class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">
                            Tentang Kami
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('services') }}"
                           class="nav-link {{ request()->routeIs('services*') ? 'active' : '' }}">
                            Layanan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('doctors') }}"
                           class="nav-link {{ request()->routeIs('doctors*') ? 'active' : '' }}">
                            Dokter & Jadwal
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('information') }}"
                           class="nav-link {{ request()->routeIs('information*') || request()->routeIs('news*') || request()->routeIs('articles*') || request()->routeIs('faq') ? 'active' : '' }}">
                            Informasi
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}"
                           class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">
                            Kontak
                        </a>
                    </li>
                </ul>
            </nav>

            {{-- Desktop CTA --}}
            <div class="nav-cta">
                <a href="tel:+62274123456" class="nav-emergency" aria-label="Hubungi IGD 24 Jam">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                    </svg>
                    IGD 24 Jam
                </a>
                <a href="{{ route('contact') }}#appointment" class="btn btn-primary btn-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="16" height="16" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                    </svg>
                    Buat Janji
                </a>
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-outline btn-sm">Dashboard</a>
                @endauth
            </div>

            {{-- Hamburger --}}
            <button class="hamburger" id="hamburgerBtn" aria-label="Buka menu" aria-expanded="false" aria-controls="mobileMenu">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </header>

    {{-- Mobile Menu --}}
    <nav class="mobile-menu" id="mobileMenu" aria-label="Navigasi Mobile" role="navigation">
        <a href="{{ route('home') }}" class="mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
            Beranda
        </a>
        <a href="{{ route('about') }}" class="mobile-nav-link {{ request()->routeIs('about') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z"/></svg>
            Tentang Kami
        </a>
        <a href="{{ route('services') }}" class="mobile-nav-link {{ request()->routeIs('services*') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"/></svg>
            Layanan
        </a>
        <a href="{{ route('doctors') }}" class="mobile-nav-link {{ request()->routeIs('doctors*') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Dokter & Jadwal
        </a>
        <a href="{{ route('information') }}" class="mobile-nav-link {{ request()->routeIs('information*') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 01-2.25 2.25M16.5 7.5V18a2.25 2.25 0 002.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 002.25 2.25h13.5M6 7.5h3v3H6v-3z"/></svg>
            Informasi
        </a>
        <a href="{{ route('contact') }}" class="mobile-nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
            Kontak
        </a>

        <div class="mobile-nav-divider"></div>

        <div class="mobile-nav-actions">
            <a href="tel:+62274123456" class="btn btn-primary btn-lg" style="justify-content:center;background:#dc2626">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="20" height="20" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/>
                </svg>
                Hubungi IGD Darurat
            </a>
            <a href="{{ route('contact') }}#appointment" class="btn btn-outline btn-lg" style="justify-content:center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="20" height="20" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/>
                </svg>
                Buat Janji Temu
            </a>
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-accent btn-lg" style="justify-content:center">
                    Dashboard SIMRS
                </a>
            @endauth
        </div>
    </nav>

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
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:3rem 2rem;margin-bottom:3rem;">
                    {{-- Brand --}}
                    <div>
                        <div style="display:flex;align-items:center;gap:.75rem;margin-bottom:1rem;">
                            <div style="width:40px;height:40px;background:rgba(255,255,255,.15);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="#fff" width="22" height="22" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
                                </svg>
                            </div>
                            <span class="footer-brand-name">RSU Rajawali Citra</span>
                        </div>
                        <p class="footer-desc">Rumah Sakit Umum yang berdedikasi memberikan pelayanan kesehatan berkualitas, profesional, dan terpercaya untuk masyarakat Bantul dan Yogyakarta.</p>
                        <div style="display:flex;flex-wrap:wrap;gap:.5rem;margin-top:1.25rem;">
                            <span class="footer-accreditation-badge">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="14" height="14" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z"/></svg>
                                Terakreditasi KARS
                            </span>
                            <span class="footer-accreditation-badge">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" width="14" height="14" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/></svg>
                                RS Tipe B
                            </span>
                        </div>
                    </div>

                    {{-- Menu Cepat --}}
                    <div>
                        <h3 class="footer-heading">Menu Cepat</h3>
                        <nav aria-label="Footer navigation">
                            <a href="{{ route('home') }}" class="footer-link">Beranda</a>
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
                        <a href="{{ route('services.detail', 'instalasi-gawat-darurat') }}" class="footer-link">IGD 24 Jam</a>
                        <a href="{{ route('services.detail', 'rawat-jalan-poliklinik') }}" class="footer-link">Poliklinik Spesialis</a>
                        <a href="{{ route('services.detail', 'rawat-inap') }}" class="footer-link">Rawat Inap</a>
                        <a href="{{ route('services.detail', 'laboratorium-klinik') }}" class="footer-link">Laboratorium</a>
                        <a href="{{ route('services.detail', 'radiologi-imaging') }}" class="footer-link">Radiologi & Imaging</a>
                        <a href="{{ route('services.detail', 'medical-check-up') }}" class="footer-link">Medical Check-Up</a>
                    </div>

                    {{-- Kontak --}}
                    <div>
                        <h3 class="footer-heading">Hubungi Kami</h3>
                        <div style="display:flex;flex-direction:column;gap:.6rem;">
                            <div style="display:flex;align-items:flex-start;gap:.5rem;font-size:.875rem;color:rgba(255,255,255,.7);">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" width="16" height="16" style="flex-shrink:0;margin-top:2px;" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                                <span>Jl. Pleret No. KM 2.5, Banjardadap, Potorono, Banguntapan, Bantul, DIY 55196</span>
                            </div>
                            <a href="tel:+62274123456" style="display:flex;align-items:center;gap:.5rem;font-size:.875rem;color:rgba(255,255,255,.7);text-decoration:none;" class="footer-link">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" width="16" height="16" flex-shrink:0 aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z"/></svg>
                                +62 274-123-456
                            </a>
                            <a href="https://wa.me/628213431353" target="_blank" rel="noopener" style="display:flex;align-items:center;gap:.5rem;font-size:.875rem;color:rgba(255,255,255,.7);text-decoration:none;" class="footer-link">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" width="16" height="16" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 9.75a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375m-13.5 3.01c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.184-4.183a1.14 1.14 0 01.778-.332 48.294 48.294 0 005.83-.498c1.585-.233 2.708-1.626 2.708-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>
                                WhatsApp: 0821-3431-3535
                            </a>
                            <a href="mailto:info@rsurajawalicitra.co.id" style="display:flex;align-items:center;gap:.5rem;font-size:.875rem;color:rgba(255,255,255,.7);text-decoration:none;" class="footer-link">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor" width="16" height="16" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                                info@rsurajawalicitra.co.id
                            </a>
                        </div>
                    </div>
                </div>

                <hr class="footer-divider">

                <div class="footer-bottom">
                    <p>&copy; {{ date('Y') }} RSU Rajawali Citra. Hak Cipta Dilindungi Undang-Undang.</p>
                    <div style="display:flex;gap:1.5rem;flex-wrap:wrap;">
                        <a href="#" class="footer-link" style="padding:0">Kebijakan Privasi</a>
                        <a href="#" class="footer-link" style="padding:0">Syarat & Ketentuan</a>
                        @auth
                            <a href="{{ route('dashboard') }}" class="footer-link" style="padding:0">Portal SIMRS</a>
                        @else
                            <a href="{{ route('login') }}" class="footer-link" style="padding:0">Login Staf</a>
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
        // Init Lucide Icons
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof lucide !== 'undefined') { lucide.createIcons(); }

            // ── Navbar scroll effect
            const navbar = document.getElementById('navbar');
            let lastScroll = 0;
            window.addEventListener('scroll', function() {
                const currentScroll = window.scrollY;
                if (currentScroll > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
                lastScroll = currentScroll;
            }, { passive: true });

            // ── Mobile menu toggle
            const hamburgerBtn = document.getElementById('hamburgerBtn');
            const mobileMenu   = document.getElementById('mobileMenu');

            if (hamburgerBtn && mobileMenu) {
                hamburgerBtn.addEventListener('click', function() {
                    const isOpen = hamburgerBtn.classList.toggle('open');
                    hamburgerBtn.setAttribute('aria-expanded', isOpen);
                    hamburgerBtn.setAttribute('aria-label', isOpen ? 'Tutup menu' : 'Buka menu');
                    if (isOpen) {
                        mobileMenu.classList.add('open');
                        mobileMenu.style.display = 'block';
                        document.body.style.overflow = 'hidden';
                    } else {
                        mobileMenu.classList.remove('open');
                        setTimeout(() => { mobileMenu.style.display = ''; }, 350);
                        document.body.style.overflow = '';
                    }
                });

                // Close on mobile link click
                mobileMenu.querySelectorAll('a').forEach(link => {
                    link.addEventListener('click', () => {
                        hamburgerBtn.classList.remove('open');
                        hamburgerBtn.setAttribute('aria-expanded', 'false');
                        hamburgerBtn.setAttribute('aria-label', 'Buka menu');
                        mobileMenu.classList.remove('open');
                        setTimeout(() => { mobileMenu.style.display = ''; }, 350);
                        document.body.style.overflow = '';
                    });
                });

                // Close on Escape
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && hamburgerBtn.classList.contains('open')) {
                        hamburgerBtn.click();
                        hamburgerBtn.focus();
                    }
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
