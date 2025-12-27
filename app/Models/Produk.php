<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    protected $fillable = [
        'nama_produk',
        'id_kategori',
        'deskripsi',
    ];

    public function kategori(){
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id');
    }

    public function varians()
{
    return $this->hasMany(Varian::class, 'id_produk');
}

}
