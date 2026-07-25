@extends('layouts.admin') 

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md mb-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold text-gray-800">Daftar Pengurus</h2>
        <a href="{{ route('pengurus.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            + Tambah Pengurus
        </a>
    </div>

    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-gray-100">
                <th class="border-b p-3">ID</th>
                <th class="border-b p-3">Nama Pengurus</th>
                <th class="border-b p-3">Jabatan (Relasi)</th>
                <th class="border-b p-3">Deskripsi</th> <th class="border-b p-3">Gaji</th>
                <th class="border-b p-3">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pengurus as $item)
            <tr class="hover:bg-gray-50">
                <td class="border-b p-3">{{ $item->id }}</td>
                <td class="border-b p-3">{{ $item->name }}</td>
                <td class="border-b p-3">
                    <span class="bg-green-100 text-green-800 text-xs font-semibold mr-2 px-2.5 py-0.5 rounded">
                        {{ $item->jabatan->name ?? 'Tidak Ada Jabatan' }}
                    </span>
                </td>
                <td class="border-b p-3">{{ $item->description ?? '-' }}</td> <td class="border-b p-3">Rp {{ number_format($item->salary, 0, ',', '.') }}</td>
                <td class="border-b p-3">
                    
                    <a href="{{ route('pengurus.edit', $item->id) }}" class="text-blue-500 font-semibold mr-4 hover:underline">Edit</a>
                    
                    <form action="{{ route('pengurus.destroy', $item->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 font-semibold hover:underline" onclick="return confirm('Yakin ingin menghapus data pengurus ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection