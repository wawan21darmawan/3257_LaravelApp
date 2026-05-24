@extends('layouts.admin')

@section('title', 'Manajemen Partner')
@section('page_title', 'Manajemen Partner')
@section('page_subtitle', 'Kelola partner event yang tersedia')

@section('content')
<div class="p-6 w-full">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-slate-800">Manajemen Partner</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola data partner event</p>
        </div>

        <a href="{{ route('admin.partners.create') }}" class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-bold hover:bg-indigo-700 transition flex items-center gap-2">
            Tambah Partner
        </a>
    </div>

    <!-- Form Pencarian (Soal 3) -->
    <form action="{{ route('admin.partners.index') }}" method="GET" class="mb-6 flex gap-2">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama partner..." 
            class="border border-slate-200 px-4 py-2 rounded-xl focus:ring-2 focus:ring-indigo-500 outline-none w-64">
        <button type="submit" class="px-5 py-2 bg-slate-800 text-white rounded-xl font-bold hover:bg-slate-900 transition">
            Cari
        </button>
    </form>

    <!-- Table (Soal 2) -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 border-b border-slate-100">
                <tr>
                    <th class="text-left px-6 py-4 font-bold text-slate-600">No</th>
                    <th class="text-left px-6 py-4 font-bold text-slate-600">Nama Partner</th>
                    <th class="text-left px-6 py-4 font-bold text-slate-600">Logo URL</th>
                    <th class="text-left px-6 py-4 font-bold text-slate-600">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100">
                @forelse($partners as $index => $partner)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4 text-slate-400 font-semibold">{{ $index + 1 }}</td>
                    <td class="px-6 py-4 font-semibold text-slate-800">{{ $partner->name }}</td>
                    <td class="px-6 py-4 text-slate-500 font-mono text-xs">{{ $partner->logo_url }}</td>
                    <td class="px-6 py-4">
                        <div class="flex gap-2">
                            <a href="{{ route('admin.partners.edit', $partner->id) }}" class="px-3 py-1.5 bg-amber-50 text-amber-600 rounded-lg font-bold text-xs hover:bg-amber-100 transition">Edit</a>
                            
                            <form action="{{ route('admin.partners.destroy', $partner->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin hapus partner ini?')"
                                    class="px-3 py-1.5 bg-red-50 text-red-600 rounded-lg font-bold text-xs hover:bg-red-100 transition">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-6 text-slate-400">Belum ada data partner.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection