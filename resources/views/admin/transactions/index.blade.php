@extends('layouts.admin')
@section('title', 'Laporan Transaksi - Admin')
@section('page_title', 'Laporan Transaksi')
@section('page_subtitle', 'Pantau arus kas dan penjualan tiket Anda secara real-time.')

@section('content')

{{-- Kalkulasi Data Asli --}}
@php
    $statTotal = \App\Models\Transaction::count();
    $statRevenue = \App\Models\Transaction::whereIn('status', ['success', 'settlement'])->sum('total_price');
    $statSuccess = \App\Models\Transaction::whereIn('status', ['success', 'settlement'])->count();
    $statPending = \App\Models\Transaction::where('status', 'pending')->count();
@endphp

<div class="w-full pb-10">

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        
        <div class="p-6 rounded-2xl bg-gradient-to-br from-indigo-500 to-purple-600 shadow-lg shadow-indigo-200 text-white relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-xs font-semibold text-indigo-100 mb-1 uppercase tracking-wider">Total Transaksi</p>
                <h3 class="text-3xl font-black">{{ number_format($statTotal, 0, ',', '.') }}</h3>
            </div>
            <svg class="absolute -bottom-4 -right-2 w-24 h-24 text-white opacity-10" fill="currentColor" viewBox="0 0 24 24"><path d="M13 2h-2v6h2V2zm0 14h-2v6h2v-6zm9-5H22v-2h-8v2h8zM4 11H2v2h2v-2z"/></svg>
        </div>

        <div class="p-6 rounded-2xl bg-gradient-to-br from-emerald-400 to-teal-500 shadow-lg shadow-emerald-200 text-white relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-xs font-semibold text-emerald-100 mb-1 uppercase tracking-wider">Pendapatan</p>
                <h3 class="text-3xl font-black"><span class="text-lg font-bold mr-1">Rp</span>{{ number_format($statRevenue, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="p-6 rounded-2xl bg-gradient-to-br from-blue-400 to-blue-600 shadow-lg shadow-blue-200 text-white relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-xs font-semibold text-blue-100 mb-1 uppercase tracking-wider">Success</p>
                <h3 class="text-3xl font-black">{{ number_format($statSuccess, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="p-6 rounded-2xl bg-gradient-to-br from-orange-400 to-amber-500 shadow-lg shadow-orange-200 text-white relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-xs font-semibold text-orange-100 mb-1 uppercase tracking-wider">Pending</p>
                <h3 class="text-3xl font-black">{{ number_format($statPending, 0, ',', '.') }}</h3>
            </div>
        </div>

    </div>

    <!-- ===== BUNGKUSAN FILTER DIUBAH MENJADI FORM ===== -->
    <form method="GET" action="{{ url()->current() }}" class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm mb-6 flex flex-wrap gap-4 items-center justify-between">
        <div class="flex flex-wrap gap-3 w-full md:w-auto flex-1">
            
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search order / nama / email..." class="bg-slate-50 border border-slate-200 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 w-full md:w-64">
            
            <select name="event_id" class="bg-slate-50 border border-slate-200 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:border-indigo-500 text-slate-600">
                <option value="">Semua Event</option>
                <!-- Nanti ditambahkan looping data events di sini jika diperlukan -->
            </select>
            
            <select name="status" class="bg-slate-50 border border-slate-200 text-sm rounded-xl px-4 py-2.5 focus:outline-none focus:border-indigo-500 text-slate-600">
                <option value="">Semua Status</option>
                <option value="success" {{ request('status') == 'success' ? 'selected' : '' }}>Success</option>
                <option value="settlement" {{ request('status') == 'settlement' ? 'selected' : '' }}>Settlement</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
            </select>

            <input type="date" name="date" value="{{ request('date') }}" class="bg-slate-50 border border-slate-200 text-sm rounded-xl px-4 py-2.5 text-slate-500 focus:outline-none focus:border-indigo-500">
        </div>
        
        <div class="flex gap-2 w-full md:w-auto">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold py-2.5 px-6 rounded-xl transition shadow-sm">
                Cari
            </button>
            <a href="{{ url()->current() }}" class="inline-block bg-white border border-slate-200 hover:bg-slate-50 text-slate-600 text-sm font-bold py-2.5 px-6 rounded-xl transition text-center">
                Reset
            </a>
        </div>
    </form>
    <!-- ===== AKHIR FORM FILTER ===== -->

    <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-slate-100">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-800 text-white text-[11px] font-bold uppercase tracking-widest">
                    <tr>
                        <th class="px-6 py-4 pl-8">Order ID</th>
                        <th class="px-6 py-4">Customer</th>
                        <th class="px-6 py-4">Event</th>
                        <th class="px-6 py-4 text-center">Tanggal</th>
                        <th class="px-6 py-4 text-center">Status</th>
                        <th class="px-6 py-4 pr-8 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($transactions as $trx)
                    <tr class="hover:bg-slate-50 transition duration-150">
                        
                        <td class="px-6 py-4 pl-8 align-middle">
                            <span class="text-indigo-600 font-mono text-xs font-bold bg-indigo-50 px-2 py-1 rounded-md">
                                {{ $trx->order_id }}
                            </span>
                        </td>
                        
                        <td class="px-6 py-4 align-middle">
                            <p class="font-bold text-slate-800 text-sm">{{ $trx->customer_name }}</p>
                            <p class="text-xs text-slate-400">{{ $trx->customer_email }}</p>
                        </td>
                        
                        <td class="px-6 py-4 align-middle">
                            <span class="text-sm font-semibold text-slate-600">
                                {{ $trx->event->title ?? '-' }}
                            </span>
                        </td>
                        
                        <td class="px-6 py-4 align-middle text-center text-xs text-slate-500">
                            {{ $trx->created_at->format('d M Y, H:i') }}
                        </td>
                        
                        <td class="px-6 py-4 align-middle text-center">
                            @if($trx->status === 'settlement' || $trx->status === 'success')
                                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-[10px] font-bold uppercase">Success</span>
                            @elseif($trx->status === 'pending')
                                <span class="px-3 py-1 bg-orange-100 text-orange-700 rounded-full text-[10px] font-bold uppercase">Pending</span>
                            @else
                                <span class="px-3 py-1 bg-rose-100 text-rose-700 rounded-full text-[10px] font-bold uppercase">{{ $trx->status }}</span>
                            @endif
                        </td>
                        
                        <td class="px-6 py-4 pr-8 align-middle text-right font-black text-slate-800">
                            Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                        </td>
                        
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-10 text-center text-slate-400">
                            Belum ada transaksi tiket.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-8 py-4 bg-slate-50/50 border-t border-slate-100">
            <!-- PENTING: Tambahan appends agar filter tidak hilang saat pindah halaman -->
            {{ $transactions->appends(request()->query())->links() }}
        </div>
    </div>
</div>
@endsection