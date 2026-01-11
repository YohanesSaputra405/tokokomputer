<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        //proteksi User
        if (Auth::user()->role !== 'user') {
            abort(403);
        }

        $orders = Order::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

            return view('user.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        //proteksi User
        if (Auth::user()->role !== 'user') {
            abort(403);
        }

        // Pastikan order milik user sendiri
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('items.produk');

        return view('user.orders.show', compact('order'));
    }

    public function cancel(Order $order)
    {
        //proteksi User
        if (Auth::user()->role !== 'user') {
            abort(403);
        }

        // Pastikan order milik user sendiri
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Hanya order dengan status 'pending' yang bisa dibatalkan
        if ($order->status !== 'pending') {
            return back()->with('error', 'Hanya order dengan status pending yang bisa dibatalkan');
        }

        $order->update(['status' => 'canceled']);

        return back()->with('success', 'Order berhasil dibatalkan');
    }
}
