@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Header sambutan -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Dashboard Organizer</h1>
            <p class="text-sm text-gray-600 mt-1">Halo, {{ auth()->user()->name }}! Kelola event dan pantau performa kepanitiaanmu di sini.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <a href="{{ route('organizer.events.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition shadow-sm">
                + Buat Event Baru
            </a>
        </div>
    </div>

    <!-- Kartu Statistik Singkat -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Event -->
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-indigo-50 text-indigo-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Event Saya</p>
                    <h3 class="text-xl font-bold text-gray-900 mt-1">{{ $totalEvents }}</h3>
                </div>
            </div>
        </div>

        <!-- Placeholder Tiket Terjual -->
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-emerald-50 text-emerald-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Tiket Terjual</p>
                    <p class="font-bold text-lg">{{ $ticketsSold }}</p>
                </div>
            </div>
        </div>

        <!-- Total Transaksi -->
        <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-50 text-blue-600 mr-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path></svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Riwayat Transaksi</p>
                    <a href="{{ route('organizer.transactions.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 mt-1 inline-block">Lihat Semua &rarr;</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bagian Tabel Event Terbaru -->
    <div class="bg-white shadow-sm rounded-xl border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-gray-900">Event Terbaru yang Dikelola</h3>
            <a href="{{ route('organizer.events.index') }}" class="text-sm text-indigo-600 hover:underline">Kelola Semua</a>
        </div>
        
        @if($recentEvents->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 text-gray-500 text-sm">
                            <th class="px-6 py-3 font-medium">Nama Event</th>
                            <th class="px-6 py-3 font-medium">Kategori</th>
                            <th class="px-6 py-3 font-medium">Tanggal Dibuat</th>
                            <th class="px-6 py-3 font-medium text-center">Aksi</th> <!-- TAMBAHAN: Kolom Aksi -->
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($recentEvents as $event)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $event->title ?? $event->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $event->category->name ?? 'Tanpa Kategori' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $event->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-sm text-center">
                                <!-- TAMBAHAN: Tombol Buka Scanner -->
                                <a href="{{ route('organizer.events.scanner', $event->id) }}" class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:outline-none focus:ring-indigo-300 transition duration-200 shadow-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                    </svg>
                                    Buka Scanner
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-6 text-center text-gray-500 text-sm py-12">
                Belum ada event yang ditambahkan. Silakan buat event pertamamu!
            </div>
        @endif
    </div>

</div>
@endsection