<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Varian;
use Illuminate\Http\Request;

class VarianController extends Controller
{
    // daftar varian per produk
    public function index(Produk $produk)
    {
        $varians = $produk->varians;

        return view('admin.varian.index', compact('produk', 'varians'));
    }

    public function create(Produk $produk)
    {
        return view('admin.varian.create', compact('produk'));
    }

    public function store(Request $request, Produk $produk)
    {
        $request->validate([
            'nama_varian' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
        ]);

       $varian = $produk->varians()->create($request->only([
        'nama_varian',
        'harga',
        'stok'
    ]));

    // ⬇️ langsung ke edit varian (upload gambar di sana)
    return redirect()->route(
        'admin.produk.varian.edit',
        [$produk->id, $varian->id]
    );
    }

    public function edit(Produk $produk, Varian $varian)
    {
        return view('admin.varian.edit', compact('produk', 'varian'));
    }

    public function update(Request $request, Produk $produk, Varian $varian)
    {
        $request->validate([
            'nama_varian' => 'required|string|max:100',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
        ]);

        $varian->update($request->all());

        return redirect()->route('admin.produk.varian.index', $produk->id);
    }

    public function destroy(Produk $produk, Varian $varian)
    {
        $varian->delete();

        return redirect()->route('admin.produk.varian.index', $produk->id);
    }
}
