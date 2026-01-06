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

    //Mengambil harga dari harga varian terendah
    public function getHargaAttribute()
    {
        if ($this->varians()->count() > 0) {
            return $this->varians()->min('harga');
        }
        return 0;
    }

    //Harga Setelah diskon (Jika ada diskon)
    public function getHargaDiskonAttribute()
    {
        if ($this->varians()->count() > 0) {
            $varianTermurah = $this->varians()->orderBy('harga')->first();
            return $varianTermurah->harga_diskon ?? $varianTermurah->harga;
        }
        return 0;
    }

}
