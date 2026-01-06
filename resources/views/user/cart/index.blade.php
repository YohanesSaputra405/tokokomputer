<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        header {
            background: #0d6efd;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header a {
            color: white;
            text-decoration: none;
            font-weight: bold;
        }

        .header-icons {
            display: flex;
            gap: 15px;
        }

        .icon {
            position: relative;
            color: white;
            font-size: 22px;
            text-decoration: none;
        }

        .icon .badge {
            position: absolute;
            top: -6px;
            right: -10px;
            background: red;
            color: white;
            font-size: 11px;
            padding: 2px 6px;
            border-radius: 50%;
        }

        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .cart-item {
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 3px 6px rgba(0, 0, 0, .1);
        }

        .item-info {
            flex: 1;
        }

        .item-actions {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .qty-input {
            width: 50px;
            padding: 5px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .btn-update {
            background: #0d6efd;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-remove {
            background: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
        }

        .total-section {
            background: white;
            padding: 20px;
            border-radius: 8px;
            text-align: right;
            margin-top: 20px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, .1);
        }

        .total-price {
            font-size: 24px;
            font-weight: bold;
            color: #198754;
        }

        .btn-checkout {
            background: #198754;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }

        .empty-cart {
            text-align: center;
            padding: 50px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, .1);
        }
    </style>
</head>

<body>

    <header>
        <a href="{{ route('home') }}">← Kembali ke Beranda</a>
        <div class="header-icons">
            <a href="{{ route('wishlist.index') }}" class="icon">
                ❤️ <span class="badge">{{ auth()->user()->wishlists()->count() }}</span>
            </a>
            <a href="{{ route('cart.index') }}" class="icon">
                🛒 <span class="badge">{{ auth()->user()->carts()->sum('qty') }}</span>
            </a>
        </div>
    </header>

    <div class="container">
        <h2>Keranjang Belanja</h2>

        @if (session('success'))
            <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        @if ($carts->count() > 0)
            @foreach ($carts as $cart)
                <div class="cart-item">
                    <div class="item-info">
                        <strong>{{ $cart->produk->nama_produk }}</strong>
                        {{-- Tampilkan varian jika ada --}}
                        @if ($cart->varian)
                            <p>Varian: {{ $cart->varian->nama_varian }}</p>
                        @endif
                        <p>
                            @if ($cart->varian && $cart->varian->is_diskon && $cart->harga < $cart->varian->harga)
                                <s style="color: #999;">Rp {{ number_format($cart->varian->harga, 0, ',', '.') }}</s>
                                →
                                <span style="color: #dc3545; font-weight: bold;">Rp
                                    {{ number_format($cart->harga, 0, ',', '.') }}</span>
                            @else
                                Rp {{ number_format($cart->harga, 0, ',', '.') }}
                            @endif
                            x {{ $cart->qty }}
                        </p>
                        <p><strong>Subtotal: Rp {{ number_format($cart->subtotal, 0, ',', '.') }}</strong></p>
                    </div>
                    <div class="item-actions">
                        <form action="{{ route('cart.update', $cart) }}" method="POST"
                            style="display: flex; gap: 5px; align-items: center;">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="qty" value="{{ $cart->qty }}" min="1"
                                class="qty-input">
                            <button type="submit" class="btn-update">Update</button>
                        </form>

                        <form action="{{ route('cart.destroy', $cart) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-remove">Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach

            <div class="total-section">
                <h3>Total Belanja</h3>
                <div class="total-price">Rp {{ number_format($total, 0, ',', '.') }}</div>
                <button class="btn-checkout">Checkout</button>
            </div>
        @else
            <div class="empty-cart">
                <p>Keranjang belanja kosong 😢</p>
                <a href="{{ route('home') }}" style="color: #0d6efd; text-decoration: none;">← Kembali berbelanja</a>
            </div>
        @endif
    </div>

</body>

</html>
