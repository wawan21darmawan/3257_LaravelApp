@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h2 class="text-xl font-bold mb-4 text-slate-800">Edit Kategori: {{ $category->name }}</h2>
    
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
        <!-- PENTING: Gunakan method PUT untuk update -->
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT') 
            
            <div class="mb-4">
                <label class="block text-sm font-bold text-slate-600 mb-2">Nama Kategori</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" 
                    class="w-full border border-slate-200 px-4 py-2 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none" required>
            </div>
            
            <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition">
                Update Kategori
            </button>
        </form>
    </div>
</div>
@endsection