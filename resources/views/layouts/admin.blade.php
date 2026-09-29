<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ config('simrs.seo.meta_description') }}">
    <meta name="author" content="{{ config('simrs.seo.meta_author') }}">
    <meta name="robots" content="{{ config('simrs.seo.meta_robots') }}">

    <title>@yield('title', 'Dashboard') | {{ config('simrs.app_title_suffix', 'SIMRS') }} - {{ config('simrs.hospital_name', 'RSU Rajawali Citra') }}</title>

    <!-- Favicon System -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <!-- Google Fonts Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS 4 Standalone & Vite -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- SweetAlert2 & Toastify -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Inter', sans-serif;
            --color-teal-50: #f0fdfa;
            --color-teal-500: #14b8a6;
            --color-teal-600: #0d9488;
            --color-teal-700: #0f766e;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>

    @stack('styles')
</head>
<body class="h-full font-sans text-slate-700 antialiased selection:bg-teal-500 selection:text-white">

    <div class="min-h-full flex">
        <!-- Sidebar Navigation Drawer -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-slate-400 flex flex-col transition-transform duration-300 ease-in-out -translate-x-full lg:translate-x-0 border-r border-slate-800">
            <!-- Brand Header -->
            <div class="h-16 flex items-center justify-between px-5 border-b border-slate-800/80 bg-slate-900/50">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 text-white text-decoration-none">
                    <img src="{{ asset('logo.png') }}" alt="Logo SIMRS Rajawali Citra" class="h-8 w-auto object-contain bg-white rounded-lg p-1 shadow-sm">
                    <span class="text-[10px] font-bold text-teal-400 block tracking-wider uppercase">Enterprise</span>
                </a>
                <button id="sidebarCloseBtn" class="lg:hidden text-slate-400 hover:text-white p-1 rounded-lg">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 overflow-y-auto px-3 py-4 space-y-6">
                <div>
                    <div class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Utama</div>
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('dashboard') ? 'bg-teal-600/20 text-teal-400 border-l-2 border-teal-500 font-semibold' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Dashboard
                    </a>
                </div>

                <div>
                    <div class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Pelayanan Medis</div>
                    <div class="space-y-1">
                        <a href="{{ route('registrations.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('registrations.*') ? 'bg-teal-600/20 text-teal-400 border-l-2 border-teal-500 font-semibold' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                            <i data-lucide="user-plus" class="w-4 h-4"></i> Pendaftaran Pasien
                        </a>
                        <a href="{{ route('outpatients.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('outpatients.*') ? 'bg-teal-600/20 text-teal-400 border-l-2 border-teal-500 font-semibold' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                            <i data-lucide="stethoscope" class="w-4 h-4"></i> Rawat Jalan (Poli)
                        </a>
                        <a href="{{ route('inpatients.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('inpatients.*') ? 'bg-teal-600/20 text-teal-400 border-l-2 border-teal-500 font-semibold' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                            <i data-lucide="bed" class="w-4 h-4"></i> Rawat Inap & Bed
                        </a>
                        <a href="{{ route('medical-records.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('medical-records.*') ? 'bg-teal-600/20 text-teal-400 border-l-2 border-teal-500 font-semibold' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                            <i data-lucide="folder-open" class="w-4 h-4"></i> Rekam Medis (EMR)
                        </a>
                    </div>
                </div>

                <div>
                    <div class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Penunjang & Farmasi</div>
                    <div class="space-y-1">
                        <a href="{{ route('pharmacy.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('pharmacy.*') ? 'bg-teal-600/20 text-teal-400 border-l-2 border-teal-500 font-semibold' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                            <i data-lucide="pill" class="w-4 h-4"></i> Farmasi & Obat
                        </a>
                        <a href="{{ route('laboratory.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('laboratory.*') ? 'bg-teal-600/20 text-teal-400 border-l-2 border-teal-500 font-semibold' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                            <i data-lucide="flask-conical" class="w-4 h-4"></i> Laboratorium
                        </a>
                        <a href="{{ route('warehouse.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('warehouse.*') ? 'bg-teal-600/20 text-teal-400 border-l-2 border-teal-500 font-semibold' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                            <i data-lucide="package-search" class="w-4 h-4"></i> Logistik & Gudang
                        </a>
                    </div>
                </div>

                <div>
                    <div class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Keuangan & Analitik</div>
                    <div class="space-y-1">
                        <a href="{{ route('billing.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('billing.*') ? 'bg-teal-600/20 text-teal-400 border-l-2 border-teal-500 font-semibold' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                            <i data-lucide="receipt" class="w-4 h-4"></i> Kasir & Billing
                        </a>
                        <a href="{{ route('reports.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('reports.*') ? 'bg-teal-600/20 text-teal-400 border-l-2 border-teal-500 font-semibold' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                            <i data-lucide="bar-chart-3" class="w-4 h-4"></i> Laporan & Analitik
                        </a>
                    </div>
                </div>

                <div>
                    <div class="px-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-2">Pengaturan & Reference</div>
                    <div class="space-y-1">
                        <a href="{{ route('master.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('master.*') ? 'bg-teal-600/20 text-teal-400 border-l-2 border-teal-500 font-semibold' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                            <i data-lucide="database" class="w-4 h-4"></i> Master Data
                        </a>
                        <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('users.*') || request()->routeIs('roles.*') || request()->routeIs('activities.*') ? 'bg-teal-600/20 text-teal-400 border-l-2 border-teal-500 font-semibold' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                            <i data-lucide="shield-check" class="w-4 h-4"></i> Manajemen User
                        </a>
                        <a href="{{ route('settings.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('settings.*') ? 'bg-teal-600/20 text-teal-400 border-l-2 border-teal-500 font-semibold' : 'text-slate-400 hover:bg-slate-800/60 hover:text-slate-200' }}">
                            <i data-lucide="settings" class="w-4 h-4"></i> Pengaturan RS
                        </a>
                    </div>
                </div>
            </nav>
        </aside>

        <!-- Overlay backdrop for mobile drawer -->
        <div id="sidebarOverlay" class="fixed inset-0 z-40 bg-slate-900/60 backdrop-blur-xs hidden lg:hidden"></div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col min-w-0 lg:pl-64">
            <!-- Sticky Topbar Header -->
            <header class="sticky top-0 z-30 h-16 bg-white/90 backdrop-blur-md border-b border-slate-200/80 px-4 sm:px-6 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <button id="sidebarToggleBtn" class="lg:hidden p-2 text-slate-500 hover:text-slate-700 hover:bg-slate-100 rounded-lg">
                        <i data-lucide="menu" class="w-5 h-5"></i>
                    </button>
                    <!-- Global Patient Search -->
                    <div class="hidden sm:flex items-center gap-2 bg-slate-100/80 border border-slate-200/80 rounded-full px-3.5 py-1.5 w-64 lg:w-80">
                        <i data-lucide="search" class="w-4 h-4 text-slate-400"></i>
                        <input type="text" placeholder="Cari No. RM / Nama Pasien..." class="bg-transparent border-none text-xs text-slate-700 placeholder-slate-400 focus:outline-none w-full">
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <div class="hidden md:block text-right">
                        <div class="text-xs font-semibold text-slate-800">{{ now()->locale('id')->translatedFormat('l, d F Y') }}</div>
                        <div class="text-[10px] font-medium text-teal-600 flex items-center justify-end gap-1"><i data-lucide="clock" class="w-3 h-3"></i> Asia/Jakarta (WIB)</div>
                    </div>

                    <!-- User Account Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button id="userMenuBtn" class="flex items-center gap-2.5 p-1.5 rounded-full hover:bg-slate-100 border border-slate-200/80 transition">
                            <div class="w-8 h-8 rounded-full bg-teal-600 text-white flex items-center justify-center font-bold text-xs shadow-xs">
                                {{ strtoupper(substr(auth()->user()->name ?? 'Administrator', 0, 1)) }}
                            </div>
                            <span class="hidden md:inline text-xs font-semibold text-slate-700 pr-1">{{ auth()->user()->name ?? 'Administrator' }}</span>
                            <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-400"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="userDropdown" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-slate-200 py-1 z-50">
                            <div class="px-4 py-2.5 border-b border-slate-100">
                                <p class="text-xs font-semibold text-slate-800">{{ auth()->user()->name ?? 'Super Admin' }}</p>
                                <p class="text-[10px] text-slate-500 truncate">{{ auth()->user()->email ?? 'admin@simrs.com' }}</p>
                            </div>
                            <a href="{{ route('users.profile') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                                <i data-lucide="user" class="w-4 h-4 text-slate-400"></i> Profil Akun
                            </a>
                            <a href="{{ route('settings.index') }}" class="flex items-center gap-2 px-4 py-2 text-xs text-slate-600 hover:bg-slate-50 hover:text-slate-900">
                                <i data-lucide="sliders" class="w-4 h-4 text-slate-400"></i> Pengaturan RS
                            </a>
                            <div class="border-t border-slate-100 my-1"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-xs text-rose-600 hover:bg-rose-50 font-medium">
                                    <i data-lucide="log-out" class="w-4 h-4 text-rose-500"></i> Keluar / Logout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Main Container -->
            <main class="flex-1 px-4 sm:px-6 lg:px-8 py-6 space-y-6 max-w-7xl mx-auto w-full">
                @if (session('success'))
                    <x-alert type="success">{{ session('success') }}</x-alert>
                @endif
                @if (session('error'))
                    <x-alert type="danger">{{ session('error') }}</x-alert>
                @endif
                @if (session('info'))
                    <x-alert type="info">{{ session('info') }}</x-alert>
                @endif

                @yield('content')
            </main>

            <!-- Minimalist Enterprise Footer -->
            <footer class="bg-white border-t border-slate-200/80 py-4 px-6 text-center text-xs text-slate-500">
                {{ config('simrs.copyright') }} — <strong>{{ config('simrs.hospital_name') }}</strong> {{ config('simrs.version') }}.
            </footer>
        </div>
    </div>

    <!-- Interactive Scripts & Lucide Icon Converter -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Lucide Icons
            lucide.createIcons();

            // Mobile Sidebar Drawer Toggle
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('sidebarToggleBtn');
            const closeBtn = document.getElementById('sidebarCloseBtn');
            const overlay = document.getElementById('sidebarOverlay');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            }

            if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
            if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
            if (overlay) overlay.addEventListener('click', closeSidebar);

            // User Dropdown Toggle
            const userMenuBtn = document.getElementById('userMenuBtn');
            const userDropdown = document.getElementById('userDropdown');

            if (userMenuBtn && userDropdown) {
                userMenuBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    userDropdown.classList.toggle('hidden');
                });
                document.addEventListener('click', () => {
                    userDropdown.classList.add('hidden');
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
