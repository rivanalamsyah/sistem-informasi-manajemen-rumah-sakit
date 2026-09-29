<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-50 light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pendaftaran Akun Baru Portal SIMRS — RSU Rajawali Citra">

    <title>Pendaftaran Akun Baru — RSU Rajawali Citra</title>

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
<body class="h-full bg-slate-50 font-sans antialiased text-slate-900 flex items-center justify-center p-4 sm:p-6 my-8">

    <main class="w-full max-w-lg bg-white rounded-2xl shadow-xl border border-slate-200 p-6 sm:p-8 space-y-6">
        {{-- Header Logo --}}
        <div class="text-center space-y-2">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center mb-1 focus:outline-none rounded-xl p-1" aria-label="Beranda Utama">
                <img src="{{ asset('logo.png') }}" alt="Logo RSU Rajawali Citra" class="h-14 sm:h-16 w-auto object-contain">
            </a>
            <h1 class="text-xl font-black text-slate-900 tracking-tight">Buat Akun Portal SIMRS</h1>
            <p class="text-xs text-slate-500 font-medium">Daftar akun mandiri untuk reservasi &amp; layanan rumah sakit online</p>
        </div>

        @if ($errors->any())
            <div class="p-3.5 bg-red-50 text-red-800 text-xs rounded-xl border border-red-200 space-y-1">
                <div class="font-bold flex items-center gap-1.5"><i data-lucide="alert-circle" class="w-4 h-4 text-red-600"></i> Mohon perbaiki kesalahan berikut:</div>
                <ul class="list-disc list-inside space-y-0.5 text-[11px]">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            {{-- Nama Lengkap --}}
            <div>
                <label for="name" class="block text-xs font-bold text-slate-700 mb-1.5">Nama Lengkap Pasien / Pengguna <span class="text-red-500">*</span></label>
                <div class="relative">
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus placeholder="Contoh: Budi Santoso"
                           class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 focus:border-blue-800 focus:bg-white focus:ring-2 focus:ring-blue-800/20 rounded-xl text-xs sm:text-sm font-medium transition">
                    <i data-lucide="user" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3"></i>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- Username --}}
                <div>
                    <label for="username" class="block text-xs font-bold text-slate-700 mb-1.5">Username <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="text" id="username" name="username" value="{{ old('username') }}" required placeholder="budi_s"
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 focus:border-blue-800 focus:bg-white focus:ring-2 focus:ring-blue-800/20 rounded-xl text-xs sm:text-sm font-medium transition">
                        <i data-lucide="at-sign" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3"></i>
                    </div>
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 mb-1.5">Alamat Email <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="budi@example.com"
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 focus:border-blue-800 focus:bg-white focus:ring-2 focus:ring-blue-800/20 rounded-xl text-xs sm:text-sm font-medium transition">
                        <i data-lucide="mail" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3"></i>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- NIK --}}
                <div>
                    <label for="nik" class="block text-xs font-bold text-slate-700 mb-1.5">NIK (KTP 16 Digit)</label>
                    <div class="relative">
                        <input type="text" id="nik" name="nik" value="{{ old('nik') }}" maxlength="16" placeholder="3402xxxxxxxxxxxx"
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 focus:border-blue-800 focus:bg-white focus:ring-2 focus:ring-blue-800/20 rounded-xl text-xs sm:text-sm font-medium transition">
                        <i data-lucide="id-card" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3"></i>
                    </div>
                </div>

                {{-- No Telepon/WhatsApp --}}
                <div>
                    <label for="phone" class="block text-xs font-bold text-slate-700 mb-1.5">No. WhatsApp / Telepon</label>
                    <div class="relative">
                        <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="08123456789"
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 focus:border-blue-800 focus:bg-white focus:ring-2 focus:ring-blue-800/20 rounded-xl text-xs sm:text-sm font-medium transition">
                        <i data-lucide="phone" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3"></i>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                {{-- Password --}}
                <div>
                    <label for="password" class="block text-xs font-bold text-slate-700 mb-1.5">Kata Sandi <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required placeholder="••••••••"
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 focus:border-blue-800 focus:bg-white focus:ring-2 focus:ring-blue-800/20 rounded-xl text-xs sm:text-sm font-medium transition">
                        <i data-lucide="lock" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3"></i>
                    </div>
                </div>

                {{-- Konfirmasi Password --}}
                <div>
                    <label for="password_confirmation" class="block text-xs font-bold text-slate-700 mb-1.5">Konfirmasi Sandi <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation" required placeholder="••••••••"
                               class="w-full pl-10 pr-4 py-2.5 bg-slate-50 border border-slate-300 focus:border-blue-800 focus:bg-white focus:ring-2 focus:ring-blue-800/20 rounded-xl text-xs sm:text-sm font-medium transition">
                        <i data-lucide="check-circle-2" class="w-4 h-4 text-slate-400 absolute left-3.5 top-3"></i>
                    </div>
                </div>
            </div>

            <button type="submit" class="w-full py-3 px-4 bg-blue-900 hover:bg-blue-800 text-white font-bold text-xs sm:text-sm rounded-xl shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer min-h-[46px] mt-2">
                <i data-lucide="user-plus" class="w-4 h-4"></i>
                <span>Daftar Akun Baru</span>
            </button>
        </form>

        <div class="text-center pt-3 border-t border-slate-100 space-y-2">
            <p class="text-xs text-slate-600">
                Sudah memiliki akun?
                <a href="{{ route('login') }}" class="font-bold text-blue-900 hover:underline">Masuk Sekarang</a>
            </p>
            <div>
                <a href="{{ route('home') }}" class="inline-flex items-center gap-1.5 text-xs text-slate-500 hover:text-blue-900 font-semibold transition py-1">
                    <i data-lucide="arrow-left" class="w-3.5 h-3.5"></i> Kembali ke Beranda Utama
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
