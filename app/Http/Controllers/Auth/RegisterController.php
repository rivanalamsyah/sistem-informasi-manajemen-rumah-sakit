<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function showRegistrationForm(): View|RedirectResponse
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('auth.register');
    }

    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:50', 'alpha_dash', 'unique:users,username'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'nik' => ['nullable', 'string', 'size:16', 'unique:users,nik'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'username' => strtolower($validated['username']),
            'email' => strtolower($validated['email']),
            'phone' => $validated['phone'] ?? null,
            'nik' => $validated['nik'] ?? null,
            'password' => Hash::make($validated['password']),
            'is_active' => true,
        ]);

        // Attach Role 'Pasien' secara default untuk registrasi mandiri publik
        $pasienRole = Role::where('name', 'Pasien')->first();
        if ($pasienRole) {
            $user->roles()->attach($pasienRole->id);
        }

        Auth::login($user);

        return redirect()->route('dashboard')
            ->with('success', 'Pendaftaran akun berhasil! Selamat datang di Portal SIMRS RSU Rajawali Citra.');
    }
}
