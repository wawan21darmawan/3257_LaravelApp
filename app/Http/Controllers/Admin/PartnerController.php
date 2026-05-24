<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Partner; // Jangan lupa tambahkan ini agar Laravel mengenali model Partner

class PartnerController extends Controller
{
    public function index(Request $request)
    {
        // Soal 3: Fitur Pencarian
        $search = $request->input('search');
        
        $partners = Partner::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', '%' . $search . '%');
        })->get();

        return view('admin.partners.index', compact('partners', 'search'));
    }
}