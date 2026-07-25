<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Transaction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\EventTicketMail;

class CheckoutController extends Controller
{
    public function create(Event $event)
    {
        $categories = Category::all();
        return view('checkout.create', compact('event', 'categories'));
    }

    public function payment($order_id)
    {
        $categories = Category::all();
        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();
        return view('checkout.payment', compact('transaction', 'categories'));
    }

    public function store(Request $request, Event $event)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
        ]);

        if ($event->stock <= 0) {
            return back()->with('error', 'Mohon maaf, tiket untuk acara ini sudah habis.');
        }

        $orderId = 'TRX-' . time() . '-' . Str::random(5);
        
        // Cek harga: Jika berbayar tambah admin 5000, jika gratis tetap 0
        $totalPrice = $event->price > 0 ? $event->price + 5000 : 0;

        $transaction = Transaction::create([
            'event_id' => $event->id,
            'order_id' => $orderId,
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'total_price' => $totalPrice,
            'status' => 'Pending',
        ]);

        // ==========================================
        // LOGIKA BYPASS UNTUK EVENT GRATIS
        // ==========================================
        if ($totalPrice == 0) {
            // Langsung ubah status jadi sukses
            $transaction->update(['status' => 'success']);
            
            // Kurangi stok
            $event->decrement('stock');
            
            // Kirim Email E-Ticket
            try {
                Mail::to($transaction->customer_email)
                    ->send(new EventTicketMail($transaction));
            } catch (\Exception $e) {
                Log::error('Gagal mengirim email E-Ticket (Event Gratis): ' . $e->getMessage());
            }

            // Arahkan langsung ke halaman sukses (Lompati Midtrans)
            return redirect()->action([CheckoutController::class, 'success'], ['order_id' => $transaction->order_id])
                             ->with('success', 'Pendaftaran event gratis berhasil!');
        }

        // ==========================================
        // LOGIKA STANDAR UNTUK EVENT BERBAYAR (MIDTRANS)
        // ==========================================
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => $request->customer_name,
                'email' => $request->customer_email,
                'phone' => $request->customer_phone,
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $transaction->update(['snap_token' => $snapToken]);
            return redirect()->route('checkout.payment', $transaction->order_id);
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses pembayaran jaringan: ' . $e->getMessage());
        }
    }

    public function success($order_id)
    {
        // Mengambil daftar kategori untuk keperluan menu footer
        $categories = Category::all();

        $transaction = Transaction::with('event')->where('order_id', $order_id)->firstOrFail();
        
        // ==========================================
        // PENCEGAHAN ERROR API MIDTRANS UNTUK EVENT GRATIS
        // ==========================================
        // Jika total harga 0, langsung tampilkan halaman sukses tanpa memanggil API Midtrans
        if ($transaction->total_price == 0) {
            return view('checkout.success', compact('transaction', 'categories'));
        }

        // Konfigurasi Midtrans untuk mengecek status transaksi langsung ke API (Untuk event berbayar)
        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        try {
            // Mengecek status pesanan secara mandiri
            $status = \Midtrans\Transaction::status($order_id);
            
            if ($status) {
                // Mengambil nilai status transaksi
                $trx_status = is_array($status) ? ($status['transaction_status'] ?? '') : ($status->transaction_status ?? '');
                
                // Jika API Midtrans mengonfirmasi bahwa transaksi telah berhasil (settlement / capture)
                if (in_array($trx_status, ['settlement', 'capture'])) {
                    // Hanya lakukan update jika status di database lokal masih 'pending'
                    if (strtolower($transaction->status) === 'pending') {
                        $transaction->update(['status' => 'success']);
                        
                        if ($transaction->event && $transaction->event->stock > 0) {
                            $transaction->event->stock = $transaction->event->stock - 1;
                            $transaction->event->save();
                            
                            try {
                                Mail::to($transaction->customer_email)
                                    ->send(new EventTicketMail($transaction));
                            } catch (\Exception $e) {
                                Log::error('Gagal mengirim email E-Ticket secara manual: ' . $e->getMessage());
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            return redirect()->route('home')->with('error', 'Transaksi tidak ditemukan atau gagal diproses oleh sistem pembayaran.');
        }

        return view('checkout.success', compact('transaction', 'categories'));
    }
}