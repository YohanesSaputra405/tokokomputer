<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index(){
        $produk = Produk::with('kategori')->get();

        return view('admin.produk.index', compact('produk'));
    }

    public function create(){
        $kategori = Kategori::all();
        return view('admin.produk.create', compact('kategori'));
    }

    public function store(Request $request){
        $request->validate([
            'nama_produk' => 'required',
            'id_kategori' => 'exists:kategoris,id',
            'deskripsi' => 'required'
        ]);

        Produk::create([
            'nama_produk' => $request->nama_produk,
            'id_kategori' =>$request->id_kategori,
            'deskripsi' =>$request->deskripsi,
        ]);

        return redirect()->route('admin.produk.index');
    }

    public function edit(String $id){
        $kategoris = Kategori::all();
        $produk = Produk::findOrFail($id);

        return view('admin.produk.edit', compact('produk','kategoris'));
    }

    public function update(Request $request, Produk $produk){
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'id_kategori' =>'nullable|exists:kategoris,id',
            'deskripsi'=> 'required',
        ]);

        $produk->update([
            'nama_produk' => $request->nama_produk,
            'id_kategori' => $request->id_kategori,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy(String $id)
    {
        $produk= Produk::destroy($id);
        return redirect()->route('admin.produk.index');
    }
}
