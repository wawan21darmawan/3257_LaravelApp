@extends('layouts.admin') 

@section('content')
<!-- Wrapper Card -->
<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-6">
    
    <!-- Header Card -->
    <div class="px-6 py-5 border-b border-slate-100 flex justify-between items-center bg-white">
        <h2 class="text-xl font-bold text-slate-800">Daftar Jabatan</h2>
        
        <a href="{{ route('jabatan.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-lg text-sm font-semibold transition-colors flex items-center gap-2 shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Jabatan
        </a>
    </div>

    <!-- Bagian Tabel -->
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-100">
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider w-20">ID</th>
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Jabatan</th>
                    <!-- Text-right agar sejajar dengan tombol aksi -->
                    <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                
                @foreach($jabatan as $item)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="px-6 py-4 text-sm text-slate-600">
                        {{ $item->id }}
                    </td>
                    <td class="px-6 py-4 text-sm font-medium text-slate-900 capitalize">
                        {{ $item->name }}
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <!-- Flex justify-end agar tombol selalu rapat ke kanan -->
                        <div class="flex justify-end items-center gap-4">
                            <!-- Tombol Edit -->
                            <a href="{{ route('jabatan.edit', $item->id) }}" class="text-indigo-600 hover:text-indigo-800 font-semibold transition-colors">
                                Edit
                            </a>
                            
                            <!-- Tombol Hapus -->
                            <form action="{{ route('jabatan.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700 font-semibold transition-colors">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    </div>
</div>
@endsection