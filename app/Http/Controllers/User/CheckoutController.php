<?php

namespace App\Http\Controllers\User;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Produk;
use App\Models\Varian;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * HALAMAN CHECKOUT (PRODUK TERPILIH)
     */
    public function index(Request $request)
    {
        if (Auth::user()->role !== 'user') {
            abort(403);
        }

        $cartIds = $request->cart_ids;

        if (!$cartIds || !is_array($cartIds) || count($cartIds) === 0) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Pilih minimal 1 produk untuk checkout');
        }

        $cartItems = Cart::with(['produk', 'varian'])
            ->where('user_id', Auth::id())
            ->whereIn('id', $cartIds)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Cart tidak valid');
        }

        // HITUNG TOTAL (PAKAI HARGA FINAL DARI CART)
        $total = $cartItems->sum(fn ($item) => $item->harga * $item->qty);

        // 🔥 KIRIM cartIds ke view
        return view('checkout.index', compact('cartItems', 'total', 'cartIds'));
    }

    /**
     * SIMPAN ORDER
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'user') {
            abort(403);
        }

        $request->validate([
            'alamat_pengiriman' => 'required|string',
            'metode_pembayaran' => 'required|string',
            'cart_ids' => 'required|array|min:1',
            'cart_ids.*' => 'exists:carts,id',
        ]);

        $cartItems = Cart::with(['produk', 'varian'])
            ->where('user_id', Auth::id())
            ->whereIn('id', $request->cart_ids)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Cart tidak ditemukan');
        }

        DB::beginTransaction();

        try {
            $total = $cartItems->sum(fn ($item) => $item->harga * $item->qty);

            // BUAT ORDER
            $order = Order::create([
                'user_id' => Auth::id(),
                'kode_order' => 'ORD-' . now()->timestamp,
                'alamat_pengiriman' => $request->alamat_pengiriman,
                'metode_pembayaran' => $request->metode_pembayaran,
                'total_harga' => $total,
                'status' => 'pending',
            ]);

            // ORDER ITEMS
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'produk_id' => $item->produk_id,
                    'varian_id' => $item->varian_id,
                    'qty' => $item->qty,
                    'harga' => $item->harga, // harga final
                    'subtotal' => $item->harga * $item->qty,
                ]);
            }

            // HAPUS CART YANG DICHECKOUT SAJA
            Cart::whereIn('id', $request->cart_ids)->delete();

            DB::commit();

            return redirect()
                ->route('orders.show', $order->id)
                ->with('success', 'Pesanan berhasil dibuat');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Checkout gagal');
        }
    }

    /**
     * BUY NOW (LANGSUNG CHECKOUT 1 PRODUK)
     */
    public function buyNow(Request $request)
    {
        if (Auth::user()->role !== 'user') {
            abort(403);
        }

        $request->validate([
            'produk_id' => 'required|exists:produks,id',
            'varian_id' => 'required|exists:varians,id',
            'qty' => 'required|integer|min:1',
        ]);

        $produk = Produk::findOrFail($request->produk_id);
        $varian = Varian::findOrFail($request->varian_id);

        // 🔥 HARGA FINAL (DISKON)
        $harga = $varian->harga_final;

        // ❌ HAPUS CART SAMA JIKA SUDAH ADA (ANTI DUPLICATE)
        Cart::where('user_id', Auth::id())
            ->where('produk_id', $produk->id)
            ->where('varian_id', $varian->id)
            ->delete();

        // ✅ BUAT CART BARU
        $cart = Cart::create([
            'user_id' => Auth::id(),
            'produk_id' => $produk->id,
            'varian_id' => $varian->id,
            'qty' => $request->qty,
            'harga' => $harga,
        ]);

        // 👉 redirect ke checkout HANYA cart ini
        return redirect()->route('checkout.index', [
            'cart_ids' => [$cart->id],
        ]);
    }
}
