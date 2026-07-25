<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. Fungsi menampilkan halaman view formulir
    public function showLogin() {
        return view('admin.login');
    }

    // 2. Fungsi memproses validasi Submit Log In
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Ambil data user yang sedang login
            $user = Auth::user();

            // Cek role dan arahkan ke dashboard yang sesuai
            if ($user->role === 'superadmin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'organizer') {
                return redirect()->route('organizer.dashboard');
            }

            Auth::logout();
        return back()->withErrors(['email' => 'Role tidak dikenali sistem.']);
        }

        return back()->withErrors([
            'email' => 'Email atau Password yang Anda berikan tidak terdaftar di database kami.',
        ]);
    }

    // 3. Fungsi memroses Log Out (Keluar)
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
