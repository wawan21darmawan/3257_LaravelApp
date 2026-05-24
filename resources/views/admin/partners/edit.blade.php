@extends('layouts.admin')

@section('title', 'Edit Partner')
@section('page_title', 'Edit Partner')
@section('page_subtitle', 'Ubah data partner event')

@section('content')
<div class="p-6 w-full">
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
        
        <!-- Penting: enctype="multipart/form-data" agar file upload bisa jalan -->
        <form action="{{ route('admin.partners.update', $partner->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT') <!-- Wajib untuk proses Update -->

            <div class="mb-4">
                <label class="block text-sm font-bold text-slate-700 mb-2">Nama Partner</label>
                <input type="text" name="name" value="{{ old('name', $partner->name) }}" 
                    class="w-full border border-slate-200 px-4 py-2 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none" required>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-bold text-slate-700 mb-2">Ganti Logo (Opsional)</label>
                
                <!-- Menampilkan logo lama -->
                @if($partner->logo_url)
                    <div class="mb-2">
                        <img src="{{ asset('storage/' . $partner->logo_url) }}" alt="Logo" class="w-20 h-20 object-contain rounded-lg border">
                    </div>
                @endif
                
                <input type="file" name="logo" class="w-full border border-slate-200 px-4 py-2 rounded-xl">
                <p class="text-xs text-slate-400 mt-1">Kosongkan jika tidak ingin mengganti logo.</p>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-6 py-2.5 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.partners.index') }}" class="px-6 py-2.5 bg-slate-100 text-slate-700 rounded-xl font-bold hover:bg-slate-200 transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection