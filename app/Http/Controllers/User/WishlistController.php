<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlists = Wishlist::with('produk')->where('user_id', Auth::id())->get();
        return view('user.wishlist.index', compact('wishlists'));
    }

    public function toggle(Request $request, Produk $produk)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('produk_id', $produk->id)
            ->first();

        if ($wishlist) {
            $wishlist->delete();
            $status = 'removed';
            $message = 'Produk dihapus dari wishlist';
        } else {
            Wishlist::create([
                'user_id' => Auth::id(),
                'produk_id' => $produk->id
            ]);
            $status = 'added';
            $message = 'Produk ditambahkan ke wishlist';
        }

        // Jika request AJAX (dari halaman produk)
        if ($request->ajax()) {
            return response()->json(['status' => $status]);
        }

        // Jika bukan AJAX (dari halaman wishlist)
        return redirect()->route('wishlist.index')->with('success', $message);
    }

    // Method khusus untuk hapus dari wishlist (non-toggle)
    public function destroy(Produk $produk)
    {
        Wishlist::where('user_id', Auth::id())
            ->where('produk_id', $produk->id)
            ->delete();

        return redirect()->route('wishlist.index')->with('success', 'Produk dihapus dari wishlist');
    }
}