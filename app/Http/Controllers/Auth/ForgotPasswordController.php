<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm(): View
    {
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->withErrors(['email' => 'Alamat email tersebut tidak terdaftar dalam sistem SIMRS.']);
        }

        // Simulasi pengiriman token reset password
        $token = Str::random(60);

        return back()->with('status', "Tautan reset kata sandi telah dikirim ke {$request->email}. Silakan periksa kotak masuk Anda.");
    }
}
