@extends('layouts.admin')

@section('title', 'Manajemen Kategori')
@section('page_title', 'Manajemen Kategori')
@section('page_subtitle', 'Kelola kategori event yang tersedia')

@section('content')
    <div class="p-6 w-full">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
        <a href="{{ route('admin.categories.create') }}"
            class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4v16m8-8H4" />
            </svg>
            Tambah Kategori
        </a>
    </div>

        <!-- Table -->
        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="text-left px-6 py-4 font-bold text-slate-600">No</th>
                        <th class="text-left px-6 py-4 font-bold text-slate-600">Nama Kategori</th>
                        <th class="text-left px-6 py-4 font-bold text-slate-600">Slug</th>
                        <th class="text-left px-6 py-4 font-bold text-slate-600">Jumlah Event</th>
                        <th class="text-left px-6 py-4 font-bold text-slate-600">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">

                    <form action="{{ route('admin.categories.index') }}" method="GET" class="mb-4">
                        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari kategori..."
                            class="border p-2 rounded">
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Cari</button>
                    </form>


                @forelse($categories as $index => $category)
                    <tr class="hover:bg-slate-50 transition">

                        <!-- No -->
                        <td class="px-6 py-4 text-slate-400 font-semibold">
                            {{ $index + 1 }}
                        </td>

                        <!-- Nama -->
                        <td class="px-6 py-4 font-semibold text-slate-800">
                            <span class="px-3 py-1 bg-indigo-50 text-indigo-700 rounded-lg">
                                {{ $category['name'] }}
                            </span>
                        </td>

                        <!-- Slug -->
                        <td class="px-6 py-4 text-slate-500 font-mono text-xs">
                            {{ $category['slug'] }}
                        </td>

                        <!-- Total -->
                        <td class="px-6 py-4 text-slate-600">
                            {{ $category['total'] }} event
                        </td>

                        <!-- Aksi -->
                        <td class="px-6 py-4">
                            <div class="flex gap-2">

                                <!-- EDIT -->
                                <button
                                    class="px-3 py-1.5 bg-amber-50 text-amber-600 rounded-lg font-bold text-xs hover:bg-amber-100 transition flex items-center gap-1">
                                    ✏️ Edit
                                </button>

                                <!-- DELETE -->
                                <button onclick="return confirm('Yakin hapus kategori ini?')"
                                    class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg font-bold text-xs hover:bg-red-100 transition flex items-center gap-1">
                                    🗑️ Hapus
                                </button>

                            </div>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-slate-400">
                            Belum ada kategori.
                        </td>
                    </tr>
                @endforelse

                </tbody>
            </table>
        </div>

    </div>
@endsection