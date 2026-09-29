<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50 light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Halaman Login Portal SIMRS — RSU Rajawali Citra">

    <title>Login Staf &amp; Portal SIMRS — RSU Rajawali Citra</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="theme-color" content="#1e3a5f">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest" defer></script>
</head>
<body class="h-full bg-slate-50 font-sans antialiased text-slate-900 flex items-center justify-center p-4 sm:p-6">

    <main class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-200 p-6 sm:p-8 space-y-6">
        {{-- Header Logo --}}
        <div class="text-center space-y-2">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2.5 mb-1 focus:outline-none rounded-xl p-1" aria-label="Beranda Utama">
                <div class="w-12 h-12 rounded-xl bg-blue-900 flex items-center justify-center text-white shrink-0 shadow-md">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="#fff" class="w-6 h-6" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                    </svg>
                </div>
                <div class="text-left">
                    <div class="text-base font-extrabold text-slate-900 leading-tight">RSU Rajawali Citra</div>
                    <div class="text-xs text-slate-500 font-medium">Bantul, DI Yogyakarta</div>
                </div>
            </a>
            <h1 class="text-xl font-black text-slate-900 tracking-tight">Portal SIMRS</h1>
            <p class="text-xs text-slate-500 font-medium">Sistem Informasi Manajemen Rumah Sakit</p>
        </div>

        @if (session('info'))
            <div class="p-3.5 bg-blue-50 text-blue-900 text-xs rounded-xl border border-blue-200 flex items-center gap-2.5">
                <i data-lucide="info" class="w-4 h-4 text-blue-600 shrink-0"></i>
                <span>{{ session('info') }}</span>
            </div>
        @endif

        @if (session('status'))
            <div class="p-3.5 bg-emerald-50 text-emerald-900 text-xs rounded-xl border border-emerald-200 flex items-center gap-2.5">
                <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600 shrink-0"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <div>
                <label for="login" class="block text-xs font-bold text-slate-700 mb-1">Username atau Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="user" class="w-4 h-4"></i>
                    </div>
                    <input type="text" name="login" id="login" value="{{ old('login', 'superadmin') }}" required autofocus placeholder="Masukkan username" class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:bg-white transition min-h-[44px]">
                </div>
                @error('login')
                    <p class="text-xs text-red-600 mt-1 flex items-center gap-1"><i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> {{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-xs font-bold text-slate-700 mb-1">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="lock" class="w-4 h-4"></i>
                    </div>
                    <input type="password" name="password" id="password" value="password" required placeholder="Masukkan password" class="w-full pl-10 pr-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs sm:text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-cyan-600 focus:bg-white transition min-h-[44px]">
                </div>
                @error('password')
                    <p class="text-xs text-red-600 mt-1 flex items-center gap-1"><i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> {{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center gap-2 text-slate-600 cursor-pointer min-h-[44px]">
                    <input type="checkbox" name="remember" checked class="rounded border-slate-300 text-blue-900 focus:ring-blue-800 w-4 h-4">
                    <span>Ingat Saya</span>
                </label>
                <span class="text-slate-500 font-medium flex items-center gap-1"><i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i> Terenkripsi SSL</span>
            </div>

            <button type="submit" class="w-full py-3 px-4 bg-blue-900 hover:bg-blue-800 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer min-h-[46px]">
                <i data-lucide="log-in" class="w-4 h-4"></i>
                <span>Masuk Ke Portal SIMRS</span>
            </button>
        </form>

        <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-200 text-[11px] text-slate-600 space-y-1">
            <div class="font-extrabold text-slate-800 flex items-center gap-1 mb-1"><i data-lucide="key-round" class="w-3.5 h-3.5 text-blue-900"></i> Akun Pengujian Demo:</div>
            <div>• <strong>Super Admin</strong>: <code class="bg-slate-200 px-1 py-0.5 rounded text-slate-800 font-mono">superadmin</code> / <code class="bg-slate-200 px-1 py-0.5 rounded text-slate-800 font-mono">password</code></div>
            <div>• <strong>Dokter</strong>: <code class="bg-slate-200 px-1 py-0.5 rounded text-slate-800 font-mono">dokter1</code> / <code class="bg-slate-200 px-1 py-0.5 rounded text-slate-800 font-mono">password</code></div>
        </div>

        <div class="text-center pt-2 border-t border-slate-100">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-500 hover:text-blue-900 font-semibold transition py-2">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Kembali ke Website Utama
            </a>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') { lucide.createIcons(); }
        });
    </script>
</body>
</html>
