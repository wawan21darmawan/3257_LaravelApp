@extends('layouts.admin')
@section('content')
<div class="p-6">
    <h2 class="text-xl font-bold mb-4">Tambah Kategori</h2>
    <form action="{{ route('admin.categories.store') }}" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Nama Kategori" class="border p-2 w-full rounded" required>
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 mt-4 rounded">Simpan</button>
    </form>
</div>
@endsection