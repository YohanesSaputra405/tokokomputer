<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $produk->nama_produk }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

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
            padding: 0 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, .1);
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
        }

        .image-area {
            width: 320px;
        }

        .main-image img {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 8px;
        }

        .thumbs {
            display: flex;
            gap: 8px;
            margin-top: 10px;
        }

        .thumbs img {
            width: 60px;
            height: 60px;
            cursor: pointer;
            border-radius: 5px;
        }

        .variant-btn {
            padding: 6px 12px;
            border: 1px solid #ddd;
            background: #f8f9fa;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 6px;
            margin-bottom: 6px;
        }

        .variant-btn.active {
            background: #0d6efd;
            color: white;
        }

        .price {
            font-size: 22px;
            font-weight: bold;
        }

        .price del {
            color: #999;
            font-size: 16px;
        }

        .btn-cart {
            padding: 10px 16px;
            background: #198754;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-buy {
            padding: 10px 16px;
            background: #fd7e14;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-buy:disabled,
        .btn-cart:disabled {
            background: #6c757d;
            cursor: not-allowed;
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .stok-habis {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>

    @php
        $defaultVarian = $produk->varians->first();
        $defaultGambar = $defaultVarian?->gambar->first();
    @endphp

    <header>
        <a href="{{ route('home') }}">← Kembali</a>
        <div class="header-icons">
            <a href="{{ route('wishlist.index') }}" class="icon">❤️</a>
            <a href="{{ route('cart.index') }}" class="icon">🛒</a>
        </div>
    </header>

    <div class="container">
        <div class="card">

            {{-- GAMBAR --}}
            <div class="image-area">
                <div class="main-image">
                    <img id="mainImage"
                        src="{{ $defaultGambar ? asset('storage/' . $defaultGambar->path_gambar) : 'https://via.placeholder.com/300' }}">
                </div>
                <div class="thumbs" id="thumbs">
                    @foreach ($defaultVarian?->gambar ?? [] as $g)
                        <img src="{{ asset('storage/' . $g->path_gambar) }}" onclick="mainImage.src=this.src">
                    @endforeach
                </div>
            </div>

            {{-- INFO --}}
            <div style="flex:1">
                <h2>{{ $produk->nama_produk }}</h2>

                <div class="price" id="price">
                    Rp {{ number_format($defaultVarian->harga_final ?? 0, 0, ',', '.') }}
                </div>

                <p>{{ $produk->deskripsi }}</p>

                <strong>Pilih Varian:</strong><br><br>

                @foreach ($produk->varians as $i => $v)
                    <button class="variant-btn {{ $i == 0 ? 'active' : '' }}" onclick="changeVarian(this)"
                        data-id="{{ $v->id }}" data-harga="{{ $v->harga }}"
                        data-harga-final="{{ $v->harga_final }}" data-stok="{{ $v->stok }}"
                        data-gambar='@json($v->gambar)'>
                        {{ $v->nama_varian }}
                    </button>
                @endforeach

                <div id="stokInfo" style="margin-top:10px"></div>

                {{-- ACTION --}}
                <div class="button-group">

                    {{-- CART --}}
                    <form action="{{ route('cart.store', $produk->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="varian_id" id="cartVarianId" value="{{ $defaultVarian?->id }}">
                        <input type="hidden" name="qty" value="1">
                        <button class="btn-cart" id="cartBtn">🛒 Tambah ke Keranjang</button>
                    </form>

                    {{-- BUY NOW --}}
                    <form action="{{ route('checkout.buyNow') }}" method="POST">
                        @csrf
                        <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                        <input type="hidden" name="varian_id" id="buyNowVarianId" value="{{ $defaultVarian?->id }}">
                        <input type="hidden" name="qty" value="1">
                        <button class="btn-buy" id="buyNowBtn">⚡ Beli Sekarang</button>
                    </form>

                </div>
            </div>

        </div>
    </div>

    <script>
        let selectedVarian = {
            id: {{ $defaultVarian?->id ?? 'null' }},
            stok: {{ $defaultVarian?->stok ?? 0 }},
            harga: {{ $defaultVarian?->harga ?? 0 }},
            harga_final: {{ $defaultVarian?->harga_final ?? 0 }},
        };

        function changeVarian(el) {
            document.querySelectorAll('.variant-btn').forEach(b => b.classList.remove('active'));
            el.classList.add('active');

            selectedVarian = {
                id: el.dataset.id,
                stok: parseInt(el.dataset.stok),
                harga: parseInt(el.dataset.harga),
                harga_final: parseInt(el.dataset.hargaFinal),
            };

            document.getElementById('cartVarianId').value = selectedVarian.id;
            document.getElementById('buyNowVarianId').value = selectedVarian.id;

            document.getElementById('price').innerHTML =
                selectedVarian.harga_final < selectedVarian.harga ?
                `<del>Rp ${selectedVarian.harga.toLocaleString('id-ID')}</del><br>
                   Rp ${selectedVarian.harga_final.toLocaleString('id-ID')}` :
                `Rp ${selectedVarian.harga.toLocaleString('id-ID')}`;

            const stokInfo = document.getElementById('stokInfo');
            const cartBtn = document.getElementById('cartBtn');
            const buyNowBtn = document.getElementById('buyNowBtn');

            if (selectedVarian.stok <= 0) {
                stokInfo.innerHTML = '<span class="stok-habis">Stok habis</span>';
                cartBtn.disabled = true;
                buyNowBtn.disabled = true;
            } else {
                stokInfo.innerHTML = 'Stok tersedia: ' + selectedVarian.stok;
                cartBtn.disabled = false;
                buyNowBtn.disabled = false;
            }

            const gambar = JSON.parse(el.dataset.gambar);
            const thumbs = document.getElementById('thumbs');
            const mainImage = document.getElementById('mainImage');

            thumbs.innerHTML = '';
            if (gambar.length) {
                mainImage.src = '/storage/' + gambar[0].path_gambar;
                gambar.forEach(g => {
                    const img = document.createElement('img');
                    img.src = '/storage/' + g.path_gambar;
                    img.onclick = () => mainImage.src = img.src;
                    thumbs.appendChild(img);
                });
            }
        }
    </script>

</body>

</html>
