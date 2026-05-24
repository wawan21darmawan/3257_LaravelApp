@extends('layouts.admin')

@section('title', 'Tambah Event Baru - Admin')
@section('page_title', 'Tambah Event Baru')
@section('page_subtitle', 'Masukkan detail acara baru.')

@section('content')
<div class="bg-white p-8 rounded-[2.5rem] border border-slate-100 shadow-sm max-w-3xl">

    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Judul -->
        <div>
            <label class="block text-sm font-bold mb-2">Judul Event</label>
            <input type="text" name="title" value="{{ old('title') }}" class="w-full px-5 py-4 bg-slate-50 rounded-2xl" required>
            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <!-- Kategori -->
        <div>
            <label class="block text-sm font-bold mb-2">Kategori</label>
            <select name="category_id" class="w-full px-5 py-4 bg-slate-50 rounded-2xl" required>
                <option value="">Pilih Kategori</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
                @endforeach
            </select>
        </div>

        <!-- Deskripsi -->
        <div>
            <label class="block text-sm font-bold mb-2">Deskripsi</label>
            <textarea name="description" class="w-full px-5 py-4 bg-slate-50 rounded-2xl">{{ old('description') }}</textarea>
        </div>

        <!-- Tanggal & Lokasi -->
        <div class="grid grid-cols-2 gap-6">
            <input type="datetime-local" name="date" value="{{ old('date') }}" class="px-5 py-4 bg-slate-50 rounded-2xl">
            <input type="text" name="location" value="{{ old('location') }}" placeholder="Lokasi" class="px-5 py-4 bg-slate-50 rounded-2xl">
        </div>

        <!-- Harga & Stok -->
        <div class="grid grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold mb-2">Harga</label>
                <input type="number" name="price" value="{{ old('price',0) }}" class="px-5 py-4 bg-slate-50 rounded-2xl">
            </div>
            <div>
                <label class="block text-sm font-bold mb-2">Stok</label>
                <input type="number" name="stock" value="{{ old('stock',1) }}" class="px-5 py-4 bg-slate-50 rounded-2xl">
            </div>
        </div>

        
        <!-- Tombol -->
        <div class="flex justify-between items-center pt-4">
            <a href="{{ route('admin.events.index') }}"
                class="px-6 py-3 bg-red-100 text-red-600 rounded-xl hover:bg-red-200 transition">
                Batal
            </a>

            <button type="submit" class="px-6 py-3 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection