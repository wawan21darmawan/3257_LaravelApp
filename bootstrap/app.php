<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request; // <-- TAMBAHAN: Jangan lupa import Request di sini

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        
        // 1. Alias Middleware 
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class, // Kode Asli Kamu
            'role' => \App\Http\Middleware\RoleMiddleware::class,   // Tambahan Baru untuk Multi-Tenant (SaaS)
        ]);

        // 2. Pengecualian blokir CSRF untuk Webhook Midtrans (Tambahan Modul)
        $middleware->validateCsrfTokens(except: [
            '/midtrans/callback',
        ]);
        
        // 3. Logika Redirect Dinamis untuk User yang Belum Login (TAMBAHAN BARU)
        $middleware->redirectGuestsTo(function (Request $request) {
            // Jika URL yang diakses mengandung 'admin' atau 'organizer'
            if ($request->is('admin') || $request->is('admin/*') || $request->is('organizer') || $request->is('organizer/*')) {
                // Arahkan ke portal login admin
                // (Pastikan route login admin kamu punya penamaan: ->name('admin.login'))
                return route('admin.login'); 
            }
            
            // Jika URL lain, arahkan ke portal login user biasa
            return route('login'); 
        });
        
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();