<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Review;
use App\Models\Event;

// Menambahkan role, organization_name, dan organizer_status agar bisa disimpan ke database
#[Fillable(['name', 'email', 'password', 'google_id', 'role', 'organization_name', 'organizer_status'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function receivedReviews()
    {
        return $this->hasMany(Review::class, 'organizer_id');
    }

    // Relasi baru: Satu User (Organizer) memiliki banyak Event
    public function events()
    {
        return $this->hasMany(Event::class);
    }
}