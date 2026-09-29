<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function showLoginForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'login' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        $loginType = filter_var($credentials['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$loginType => $credentials['login'], 'password' => $credentials['password']], $request->boolean('remember'))) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Periksa status aktif akun setelah berhasil authenticate
            if (! $user->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                // Catat percobaan login akun nonaktif
                \App\Models\UserLogin::create([
                    'user_id' => $user->id,
                    'login_at' => now(),
                    'ip_address' => $request->ip(),
                    'user_agent' => substr($request->userAgent() ?? '', 0, 250),
                    'browser' => 'Web Browser',
                    'device' => 'Desktop/Mobile',
                    'status' => 'Ditolak — Akun Nonaktif',
                ]);

                return back()->withErrors([
                    'login' => 'Akun Anda telah dinonaktifkan. Hubungi Administrator sistem untuk informasi lebih lanjut.',
                ])->onlyInput('login');
            }

            // Update user last login
            $user->update(['last_login_at' => now()]);

            // Catat UserLogin berhasil
            \App\Models\UserLogin::create([
                'user_id' => $user->id,
                'login_at' => now(),
                'ip_address' => $request->ip(),
                'user_agent' => substr($request->userAgent() ?? '', 0, 250),
                'browser' => 'Web Browser',
                'device' => 'Desktop/Mobile',
                'status' => 'Sukses',
            ]);

            // Catat ActivityLog
            \App\Models\ActivityLog::create([
                'user_id' => $user->id,
                'module' => 'Authentication',
                'action' => 'Login',
                'description' => "Pengguna {$user->name} berhasil masuk ke sistem.",
                'ip_address' => $request->ip(),
            ]);

            return redirect()->intended(route('dashboard'))
                ->with('success', 'Selamat datang kembali! Login berhasil diselesaikan.');
        }

        return back()->withErrors([
            'login' => 'Username/Email atau Password yang Anda masukkan tidak sesuai.',
        ])->onlyInput('login');
    }

    public function logout(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if ($user) {
            // Update UserLogin logout_at
            \App\Models\UserLogin::where('user_id', $user->id)
                ->whereNull('logout_at')
                ->latest()
                ->first()?->update(['logout_at' => now()]);

            // Catat ActivityLog
            \App\Models\ActivityLog::create([
                'user_id' => $user->id,
                'module' => 'Authentication',
                'action' => 'Logout',
                'description' => "Pengguna {$user->name} keluar dari sistem.",
                'ip_address' => $request->ip(),
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('info', 'Anda telah berhasil keluar dari sistem.');
    }
}
