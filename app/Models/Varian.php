<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Varian extends Model
{
    protected $fillable = [
        'id_produk',
        'nama_varian',
        'harga',
        'stok',
    ];

     public function produk()
    {
        return $this->belongsTo(Produk::class, 'id_produk');
    }

    public function gambar()
    {
        return $this->hasMany(GambarVarian::class, 'id_varian');
    }

    public function gambarUtama()
    {
        return $this->hasOne(GambarVarian::class, 'id_varian')
                    ->where('is_primary', true);
    }

}
