<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Varian extends Model
{
    protected $fillable = [
        'id_produk',
        'nama_varian',
        'harga',
        'stok',
        'is_diskon',
    'diskon_tipe',
    'diskon_nilai',
    'diskon_mulai',
    'diskon_selesai',
    ];

     protected $casts = [
        'is_diskon' => 'boolean',
        'diskon_mulai' => 'datetime',
        'diskon_selesai' => 'datetime',
        'harga' => 'float',
    ];

     protected $appends = ['harga_final'];

    //Diskon


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

    public function getHargaFinalAttribute()
{
    // kalau tidak diskon
    if (
        !$this->is_diskon ||
        !$this->diskon_tipe ||
        !$this->diskon_nilai ||
        $this->diskon_nilai <= 0
    ) {
        return $this->harga;
    }

    $now = Carbon::now();

    // cek waktu mulai diskon
    if ($this->diskon_mulai && $now->lt(
    Carbon::parse($this->diskon_mulai)->startOfDay()
    )) {
    return $this->harga;
    }

    // cek waktu selesai diskon
    if ($this->diskon_selesai && $now->gt(
    Carbon::parse($this->diskon_selesai)->endOfDay()
    )) {
    return $this->harga;
    }

    // diskon persen
    if ($this->diskon_tipe === 'persen') {
        return max(
            0,
            $this->harga - ($this->harga * $this->diskon_nilai / 100)
        );
    }

    // diskon nominal
    if ($this->diskon_tipe === 'nominal') {
        return max(
            0,
            $this->harga - $this->diskon_nilai
        );
    }

    return $this->harga;
}

}
