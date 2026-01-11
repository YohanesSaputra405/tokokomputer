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
            font-size: 22px;
        }

        .badge {
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
        }

        .cart-item {
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, .1);
        }

        .item-info {
            flex: 1;
        }

        .item-actions {
            display: flex;
            gap: 10px;
        }

        .qty-input {
            width: 60px;
            padding: 5px;
            text-align: center;
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
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }

        .empty-cart {
            background: white;
            padding: 40px;
            text-align: center;
            border-radius: 8px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, .1);
        }
    </style>
</head>

<body>

    <header>
        <a href="{{ route('home') }}">← Kembali</a>
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

        @if ($carts->count() > 0)

            {{-- LIST CART --}}
            @foreach ($carts as $cart)
                <div class="cart-item">

                    {{-- CHECKOUT CHECKBOX --}}
                    <input type="checkbox" name="cart_ids[]" value="{{ $cart->id }}" form="checkoutForm">

                    <div class="item-info">
                        <strong>{{ $cart->produk->nama_produk }}</strong>

                        @if ($cart->varian)
                            <p>Varian: {{ $cart->varian->nama_varian }}</p>
                        @endif

                        <p>
                            Rp {{ number_format($cart->harga, 0, ',', '.') }}
                            x {{ $cart->qty }}
                        </p>

                        <strong>
                            Subtotal: Rp {{ number_format($cart->subtotal, 0, ',', '.') }}
                        </strong>
                    </div>

                    <div class="item-actions">

                        {{-- UPDATE --}}
                        <form action="{{ route('cart.update', $cart) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="number" name="qty" value="{{ $cart->qty }}" min="1"
                                class="qty-input">
                            <button class="btn-update">Update</button>
                        </form>

                        {{-- DELETE --}}
                        <form action="{{ route('cart.destroy', $cart) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn-remove" onclick="return confirm('Hapus produk ini?')">
                                Hapus
                            </button>
                        </form>

                    </div>
                </div>
            @endforeach

            {{-- CHECKOUT --}}
            <form id="checkoutForm" action="{{ route('checkout.index') }}" method="GET">
                <div class="total-section">
                    <h3>Total Belanja</h3>
                    <div class="total-price">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </div>
                    <button type="submit" class="btn-checkout">
                        Checkout Produk Terpilih
                    </button>
                </div>
            </form>
        @else
            <div class="empty-cart">
                <h3>Keranjang masih kosong</h3>
                <a href="{{ route('home') }}">Belanja sekarang</a>
            </div>
        @endif

    </div>

</body>

</html>
