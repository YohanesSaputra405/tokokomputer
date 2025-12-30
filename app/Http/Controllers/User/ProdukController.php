<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
   public function index()
{
    $produks = Produk::with([
        'varians.gambarUtama'
    ])->get();

    return view('user.produk.index', compact('produks'));
}


public function show(Produk $produk)
{
    $produk->load([
        'varians.gambar' => function ($q) {
            $q->orderByDesc('is_primary');
        }
    ]);

    return view('user.produk.show', compact('produk'));
}

}
