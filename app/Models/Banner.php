<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Banner extends Model
{
    Use HasFactory;

    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
        'status',
    ];
}
