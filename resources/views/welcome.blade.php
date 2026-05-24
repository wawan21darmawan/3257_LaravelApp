@extends('layouts.app')

@section('content')
<style>
    .hide-scroll::-webkit-scrollbar {
        display: none;
    }
    .hide-scroll {
        -ms-overflow-style: none; 
        scrollbar-width: none;  
    }
</style>

<!-- Hero Section -->
<section class="max-w-7xl mx-auto px-6 py-20 flex flex-col md:flex-row items-center gap-12">
    <div class="flex-1 space-y-8">
        <span class="inline-block px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">
            #1 Event Platform
        </span>
        <h1 class="text-5xl md:text-7xl font-extrabold leading-tight">
            Temukan & Pesan <span class="text-indigo-600">Tiket Event</span> Impianmu.
        </h1>
        <p class="text-lg text-slate-500 max-w-lg leading-relaxed">
            Dari konser musik hingga workshop teknologi, semua ada di genggamanmu. Pesan aman & cepat dengan Midtrans.
        </p>
        <div class="flex gap-4">
            <a href="#events" class="px-8 py-4 bg-indigo-600 text-white rounded-2xl font-bold text-lg shadow-xl shadow-indigo-200 hover:scale-105 transition-transform">
                Mulai Jelajah
            </a>
            <a href="#" class="px-8 py-4 border-2 border-slate-200 rounded-2xl font-bold text-lg hover:border-indigo-600 hover:text-indigo-600 transition">
                Cara Pesan
            </a>
        </div>
    </div>
    <div class="flex-1 relative">
        <div class="absolute -top-10 -left-10 w-64 h-64 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
        <div class="absolute -bottom-10 -right-10 w-64 h-64 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
        <img src="assets/concert.png" alt="Concert" class="rounded-[2rem] shadow-2xl relative z-10 w-full object-cover aspect-[4/5] object-center">

        <div class="absolute -bottom-6 -left-6 glass p-6 rounded-2xl shadow-xl z-20 border border-white bg-white/90 backdrop-blur">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-slate-500 font-bold uppercase">Terverifikasi</p>
                    <p class="font-bold">Pembayaran Aman via Midtrans</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="max-w-7xl mx-auto px-6 py-20 border-t border-slate-100">
    <div class="text-center mb-12">
        <h2 class="text-3xl font-extrabold text-slate-900 mb-4">Didukung Oleh</h2>
        <p class="text-slate-500">Partner luar biasa yang mensukseskan acara kami.</p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-6 items-center">
        @foreach($partners as $partner)
        <div class="group relative bg-white border border-slate-100 rounded-2xl p-6 flex items-center justify-center h-32 transition-all duration-500 hover:shadow-2xl hover:border-indigo-200 hover:-translate-y-2">
            
            @if($partner->logo_url)
                <img src="{{ asset('storage/' . $partner->logo_url) }}" alt="{{ $partner->name }}" 
                     class="max-h-full max-w-full object-contain grayscale group-hover:grayscale-0 transition-all duration-500 opacity-60 group-hover:opacity-100 scale-100 group-hover:scale-110">
            @endif

            <div class="absolute -bottom-8 opacity-0 group-hover:opacity-100 group-hover:bottom-4 transition-all duration-300 bg-indigo-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg pointer-events-none">
                {{ $partner->name }}
            </div>
        </div>
        @endforeach
    </div>
</section>

<!-- Events Grid -->
<section id="events" class="max-w-7xl mx-auto px-6 py-20">
    <div class="relative mb-16 overflow-hidden rounded-[2rem] bg-white border border-slate-100 shadow-sm p-10">

        <!-- Blue Blur Background -->
        <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-r from-indigo-400/10 via-blue-400/10 to-purple-400/10 blur-3xl"></div>

        <div class="relative z-10 flex flex-col lg:flex-row lg:items-center justify-between gap-8">

            <!-- Text Area -->
            <div class="lg:w-1/3 shrink-0">
                <span class="inline-block px-4 py-2 bg-indigo-100 text-indigo-700 rounded-full text-xs font-bold uppercase tracking-widest mb-4">
                    Upcoming Events
                </span>
                <h2 class="text-4xl font-black text-slate-900 mb-3">
                    Event <span class="text-indigo-600">Terdekat</span>
                </h2>
                <p class="text-slate-500 text-lg leading-relaxed">
                    Temukan konser, seminar, workshop, dan berbagai acara menarik.
                </p>
            </div>

            <!-- Filter Area (Bisa digeser) -->
            <div class="lg:w-2/3 w-full overflow-hidden relative">
                <div class="absolute right-0 top-0 bottom-0 w-12 bg-gradient-to-l from-white to-transparent pointer-events-none z-10"></div>
                
                <div class="flex flex-nowrap overflow-x-auto gap-3 pb-2 pt-2 hide-scroll scroll-smooth snap-x">

                    <!-- Semua -->
                    <a href="/"
                        class="shrink-0 snap-start px-5 py-3 rounded-2xl font-semibold text-sm transition-all duration-300
                    {{ request('category') == '' || !request()->has('category') 
                        ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200' 
                        : 'bg-white border border-indigo-100 text-indigo-600 hover:bg-indigo-600 hover:text-white' }}">
                        Semua
                    </a>

                    @foreach($categories as $cat)
                    <a href="/?category={{ $cat->slug }}"
                        class="shrink-0 snap-start px-5 py-3 rounded-2xl font-semibold text-sm transition-all duration-300
                    {{ request('category') == $cat->slug 
                        ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200'
                        : 'bg-white border border-indigo-100 text-indigo-600 hover:bg-indigo-600 hover:text-white' }}">
                        {{ $cat->name }}
                    </a>
                    @endforeach

                </div>
            </div>
        </div>
    </div>

    <!-- Zona Menampilkan Grid List Event -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($events as $event)
        <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden flex flex-col">
            <div class="relative overflow-hidden aspect-[3/4] bg-slate-100">
                <img src="https://placehold.co/200x600" alt="{{ $event->title }}"
                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute top-4 left-4 px-3 py-1 bg-white/90 backdrop-blur rounded-lg text-xs font-bold uppercase text-indigo-600">
                    {{ $event->category->name }}
                </div>
            </div>
            <div class="p-6 flex flex-col flex-1 justify-between">
                <div>
                    <h3 class="text-xl font-bold mb-2 group-hover:text-indigo-600 transition">{{ $event->title }}</h3>
                    <div class="flex items-center gap-2 text-slate-500 text-sm mb-4">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($event->date)->format('d-m-Y H:i') }}</span>
                    </div>
                </div>
                <div class="flex justify-between items-center pt-4 border-t mt-auto">
                    <span class="text-2xl font-black text-indigo-600">Rp {{ number_format($event->price, 0, ',', '.') }}</span>
                    <a href="{{ url('event/1') }}" class="px-5 py-2 bg-indigo-50 text-indigo-600 rounded-xl font-bold hover:bg-indigo-600 hover:text-white transition whitespace-nowrap">
                        Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>
@endsection