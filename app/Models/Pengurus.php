<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengurus extends Model
{
    use HasFactory;

    protected $table = 'pengurus';
    protected $fillable = ['jabatan_id', 'name', 'description', 'salary', 'created_by', 'updated_by'];

    // Relasi BelongsTo: 1 Pengurus dimiliki oleh 1 Jabatan
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }
}