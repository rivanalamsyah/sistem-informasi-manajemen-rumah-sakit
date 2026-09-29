<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50 light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Lupa Kata Sandi Portal SIMRS — RSU Rajawali Citra">

    <title>Lupa Kata Sandi — RSU Rajawali Citra</title>

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
<body class="h-full bg-slate-50 font-sans antialiased text-slate-900 flex items-center justify-center p-4 sm:p-6">

    <main class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-200 p-6 sm:p-8 space-y-6">
        {{-- Header Logo --}}
        <div class="text-center space-y-2">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center mb-1 focus:outline-none rounded-xl p-1" aria-label="Beranda Utama">
                <img src="{{ asset('logo.png') }}" alt="Logo RSU Rajawali Citra" class="h-14 sm:h-16 w-auto object-contain">
            </a>
            <h1 class="text-xl font-black text-slate-900 tracking-tight">Lupa Kata Sandi</h1>
            <p class="text-xs text-slate-500 font-medium leading-relaxed">Masukkan alamat email Anda yang terdaftar untuk menerima tautan pemulihan kata sandi.</p>
        </div>

        @if (session('status'))
            <div class="p-3.5 bg-emerald-50 text-emerald-900 text-xs rounded-xl border border-emerald-200 flex items-start gap-2.5">
                <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5"></i>
                <span class="font-medium">{{ session('status') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="p-3.5 bg-red-50 text-red-800 text-xs rounded-xl border border-red-200 flex items-center gap-2.5">
                <i data-lucide="alert-circle" class="w-4 h-4 text-red-600 shrink-0"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
            @csrf

            {{-- Email --}}
            <div>
                <label for="email" class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Email Terdaftar <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@email.com"
                           class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 focus:border-blue-800 focus:bg-white focus:ring-2 focus:ring-blue-800/20 rounded-xl text-xs sm:text-sm font-medium transition">
                    <i data-lucide="mail" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3"></i>
                </div>
            </div>

            <button type="submit" class="w-full py-3 px-4 bg-blue-900 hover:bg-blue-800 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer min-h-[46px]">
                <i data-lucide="send" class="w-4 h-4"></i>
                <span>Kirim Tautan Reset Password</span>
            </button>
        </form>

        <div class="text-center pt-2 border-t border-slate-100 space-y-2">
            <p class="text-xs text-slate-600">
                Ingat kata sandi Anda?
                <a href="{{ route('login') }}" class="font-bold text-blue-900 hover:underline">Kembali ke Login</a>
            </p>
            <div>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-500 hover:text-blue-900 font-semibold transition py-1">
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Beranda Utama
                </a>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (typeof lucide !== 'undefined') { lucide.createIcons(); }
        });
    </script>
</body>
</html>
