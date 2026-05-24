@extends('layouts.admin')
@section('content')
<div class="p-6">
    <h2 class="text-xl font-bold mb-4">Tambah Partner</h2>
    <form action="{{ route('admin.partners.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="mb-4">
        <label>Nama Partner</label>
        <input type="text" name="name" class="border p-2 w-full rounded" required>
    </div>
    <div class="mb-4">
        <label>Upload Logo</label>
        <!-- Perhatikan type="file" dan accept="image/*" -->
        <input type="file" name="logo" class="border p-2 w-full rounded" accept="image/*" required>
    </div>
    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Simpan Partner</button>
</form>
</div>
@endsection