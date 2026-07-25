<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    // Fungsi 1: Menampilkan halaman Dashboard beserta kotak statisnya
    public function index()
    {
        $totalRevenue = Transaction::whereIn('status', ['settlement', 'success'])->sum('total_price');
        $ticketsSold = Transaction::whereIn('status', ['settlement', 'success'])->count();
        $activeEvents = Event::where('date', '>=', now())->count();
        $totalEvents = Event::count();
        $pendingOrders = Transaction::where('status', 'pending')->count();
        $recentTransactions = Transaction::with('event')->latest()->take(5)->get();

        // Kita tidak lagi melempar data grafik dari sini!
        return view('admin.dashboard', compact(
            'totalRevenue', 
            'ticketsSold', 
            'activeEvents', 
            'totalEvents', 
            'pendingOrders', 
            'recentTransactions'
        ));
    }

    // Fungsi 2: API Khusus untuk mengambil data grafik secara Real-Time (AJAX)
    public function getChartData(Request $request)
    {
        // Tangkap pilihan dropdown dari frontend, default ke '7days'
        $filter = $request->query('filter', '7days');
        
        $labels = [];
        $data = [];

        if ($filter === '7days') {
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i)->format('Y-m-d');
                $labels[] = Carbon::parse($date)->translatedFormat('d M');
                $data[] = Transaction::whereDate('created_at', $date)
                    ->whereIn('status', ['settlement', 'success'])
                    ->sum('total_price');
            }
        } 
        elseif ($filter === '30days') {
            for ($i = 29; $i >= 0; $i--) {
                $date = Carbon::now()->subDays($i)->format('Y-m-d');
                $labels[] = Carbon::parse($date)->translatedFormat('d M');
                $data[] = Transaction::whereDate('created_at', $date)
                    ->whereIn('status', ['settlement', 'success'])
                    ->sum('total_price');
            }
        } 
        elseif ($filter === 'year') {
            // Jika setahun, kelompokkan per bulan
            for ($i = 1; $i <= 12; $i++) {
                // Set bahasa ke Indonesia (opsional, tergantung config Laravel-mu)
                $month = Carbon::create(Carbon::now()->year, $i, 1);
                $labels[] = $month->translatedFormat('F'); // Januari, Februari, dst
                
                $data[] = Transaction::whereYear('created_at', Carbon::now()->year)
                    ->whereMonth('created_at', $i)
                    ->whereIn('status', ['settlement', 'success'])
                    ->sum('total_price');
            }
        }

        // Kembalikan ke frontend dalam bentuk JSON murni
        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }
}