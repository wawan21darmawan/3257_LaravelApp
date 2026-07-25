<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Category;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
    {
        // 🌟 MAGIC SAAS MULTI-ROLE 🌟
        // Cek apakah yang sedang login adalah Superadmin atau Organizer
        if (Auth::user()->role === 'superadmin') {
            // MODE PANTAU SUPERADMIN: Ambil SEMUA data event dari seluruh tabel
            $events = Event::with('category')->latest()->paginate(10);
        } else {
            // MODE ORGANIZER: HANYA mengambil data event yang memiliki user_id milik mereka sendiri
            $events = Event::where('user_id', Auth::id())->with('category')->latest()->paginate(10);
        }
        
        // Catatan: Path view tetap menggunakan folder 'admin' agar efisien satu file view untuk dua role.
        return view('admin.events.index', compact('events'));
    }

    // 🔹 CREATE (tampilkan form)
    public function create()
    {
        $categories = Category::all();
        return view('admin.events.create', compact('categories'));
    }

    // 🔹 STORE (simpan data beserta gambar)
    public function store(Request $request)
    {
        // Menerapkan validasi data request dari pengguna
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:1',
            'poster' => 'nullable|image|max:2048' // Maksimal 2MB
        ]);

        // Cek apakah ada file poster yang diunggah
        if ($request->hasFile('poster')) {
            // Simpan ke direktori storage/app/public/posters
            $data['poster_path'] = $request->file('poster')->store('posters', 'public');
        }

        // MAGIC SAAS: Sisipkan ID Organizer yang sedang login ke dalam data event sebelum di-save
        $data['user_id'] = Auth::id();

        // Menyimpan data yang telah divalidasi ke dalam tabel menggunakan Model
        Event::create($data);

        // Redirect diubah menyesuaikan route web.php yang baru (organizer.events.index)
        return redirect()
            ->route('organizer.events.index')
            ->with('success', 'Data Event berhasil ditambahkan.');
    }

    public function show(Event $event)
    {
        // Keamanan: Cek apakah event ini benar-benar milik organizer yang sedang login
        if ($event->user_id !== Auth::id()) {
            abort(403, 'Akses Ditolak! Ini bukan event milik organisasimu.');
        }

        return view('admin.events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        // Keamanan: Cegah organizer mengedit event orang lain melalui URL
        if ($event->user_id !== Auth::id()) {
            abort(403, 'Akses Ditolak! Kamu tidak berhak mengedit event ini.');
        }

        $categories = Category::all();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    // 🔹 Proses update data (Menghapus gambar lama jika ada yang baru)
    public function update(Request $request, Event $event)
    {
        // Keamanan: Cegah update paksa lewat API/Postman pada event orang lain
        if ($event->user_id !== Auth::id()) {
            abort(403, 'Akses Ditolak!');
        }

        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:1',
            'poster' => 'nullable|image|max:2048'
        ]); 

        if ($request->hasFile('poster')) {
            // Hapus gambar lama jika sebelumnya sudah memiliki poster
            if ($event->poster_path) {
                Storage::disk('public')->delete($event->poster_path);
            }
            // Upload gambar baru
            $data['poster_path'] = $request->file('poster')->store('posters', 'public');
        }

        $event->update($data);
        
        // Redirect diubah menyesuaikan route web.php yang baru
        return redirect()
            ->route('organizer.events.index')
            ->with('success', 'Event berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        // Keamanan: Cegah hapus event orang lain
        if ($event->user_id !== Auth::id()) {
            abort(403, 'Akses Ditolak!');
        }

        if ($event->poster_path) {
            Storage::disk('public')->delete($event->poster_path);
        }
        
        $event->delete();
        
        // Redirect diubah menyesuaikan route web.php yang baru
        return redirect()
            ->route('organizer.events.index')
            ->with('success', 'Data event beserta posternya berhasil dihapus secara permanen.');
    }
}