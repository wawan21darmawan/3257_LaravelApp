<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Event;

class CheckInController extends Controller
{
    // Menampilkan halaman scanner web (kamera)
    public function index($eventId)
    {
        $event = Event::findOrFail($eventId);
        
        // Pastikan event ini memang milik organizer yang sedang login (opsional untuk keamanan)
        // if ($event->user_id !== auth()->id()) { abort(403); }

        return view('organizer.scanner', compact('event'));
    }

    // Memproses data hasil scan QR Code
    public function process(Request $request)
    {
        $request->validate([
            'order_id' => 'required|string',
            'event_id' => 'required|integer'
        ]);

        // Cari transaksi berdasarkan order_id dan pastikan untuk event yang benar
        // PERBAIKAN 1: Tambahkan pengecekan status SUCCESS agar tiket yang belum dibayar tidak bisa masuk
        $transaction = Transaction::where('order_id', $request->order_id)
                                  ->where('event_id', $request->event_id)
                                  ->where('status', 'SUCCESS')
                                  ->first();

        // 1. Jika tiket tidak ditemukan atau belum sukses pembayarannya
        if (!$transaction) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket tidak valid atau pembayaran belum sukses!'
            ], 200);
        }

        // 2. Jika tiket sudah pernah di-scan sebelumnya (mencegah penyusup / double entry)
        if ($transaction->is_used) {
            return response()->json([
                'success' => false,
                'message' => 'Tiket sudah digunakan sebelumnya!'
            ], 200);
        }

        // 3. Jika tiket valid dan belum di-scan, ubah statusnya
        // PERBAIKAN 2: Gunakan assignment dan save() untuk menghindari kegagalan karena $fillable di Model
        $transaction->is_used = true;
        $transaction->save(); 

        // Deteksi nama peserta (jika kolom customer_name kosong, ambil dari relasi user)
        $namaCustomer = $transaction->customer_name ?? ($transaction->user ? $transaction->user->name : 'Peserta');

        return response()->json([
            'success' => true,
            'message' => 'Check-in berhasil! Nama: ' . $namaCustomer
        ], 200);
    }
}