<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request; // WAJIB DITAMBAHKAN

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        // 1. Mulai query dasar dengan relasi 'event'
        $query = Transaction::with('event');

        // 2. Filter Pencarian Teks (Order ID, Nama, Email)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('order_id', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        // 3. Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 4. Filter Tanggal
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        // 5. Eksekusi query dengan latest dan pagination
        $transactions = $query->latest()->paginate(20);

        return view('admin.transactions.index', compact('transactions'));
    }
}