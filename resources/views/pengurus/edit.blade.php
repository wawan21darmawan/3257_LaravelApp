@extends('layouts.app') @section('content')
<div class="bg-white p-6 rounded-lg shadow-md mb-6 max-w-lg">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Edit Pengurus</h2>
    
    <form action="{{ route('pengurus.update', $pengurus->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Pengurus</label>
            <input type="text" name="name" value="{{ $pengurus->name }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Jabatan</label>
            <select name="jabatan_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="">-- Pilih Jabatan --</option>
                @foreach($jabatan as $jbt)
                    <option value="{{ $jbt->id }}" {{ $pengurus->jabatan_id == $jbt->id ? 'selected' : '' }}>
                        {{ $jbt->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
            <input type="text" name="description" value="{{ $pengurus->description }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 text-sm font-bold mb-2">Gaji (Salary)</label>
            <input type="number" name="salary" value="{{ (int)$pengurus->salary }}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
        </div>
        
        <div class="flex items-center justify-between">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Update Data
            </button>
            <a href="{{ route('pengurus.index') }}" class="text-gray-500 hover:text-gray-800 font-bold">Batal</a>
        </div>
    </form>
</div>
@endsection