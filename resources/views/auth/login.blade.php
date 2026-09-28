<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Halaman Login Portal SIMRS — RSU Rajawali Citra">

    <title>Login Staf & Portal SIMRS — RSU Rajawali Citra</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <meta name="theme-color" content="#1e3a5f">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest" defer></script>
</head>
<body class="h-full bg-slate-50 font-sans antialiased text-slate-900 flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-200 p-8 space-y-6">
        {{-- Logo & Header --}}
        <div class="text-center space-y-2">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 mb-2 focus:outline-none rounded-lg p-1">
                <img src="{{ asset('logo.png') }}" alt="RSU Rajawali Citra" class="h-12 w-auto object-contain" onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='inline-flex';">
                <div class="hidden items-center justify-center w-12 h-12 rounded-xl bg-blue-900 text-white font-black text-xl shadow-md">
                    RC
                </div>
            </a>
            <h1 class="text-xl font-extrabold text-slate-900 tracking-tight">Portal SIMRS</h1>
            <p class="text-xs text-slate-500 font-medium">RSU Rajawali Citra — Sistem Informasi Manajemen Rumah Sakit</p>
        </div>

        @if (session('info'))
            <div class="p-3 bg-blue-50 text-blue-800 text-xs rounded-xl border border-blue-200 flex items-center gap-2">
                <i data-lucide="info" class="w-4 h-4 text-blue-600 flex-shrink-0"></i>
                <span>{{ session('info') }}</span>
            </div>
        @endif

        @if (session('status'))
            <div class="p-3 bg-emerald-50 text-emerald-800 text-xs rounded-xl border border-emerald-200 flex items-center gap-2">
                <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600 flex-shrink-0"></i>
                <span>{{ session('status') }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf
            <div>
                <label for="login" class="block text-xs font-semibold text-slate-700 mb-1">Username atau Email</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="user" class="w-4 h-4"></i>
                    </div>
                    <input type="text" name="login" id="login" value="{{ old('login', 'superadmin') }}" required autofocus placeholder="Masukkan username atau email" class="w-full pl-9 pr-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:bg-white transition">
                </div>
                @error('login')
                    <p class="text-xs text-rose-600 mt-1 flex items-center gap-1"><i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> {{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-xs font-semibold text-slate-700 mb-1">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="lock" class="w-4 h-4"></i>
                    </div>
                    <input type="password" name="password" id="password" value="password" required placeholder="Masukkan password Anda" class="w-full pl-9 pr-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-600 focus:bg-white transition">
                </div>
                @error('password')
                    <p class="text-xs text-rose-600 mt-1 flex items-center gap-1"><i data-lucide="alert-circle" class="w-3.5 h-3.5"></i> {{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center gap-2 text-slate-600 cursor-pointer">
                    <input type="checkbox" name="remember" checked class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                    <span>Ingat Saya</span>
                </label>
                <span class="text-slate-500 font-medium flex items-center gap-1"><i data-lucide="shield-check" class="w-3.5 h-3.5 text-emerald-600"></i> Terenkripsi SSL</span>
            </div>

            <button type="submit" class="w-full py-2.5 px-4 bg-blue-900 hover:bg-blue-800 text-white font-semibold text-xs rounded-xl shadow-sm transition-all duration-200 flex items-center justify-center gap-2 cursor-pointer">
                <i data-lucide="log-in" class="w-4 h-4"></i> Masuk Ke Portal SIMRS
            </button>
        </form>

        <div class="p-3 bg-slate-50 rounded-xl border border-slate-200 text-[11px] text-slate-600 space-y-1">
            <div class="font-bold text-slate-800 flex items-center gap-1"><i data-lucide="key-round" class="w-3.5 h-3.5 text-blue-600"></i> Akun Pengujian Demo:</div>
            <div>• <strong>Super Admin</strong>: <code class="bg-slate-200 px-1 py-0.5 rounded text-slate-800 font-mono">superadmin</code> / <code class="bg-slate-200 px-1 py-0.5 rounded text-slate-800 font-mono">password</code></div>
            <div>• <strong>Dokter</strong>: <code class="bg-slate-200 px-1 py-0.5 rounded text-slate-800 font-mono">dokter1</code> / <code class="bg-slate-200 px-1 py-0.5 rounded text-slate-800 font-mono">password</code></div>
        </div>

        <div class="text-center pt-2 border-t border-slate-100">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-500 hover:text-blue-700 font-medium transition">
                <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Kembali ke Website Utama
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') { lucide.createIcons(); }
        });
    </script>
</body>
</html>
