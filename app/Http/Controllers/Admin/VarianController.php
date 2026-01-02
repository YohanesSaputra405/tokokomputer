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
    $data = $request->validate([
        'nama_varian' => 'required|string|max:100',
        'harga' => 'required|numeric|min:0',
        'stok' => 'required|integer|min:0',

        'is_diskon' => 'nullable|boolean',
        'diskon_tipe' => 'nullable|in:persen,nominal',
        'diskon_nilai' => 'nullable|numeric|min:0',
        'diskon_mulai' => 'nullable|date',
        'diskon_selesai' => 'nullable|date',
    ]);

    // handle checkbox
    $data['is_diskon'] = $request->has('is_diskon');

    $varian = $produk->varians()->create($data);

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
    $data = $request->validate([
        'nama_varian' => 'required|string|max:100',
        'harga' => 'required|numeric|min:0',
        'stok' => 'required|integer|min:0',

        'is_diskon' => 'nullable|boolean',
        'diskon_tipe' => 'nullable|in:persen,nominal',
        'diskon_nilai' => 'nullable|numeric|min:0',
        'diskon_mulai' => 'nullable|date',
        'diskon_selesai' => 'nullable|date',
    ]);

    $data['is_diskon'] = $request->has('is_diskon');

    $varian->update($data);

    return redirect()->route('admin.produk.varian.index', $produk->id);
}

    public function destroy(Produk $produk, Varian $varian)
    {
        $varian->delete();

        return redirect()->route('admin.produk.varian.index', $produk->id);
    }
}
