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
        }

        .card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 6px;
        }

        .badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: red;
            color: white;
            padding: 4px 8px;
            font-size: 12px;
            font-weight: bold;
            border-radius: 4px;
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
        }
    </style>
</head>

<body>

    <header>
        <h2>Toko Komputer</h2>

        <div>
            @auth
                <div class="user-menu">
                    <span class="user-name">
                        Halo, {{ auth()->user()->name }} ▾
                    </span>

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
                    <img src="{{ asset('storage/' . $banner->gambar) }}">
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
                @endphp

                <div class="card">
                    @if ($varian && $varian->is_diskon)
                        <div class="badge">DISKON</div>
                    @endif

                    <img
                        src="{{ $gambar ? asset('storage/' . $gambar->path_gambar) : 'https://via.placeholder.com/300x200' }}">

                    <h4>{{ $produk->nama_produk }}</h4>

                    <div class="price">
                        @if ($varian && $varian->is_diskon)
                            <del>Rp {{ number_format($varian->harga, 0, ',', '.') }}</del><br>
                            <span>Rp {{ number_format($varian->harga_final, 0, ',', '.') }}</span>
                        @else
                            Rp {{ number_format($varian->harga ?? 0, 0, ',', '.') }}
                        @endif
                    </div>

                    <a href="{{ route('produk.show', $produk->id) }}" class="btn">Lihat Detail</a>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        const slides = document.querySelectorAll('.banner-slide');
        const dots = document.querySelectorAll('.banner-dot');
        let currentIndex = 0;

        function showSlide(index) {
            slides.forEach(s => s.classList.remove('active'));
            dots.forEach(d => d.classList.remove('active'));
            slides[index].classList.add('active');
            dots[index].classList.add('active');
            currentIndex = index;
        }

        setInterval(() => {
            if (slides.length) {
                showSlide((currentIndex + 1) % slides.length);
            }
        }, 3500);
    </script>

</body>

</html>
