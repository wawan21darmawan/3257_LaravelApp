<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatan = Jabatan::all();
        return view('jabatan.index', compact('jabatan'));
    }

    public function create()
    {
        return view('jabatan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100'
        ]);

        Jabatan::create($request->all());
        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil ditambahkan');
    }

    public function edit(Jabatan $jabatan)
    {
        return view('jabatan.edit', compact('jabatan'));
    }

    public function update(Request $request, Jabatan $jabatan)
    {
        $request->validate([
            'name' => 'required|string|max:100'
        ]);

        $jabatan->update($request->all());
        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil diperbarui');
    }

    public function destroy(Jabatan $jabatan)
    {
        $jabatan->delete();
        return redirect()->route('jabatan.index')->with('success', 'Jabatan berhasil dihapus');
    }
}