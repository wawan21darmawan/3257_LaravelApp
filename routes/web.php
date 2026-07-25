<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\EventController as EventAdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\CheckoutController; 
use App\Http\Controllers\MidtransWebhookController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\PengurusController;
use App\Http\Controllers\SocialiteController; 
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\CheckInController; // <-- TAMBAHAN BARU

Route::resource('jabatan', JabatanController::class);
Route::resource('pengurus', PengurusController::class);

Route::post('/midtrans/callback', [MidtransWebhookController::class, 'handle']);

// ==========================================
// ROUTE USER AREA (Akses Publik)
// ==========================================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/event/{event}', [EventController::class, 'show'])->name('events.show');

// Area Route Checkout Publik
Route::get('/checkout/{event}', [CheckoutController::class, 'create'])->name('checkout.create');
Route::post('/checkout/{event}', [CheckoutController::class, 'store'])->name('checkout.store');

// Rute Payment & Success
Route::get('/checkout/payment/{order_id}', [CheckoutController::class, 'payment'])->name('checkout.payment');
Route::get('/checkout/success/{order_id}', [CheckoutController::class, 'success'])->name('checkout.success');

Route::get('/my-ticket', [EventController::class, 'ticket'])->name('ticket');

// ---> RUTE GOOGLE SSO <---
Route::get('auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [SocialiteController::class, 'handleGoogleCallback']);

// ==========================================
// ROUTE KHUSUS ORGANIZER (Kepanitiaan/HIMA)
// Ditaruh di atas agar terbaca sebelum route publik {id}
// ==========================================
Route::middleware(['auth', 'role:organizer'])->prefix('organizer')->name('organizer.')->group(function () {
    Route::get('dashboard', function () {
        $user = auth()->user();
        
        // Hitung total event khusus milik organizer yang sedang login
        $totalEvents = \App\Models\Event::where('user_id', $user->id)->count();
        
        $ticketsSold = \App\Models\Transaction::whereHas('event', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->where('status', 'SUCCESS')->count();

        // Ambil 5 event terbaru milik organizer ini untuk ditampilkan di tabel
        $recentEvents = \App\Models\Event::where('user_id', $user->id)
                        ->orderBy('created_at', 'desc')
                        ->get();
                        
        // Kirim data ke view
        return view('organizer.dashboard', compact('totalEvents', 'recentEvents', 'ticketsSold'));
    })->name('dashboard');
    
    // Hak pembuatan Event sekarang dialihkan ke Organizer
    Route::resource('events', EventAdminController::class); 
    
    // Hak melihat transaksi tiket event milik mereka sendiri
    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');

    // ---> TAMBAHAN BARU: Rute Check-in Scanner <---
    Route::get('events/{eventId}/scanner', [CheckInController::class, 'index'])->name('events.scanner');
    Route::post('scanner/process', [CheckInController::class, 'process'])->name('scanner.process');
});

// Route untuk melihat profil publik penyelenggara (dibatasi hanya angka agar aman)
Route::get('/organizer/{id}', [OrganizerController::class, 'show'])->name('organizer.show')->where('id', '[0-9]+');

// Rute Halaman Login Pengunjung (User)
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login.post');

Route::middleware(['auth'])->group(function () {
    Route::post('/events/{eventId}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
});


// ==========================================
// AREA AUTHENTICATION (Login Manual Sistem)
// ==========================================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login'])->name('login.post');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});


// ==========================================
// ROUTE KHUSUS SUPERADMIN
// ==========================================
Route::middleware(['auth', 'role:superadmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategoryController::class);
    Route::resource('partners', \App\Http\Controllers\Admin\PartnerController::class);
    Route::get('/chart-data', [\App\Http\Controllers\Admin\DashboardController::class, 'getChartData'])->name('chart.data');
    
    // Rute Pantau Event untuk Superadmin (Read-Only)
    Route::get('events', [EventAdminController::class, 'index'])->name('events.index');
    
    Route::get('transactions', [TransactionController::class, 'index'])->name('transactions.index');
});