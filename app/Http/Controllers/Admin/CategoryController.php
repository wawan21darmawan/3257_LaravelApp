<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $categories = Category::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', '%' . $search . '%');
        })->get();
        return view('admin.categories.index', compact('categories', 'search'));
    }

    public function create() {
        return view('admin.categories.create'); // Kamu perlu membuat file ini
    }

    public function store(Request $request) {
        $request->validate(['name' => 'required']);
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        return redirect()->route('admin.categories.index')->with('success', 'Kategori ditambah!');
    }

    public function edit($id) {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id) {
        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
        return redirect()->route('admin.categories.index')->with('success', 'Kategori diupdate!');
    }

    public function destroy($id) {
        Category::findOrFail($id)->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Kategori dihapus!');
    }
}