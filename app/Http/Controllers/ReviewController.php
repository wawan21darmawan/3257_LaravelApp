<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event; 
use App\Models\Review; 
use App\Models\Transaction; // <-- TAMBAHAN 1: Import model Transaction
use Carbon\Carbon;

class ReviewController extends Controller
{
    public function store(Request $request, $eventId)
    {
        $event = Event::findOrFail($eventId);

        // <-- TAMBAHAN 2: Validasi Verified Purchase (Cek kepemilikan tiket)
        $hasPurchased = Transaction::where('event_id', $eventId)
                            ->where('customer_email', auth()->user()->email)
                            ->where('status', 'Success') // Catatan: Sesuaikan jika Midtrans milikmu mengirim status 'settlement' atau yang lain
                            ->exists();

        if (!$hasPurchased) {
            return back()->with('error', 'Akses Ditolak: Anda harus membeli tiket acara ini terlebih dahulu untuk memberikan ulasan.');
        }
        // <-- AKHIR TAMBAHAN 2

        // Hitung waktu buka ulasan (H+1 dari tanggal event)
        $reviewUnlockDate = \Carbon\Carbon::parse($event->date)->addDay();

        // Jika waktu sekarang masih sebelum tanggal buka ulasan, maka blokir
        if (now()->lt($reviewUnlockDate)) {
            return back()->with('error', 'Ulasan baru dapat dikirimkan sehari setelah acara tuntas.');
        }

        // Validasi input dari form
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'testimonial' => 'required|string|max:1000',
        ]);

        // Simpan ulasan ke database
        Review::create([
            'event_id' => $event->id,
            'user_id' => auth()->id(),
            'rating' => $request->rating,
            'testimonial' => $request->testimonial,
        ]);

        return redirect()->back()->with('success', 'Terima kasih atas ulasan Anda!');
    }
}