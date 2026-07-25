<?php

namespace App\Http\Controllers;

use App\Models\Pengurus;
use App\Models\Jabatan;
use Illuminate\Http\Request;

class PengurusController extends Controller
{
    public function index()
    {
        $pengurus = Pengurus::with('jabatan')->get();
        return view('pengurus.index', compact('pengurus'));
    }

    public function create()
    {
        $jabatan = Jabatan::all();
        return view('pengurus.create', compact('jabatan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jabatan_id' => 'required|exists:jabatan,id',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'salary' => 'required|numeric'
        ]);

        Pengurus::create($request->all());
        return redirect()->route('pengurus.index')->with('success', 'Data berhasil ditambahkan');
    }

    // PERBAIKAN: Menggunakan $id dan findOrFail agar kebal dari error bahasa
    public function edit($id)
    {
        $pengurus = Pengurus::findOrFail($id);
        $jabatan = Jabatan::all();
        return view('pengurus.edit', compact('pengurus', 'jabatan'));
    }

    // PERBAIKAN: Menggunakan $id dan findOrFail
    public function update(Request $request, $id)
    {
        $request->validate([
            'jabatan_id' => 'required|exists:jabatan,id',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'salary' => 'required|numeric'
        ]);

        $pengurus = Pengurus::findOrFail($id);
        $pengurus->update($request->all());
        return redirect()->route('pengurus.index')->with('success', 'Data berhasil diperbarui');
    }

    // PERBAIKAN: Menggunakan $id dan findOrFail
    public function destroy($id)
    {
        $pengurus = Pengurus::findOrFail($id);
        $pengurus->delete();
        return redirect()->route('pengurus.index')->with('success', 'Data berhasil dihapus');
    }
}