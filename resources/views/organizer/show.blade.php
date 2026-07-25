@extends('layouts.detail') {{-- Tetap menggunakan layout detail milikmu --}}

@section('content')
<div class="max-w-5xl mx-auto px-4 py-10 mb-20">

    <!-- ================= HEADER PROFIL PENYELENGGARA ================= -->
    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <!-- Cover Gradient -->
        <div class="h-32 md:h-40 bg-gradient-to-r from-indigo-500 to-purple-600"></div>

        <div class="px-6 md:px-10 pb-8">
            <!-- Avatar & Identitas -->
            <div class="relative flex flex-col md:flex-row justify-between md:items-end -mt-12 md:-mt-16 mb-6 gap-4">
                <div class="flex items-end gap-5">
                    <!-- Avatar Dinamis (2 Huruf Pertama) -->
                    <div class="w-24 h-24 md:w-32 md:h-32 bg-white rounded-2xl p-1 shadow-md">
                        <div class="w-full h-full bg-slate-50 border border-slate-100 rounded-xl flex items-center justify-center text-3xl md:text-5xl font-black text-indigo-300">
                            {{ strtoupper(substr($organizer->name ?? 'OR', 0, 2)) }}
                        </div>
                    </div>
                    <div class="mb-2">
                        <div class="flex items-center gap-2">
                            <!-- Nama Organizer -->
                            <h1 class="text-2xl md:text-3xl font-bold text-slate-900">
                                {{ $organizer->name ?? 'Admin Amikom' }}
                            </h1>
                            <!-- Verified Badge -->
                            <svg class="w-6 h-6 text-blue-500" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm-1.9 14.7L6 12.6l1.5-1.5 2.6 2.6 6.4-6.4 1.5 1.5-8.1 7.9z"/>
                            </svg>
                        </div>
                        <span class="text-indigo-700 font-semibold text-xs bg-indigo-50 px-3 py-1 rounded-full mt-2 inline-block">
                            Verified Organizer
                        </span>
                    </div>
                </div>
            </div>

            <!-- Stats Bar Dinamis -->
            <div class="flex gap-8 border-t border-slate-100 pt-6 mt-2">
                <div>
                    <p class="text-sm text-slate-500 font-medium mb-1">Rata-rata Rating</p>
                    <div class="flex items-center gap-2">
                        <svg class="w-6 h-6 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        <span class="text-2xl font-bold text-slate-900">
                            {{ number_format($averageRating ?? 0, 1) }} 
                            <span class="text-slate-400 text-sm font-medium">/ 5.0</span>
                        </span>
                    </div>
                </div>
                <div class="w-px bg-slate-200"></div>
                <div>
                    <p class="text-sm text-slate-500 font-medium mb-1">Total Testimoni Peserta</p>
                    <p class="text-2xl font-bold text-slate-900">
                        {{ $totalReviews ?? 0 }} 
                        <span class="text-slate-400 text-sm font-medium">Ulasan</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- ================= DAFTAR TESTIMONI ================= -->
    <div class="mt-12">
        <h2 class="text-2xl font-bold text-slate-900 mb-6">Rekam Jejak Penilaian & Testimoni</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            @forelse($reviews as $review)
                <!-- Kartu Review Dinamis -->
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-3">
                            <!-- Inisial Nama Reviewer (2 Huruf Pertama) -->
                            <div class="w-10 h-10 bg-indigo-50 text-indigo-600 font-bold rounded-full flex items-center justify-center text-sm border border-indigo-100">
                                {{ strtoupper(substr($review->user->name ?? 'AN', 0, 2)) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm line-clamp-1">
                                    {{ $review->user->name ?? 'Anonim' }}
                                </h4>
                                <span class="text-xs text-slate-400">
                                    {{ $review->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Logika Bintang Dinamis -->
                    <div class="flex gap-1 mb-4">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $review->rating)
                                <!-- Bintang Kuning (Aktif) -->
                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @else
                                <!-- Bintang Abu-abu (Tidak Aktif) -->
                                <svg class="w-4 h-4 text-slate-200" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endif
                        @endfor
                    </div>

                    <p class="text-slate-700 text-sm mb-5 leading-relaxed">
                        "{{ $review->testimonial }}"
                    </p>

                    <div class="inline-block bg-slate-50 border border-slate-100 px-3 py-1.5 rounded-lg mt-auto">
                        <p class="text-xs text-slate-500">
                            Event: <span class="font-semibold text-slate-800">{{ $review->event->title ?? 'Event' }}</span>
                        </p>
                    </div>
                </div>
            @empty
                <!-- Jika Tidak Ada Ulasan -->
                <div class="col-span-1 md:col-span-2 text-center py-10 bg-white rounded-2xl border border-slate-100 shadow-sm">
                    <p class="text-slate-500 font-medium">Belum ada ulasan untuk penyelenggara ini.</p>
                </div>
            @endforelse

        </div>
    </div>
</div>
@endsection