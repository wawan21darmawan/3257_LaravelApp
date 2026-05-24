<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Event;
use App\Models\Partner;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil semua kategori dan partner
        $categories = Category::all();
        $partners = Partner::all();

        // 2. Ambil data event (beserta relasi kategorinya)
        $query = Event::with('category');

        // 3. Logika untuk menjalankan filter kategori saat tombol diklik
        if ($request->has('category') && $request->query('category') != '') {
            $slug = $request->query('category');
            $query->whereHas('category', function($q) use ($slug) {
                $q->where('slug', $slug);
            });
        }

        // Ambil data event terbaru
        $events = $query->latest()->get();

        // 4. Kirim semua data ke tampilan welcome
        return view('welcome', compact('categories', 'partners', 'events'));
    }
}