@php
    use App\Models\Wishlist;
    use App\Models\Cart;

    $wishlistCount = auth()->check() ? Wishlist::where('user_id', auth()->id())->count() : 0;
    $cartCount = auth()->check() ? Cart::where('user_id', auth()->id())->sum('qty') : 0;
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Toko Komputer</title>
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
            margin-left: 15px;
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

        /* USER MENU */
        .user-menu {
            position: relative;
            display: inline-block;
        }

        .user-name {
            cursor: pointer;
            font-weight: bold;
        }

        .dropdown {
            display: none;
            position: absolute;
            right: 0;
            background: white;
            min-width: 160px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, .15);
            border-radius: 6px;
            overflow: hidden;
            z-index: 10;
        }

        .dropdown a,
        .dropdown button {
            display: block;
            width: 100%;
            padding: 10px 14px;
            text-align: left;
            border: none;
            background: none;
            color: #333;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .dropdown a:hover,
        .dropdown button:hover {
            background: #f1f1f1;
        }

        .user-menu:hover .dropdown {
            display: block;
        }

        .disabled {
            color: #999;
            cursor: not-allowed;
        }

        /* BANNER */
        .banner-slider {
            position: relative;
            width: 100%;
            aspect-ratio: 16 / 9;
            max-height: 420px;
            overflow: hidden;
            background: #000;
        }

        .banner-slide {
            position: absolute;
            inset: 0;
            opacity: 0;
            transition: opacity 1s ease-in-out;
        }

        .banner-slide.active {
            opacity: 1;
        }

        .banner-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .banner-dots {
            position: absolute;
            bottom: 15px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 8px;
        }

        .banner-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .5);
            cursor: pointer;
        }

        .banner-dot.active {
            background: #fff;
            transform: scale(1.2);
        }

        /* PRODUK */
        .section-produk {
            padding: 20px 30px 0;
            font-size: 22px;
            font-weight: bold;
        }

        .container {
            padding: 30px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }

        .card {
            background: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, .1);
            position: relative;
            text-align: center;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, .15);
        }

        .card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        .badge-diskon {
            position: absolute;
            top: 10px;
            left: 10px;
            background: red;
            color: white;
            padding: 4px 8px;
            font-size: 12px;
            font-weight: bold;
            border-radius: 4px;
            z-index: 2;
        }

        .badge-stok {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #28a745;
            color: white;
            padding: 4px 8px;
            font-size: 12px;
            font-weight: bold;
            border-radius: 4px;
            z-index: 2;
        }

        .badge-habis {
            position: absolute;
            top: 10px;
            left: 10px;
            background: #dc3545;
            color: white;
            padding: 4px 8px;
            font-size: 12px;
            font-weight: bold;
            border-radius: 4px;
            z-index: 2;
        }

        .price del {
            color: #999;
            font-size: 14px;
        }

        .price span {
            color: red;
            font-size: 16px;
            font-weight: bold;
        }

        .btn {
            display: inline-block;
            padding: 8px 14px;
            background: #0d6efd;
            color: white;
            border-radius: 4px;
            text-decoration: none;
            margin-top: 10px;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #0b5ed7;
        }

        .btn-disabled {
            background: #6c757d;
            cursor: not-allowed;
        }

        .btn-disabled:hover {
            background: #6c757d;
        }

        /* WISHLIST */
        .wishlist-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 22px;
            cursor: pointer;
            color: #ccc;
            z-index: 2;
            transition: transform 0.2s;
        }

        .wishlist-btn:hover {
            transform: scale(1.2);
        }

        .wishlist-btn.active {
            color: red;
        }

        .product-title {
            font-size: 16px;
            font-weight: bold;
            margin: 10px 0;
            height: 40px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .stok-info {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }

        .stok-habis {
            color: #dc3545;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <header>
        <h2>Toko Komputer</h2>
        <div class="header-icons">
            @auth
                <a href="{{ route('wishlist.index') }}" class="icon">
                    ❤️ <span class="badge">{{ $wishlistCount }}</span>
                </a>
                <a href="{{ route('cart.index') }}" class="icon">
                    🛒 <span class="badge">{{ $cartCount }}</span>
                </a>
            @else
                <a href="{{ route('login') }}" class="icon">❤️</a>
                <a href="{{ route('login') }}" class="icon">🛒</a>
            @endauth
        </div>
        <div>
            @auth
                <div class="user-menu">
                    <span class="user-name">Halo, {{ auth()->user()->name }} ▾</span>
                    <div class="dropdown">
                        <a href="#" class="disabled">Profil (soon)</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">Logout</button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}">Login</a>
            @endauth
        </div>
    </header>

    {{-- BANNER --}}
    @if ($banners->count())
        <div class="banner-slider">
            @foreach ($banners as $index => $banner)
                <div class="banner-slide {{ $index == 0 ? 'active' : '' }}">
                    <img src="{{ asset('storage/' . $banner->gambar) }}" alt="Banner {{ $index + 1 }}">
                </div>
            @endforeach
            <div class="banner-dots">
                @foreach ($banners as $index => $banner)
                    <span class="banner-dot {{ $index == 0 ? 'active' : '' }}"
                        onclick="goToSlide({{ $index }})"></span>
                @endforeach
            </div>
        </div>
    @endif

    <div class="section-produk">Daftar Produk</div>
    <div class="container">
        <div class="grid">
            @foreach ($produks as $produk)
                @php
                    $varian = $produk->varians->first();
                    $gambar = $varian?->gambar->first();
                    $isWishlist = auth()->check()
                        ? Wishlist::where('user_id', auth()->id())
                            ->where('produk_id', $produk->id)
                            ->exists()
                        : false;

                    // Cek stok varian
                    $stokVarian = $varian ? $varian->stok : 0;
                    $stokHabis = $stokVarian <= 0;
                @endphp
                <div class="card">
                    {{-- BADGE DISKON --}}
                    @if ($varian && $varian->harga_final < $varian->harga)
                        <div class="badge-diskon">DISKON</div>
                    @endif

                    {{-- BADGE STOK --}}
                    @if ($stokHabis)
                        <div class="badge-habis">HABIS</div>
                    @elseif($stokVarian > 0 && $stokVarian <= 5)
                        <div class="badge-stok">TERBATAS</div>
                    @endif

                    {{-- TOMBOL WISHLIST --}}
                    @auth
                        <button class="wishlist-btn {{ $isWishlist ? 'active' : '' }}"
                            onclick="toggleWishlist({{ $produk->id }}, this)">
                            ❤️
                        </button>
                    @endauth

                    {{-- GAMBAR PRODUK --}}
                    <img src="{{ $gambar ? asset('storage/' . $gambar->path_gambar) : 'https://via.placeholder.com/300x200?text=No+Image' }}"
                        alt="{{ $produk->nama_produk }}"
                        onerror="this.src='https://via.placeholder.com/300x200?text=No+Image'">

                    {{-- NAMA PRODUK --}}
                    <div class="product-title">{{ $produk->nama_produk }}</div>

                    {{-- HARGA --}}
                    <div class="price">
                        @if ($varian && $varian->harga_final < $varian->harga)
                            <del>Rp {{ number_format($varian->harga, 0, ',', '.') }}</del><br>
                            <span>Rp {{ number_format($varian->harga_final, 0, ',', '.') }}</span>
                        @elseif($varian)
                            Rp {{ number_format($varian->harga, 0, ',', '.') }}
                        @endif
                    </div>

                    {{-- INFO STOK --}}
                    @if ($varian && !$stokHabis)
                        <div class="stok-info">Stok: {{ $stokVarian }}</div>
                    @endif

                    {{-- TOMBOL DETAIL --}}
                    @if (!$varian)
                        <div class="stok-info stok-habis">Varian tidak tersedia</div>
                    @else
                        <a href="{{ route('produk.show', $produk->id) }}"
                            class="btn {{ $stokHabis ? 'btn-disabled' : '' }}"
                            {{ $stokHabis ? 'style="pointer-events: none; opacity: 0.6;"' : '' }}>
                            {{ $stokHabis ? 'Stok Habis' : 'Lihat Detail' }}
                        </a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>

    <script>
        // Banner slider
        const slides = document.querySelectorAll('.banner-slide');
        const dots = document.querySelectorAll('.banner-dot');
        let currentIndex = 0;
        let bannerInterval;

        function showSlide(index) {
            slides.forEach(s => s.classList.remove('active'));
            dots.forEach(d => d.classList.remove('active'));
            slides[index].classList.add('active');
            dots[index].classList.add('active');
            currentIndex = index;
        }

        function goToSlide(index) {
            showSlide(index);
            // Reset interval saat manual click
            clearInterval(bannerInterval);
            bannerInterval = setInterval(nextSlide, 3500);
        }

        function nextSlide() {
            showSlide((currentIndex + 1) % slides.length);
        }

        // Start banner auto-slide
        if (slides.length > 1) {
            bannerInterval = setInterval(nextSlide, 3500);
        }

        // Pause banner on hover
        document.querySelector('.banner-slider')?.addEventListener('mouseenter', () => {
            clearInterval(bannerInterval);
        });

        document.querySelector('.banner-slider')?.addEventListener('mouseleave', () => {
            if (slides.length > 1) {
                bannerInterval = setInterval(nextSlide, 3500);
            }
        });

        // Wishlist AJAX toggle
        function toggleWishlist(produkId, btn) {
            fetch(`/wishlist/${produkId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'added') {
                        btn.classList.add('active');
                        // Animasi hati
                        btn.style.transform = 'scale(1.3)';
                        setTimeout(() => btn.style.transform = 'scale(1)', 200);
                    } else {
                        btn.classList.remove('active');
                        // Animasi hati
                        btn.style.transform = 'scale(0.8)';
                        setTimeout(() => btn.style.transform = 'scale(1)', 200);
                    }

                    // Update header badge
                    const badge = document.querySelector('.header-icons a[href$="wishlist"] .badge');
                    let count = parseInt(badge.textContent);
                    if (data.status === 'added') count++;
                    else count--;
                    badge.textContent = count;
                })
                .catch(err => console.error(err));
        }
    </script>

</body>

</html>
