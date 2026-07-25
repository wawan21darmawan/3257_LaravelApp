<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class SocialiteController extends Controller
{
    // Mengalihkan pengguna ke halaman login Google
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Menangani balikan/callback dari Google setelah login sukses
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Cek apakah user dengan email ini sudah ada
            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                // Jika user sudah ada, update google_id-nya dan login
                $user->update([
                    'google_id' => $googleUser->id,
                ]);
            } else {
                // Jika belum ada, buat user baru
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    // Beri password acak karena dia login via Google
                    'password' => Hash::make(Str::random(24)) 
                ]);
            }

            // Daftarkan session login
            Auth::login($user);

            // Arahkan ke halaman utama atau dashboard
            return redirect('/')->with('success', 'Berhasil Login dengan Google!');

        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Gagal login menggunakan Google. Silakan coba lagi.');
        }
    }
}