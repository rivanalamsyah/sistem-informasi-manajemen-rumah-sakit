<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-900">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Halaman Login Otentikasi SIMRS RSU Rajawali Citra">
    <meta name="author" content="{{ config('simrs.seo.meta_author') }}">

    <title>Login Otentikasi | {{ config('simrs.app_title_suffix', 'SIMRS') }} - {{ config('simrs.hospital_name', 'RSU Rajawali Citra') }}</title>

    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="h-full flex items-center justify-center p-4 bg-gradient-to-br from-slate-900 via-slate-800 to-teal-950 font-sans antialiased text-slate-700">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl border border-slate-100 p-8 space-y-6">
        <!-- Logo & Header -->
        <div class="text-center space-y-2">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-teal-600 text-white shadow-lg shadow-teal-900/30 mb-2">
                <i data-lucide="building-2" class="w-7 h-7"></i>
            </div>
            <h1 class="text-xl font-bold text-slate-900 tracking-tight">{{ config('simrs.app_name', 'SIMRS RSU Rajawali Citra') }}</h1>
            <p class="text-xs text-slate-500">{{ config('simrs.hospital_name', 'RSU Rajawali Citra') }}</p>
        </div>

        @if (session('info'))
            <div class="p-3 bg-sky-50 text-sky-800 text-xs rounded-xl border border-sky-200 flex items-center gap-2">
                <i data-lucide="info" class="w-4 h-4 text-sky-600"></i>
                <span>{{ session('info') }}</span>
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
                    <input type="text" name="login" id="login" value="{{ old('login', 'superadmin') }}" required autofocus placeholder="Masukkan username/email" class="w-full pl-9 pr-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition">
                </div>
                @error('login')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-xs font-semibold text-slate-700 mb-1">Password</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i data-lucide="lock" class="w-4 h-4"></i>
                    </div>
                    <input type="password" name="password" id="password" value="password" required placeholder="Masukkan password" class="w-full pl-9 pr-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition">
                </div>
                @error('password')
                    <p class="text-xs text-rose-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between text-xs">
                <label class="flex items-center gap-2 text-slate-600 cursor-pointer">
                    <input type="checkbox" name="remember" checked class="rounded border-slate-300 text-teal-600 focus:ring-teal-500">
                    <span>Ingat Saya</span>
                </label>
                <span class="text-teal-600 font-medium flex items-center gap-1"><i data-lucide="shield-check" class="w-3.5 h-3.5"></i> SSL Protected</span>
            </div>

            <button type="submit" class="w-full py-2.5 px-4 bg-teal-600 hover:bg-teal-700 text-white font-semibold text-xs rounded-xl shadow-sm transition-all duration-200 flex items-center justify-center gap-2">
                <i data-lucide="log-in" class="w-4 h-4"></i> Masuk Ke SIMRS
            </button>
        </form>

        <div class="p-3 bg-slate-50 rounded-xl border border-slate-200/80 text-[11px] text-slate-600 space-y-1">
            <div class="font-bold text-slate-800 flex items-center gap-1"><i data-lucide="help-circle" class="w-3.5 h-3.5 text-teal-600"></i> Akun Pengujian Seeder:</div>
            <div>• <strong>Super Admin</strong>: <code class="bg-slate-200 px-1 py-0.5 rounded text-slate-800">superadmin</code> / <code class="bg-slate-200 px-1 py-0.5 rounded text-slate-800">password</code></div>
            <div>• <strong>Dokter</strong>: <code class="bg-slate-200 px-1 py-0.5 rounded text-slate-800">dokter1</code> / <code class="bg-slate-200 px-1 py-0.5 rounded text-slate-800">password</code></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => lucide.createIcons());
    </script>
</body>
</html>
