<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction; // Tambahkan pemanggilan model Transaction

class EventController extends Controller
{
    public function show(\App\Models\Event $event)
    {
        // Mengambil daftar kategori untuk keperluan menu footer/header
        $categories = \App\Models\Category::all();

        // 1. Buat variabel default false (dianggap belum beli)
        $hasPurchased = false; 

        // 2. Cek apakah user login dan emailnya ada di transaksi event ini
        if (Auth::check()) {
            $hasPurchased = Transaction::where('event_id', $event->id)
                ->where('customer_email', Auth::user()->email)
                ->where('status', 'Success') // Sesuaikan jika penamaan status lunasmu berbeda (misal: 'Paid' atau 'Lunas')
                ->exists();
        }

        // Me-render view dengan membawa data kategori, data spesifik acara, dan status pembelian
        return view('event-detail', compact('categories', 'event', 'hasPurchased'));
    }

    public function checkout()
    {
        return view('checkout');
    }

    public function ticket()
    {
        return view('ticket'); // halaman tiket user
    }

    public function indexAdmin()
    {
        return view('admin.events'); // halaman admin event list
    }
}