<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        // 2. Cek apakah role user sesuai
        if ($user->role !== $role) {
            // JANGAN PAKAI ABORT. Kita kirim view error dengan status 200 agar Nginx tenang.
            return response()->view('errors.403', [
                'message' => 'Akses Ditolak! Halaman ini hanya diperuntukkan bagi ' . ucfirst($role) . '.'
            ], 200);
        }

        // 3. Khusus untuk Organizer, cek apakah akunnya sudah di-approve
        if ($role === 'organizer' && $user->organizer_status !== 'approved') {
            // Sama seperti di atas, kirim view error dengan status 200.
            return response()->view('errors.403', [
                'message' => 'Akun Organizer kamu sedang menunggu persetujuan Superadmin atau telah ditolak.'
            ], 200);
        }

        return $next($request);
    }
}