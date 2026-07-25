<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    // Mengizinkan kolom-kolom ini diisi secara otomatis lewat form
    protected $fillable = [
        'event_id',
        'user_id',
        'rating',
        'testimonial',
    ];

    // Relasi ke peserta/user yang menulis ulasan
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke acara yang diulas
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}