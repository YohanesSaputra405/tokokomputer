<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Toko Komputer</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
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

        .container {
            padding: 30px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 20px;
        }

        .card {
            background: #fff;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, .1);
            text-align: center;
        }

        .card img {
            width: 100%;
            height: 160px;
            object-fit: cover;
            border-radius: 6px;
        }

        .card h4 {
            margin: 10px 0 5px;
        }

        .price {
            color: #198754;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .btn {
            display: inline-block;
            padding: 8px 14px;
            background: #0d6efd;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }

        .btn:hover {
            background: #0b5ed7;
        }
    </style>
</head>

<body>

    <header>
        <h2>Toko Komputer</h2>
        <div>
            @auth
                Halo, {{ auth()->user()->name }}
            @else
                <a href="{{ route('login') }}">Login</a>
            @endauth
        </div>
    </header>

    <div class="container">
        <div class="grid">
            @foreach ($produks as $produk)
                @php
                    $varian = $produk->varians->first();
                    $gambar = $varian?->gambarUtama;
                @endphp

                <div class="card">

                    @if ($gambar)
                        <img src="{{ asset('storage/' . ltrim($gambar->path_gambar, '/')) }}">
                    @else
                        <img src="https://via.placeholder.com/300x200?text=No+Image">
                    @endif

                    <h4>{{ $produk->nama_produk }}</h4>

                    <div class="price">
                        Rp {{ number_format($varian->harga ?? 0, 0, ',', '.') }}
                    </div>

                    <a href="{{ route('produk.show', $produk->id) }}" class="btn">
                        Lihat Detail
                    </a>
                </div>
            @endforeach


        </div>
    </div>

</body>

</html>
