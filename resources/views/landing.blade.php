<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SIMRS Enterprise — Sistem Informasi Manajemen Rumah Sakit Terintegrasi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }
        .glass-header {
            background: rgba(15, 23, 42, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
        }
        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }
        .gradient-text {
            background: linear-gradient(135deg, #14b8a6 0%, #06b6d4 50%, #3b82f6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .gradient-bg-teal {
            background: linear-gradient(135deg, #0d9488 0%, #0284c7 100%);
        }
        .hero-pattern {
            background-color: #0f172a;
            background-image: radial-gradient(rgba(20, 184, 166, 0.15) 1px, transparent 1px);
            background-size: 24px 24px;
        }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 antialiased selection:bg-teal-500 selection:text-white">

    {{-- SECTION 1: GLASSMORPHISM STICKY NAVIGATION BAR --}}
    <header class="fixed top-0 inset-x-0 z-50 glass-header border-b border-slate-800/80 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <a href="{{ route('landing') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-2xl bg-teal-500/20 border border-teal-500/40 flex items-center justify-center text-teal-400 group-hover:scale-105 transition">
                    <i data-lucide="hospital" class="w-6 h-6"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="font-extrabold text-lg text-white tracking-tight">SIMRS <span class="text-teal-400">Enterprise</span></span>
                        <span class="px-2 py-0.5 text-[10px] font-bold bg-teal-500/20 text-teal-300 border border-teal-500/30 rounded-full font-mono">v4.2 PROD</span>
                    </div>
                    <span class="text-[11px] text-slate-400 block -mt-0.5">RSU Rajawali Citra</span>
                </div>
            </a>

            <nav class="hidden lg:flex items-center gap-8 text-xs font-semibold text-slate-300">
                <a href="#fitur" class="hover:text-teal-400 transition">Fitur Core</a>
                <a href="#modul" class="hover:text-teal-400 transition">13 Modul</a>
                <a href="#alur" class="hover:text-teal-400 transition">Alur Pelayanan</a>
                <a href="#integrasi" class="hover:text-teal-400 transition">SATUSEHAT & BPJS</a>
                <a href="#kalkulator" class="hover:text-teal-400 transition">Kalkulator ROI</a>
                <a href="#faq" class="hover:text-teal-400 transition">FAQ</a>
            </nav>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-teal-500 hover:bg-teal-400 text-slate-950 font-bold text-xs rounded-xl shadow-lg shadow-teal-500/20 transition hover:scale-105">
                        <i data-lucide="layout-dashboard" class="w-4 h-4"></i> Masuk Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-4 py-2 text-slate-300 hover:text-white text-xs font-semibold rounded-xl hover:bg-slate-800 transition">
                        <i data-lucide="log-in" class="w-4 h-4"></i> Sign In
                    </a>
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-teal-500 hover:bg-teal-400 text-slate-950 font-bold text-xs rounded-xl shadow-lg shadow-teal-500/20 transition hover:scale-105">
                        <i data-lucide="shield-check" class="w-4 h-4"></i> Akses SIMRS Now
                    </a>
                @endauth
            </div>
        </div>
    </header>

    {{-- SECTION 2: HERO SECTION (ENTERPRISE EXECUTIVE BANNER) --}}
    <section class="relative pt-32 pb-20 lg:pt-40 lg:pb-32 hero-pattern overflow-hidden">
        <div class="absolute -top-40 right-0 w-[600px] h-[600px] bg-teal-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-60 -left-40 w-[500px] h-[500px] bg-sky-500/10 rounded-full blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto space-y-6">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-slate-800/80 border border-teal-500/30 rounded-full text-xs font-semibold text-teal-300 shadow-xl backdrop-blur-md">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    <span>Standard Akreditasi STARKES & Integrasi Kemenkes SATUSEHAT</span>
                </div>

                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-white tracking-tight leading-tight">
                    Sistem Informasi Management <br class="hidden sm:inline">
                    <span class="gradient-text">Rumah Sakit Next-Gen</span>
                </h1>

                <p class="text-slate-400 text-sm sm:text-base leading-relaxed">
                    Platform SIMRS berbasis Enterprise Architecture 100% terintegrasi. Mengintegrasikan Pendaftaran, Rawat Jalan, Rawat Inap, EMR SOAP & ICD-10, Farmasi & E-Resep, Laboratorium LIS, Kasir Billing, Gudang Logistik, & Analitik BI Eksekutif.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 bg-teal-500 hover:bg-teal-400 text-slate-950 font-bold text-sm rounded-2xl shadow-xl shadow-teal-500/25 transition hover:scale-105">
                            <i data-lucide="play-circle" class="w-5 h-5"></i> Buka Aplikasi SIMRS
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 bg-teal-500 hover:bg-teal-400 text-slate-950 font-bold text-sm rounded-2xl shadow-xl shadow-teal-500/25 transition hover:scale-105">
                            <i data-lucide="lock" class="w-5 h-5"></i> Login System SIMRS
                        </a>
                    @endauth
                    <a href="#modul" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-7 py-4 glass-card hover:bg-slate-800/80 text-white font-semibold text-sm rounded-2xl border border-slate-700 transition">
                        <i data-lucide="grid" class="w-5 h-5 text-teal-400"></i> Jelajahi 13 Modul Core
                    </a>
                </div>

                {{-- Key Highlights Badges --}}
                <div class="pt-8 flex flex-wrap justify-center gap-6 text-xs font-semibold text-slate-400">
                    <div class="flex items-center gap-2">
                        <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400"></i> ISO 27001 Security Standard
                    </div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="zap" class="w-4 h-4 text-amber-400"></i> 0.18 Detik Server Response Time
                    </div>
                    <div class="flex items-center gap-2">
                        <i data-lucide="database" class="w-4 h-4 text-sky-400"></i> MySQL Transactional Integrity
                    </div>
                </div>
            </div>

            {{-- Interactive Hero Mockup Card --}}
            <div class="mt-14 relative max-w-5xl mx-auto">
                <div class="absolute -inset-1 bg-gradient-to-r from-teal-500 to-sky-500 rounded-3xl blur-xl opacity-30"></div>
                <div class="relative bg-slate-900 border border-slate-800 rounded-3xl p-4 sm:p-6 shadow-2xl overflow-hidden">
                    <div class="flex items-center justify-between border-b border-slate-800 pb-4 mb-4">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                            <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                            <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                            <span class="text-xs text-slate-500 font-mono ml-2">https://simrs.rsurajawalicitra.co.id/dashboard</span>
                        </div>
                        <span class="px-3 py-1 bg-teal-500/20 text-teal-300 rounded-full text-[10px] font-bold font-mono">LIVE PREVIEW</span>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-left">
                        <div class="bg-slate-950/80 p-4 rounded-2xl border border-slate-800">
                            <span class="text-xs text-slate-400 font-semibold block">Total Kunjungan Pasien</span>
                            <div class="flex items-baseline gap-2 mt-2">
                                <span class="text-2xl font-black text-white">1,482</span>
                                <span class="text-xs text-emerald-400 font-bold">+18.5%</span>
                            </div>
                            <span class="text-[10px] text-slate-500 block mt-1">Rawat Jalan & Rawat Inap</span>
                        </div>
                        <div class="bg-slate-950/80 p-4 rounded-2xl border border-slate-800">
                            <span class="text-xs text-slate-400 font-semibold block">Pendapatan Billing RS</span>
                            <div class="flex items-baseline gap-2 mt-2">
                                <span class="text-2xl font-black text-teal-400">Rp 482.5M</span>
                                <span class="text-xs text-emerald-400 font-bold">Lunas</span>
                            </div>
                            <span class="text-[10px] text-slate-500 block mt-1">Kasir & BPJS Bridging</span>
                        </div>
                        <div class="bg-slate-950/80 p-4 rounded-2xl border border-slate-800">
                            <span class="text-xs text-slate-400 font-semibold block">Ketersediaan Bed Rawat Inap</span>
                            <div class="flex items-baseline gap-2 mt-2">
                                <span class="text-2xl font-black text-sky-400">84 / 120</span>
                                <span class="text-xs text-amber-400 font-bold">70% BOR</span>
                            </div>
                            <span class="text-[10px] text-slate-500 block mt-1">Real-time Bed Allocation</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION 3: REAL-TIME LIVE STATS & METRICS GRID --}}
    <section class="py-12 bg-slate-900/60 border-y border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-5 gap-6 text-center">
                <div class="space-y-1">
                    <h3 class="text-3xl lg:text-4xl font-black text-white font-mono">15,000+</h3>
                    <p class="text-xs text-slate-400 font-medium">Pasien Terlayani / Bulan</p>
                </div>
                <div class="space-y-1">
                    <h3 class="text-3xl lg:text-4xl font-black text-teal-400 font-mono">100%</h3>
                    <p class="text-xs text-slate-400 font-medium">Paperless EMR SOAP</p>
                </div>
                <div class="space-y-1">
                    <h3 class="text-3xl lg:text-4xl font-black text-sky-400 font-mono">13</h3>
                    <p class="text-xs text-slate-400 font-medium">Modul Core SIMRS Ready</p>
                </div>
                <div class="space-y-1">
                    <h3 class="text-3xl lg:text-4xl font-black text-amber-400 font-mono">&lt; 0.2s</h3>
                    <p class="text-xs text-slate-400 font-medium">Waktu Respon Server</p>
                </div>
                <div class="col-span-2 lg:col-span-1 space-y-1">
                    <h3 class="text-3xl lg:text-4xl font-black text-emerald-400 font-mono">99.8%</h3>
                    <p class="text-xs text-slate-400 font-medium">Kepuasan Tenaga Medis</p>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION 4: COMPREHENSIVE MODULE SHOWCASE (13 MODUL CORE) --}}
    <section id="modul" class="py-24 bg-slate-950 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <span class="text-xs font-bold text-teal-400 uppercase tracking-widest font-mono">Arsitektur Modular</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white">13 Modul Utama Terintegrasi Tanpa Celah</h2>
                <p class="text-slate-400 text-sm">Seluruh modul saling terhubung secara konsisten, berbagi data pasien secara otomatis, dan mempercepat alur kerja operasional rumah sakit.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- Modul 1 --}}
                <div class="p-6 bg-slate-900 border border-slate-800 rounded-3xl hover:border-teal-500/50 transition group">
                    <div class="w-12 h-12 rounded-2xl bg-teal-500/10 text-teal-400 flex items-center justify-center mb-4 group-hover:scale-110 transition">
                        <i data-lucide="user-plus" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">1. Pendaftaran & Antrean</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">Registrasi pasien baru/lama, generasi nomor RM otomatis, pemilihan poliklinik, dokter, & antrean berbasis mesin pemanggil suara.</p>
                    <span class="inline-block mt-4 text-[10px] font-bold text-teal-400 font-mono">STATUS: 100% READY</span>
                </div>

                {{-- Modul 2 --}}
                <div class="p-6 bg-slate-900 border border-slate-800 rounded-3xl hover:border-teal-500/50 transition group">
                    <div class="w-12 h-12 rounded-2xl bg-sky-500/10 text-sky-400 flex items-center justify-center mb-4 group-hover:scale-110 transition">
                        <i data-lucide="stethoscope" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">2. Poliklinik & Rawat Jalan</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">Pemeriksaan TTV perawat (vital signs), pemanggilan antrean periksa, pemeriksaan DPJP dokter, & penyelesaian kunjungan.</p>
                    <span class="inline-block mt-4 text-[10px] font-bold text-sky-400 font-mono">STATUS: 100% READY</span>
                </div>

                {{-- Modul 3 --}}
                <div class="p-6 bg-slate-900 border border-slate-800 rounded-3xl hover:border-teal-500/50 transition group">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center mb-4 group-hover:scale-110 transition">
                        <i data-lucide="bed" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">3. Rawat Inap & Bed Management</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">Admisi masuk pasien ranap, alokasi tempat tidur (Bed Management), pemindahan kamar (transfer), & proses kepulangan (discharge).</p>
                    <span class="inline-block mt-4 text-[10px] font-bold text-emerald-400 font-mono">STATUS: 100% READY</span>
                </div>

                {{-- Modul 4 --}}
                <div class="p-6 bg-slate-900 border border-slate-800 rounded-3xl hover:border-teal-500/50 transition group">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-500/10 text-indigo-400 flex items-center justify-center mb-4 group-hover:scale-110 transition">
                        <i data-lucide="file-text" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">4. Rekam Medis Elektronik (EMR)</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">Catatan medis SOAP lengkap, kodifikasi ICD-10 & ICD-9-CM, riwayat longitudinal episode kunjungan pasien, & persetujuan medis.</p>
                    <span class="inline-block mt-4 text-[10px] font-bold text-indigo-400 font-mono">STATUS: 100% READY</span>
                </div>

                {{-- Modul 5 --}}
                <div class="p-6 bg-slate-900 border border-slate-800 rounded-3xl hover:border-teal-500/50 transition group">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-400 flex items-center justify-center mb-4 group-hover:scale-110 transition">
                        <i data-lucide="pill" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">5. Farmasi & E-Resep</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">Penerimaan E-Resep otomatis dari EMR, validasi apoteker, penyiapan & penyerahan obat (dispensing), & auto-deduct stok obat FIFO.</p>
                    <span class="inline-block mt-4 text-[10px] font-bold text-amber-400 font-mono">STATUS: 100% READY</span>
                </div>

                {{-- Modul 6 --}}
                <div class="p-6 bg-slate-900 border border-slate-800 rounded-3xl hover:border-teal-500/50 transition group">
                    <div class="w-12 h-12 rounded-2xl bg-rose-500/10 text-rose-400 flex items-center justify-center mb-4 group-hover:scale-110 transition">
                        <i data-lucide="flask-conical" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">6. Laboratorium (LIS)</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">Order pemeriksaan lab otomatis, penerimaan sampel darah/urin, entry nilai hasil & nilai rujukan, serta validasi analis lab.</p>
                    <span class="inline-block mt-4 text-[10px] font-bold text-rose-400 font-mono">STATUS: 100% READY</span>
                </div>

                {{-- Modul 7 --}}
                <div class="p-6 bg-slate-900 border border-slate-800 rounded-3xl hover:border-teal-500/50 transition group">
                    <div class="w-12 h-12 rounded-2xl bg-teal-500/10 text-teal-400 flex items-center justify-center mb-4 group-hover:scale-110 transition">
                        <i data-lucide="credit-card" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">7. Kasir & Billing Pelayanan</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">Generasi invoice konsolidasi biaya registrasi, dokter, obat, & lab, proses pelunasan kasir, penerbitan kuitansi, & pembatalan/void.</p>
                    <span class="inline-block mt-4 text-[10px] font-bold text-teal-400 font-mono">STATUS: 100% READY</span>
                </div>

                {{-- Modul 8 --}}
                <div class="p-6 bg-slate-900 border border-slate-800 rounded-3xl hover:border-teal-500/50 transition group">
                    <div class="w-12 h-12 rounded-2xl bg-purple-500/10 text-purple-400 flex items-center justify-center mb-4 group-hover:scale-110 transition">
                        <i data-lucide="boxes" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">8. Gudang & Logistik</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">Penerimaan faktur supplier (Inbound), distribusi barang ke unit/farmasi (Outbound), mutasi antar depo, & Stock Opname audit.</p>
                    <span class="inline-block mt-4 text-[10px] font-bold text-purple-400 font-mono">STATUS: 100% READY</span>
                </div>

                {{-- Modul 9 --}}
                <div class="p-6 bg-slate-900 border border-slate-800 rounded-3xl hover:border-teal-500/50 transition group">
                    <div class="w-12 h-12 rounded-2xl bg-blue-500/10 text-blue-400 flex items-center justify-center mb-4 group-hover:scale-110 transition">
                        <i data-lucide="users" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">9. User Management & Audit Trail</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">Manajemen pengguna, Spatie RBAC permission matrix grid, riwayat login sesi, & audit trail log aktivitas pencatatan transaksi.</p>
                    <span class="inline-block mt-4 text-[10px] font-bold text-blue-400 font-mono">STATUS: 100% READY</span>
                </div>

                {{-- Modul 10 --}}
                <div class="p-6 bg-slate-900 border border-slate-800 rounded-3xl hover:border-teal-500/50 transition group">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center mb-4 group-hover:scale-110 transition">
                        <i data-lucide="bar-chart-3" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">10. Laporan & Dashboard Analitik BI</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">Grafik analitik kunjungan, pendapatan, 10 penyakit terbanyak, penggunaan obat, BOR rawat inap, & ekspor CSV server-side.</p>
                    <span class="inline-block mt-4 text-[10px] font-bold text-emerald-400 font-mono">STATUS: 100% READY</span>
                </div>

                {{-- Modul 11 --}}
                <div class="p-6 bg-slate-900 border border-slate-800 rounded-3xl hover:border-teal-500/50 transition group">
                    <div class="w-12 h-12 rounded-2xl bg-amber-500/10 text-amber-400 flex items-center justify-center mb-4 group-hover:scale-110 transition">
                        <i data-lucide="settings" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">11. Pengaturan System & Backup</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">Profil RS, format penomoran dokumen otomatis, SMTP email server, notifikasi alert stok/expired, & backup CLI/dump database.</p>
                    <span class="inline-block mt-4 text-[10px] font-bold text-amber-400 font-mono">STATUS: 100% READY</span>
                </div>

                {{-- Modul 12 --}}
                <div class="p-6 bg-slate-900 border border-slate-800 rounded-3xl hover:border-teal-500/50 transition group">
                    <div class="w-12 h-12 rounded-2xl bg-sky-500/10 text-sky-400 flex items-center justify-center mb-4 group-hover:scale-110 transition">
                        <i data-lucide="database" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white mb-2">12. Master Data Rumah Sakit</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">Master Poliklinik, Dokter & Jadwal Praktik, Ruangan & Bed, Layanan & Tarif Medis, Kategori Obat, & Daftar Supplier PBF.</p>
                    <span class="inline-block mt-4 text-[10px] font-bold text-sky-400 font-mono">STATUS: 100% READY</span>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION 5: END-TO-END PATIENT WORKFLOW ARCHITECTURE --}}
    <section id="alur" class="py-24 bg-slate-900/80 border-t border-slate-800 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <span class="text-xs font-bold text-sky-400 uppercase tracking-widest font-mono">Workflow Pelayanan Seamless</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white">Alur Perjalanan Pasien Tanpa Hambatan</h2>
                <p class="text-slate-400 text-sm">Setiap tahap pelayanan dari pintu masuk hingga kepulangan terkoordinasi secara otomatis.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 relative">
                {{-- Step 1 --}}
                <div class="bg-slate-950 p-6 rounded-3xl border border-slate-800 relative">
                    <span class="w-8 h-8 rounded-full bg-teal-500 text-slate-950 font-black text-xs flex items-center justify-center mb-4 font-mono">01</span>
                    <h4 class="font-bold text-white text-base mb-1">Pendaftaran & Antrean</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">Pasien mendaftar, mendapatkan nomor RM & tiket antrean poli tujuan.</p>
                </div>
                {{-- Step 2 --}}
                <div class="bg-slate-950 p-6 rounded-3xl border border-slate-800 relative">
                    <span class="w-8 h-8 rounded-full bg-sky-500 text-slate-950 font-black text-xs flex items-center justify-center mb-4 font-mono">02</span>
                    <h4 class="font-bold text-white text-base mb-1">Assessment TTV & Dokter</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">Perawat mencatat TTV, Dokter menginput EMR SOAP, ICD-10, E-Resep & Lab.</p>
                </div>
                {{-- Step 3 --}}
                <div class="bg-slate-950 p-6 rounded-3xl border border-slate-800 relative">
                    <span class="w-8 h-8 rounded-full bg-indigo-500 text-white font-black text-xs flex items-center justify-center mb-4 font-mono">03</span>
                    <h4 class="font-bold text-white text-base mb-1">Farmasi & Laboratorium</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">Apoteker menyiapkan obat, Analis memproses sampel lab & mempublikasikan hasil.</p>
                </div>
                {{-- Step 4 --}}
                <div class="bg-slate-950 p-6 rounded-3xl border border-slate-800 relative">
                    <span class="w-8 h-8 rounded-full bg-emerald-500 text-slate-950 font-black text-xs flex items-center justify-center mb-4 font-mono">04</span>
                    <h4 class="font-bold text-white text-base mb-1">Billing & Pelunasan Kasir</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">Kasir menerbitkan invoice konsolidasi, menerima pembayaran & mencetak kuitansi.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION 6: INTEGRATION & SECURITY STANDARDS --}}
    <section id="integrasi" class="py-24 bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <div class="space-y-6">
                    <span class="text-xs font-bold text-emerald-400 uppercase tracking-widest font-mono">Kepatuhan Regulasi & Security</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-white leading-tight">Siap Terhubung dengan Ecosystem Kesehatan Nasional</h2>
                    <p class="text-slate-400 text-sm leading-relaxed">
                        Arsitektur data dirancang memenuhi standar interoperabilitas data kesehatan Kemenkes RI, BPJS Kesehatan, & standar keamanan informasi tingkat tinggi.
                    </p>

                    <div class="space-y-4">
                        <div class="flex items-start gap-4 p-4 bg-slate-900 border border-slate-800 rounded-2xl">
                            <div class="p-2 bg-emerald-500/10 text-emerald-400 rounded-xl">
                                <i data-lucide="activity" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-white text-sm">Kemenkes SATUSEHAT Compatible</h4>
                                <p class="text-xs text-slate-400">Standar pemetaan variabel data pasien & rekam medis sesuai spesifikasi HL7 FHIR.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 p-4 bg-slate-900 border border-slate-800 rounded-2xl">
                            <div class="p-2 bg-sky-500/10 text-sky-400 rounded-xl">
                                <i data-lucide="shield" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-white text-sm">BPJS Kesehatan Bridging Ready</h4>
                                <p class="text-xs text-slate-400">Siap dihubungkan dengan Web Service VClaim BPJS & Antrean Online RS.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 p-4 bg-slate-900 border border-slate-800 rounded-2xl">
                            <div class="p-2 bg-purple-500/10 text-purple-400 rounded-xl">
                                <i data-lucide="lock" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-white text-sm">Audit Trail & Encrypted Credentials</h4>
                                <p class="text-xs text-slate-400">Setiap perubahan data penting dicatat pada log audit trail secara permanen.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Code / Ecosystem Preview Card --}}
                <div class="bg-slate-900 border border-slate-800 rounded-3xl p-6 shadow-2xl space-y-4 font-mono text-xs">
                    <div class="flex items-center justify-between border-b border-slate-800 pb-3">
                        <span class="text-slate-400">satusehat_integration.json</span>
                        <span class="text-emerald-400 font-bold">200 OK</span>
                    </div>
                    <pre class="text-slate-300 leading-relaxed overflow-x-auto p-3 bg-slate-950 rounded-xl">{
  "resourceType": "Encounter",
  "status": "arrived",
  "class": {
    "system": "http://terminology.hl7.org/CodeSystem/v3-ActCode",
    "code": "AMB",
    "display": "ambulatory"
  },
  "subject": {
    "reference": "Patient/100029381",
    "display": "Budi Santoso"
  },
  "serviceProvider": {
    "reference": "Organization/3171999",
    "display": "RSU Rajawali Citra"
  }
}</pre>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION 7: INTERACTIVE DASHBOARD PREVIEW --}}
    <section class="py-24 bg-slate-900/60 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12 space-y-3">
                <span class="text-xs font-bold text-sky-400 uppercase tracking-widest font-mono">Antarmuka Modern</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white">Desain Enterprise Tailwind CSS 4</h2>
                <p class="text-slate-400 text-sm">Antarmuka yang responsif, bersih, dan memanjakan mata pengguna medis dengan kenyamanan maksimal.</p>
            </div>

            <div class="bg-slate-950 border border-slate-800 rounded-3xl p-6 sm:p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="p-4 bg-slate-900 border border-slate-800 rounded-2xl">
                        <span class="text-xs text-slate-400 block">Kunjungan Poliklinik</span>
                        <h3 class="text-2xl font-bold text-white mt-1">942 Pasien</h3>
                    </div>
                    <div class="p-4 bg-slate-900 border border-slate-800 rounded-2xl">
                        <span class="text-xs text-slate-400 block">Resep Obat Diproses</span>
                        <h3 class="text-2xl font-bold text-teal-400 mt-1">810 Resep</h3>
                    </div>
                    <div class="p-4 bg-slate-900 border border-slate-800 rounded-2xl">
                        <span class="text-xs text-slate-400 block">Pengujian Lab Selesai</span>
                        <h3 class="text-2xl font-bold text-sky-400 mt-1">340 Order</h3>
                    </div>
                </div>

                {{-- Chart canvas --}}
                <div class="h-64 w-full">
                    <canvas id="landingChart"></canvas>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION 8: USER ROLE EXPERIENCE --}}
    <section class="py-24 bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <span class="text-xs font-bold text-teal-400 uppercase tracking-widest font-mono">Pengalaman Pengguna Spesifik</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white">Didesain Khusus untuk Setiap Peran Medis</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="p-6 bg-slate-900 border border-slate-800 rounded-3xl">
                    <div class="w-10 h-10 rounded-xl bg-teal-500/10 text-teal-400 flex items-center justify-center mb-3">
                        <i data-lucide="stethoscope" class="w-5 h-5"></i>
                    </div>
                    <h4 class="font-bold text-white text-sm mb-1">Dokter DPJP</h4>
                    <p class="text-xs text-slate-400">Entry EMR SOAP cepat, autocomplete ICD-10, & E-Resep instant tanpa perlu menulis manual.</p>
                </div>

                <div class="p-6 bg-slate-900 border border-slate-800 rounded-3xl">
                    <div class="w-10 h-10 rounded-xl bg-sky-500/10 text-sky-400 flex items-center justify-center mb-3">
                        <i data-lucide="activity" class="w-5 h-5"></i>
                    </div>
                    <h4 class="font-bold text-white text-sm mb-1">Perawat Poli & Ranap</h4>
                    <p class="text-xs text-slate-400">Input Tanda-Tanda Vital (TTV) mudah, pemanggilan antrean suara, & monitoring bed.</p>
                </div>

                <div class="p-6 bg-slate-900 border border-slate-800 rounded-3xl">
                    <div class="w-10 h-10 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center mb-3">
                        <i data-lucide="pill" class="w-5 h-5"></i>
                    </div>
                    <h4 class="font-bold text-white text-sm mb-1">Apoteker Farmasi</h4>
                    <p class="text-xs text-slate-400">Menerima E-Resep otomatis, validasi stok obat real-time, & print etiket obat otomatis.</p>
                </div>

                <div class="p-6 bg-slate-900 border border-slate-800 rounded-3xl">
                    <div class="w-10 h-10 rounded-xl bg-indigo-500/10 text-indigo-400 flex items-center justify-center mb-3">
                        <i data-lucide="credit-card" class="w-5 h-5"></i>
                    </div>
                    <h4 class="font-bold text-white text-sm mb-1">Petugas Kasir</h4>
                    <p class="text-xs text-slate-400">Kalkulasi otomatis total biaya pelayanan, opsi metode bayar tunai/non-tunai, & cetak kuitansi.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION 9: KEY ENTERPRISE ADVANTAGES --}}
    <section class="py-24 bg-slate-900/80 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <span class="text-xs font-bold text-indigo-400 uppercase tracking-widest font-mono">Keunggulan Teknologi</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white">Mengapa Memilih SIMRS Enterprise?</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-teal-500/10 text-teal-400 flex items-center justify-center">
                        <i data-lucide="zap" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Ultra Performa & Ringan</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">Dibangun di atas Laravel 12 & Blade tanpa overhead berat, mampu melayani ribuan request serentak dengan latency minimal.</p>
                </div>

                <div class="space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-sky-500/10 text-sky-400 flex items-center justify-center">
                        <i data-lucide="hard-drive" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Zero Hardware Lock-in</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">Dapat di-deploy pada server On-Premise Rumah Sakit maupun Cloud Server (GCP, AWS, VPS Local) tanpa batasan lisensi per PC.</p>
                </div>

                <div class="space-y-3">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center">
                        <i data-lucide="download" class="w-6 h-6"></i>
                    </div>
                    <h3 class="text-lg font-bold text-white">Ekspor Data Server-Side</h3>
                    <p class="text-xs text-slate-400 leading-relaxed">Dukungan penuh ekspor laporan CSV dengan enkoding UTF-8 BOM untuk kompatibilitas sempurna dengan Microsoft Excel.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION 10: INTERACTIVE HOSPITAL ROI & EFFICIENCY CALCULATOR --}}
    <section id="kalkulator" class="py-24 bg-slate-950">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-slate-900 border border-slate-800 rounded-3xl p-8 shadow-2xl text-center space-y-6">
                <span class="text-xs font-bold text-teal-400 uppercase tracking-widest font-mono">Kalkulator Efisiensi RS</span>
                <h2 class="text-3xl font-extrabold text-white">Hitung Penghematan Operasional Rumah Sakit Anda</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-left pt-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-2">Jumlah Pasien per Hari: <span id="valPatients" class="text-teal-400 font-bold">250</span> Pasien</label>
                        <input type="range" id="rangePatients" min="50" max="1000" step="50" value="250" class="w-full accent-teal-500 cursor-pointer">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 mb-2">Jumlah Tempat Tidur (Bed): <span id="valBeds" class="text-sky-400 font-bold">100</span> Bed</label>
                        <input type="range" id="rangeBeds" min="20" max="500" step="10" value="100" class="w-full accent-sky-500 cursor-pointer">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-4 border-t border-slate-800 text-center">
                    <div class="p-4 bg-slate-950 rounded-2xl border border-slate-800">
                        <span class="text-xs text-slate-400 block">Estimasi Penghematan Kertas</span>
                        <span id="resPaper" class="text-xl font-bold text-teal-400 block mt-1">Rp 45.000.000 / Thn</span>
                    </div>
                    <div class="p-4 bg-slate-950 rounded-2xl border border-slate-800">
                        <span class="text-xs text-slate-400 block">Waktu Tunggu Pasien Berkurang</span>
                        <span id="resTime" class="text-xl font-bold text-sky-400 block mt-1">65% Lebih Cepat</span>
                    </div>
                    <div class="p-4 bg-slate-950 rounded-2xl border border-slate-800">
                        <span class="text-xs text-slate-400 block">Mencegah Kebocoran Billing</span>
                        <span id="resRevenue" class="text-xl font-bold text-emerald-400 block mt-1">100% Akurat</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION 11: REAL HOSPITAL TESTIMONIALS & SUCCESS STORIES --}}
    <section class="py-24 bg-slate-900/60 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <span class="text-xs font-bold text-amber-400 uppercase tracking-widest font-mono">Testimoni Pengguna</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white">Dipercaya oleh Para Ahli & Praktisi Kesehatan</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-6 bg-slate-950 border border-slate-800 rounded-3xl space-y-4">
                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                        ★★★★★
                    </div>
                    <p class="text-xs text-slate-300 leading-relaxed font-italic">
                        "Implementasi SIMRS ini mempercepat alur pelayanan rawat jalan dan rekam medis SOAP secara signifikan. Dokter tidak lagi menghabiskan waktu menulis resep manual."
                    </p>
                    <div class="border-t border-slate-800 pt-3 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-teal-500/20 text-teal-400 flex items-center justify-center font-bold text-xs">AF</div>
                        <div>
                            <h4 class="font-bold text-white text-xs">dr. H. Ahmad Fauzi, Sp.OG</h4>
                            <span class="text-[10px] text-slate-500 block">Direktur Utama RSUD</span>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-slate-950 border border-slate-800 rounded-3xl space-y-4">
                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                        ★★★★★
                    </div>
                    <p class="text-xs text-slate-300 leading-relaxed font-italic">
                        "Integrasi stok obat antara Gudang Logistik dan Depo Farmasi berjalan otomatis. Peringatan stok minimum membantu kami menghindari kekosongan obat kritis."
                    </p>
                    <div class="border-t border-slate-800 pt-3 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-sky-500/20 text-sky-400 flex items-center justify-center font-bold text-xs">apt</div>
                        <div>
                            <h4 class="font-bold text-white text-xs">apt. Siti Rahmawati, S.Farm</h4>
                            <span class="text-[10px] text-slate-500 block">Kepala Instalasi Farmasi</span>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-slate-950 border border-slate-800 rounded-3xl space-y-4">
                    <div class="flex items-center gap-1 text-amber-400 text-xs">
                        ★★★★★
                    </div>
                    <p class="text-xs text-slate-300 leading-relaxed font-italic">
                        "Proses billing konsolidasi dari seluruh poliklinik, lab, dan ranap langsung terkumpul di kasir secara akurat. Kebocoran biaya dapat ditekan hingga 0%."
                    </p>
                    <div class="border-t border-slate-800 pt-3 flex items-center gap-3">
                        <div class="w-9 h-9 rounded-full bg-purple-500/20 text-purple-400 flex items-center justify-center font-bold text-xs">SE</div>
                        <div>
                            <h4 class="font-bold text-white text-xs">Budi Prasetyo, S.E.</h4>
                            <span class="text-[10px] text-slate-500 block">Kabid Keuangan & Billing</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION 12: SYSTEM REQUIREMENTS & DEPLOYMENT ARCHITECTURE --}}
    <section class="py-24 bg-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-slate-900 border border-slate-800 rounded-3xl p-8 lg:p-12">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                    <div class="space-y-4">
                        <span class="text-xs font-bold text-sky-400 uppercase tracking-widest font-mono">Spesifikasi Sistem</span>
                        <h2 class="text-3xl font-extrabold text-white">Kebutuhan Infrastruktur Server</h2>
                        <p class="text-xs text-slate-400 leading-relaxed">
                            SIMRS dapat dijalankan pada lingkungan server lokal rumah sakit (On-Premise) maupun Cloud VPS.
                        </p>

                        <div class="grid grid-cols-2 gap-4 pt-2 text-xs">
                            <div class="p-3 bg-slate-950 rounded-xl border border-slate-800">
                                <span class="text-slate-500 font-medium block">Operating System</span>
                                <span class="font-bold text-white">Windows Server / Linux Ubuntu</span>
                            </div>
                            <div class="p-3 bg-slate-950 rounded-xl border border-slate-800">
                                <span class="text-slate-500 font-medium block">Database Engine</span>
                                <span class="font-bold text-white">MySQL 8.0+ / MariaDB</span>
                            </div>
                            <div class="p-3 bg-slate-950 rounded-xl border border-slate-800">
                                <span class="text-slate-500 font-medium block">PHP Environment</span>
                                <span class="font-bold text-white">PHP 8.2 — 8.5+</span>
                            </div>
                            <div class="p-3 bg-slate-950 rounded-xl border border-slate-800">
                                <span class="text-slate-500 font-medium block">Web Server</span>
                                <span class="font-bold text-white">Nginx / Apache / Laragon</span>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 bg-slate-950 border border-slate-800 rounded-2xl text-xs space-y-3 font-mono">
                        <div class="text-teal-400 font-bold">// Verifikasi Performa Server</div>
                        <div class="text-slate-300">php artisan optimize:clear</div>
                        <div class="text-slate-400">INFO  Clearing cached bootstrap files... DONE</div>
                        <div class="text-slate-300">php artisan route:list</div>
                        <div class="text-emerald-400">INFO  Showing [220] routes. All modules active.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION 13: FREQUENTLY ASKED QUESTIONS (FAQ ACCORDION) --}}
    <section id="faq" class="py-24 bg-slate-900/60 border-t border-slate-800">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <span class="text-xs font-bold text-teal-400 uppercase tracking-widest font-mono">FAQ</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white">Pertanyaan Sering Diajukan</h2>
            </div>

            <div class="space-y-4">
                <div class="bg-slate-950 border border-slate-800 rounded-2xl p-5 cursor-pointer" onclick="toggleFaq(1)">
                    <div class="flex justify-between items-center">
                        <h4 class="font-bold text-white text-sm">Apakah SIMRS ini sudah mendukung regulasi Kemenkes SATUSEHAT?</h4>
                        <i data-lucide="chevron-down" id="iconFaq1" class="w-4 h-4 text-slate-400 transition"></i>
                    </div>
                    <p id="ansFaq1" class="text-xs text-slate-400 mt-3 hidden leading-relaxed">
                        Ya. Struktur database dan skema data rekam medis EMR telah disesuaikan dengan variabel standar HL7 FHIR Kemenkes RI SATUSEHAT.
                    </p>
                </div>

                <div class="bg-slate-950 border border-slate-800 rounded-2xl p-5 cursor-pointer" onclick="toggleFaq(2)">
                    <div class="flex justify-between items-center">
                        <h4 class="font-bold text-white text-sm">Apakah terdapat batasan jumlah pengguna (user/client)?</h4>
                        <i data-lucide="chevron-down" id="iconFaq2" class="w-4 h-4 text-slate-400 transition"></i>
                    </div>
                    <p id="ansFaq2" class="text-xs text-slate-400 mt-3 hidden leading-relaxed">
                        Tidak ada batasan (Unlimited User). Anda dapat mendaftarkan akun dokter, perawat, apoteker, kasir, dan staf tanpa biaya per lisensi user.
                    </p>
                </div>

                <div class="bg-slate-950 border border-slate-800 rounded-2xl p-5 cursor-pointer" onclick="toggleFaq(3)">
                    <div class="flex justify-between items-center">
                        <h4 class="font-bold text-white text-sm">Bagaimana mekanisme backup data rumah sakit?</h4>
                        <i data-lucide="chevron-down" id="iconFaq3" class="w-4 h-4 text-slate-400 transition"></i>
                    </div>
                    <p id="ansFaq3" class="text-xs text-slate-400 mt-3 hidden leading-relaxed">
                        Modul Pengaturan Sistem menyediakan fitur backup otomatis database `.sql.gz` secara manual atau terjadwal CLI dump dengan opsi unduh file terenkripsi.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION 14: FINAL CALL TO ACTION (CTA BANNER) --}}
    <section class="py-20 bg-slate-950 relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="bg-gradient-to-r from-teal-900/80 via-slate-900 to-sky-900/80 border border-teal-500/30 rounded-3xl p-10 lg:p-16 text-center space-y-6 backdrop-blur-xl shadow-2xl">
                <h2 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight">
                    Siap Mentransformasi Pelayanan Rumah Sakit Anda?
                </h2>
                <p class="text-slate-300 text-sm sm:text-base max-w-2xl mx-auto">
                    Tingkatkan kecepatan pelayanan medis, eliminasi kertas EMR, dan amankan pengelolaan keuangan rumah sakit secara real-time.
                </p>

                <div class="flex flex-col sm:flex-row justify-center gap-4 pt-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-teal-500 hover:bg-teal-400 text-slate-950 font-bold text-sm rounded-2xl shadow-xl transition hover:scale-105">
                            <i data-lucide="layout-dashboard" class="w-5 h-5"></i> Masuk Ke Dashboard Sekarang
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-teal-500 hover:bg-teal-400 text-slate-950 font-bold text-sm rounded-2xl shadow-xl transition hover:scale-105">
                            <i data-lucide="shield-check" class="w-5 h-5"></i> Login Sistem SIMRS
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </section>

    {{-- SECTION 15: ENTERPRISE FOOTER --}}
    <footer class="bg-slate-950 border-t border-slate-900 pt-16 pb-12 text-xs text-slate-400">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <div class="space-y-3">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-xl bg-teal-500/20 text-teal-400 flex items-center justify-center">
                            <i data-lucide="hospital" class="w-5 h-5"></i>
                        </div>
                        <span class="font-extrabold text-base text-white">SIMRS Enterprise</span>
                    </div>
                    <p class="text-slate-500 leading-relaxed">
                        Sistem Informasi Manajemen Rumah Sakit Terintegrasi. Dikembangkan dengan standar arsitektur enterprise modern.
                    </p>
                </div>

                <div>
                    <h4 class="font-bold text-white text-xs mb-3 uppercase tracking-wider">Modul Layanan</h4>
                    <ul class="space-y-2 text-slate-500">
                        <li>Pendaftaran & Antrean</li>
                        <li>Poliklinik Rawat Jalan</li>
                        <li>Rawat Inap & Bed Management</li>
                        <li>Rekam Medis EMR SOAP</li>
                        <li>Farmasi & E-Resep</li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-white text-xs mb-3 uppercase tracking-wider">Modul Penunjang</h4>
                    <ul class="space-y-2 text-slate-500">
                        <li>Laboratorium LIS</li>
                        <li>Kasir & Billing Pelayanan</li>
                        <li>Gudang & Logistik Medis</li>
                        <li>User & Security RBAC</li>
                        <li>Laporan & Analitik BI</li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-bold text-white text-xs mb-3 uppercase tracking-wider">Kontak & Support</h4>
                    <ul class="space-y-2 text-slate-500">
                        <li>RSU Rajawali Citra</li>
                        <li>Jl. Pleret No.KM 2.5, Banjardadap, Potorono, Banguntapan, Bantul, DIY 55196</li>
                        <li>Telepon: 0821-3431-3535</li>
                        <li>Email: info@rsurajawalicitra.co.id</li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-slate-900 pt-8 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p>&copy; {{ date('Y') }} RSU Rajawali Citra — SIMRS Enterprise Architecture. All rights reserved.</p>
                <div class="flex gap-4 font-mono text-[10px] text-slate-500">
                    <span>Laravel 12</span> · <span>Tailwind CSS 4</span> · <span>MySQL 8</span>
                </div>
            </div>
        </div>
    </footer>

    {{-- Interactive Scripts --}}
    <script>
        lucide.createIcons();

        // Landing Chart Preview
        const ctx = document.getElementById('landingChart')?.getContext('2d');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'],
                    datasets: [
                        {
                            label: 'Rawat Jalan',
                            data: [120, 190, 170, 210, 250, 180, 90],
                            borderColor: '#0d9488',
                            backgroundColor: 'rgba(13, 148, 136, 0.1)',
                            tension: 0.4,
                            fill: true
                        },
                        {
                            label: 'Rawat Inap',
                            data: [40, 45, 50, 52, 60, 58, 55],
                            borderColor: '#0284c7',
                            backgroundColor: 'rgba(2, 132, 199, 0.1)',
                            tension: 0.4,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { labels: { color: '#94a3b8', font: { size: 11 } } }
                    },
                    scales: {
                        x: { ticks: { color: '#64748b' }, grid: { color: 'rgba(255,255,255,0.05)' } },
                        y: { ticks: { color: '#64748b' }, grid: { color: 'rgba(255,255,255,0.05)' } }
                    }
                }
            });
        }

        // ROI Calculator Logic
        const pInput = document.getElementById('rangePatients');
        const bInput = document.getElementById('rangeBeds');

        function updateRoi() {
            const p = parseInt(pInput.value);
            const b = parseInt(bInput.value);

            document.getElementById('valPatients').innerText = p;
            document.getElementById('valBeds').innerText = b;

            const paperSave = (p * 365 * 500).toLocaleString('id-ID');
            document.getElementById('resPaper').innerText = 'Rp ' + paperSave + ' / Thn';

            const timeSave = Math.min(80, Math.round(50 + (p / 20)));
            document.getElementById('resTime').innerText = timeSave + '% Lebih Cepat';
        }

        if (pInput && bInput) {
            pInput.addEventListener('input', updateRoi);
            bInput.addEventListener('input', updateRoi);
        }

        // FAQ Toggle
        function toggleFaq(id) {
            const ans = document.getElementById('ansFaq' + id);
            const icon = document.getElementById('iconFaq' + id);
            if (ans.classList.contains('hidden')) {
                ans.classList.remove('hidden');
                icon.classList.add('rotate-180');
            } else {
                ans.classList.add('hidden');
                icon.classList.remove('rotate-180');
            }
        }
    </script>
</body>
</html>
