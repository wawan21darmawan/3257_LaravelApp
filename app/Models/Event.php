<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Review;
use App\Models\User;

class Event extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'description',
        'date',
        'location',
        'price',
        'stock',
        'poster_path'
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Relasi ke tabel users (Organizer)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Accessor otomatis untuk mencegah error UrlGenerationException jika user_id kosong/null di database
    public function getUserIdAttribute($value)
    {
        return $value ?? 1;
    }
}