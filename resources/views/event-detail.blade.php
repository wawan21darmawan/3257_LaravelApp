@extends('layouts.detail')

@section('content')

<main class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 lg:grid-cols-3 gap-12">
    <div class="lg:col-span-1">
        <div class="sticky top-32">
            
            <img src="{{ ($event->poster_path && Storage::disk('public')->exists($event->poster_path))
                ? asset('storage/' . $event->poster_path)
                : 'https://placehold.co/200x600' }}" alt="{{ $event->title }}" 
                  class="w-full rounded-[2.5rem] shadow-2xl border-8 border-white object-cover aspect-[3/4]">
            
            <!-- KOTAK PENYELENGGARA YANG SUDAH DIBERI TAUTAN KE PROFIL -->
            <a href="{{ route('organizer.show', $event->user_id) }}" class="block mt-8 group">
                <div class="p-6 bg-white rounded-3xl border border-slate-100 shadow-sm group-hover:border-indigo-300 transition-all">
                    <h4 class="font-bold mb-4 text-slate-800 group-hover:text-indigo-600 transition-colors flex items-center justify-between">
                        <span>Penyelenggara</span>
                        <svg class="w-4 h-4 text-indigo-600 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </h4>
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold uppercase">
                            {{ substr($event->user->name ?? 'AB', 0, 2) }}
                        </div>
                        <div>
                            <p class="font-bold text-slate-800">{{ $event->user->name ?? 'ABP Productions' }}</p>
                            <p class="text-xs text-slate-500">Verified Organizer • Klik untuk lihat profil</p>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="lg:col-span-2 space-y-12">
        <div class="space-y-4">
            
            <span class="px-4 py-1.5 bg-indigo-100 text-indigo-700 rounded-full text-sm font-bold uppercase tracking-wider">
                {{ $event->category?->name }}
            </span>
            
            <h1 class="text-4xl md:text-5xl font-black leading-tight">{{ $event->title }}</h1>
            
            <div class="flex flex-wrap gap-6 text-slate-500 font-medium">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span>{{ \Carbon\Carbon::parse($event->date)->format('d M Y, H:i') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                        </path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span>{{ $event->location }}</span>
                </div>
            </div>
        </div>

        <div class="prose prose-slate max-w-none">
            <h3 class="text-2xl font-bold mb-4">Deskripsi Event</h3>
            
            <p class="text-lg text-slate-600 leading-relaxed whitespace-pre-line">
                {{ $event->description }}
            </p>
        </div>

        <div class="bg-indigo-600 rounded-[2.5rem] p-8 md:p-12 text-white shadow-2xl shadow-indigo-200 relative overflow-hidden">
            <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-8">
                <div>
                    <p class="text-indigo-200 font-bold uppercase tracking-widest text-sm mb-2">Harga Tiket</p>
                    
                    <h2 class="text-5xl font-black">Rp {{ number_format($event->price, 0, ',', '.') }} <span class="text-lg font-medium text-indigo-200">/ orang</span></h2>
                    
                    <p class="mt-4 text-indigo-100 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        
                        Sisa stok: <span class="font-bold underline">{{ $event->stock }} Tiket lagi!</span>
                    </p>
                </div>
                <div>
                    
                    <a href="{{ url('checkout/'.$event->id) }}"
                        class="inline-block px-10 py-5 bg-white text-indigo-600 rounded-2xl font-black text-xl hover:scale-105 transition-transform shadow-xl">
                        Pesan Sekarang
                    </a>
                    
                </div>
            </div>
            <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-white opacity-10 rounded-full"></div>
            <div class="absolute -left-10 -top-10 w-32 h-32 bg-indigo-400 opacity-20 rounded-full"></div>
        </div>

        <div class="space-y-4">
            <h3 class="text-xl font-bold">Kebijakan Tiket</h3>
            <ul class="space-y-3 text-slate-500">
                <li class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-green-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    E-Ticket akan dikirimkan otomatis setelah pembayaran berhasil.
                </li>
                <li class="flex items-start gap-2">
                    <svg class="w-5 h-5 text-green-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Tiket dapat discan di pintu masuk (Check-in).
                </li>
                <li class="flex items-start gap-2 text-rose-500">
                    <svg class="w-5 h-5 text-rose-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Tiket yang sudah dibeli tidak dapat direfund.
                </li>
            </ul>
        </div>

        <!-- MULAI BAGIAN FORM ULASAN DAN RATING -->
        <hr class="border-slate-200 my-8">

        <div class="space-y-6">
            <h3 class="text-2xl font-bold">Ulasan & Penilaian</h3>

            <!-- BLOK NOTIFIKASI -->
            @if (session('success'))
                <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-700 font-bold mb-6 flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 font-bold mb-6 flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 mb-6">
                    <ul class="list-disc pl-5 font-medium space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <!-- BLOK NOTIFIKASI SELESAI -->

            @php
                // Menghitung H+1 dari tanggal acara
                $reviewUnlockDate = \Carbon\Carbon::parse($event->date)->addDay();
            @endphp

            @auth
                @if($hasPurchased)
                    @if(now()->gte($reviewUnlockDate))
                        <!-- Form akan muncul jika sudah Beli & sudah H+1 -->
                        <form action="{{ route('reviews.store', $event->id) }}" method="POST" class="bg-slate-50 p-6 md:p-8 rounded-[2rem] border border-slate-100 shadow-sm">
                            @csrf
                            
                            <div class="mb-6">
                                <label class="block text-slate-700 font-bold mb-3">Beri Rating (1-5)</label>
                                <select name="rating" class="w-full md:w-1/2 bg-white border border-slate-300 text-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" required>
                                    <option value="">Pilih Bintang...</option>
                                    <option value="5">5 - Sangat Memuaskan ⭐⭐⭐⭐⭐</option>
                                    <option value="4">4 - Memuaskan ⭐⭐⭐⭐</option>
                                    <option value="3">3 - Cukup ⭐⭐⭐</option>
                                    <option value="2">2 - Kurang ⭐⭐</option>
                                    <option value="1">1 - Sangat Kurang ⭐</option>
                                </select>
                            </div>

                            <div class="mb-6">
                                <label class="block text-slate-700 font-bold mb-3">Bagaimana pengalamanmu?</label>
                                <textarea name="testimonial" rows="4" class="w-full bg-white border border-slate-300 text-slate-700 rounded-xl px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent" placeholder="Ceritakan keseruanmu di acara ini..."></textarea>
                            </div>

                            <button type="submit" class="px-8 py-4 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200">
                                Kirim Ulasan Sekarang
                            </button>
                        </form>
                    @else
                        <!-- Pesan Terkunci jika belum H+1 -->
                        <div class="bg-indigo-50 text-indigo-700 p-6 rounded-[2rem] border border-indigo-100 flex flex-col md:flex-row items-start md:items-center gap-4">
                            <div class="p-3 bg-indigo-100 rounded-full flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold text-lg">Form Ulasan Belum Dibuka</p>
                                <p class="text-indigo-600 mt-1">Kamu baru bisa memberikan ulasan pada <strong class="font-bold">{{ $reviewUnlockDate->format('d M Y, H:i') }}</strong> (sehari setelah acara selesai).</p>
                            </div>
                        </div>
                    @endif
                @else
                    <!-- JIKA USER LOGIN TAPI BELUM BELI TIKET -->
                    <div class="bg-rose-50 text-rose-700 p-6 rounded-[2rem] border border-rose-100 flex flex-col md:flex-row items-start md:items-center gap-4">
                        <div class="p-3 bg-rose-100 rounded-full flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-lg">🔒 Ulasan Terkunci</p>
                            <p class="text-rose-600 mt-1">Hanya peserta yang telah berhasil <strong>membeli tiket</strong> yang dapat memberikan ulasan untuk acara ini.</p>
                        </div>
                    </div>
                @endif
            @else
                <!-- JIKA USER BELUM LOGIN SAMA SEKALI -->
                <div class="bg-slate-50 text-slate-700 p-6 rounded-[2rem] border border-slate-200 text-center">
                    <p class="mb-0">Silakan <a href="{{ route('login') }}" class="text-indigo-600 font-bold hover:underline">Login</a> terlebih dahulu untuk memberikan ulasan.</p>
                </div>
            @endauth
        </div>

        <!-- MULAI BAGIAN MENAMPILKAN HASIL ULASAN -->
        <hr class="border-slate-200 my-8">
        
        <div class="space-y-6">
            <h3 class="text-xl font-bold">Apa Kata Mereka?</h3>

            @if($event->reviews && $event->reviews->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($event->reviews as $review)
                        <div class="p-6 bg-white border border-slate-200 rounded-2xl shadow-sm">
                            <div class="flex items-center gap-3 mb-3">
                                <!-- Avatar inisial user -->
                                <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold uppercase">
                                    {{ substr($review->user->name ?? 'A', 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800">{{ $review->user->name ?? 'Anonim' }}</p>
                                    <div class="flex text-yellow-400 text-sm">
                                        <!-- Looping Bintang sesuai rating -->
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                ⭐
                                            @else
                                                <span class="text-slate-200">★</span>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <p class="text-slate-600 italic">"{{ $review->testimonial }}"</p>
                            <p class="text-xs text-slate-400 mt-3">{{ $review->created_at->diffForHumans() }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-6 bg-slate-50 border border-slate-100 rounded-2xl text-center">
                    <p class="text-slate-500">Belum ada ulasan untuk event ini. Jadilah yang pertama memberikan ulasan!</p>
                </div>
            @endif
        </div>
        <!-- SELESAI BAGIAN MENAMPILKAN HASIL ULASAN -->

    </div>
</main>

@endsection