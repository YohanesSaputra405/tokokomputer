@php
    use App\Models\Wishlist;
    use App\Models\Cart;

    $wishlistCount =
        auth()->check() && method_exists(auth()->user(), 'wishlists') ? auth()->user()->wishlists()->count() : 0;

    $cartCount = auth()->check() && method_exists(auth()->user(), 'cart') ? auth()->user()->cart()->sum('qty') : 0;
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        header {
            background: #0d6efd;
            color: #fff;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header a {
            color: #fff;
            text-decoration: none;
            margin-left: 15px;
            font-weight: bold;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 255, 255, 0.2);
            padding: 8px 15px;
            border-radius: 4px;
            transition: background 0.3s;
        }

        .back-button:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
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

        .wishlist-card {
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 3px 6px rgba(0, 0, 0, .1);
        }

        .wishlist-card form {
            display: inline-block;
            margin-left: 10px;
        }

        button {
            padding: 6px 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-cart {
            background: #0d6efd;
            color: #fff;
        }

        .btn-remove {
            background: #dc3545;
            color: #fff;
        }
    </style>
</head>

<body>

    <header>
        <div class="header-left">
            <a href="{{ route('home') }}" class="back-button">
                ← Kembali
            </a>
            <h2 style="margin: 0;">Wishlist Saya</h2>
        </div>
        <div class="header-icons">
            <a href="{{ route('wishlist.index') }}" class="icon">
                ❤️ <span class="badge">{{ $wishlistCount }}</span>
            </a>


            <a href="{{ route('cart.index') }}" class="icon">
                🛒 <span class="badge">{{ $cartCount }}</span>
            </a>
        </div>
    </header>

    <div class="container" style="padding:30px;">
        @if ($wishlists->count())
            @foreach ($wishlists as $item)
                <div class="wishlist-card">
                    <div>
                        <strong>{{ $item->produk->nama_produk }}</strong>
                    </div>
                    <div>
                        <form action="{{ route('cart.fromWishlist', $item->produk->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-cart">🛒 Tambah ke Cart</button>
                        </form>

                        <form action="{{ route('wishlist.destroy', $item->produk->id) }}" method="POST">
                            @csrf
                            @method('Delete')
                            <button type="submit" class="btn-remove">❌ Hapus</button>
                        </form>
                    </div>
                </div>
            @endforeach
        @else
            <p>Wishlist masih kosong 😢</p>
        @endif
    </div>

</body>
<script>
    // AJAX untuk wishlist di halaman wishlist
    document.querySelectorAll('.wishlist-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // Reload halaman setelah berhasil
                    if (data.status === 'removed') {
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Fallback: submit form biasa
                    this.submit();
                });
        });
    });
</script>

</html>
