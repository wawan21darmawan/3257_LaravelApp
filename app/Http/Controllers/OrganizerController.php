<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Review;
use Illuminate\Http\Request;

class OrganizerController extends Controller
{
    public function show($id)
    {
        // Cari data organizer berdasarkan ID
        $organizer = User::findOrFail($id);

        // Ambil semua ulasan secara langsung tanpa filter user_id pada tabel events
        $reviews = Review::with(['user', 'event'])->latest()->get();

        // Hitung total ulasan dan rata-rata rating
        $totalReviews = $reviews->count();
        $averageRating = $totalReviews > 0 ? $reviews->avg('rating') : 0;

        return view('organizer.show', compact('organizer', 'reviews', 'totalReviews', 'averageRating'));
    }
}