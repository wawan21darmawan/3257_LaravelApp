<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Partner extends Model
{
    use HasFactory;

    // Menentukan kolom yang boleh diisi
    protected $fillable = ['name', 'logo_url'];
}