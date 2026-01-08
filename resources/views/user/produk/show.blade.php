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
            flex-wrap: wrap;
        }

        .thumbs img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            cursor: pointer;
            border-radius: 5px;
            border: 2px solid transparent;
        }

        .thumbs img:hover {
            border-color: #0d6efd;
        }

        .variant-btn {
            padding: 6px 12px;
            border: 1px solid #ddd;
            background: #f8f9fa;
            border-radius: 4px;
            margin-right: 6px;
            margin-bottom: 6px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .variant-btn.active {
            background: #0d6efd;
            color: white;
            border-color: #0d6efd;
        }

        .variant-btn:hover:not(.active) {
            background: #e9ecef;
        }

        .price {
            font-size: 22px;
            font-weight: bold;
            margin: 10px 0;
        }

        .price del {
            color: #999;
            font-size: 16px;
        }

        .price span {
            color: red;
        }

        .btn-cart {
            padding: 10px 16px;
            background: #198754;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 10px;
            transition: background 0.2s;
        }

        .btn-cart:hover {
            background: #157347;
        }

        .btn-wishlist {
            padding: 10px 16px;
            background: #dc3545;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-wishlist:hover {
            background: #bb2d3b;
        }

        .btn-wishlist.in-wishlist {
            background: #6c757d;
        }

        .btn-wishlist.in-wishlist:hover {
            background: #5c636a;
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
            flex-wrap: wrap;
        }

        .stok-info {
            margin-top: 10px;
            color: #666;
            font-size: 14px;
        }

        .stok-ada {
            color: #198754;
            font-weight: bold;
        }

        .stok-habis {
            color: #dc3545;
            font-weight: bold;
        }

        .selected-varian {
            background: #e7f1ff;
            padding: 8px 12px;
            border-radius: 4px;
            margin-top: 10px;
            border-left: 4px solid #0d6efd;
            display: inline-block;
        }

        .alert-warning {
            background: #fff3cd;
            color: #856404;
            padding: 10px;
            border-radius: 4px;
            margin: 10px 0;
            border: 1px solid #ffeaa7;
        }
    </style>
</head>

<body>

    <header>
        <a href="{{ route('home') }}">← Kembali</a>
        <div class="header-icons">
            <a href="{{ route('wishlist.index') }}" class="icon">
                ❤️ <span class="badge">{{ $wishlistCount ?? 0 }}</span>
            </a>
            <a href="{{ route('cart.index') }}" class="icon">
                🛒 <span class="badge">{{ $cartCount ?? 0 }}</span>
            </a>
        </div>
    </header>

    @php
        use App\Models\Wishlist;
        use App\Models\Cart;

        // Hitung jumlah wishlist dan cart
        $wishlistCount = auth()->check() ? auth()->user()->wishlists()->count() : 0;
        $cartCount = auth()->check() ? auth()->user()->carts()->sum('qty') : 0;

        // Cek apakah produk ini sudah ada di wishlist user
        $isInWishlist = auth()->check()
            ? auth()->user()->wishlists()->where('produk_id', $produk->id)->exists()
            : false;

        $defaultVarian = $produk->varians->first();
        $defaultGambar = $defaultVarian?->gambar->first();

        // Set varian yang aktif (default varian pertama)
        $activeVarian = $defaultVarian;
    @endphp

    <div class="container">
        <div class="card">

            {{-- GAMBAR --}}
            <div class="image-area">
                <div class="main-image">
                    <img id="mainImage"
                        src="{{ $defaultGambar ? asset('storage/' . $defaultGambar->path_gambar) : 'https://via.placeholder.com/300' }}"
                        alt="{{ $produk->nama_produk }}">
                </div>

                <div class="thumbs" id="thumbs">
                    @foreach ($defaultVarian?->gambar ?? [] as $g)
                        <img src="{{ asset('storage/' . $g->path_gambar) }}"
                            onclick="document.getElementById('mainImage').src=this.src"
                            alt="Thumbnail {{ $loop->iteration }}">
                    @endforeach
                </div>
            </div>

            {{-- INFO --}}
            <div style="flex: 1;">
                <h2>{{ $produk->nama_produk }}</h2>

                <div class="price" id="price">
                    @if ($activeVarian && $activeVarian->harga_final < $activeVarian->harga)
                        <del>Rp {{ number_format($activeVarian->harga, 0, ',', '.') }}</del><br>
                        <span>Rp {{ number_format($activeVarian->harga_final, 0, ',', '.') }}</span>
                    @else
                        Rp {{ number_format($activeVarian->harga ?? 0, 0, ',', '.') }}
                    @endif
                </div>

                <p>{{ $produk->deskripsi }}</p>

                {{-- STOK --}}
                <div class="stok-info" id="stokInfo">
                    @if ($activeVarian)
                        Stok: <span class="{{ $activeVarian->stok > 0 ? 'stok-ada' : 'stok-habis' }}">
                            {{ $activeVarian->stok > 0 ? 'Tersedia (' . $activeVarian->stok . ')' : 'Habis' }}
                        </span>
                    @endif
                </div>

                <strong>Pilih Varian:</strong><br><br>

                <div id="variantContainer">
                    @foreach ($produk->varians as $i => $v)
                        <button class="variant-btn {{ $i == 0 ? 'active' : '' }}" onclick="changeVarian(this)"
                            data-id="{{ $v->id }}" data-harga="{{ $v->harga }}"
                            data-harga-final="{{ $v->harga_final }}" data-diskon="{{ $v->is_diskon }}"
                            data-stok="{{ $v->stok }}" data-nama="{{ $v->nama_varian }}"
                            data-gambar='@json($v->gambar)'>
                            {{ $v->nama_varian }}
                        </button>
                    @endforeach
                </div>

                {{-- VARIAN YANG DIPILIH --}}
                <div class="selected-varian" id="selectedVarianDisplay" style="display: none;">
                    <strong>Varian dipilih:</strong> <span id="selectedVarianName"></span>
                </div>

                {{-- TOMBOL AKSI --}}
                <div class="button-group">
                    <form action="{{ route('cart.store', $produk->id) }}" method="POST" id="cartForm"
                        style="display: inline;">
                        @csrf
                        <input type="hidden" name="varian_id" id="selectedVarianId"
                            value="{{ $defaultVarian->id ?? '' }}">
                        <input type="hidden" name="qty" value="1">
                        <button type="submit" class="btn-cart" id="cartButton">🛒 Tambah ke Keranjang</button>
                    </form>

                    <form action="{{ route('wishlist.toggle', $produk->id) }}" method="POST" class="wishlist-form">
                        @csrf
                        <button type="submit" class="btn-wishlist {{ $isInWishlist ? 'in-wishlist' : '' }}"
                            id="wishlistBtn">
                            @if ($isInWishlist)
                                ❤️ Hapus dari Wishlist
                            @else
                                🤍 Tambah ke Wishlist
                            @endif
                        </button>
                    </form>
                </div>

                {{-- ALERT STOK HABIS --}}
                <div id="outOfStockAlert" class="alert-warning" style="display: none; margin-top: 15px;">
                    ⚠️ Varian ini sedang habis stok
                </div>
            </div>

        </div>
    </div>

    <script>
        let selectedVarian = {
            id: {{ $defaultVarian->id ?? 'null' }},
            nama: '{{ $defaultVarian->nama_varian ?? '' }}',
            stok: {{ $defaultVarian->stok ?? 0 }},
            harga: {{ $defaultVarian->harga ?? 0 }},
            harga_final: {{ $defaultVarian->harga_final ?? 0 }},
            is_diskon: {{ $defaultVarian->is_diskon ? 'true' : 'false' }}
        };

        function changeVarian(el) {
            // Update tombol aktif
            document.querySelectorAll('.variant-btn').forEach(b => b.classList.remove('active'));
            el.classList.add('active');

            // Update data varian yang dipilih
            selectedVarian = {
                id: el.dataset.id,
                nama: el.dataset.nama,
                stok: parseInt(el.dataset.stok),
                harga: parseInt(el.dataset.harga),
                harga_final: parseFloat(el.dataset.hargaFinal),
                is_diskon: parseFloat(el.dataset.hargaFinal) < parseInt(el.dataset.harga)
            };

            // Update input hidden
            document.getElementById('selectedVarianId').value = selectedVarian.id;

            // Update harga display
            const price = document.getElementById('price');
            if (selectedVarian.is_diskon) {
                price.innerHTML =
                    `<del>Rp ${selectedVarian.harga.toLocaleString('id-ID')}</del><br>
         <span>Rp ${selectedVarian.harga_final.toLocaleString('id-ID')}</span>`;
            } else {
                price.innerHTML = `Rp ${selectedVarian.harga.toLocaleString('id-ID')}`;
            }


            // Update stok display
            const stokInfo = document.getElementById('stokInfo');
            const stokClass = selectedVarian.stok > 0 ? 'stok-ada' : 'stok-habis';
            const stokText = selectedVarian.stok > 0 ? `Tersedia (${selectedVarian.stok})` : 'Habis';

            stokInfo.innerHTML = `Stok: <span class="${stokClass}">${stokText}</span>`;

            // Update gambar
            const gambar = JSON.parse(el.dataset.gambar);
            const mainImage = document.getElementById('mainImage');
            const thumbs = document.getElementById('thumbs');

            thumbs.innerHTML = '';

            if (gambar.length > 0) {
                mainImage.src = '/storage/' + gambar[0].path_gambar;

                gambar.forEach(g => {
                    const img = document.createElement('img');
                    img.src = '/storage/' + g.path_gambar;
                    img.onclick = () => mainImage.src = img.src;
                    thumbs.appendChild(img);
                });
            }

            // Tampilkan nama varian yang dipilih
            const selectedDisplay = document.getElementById('selectedVarianDisplay');
            const selectedName = document.getElementById('selectedVarianName');
            selectedName.textContent = selectedVarian.nama;
            selectedDisplay.style.display = 'block';

            // Cek stok dan nonaktifkan tombol cart jika habis
            const cartButton = document.getElementById('cartButton');
            const outOfStockAlert = document.getElementById('outOfStockAlert');

            if (selectedVarian.stok <= 0) {
                cartButton.disabled = true;
                cartButton.style.background = '#6c757d';
                cartButton.style.cursor = 'not-allowed';
                outOfStockAlert.style.display = 'block';
            } else {
                cartButton.disabled = false;
                cartButton.style.background = '#198754';
                cartButton.style.cursor = 'pointer';
                outOfStockAlert.style.display = 'none';
            }
        }

        // Inisialisasi varian pertama
        document.addEventListener('DOMContentLoaded', function() {
            if (selectedVarian.id) {
                // Tampilkan nama varian default
                const selectedDisplay = document.getElementById('selectedVarianDisplay');
                const selectedName = document.getElementById('selectedVarianName');
                selectedName.textContent = selectedVarian.nama;
                selectedDisplay.style.display = 'block';

                // Cek stok default varian
                if (selectedVarian.stok <= 0) {
                    const cartButton = document.getElementById('cartButton');
                    const outOfStockAlert = document.getElementById('outOfStockAlert');
                    cartButton.disabled = true;
                    cartButton.style.background = '#6c757d';
                    cartButton.style.cursor = 'not-allowed';
                    outOfStockAlert.style.display = 'block';
                }
            }
        });

        // AJAX untuk wishlist agar tidak reload page
        document.querySelectorAll('.wishlist-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                const button = this.querySelector('button');
                const formData = new FormData(this);

                fetch(this.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Update tombol wishlist
                        const wishlistBtn = document.getElementById('wishlistBtn');
                        const wishlistBadge = document.querySelector(
                            '.header-icons a[href$="wishlist"] .badge');

                        if (data.status === 'added') {
                            wishlistBtn.innerHTML = '❤️ Hapus dari Wishlist';
                            wishlistBtn.classList.add('in-wishlist');
                            // Update badge count
                            if (wishlistBadge) {
                                wishlistBadge.textContent = parseInt(wishlistBadge.textContent) + 1;
                            }
                        } else {
                            wishlistBtn.innerHTML = '🤍 Tambah ke Wishlist';
                            wishlistBtn.classList.remove('in-wishlist');
                            // Update badge count
                            if (wishlistBadge) {
                                const newCount = parseInt(wishlistBadge.textContent) - 1;
                                wishlistBadge.textContent = newCount > 0 ? newCount : 0;
                            }
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });

        // AJAX untuk cart dengan feedback
        document.getElementById('cartForm').addEventListener('submit', function(e) {
            e.preventDefault();

            // Validasi stok
            if (selectedVarian.stok <= 0) {
                alert('Maaf, varian ini habis stok');
                return;
            }

            const formData = new FormData(this);
            const button = document.getElementById('cartButton');
            const originalText = button.textContent;

            button.textContent = 'Menambahkan...';
            button.disabled = true;

            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        // Update cart badge
                        const cartBadge = document.querySelector('.header-icons a[href$="cart"] .badge');
                        if (cartBadge) {
                            cartBadge.textContent = parseInt(cartBadge.textContent) + 1;
                        }

                        // Tampilkan feedback sukses
                        button.textContent = '✓ Berhasil Ditambahkan';
                        button.style.background = '#198754';

                        // Reset tombol setelah 2 detik
                        setTimeout(() => {
                            button.textContent = originalText;
                            button.disabled = false;
                        }, 2000);
                    } else {
                        button.textContent = 'Gagal!';
                        button.style.background = '#dc3545';
                        setTimeout(() => {
                            button.textContent = originalText;
                            button.disabled = false;
                            button.style.background = '#198754';
                        }, 2000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    button.textContent = 'Error!';
                    button.style.background = '#dc3545';
                    setTimeout(() => {
                        button.textContent = originalText;
                        button.disabled = false;
                        button.style.background = '#198754';
                    }, 2000);
                });
        });
    </script>

</body>

</html>
