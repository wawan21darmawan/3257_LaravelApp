<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory;

    protected $table = 'jabatan';
    protected $fillable = ['name', 'created_by', 'updated_by'];

    // Relasi One-to-Many: 1 Jabatan memiliki banyak Pengurus
    public function pengurus()
    {
        return $this->hasMany(Pengurus::class, 'jabatan_id');
    }
}