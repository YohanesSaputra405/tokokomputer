<?php

namespace App\Http\Controllers\Admin;

use App\Models\Varian;
use App\Models\GambarVarian;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Produk;
use Illuminate\Support\Facades\Storage;

class GambarVarianController extends Controller
{
    public function store(Request $request, Produk $produk, Varian $varian)
{
    $request->validate([
        'gambar.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    foreach ($request->file('gambar') as $file) {
        $path = $file->store('varian', 'public');

        GambarVarian::create([
            'id_varian' => $varian->id,
            'path_gambar' => $path,
        ]);
    }

    return back()->with('success', 'Gambar berhasil diupload');
}

public function setPrimary(GambarVarian $gambar)
{
    // reset semua gambar jadi non-primary
    GambarVarian::where('id_varian', $gambar->id_varian)
        ->update(['is_primary' => false]);

    // set gambar ini jadi primary
    $gambar->update(['is_primary' => true]);

    return back()->with('success', 'Gambar utama berhasil diubah');
}

public function destroy(GambarVarian $gambar)
{
    Storage::disk('public')->delete($gambar->path_gambar);
    $gambar->delete();

    return back()->with('success', 'Gambar berhasil dihapus');
}
}
