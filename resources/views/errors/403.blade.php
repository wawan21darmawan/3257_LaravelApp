@extends('layouts.app') 

@section('content')
<div class="container mx-auto px-4 py-16 text-center">
    <h1 class="text-5xl font-black text-red-600 mb-4">403</h1>
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Akses Ditolak</h2>
    <p class="text-gray-600 mb-8">{{ $message }}</p>
    
    <a href="/" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-full">
        Kembali ke Beranda
    </a>
</div>
@endsection