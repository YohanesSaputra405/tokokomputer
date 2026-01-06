<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Produk;
use App\Models\Varian;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // 🛒 halaman cart
    public function index()
    {
        $carts = Cart::with(['produk', 'varian'])
            ->where('user_id', Auth::id())
            ->get();

        // Hitung total harga
        $total = $carts->sum('subtotal');

        return view('user.cart.index', compact('carts', 'total'));
    }

    // ➕ tambah ke cart (dengan varian)
    public function store(Request $request, Produk $produk)
    {
        $request->validate([
            'varian_id' => 'required|exists:varians,id',
            'qty' => 'nullable|integer|min:1'
        ]);

        // Pastikan varian milik produk ini
        $varian = Varian::where('id', $request->varian_id)
            ->where('id_produk', $produk->id)
            ->first();

        if (!$varian) {
            return back()->with('error', 'Varian tidak valid!');
        }

        $cart = Cart::where('user_id', Auth::id())
            ->where('produk_id', $produk->id)
            ->where('varian_id', $request->varian_id)
            ->first();

        $qty = $request->qty ?? 1;

        if ($cart) {
            $cart->increment('qty', $qty);
            $message = 'Jumlah produk di keranjang berhasil ditambah!';
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'produk_id' => $produk->id,
                'varian_id' => $request->varian_id,
                'qty' => $qty
            ]);
            $message = 'Produk berhasil ditambahkan ke keranjang!';
        }

        return redirect()->route('cart.index')->with('success', $message);
    }

    // ✏️ update qty di cart
    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'qty' => 'required|integer|min:1|max:99'
        ]);

        // Pastikan cart milik user yang sedang login
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cart->update(['qty' => $request->qty]);

        return back()->with('success', 'Jumlah produk berhasil diupdate!');
    }

    // ➕ dari wishlist (ambil varian pertama)
    public function fromWishlist(Produk $produk)
    {
        // Ambil varian pertama produk
        $varian = $produk->varians->first();
        
        if (!$varian) {
            return redirect()->route('wishlist.index')
                ->with('error', 'Produk tidak memiliki varian!');
        }

        // Cek apakah sudah ada di cart
        $cart = Cart::where('user_id', Auth::id())
            ->where('produk_id', $produk->id)
            ->where('varian_id', $varian->id)
            ->first();

        if ($cart) {
            $cart->increment('qty');
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'produk_id' => $produk->id,
                'varian_id' => $varian->id,
                'qty' => 1
            ]);
        }

        // Hapus dari wishlist
        Wishlist::where('user_id', Auth::id())
            ->where('produk_id', $produk->id)
            ->delete();

        return redirect()->route('cart.index')->with('success', 'Produk berhasil dipindahkan ke keranjang!');
    }

    // ❌ hapus cart
    public function destroy(Cart $cart)
    {
        // Pastikan cart milik user yang sedang login
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cart->delete();
        
        return back()->with('success', 'Produk berhasil dihapus dari keranjang!');
    }
}