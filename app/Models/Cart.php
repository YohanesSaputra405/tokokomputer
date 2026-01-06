<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
protected $fillable = ['user_id', 'produk_id', 'varian_id', 'qty'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function varian()
    {
        return $this->belongsTo(Varian::class);
    }

    // Accessor untuk harga dari varian
    public function getHargaAttribute()
    {
        if ($this->varian) {
            return $this->varian->harga_final; // Harga setelah diskon
        }
        
        // Fallback ke varian pertama produk
        if ($this->produk && $this->produk->varians->count() > 0) {
            $varian = $this->produk->varians->first();
            return $varian->harga_final;
        }
        
        return $this->produk->harga ?? 0;
    }

    // Accessor untuk subtotal
    public function getSubtotalAttribute()
    {
        return $this->harga * $this->qty;
    }

    // Accessor untuk nama varian
    public function getNamaVarianAttribute()
    {
        return $this->varian ? $this->varian->nama_varian : 'Default';
    }
}
