<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GambarVarian extends Model
{
     protected $fillable = [
        'id_varian',
        'path_gambar',
        'is_primary',
    ];

    public function varian()
    {
        return $this->belongsTo(Varian::class, 'id_varian');
    }
}
