<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Partner;       
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $partners = Partner::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', '%' . $search . '%');
        })->get();

        return view('admin.partners.index', compact('partners', 'search'));
    }

    public function create() {
        return view('admin.partners.create');
    }

    public function edit($id) {
        $partner = Partner::findOrFail($id);
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(Request $request, $id) 
    {
        $request->validate([
            'name' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $partner = Partner::findOrFail($id);
        $data = ['name' => $request->name];

        // LOGIKA UPDATE LOGO
        if ($request->hasFile('logo')) {
            if ($partner->logo_url) {
                Storage::disk('public')->delete($partner->logo_url);
            }

            // 2. Upload file baru
            $file = $request->file('logo');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('partners', $fileName, 'public');
            
            // 3. Masukkan path baru ke data yang akan diupdate
            $data['logo_url'] = $path;
        }

        $partner->update($data);
        return redirect()->route('admin.partners.index')->with('success', 'Partner diupdate!');
    }
    public function destroy($id) {
        Partner::findOrFail($id)->delete();
        return redirect()->route('admin.partners.index')->with('success', 'Partner dihapus!');
    }

    public function store(Request $request) 
{
    $request->validate([
        'name' => 'required',
        'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi file
    ]);

    if ($request->hasFile('logo')) {
        $file = $request->file('logo');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('partners', $fileName, 'public'); // Simpan di storage/app/public/partners
        
        \App\Models\Partner::create([
            'name' => $request->name,
            'logo_url' => 'partners/' . $fileName, // Simpan path ke database
        ]);
    }

    return redirect()->route('admin.partners.index')->with('success', 'Partner ditambah!');
}
}