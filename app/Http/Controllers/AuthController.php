<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Fungsi memproses validasi Submit Log In khusus User (Peserta)
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            $user = Auth::user();

            // 1. Cek jika role-nya benar-benar 'user'
            if ($user->role === 'user') {
                return redirect()->intended('/'); // Lolos, masuk ke halaman utama
            }

            // 2. Jika 'superadmin' atau 'organizer' mencoba login dari form user biasa, tolak!
            Auth::logout();
            return back()->withErrors([
                'email' => 'Akses ditolak. Admin dan Organizer harap login melalui portal khusus.',
            ])->onlyInput('email');
        }

        // Jika email tidak ada atau password salah
        return back()->withErrors([
            'email' => 'Email atau Password yang Anda berikan tidak terdaftar di database kami.',
        ])->onlyInput('email');
    }
}