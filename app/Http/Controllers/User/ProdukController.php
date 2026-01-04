<?php

namespace App\Http\Controllers\User;

use App\Models\Banner;
use App\Models\Produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProdukController extends Controller
{
   public function index()
{
    $produks = Produk::with([
        'varians.gambarUtama'
    ])->get();

    $banners = Banner::where('status', true)->get();
    return view('user.produk.index', compact('produks', 'banners'));
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
