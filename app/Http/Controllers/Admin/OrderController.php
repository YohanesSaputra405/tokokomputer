<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * List Semua Order
     */

    public function index()
    {
        //proteksi
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }
        
        $orders = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->get();

            return view('admin.orders.index', compact('orders'));
    }

    /**
     * Tampilkan detail order
     */

    public function show(Order $order)
    {
        $order->load('items.produk', 'user');

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update status order
     */
    public function updateStatus(Request $request, Order $order)
{
        // Cegah update jika order sudah final
        if (in_array($order->status, ['completed', 'canceled'])) {
            return back()->with('error', 'Order sudah final');
        }

        $request->validate([
            'status' => 'required|in:pending,paid,shipped,completed,canceled',
        ]);

        //simpan status lama
        $oldStatus = $order->status;

        $order->update([
            'status' => $request->status,
        ]);

        //potong Stok jika baru saa complete 
        if ($oldStatus !== 'completed' && $request->status === 'completed') {
            foreach ($order-> items as $item) {
                //jika menggunakan varian
                if ($item->produk->varians()->exist()) {
                    $item->produk->varians()->first()->decrement('stok', $item->qty);
                }else {
                    //jika menggunakan produk (maksudnya stoknya di produk)
                    $item->produk->decrement('stok', $item->qty);
                }
            }
        }
        
        return back()->with('success', 'Status order anda telah diperbaharui');
    }
}