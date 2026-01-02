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
        }

        header a {
            color: white;
            text-decoration: none;
            font-weight: bold;
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
            cursor: pointer;
        }

        .variant-btn.active {
            background: #0d6efd;
            color: white;
            border-color: #0d6efd;
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
        }
    </style>
</head>

<body>

    <header>
        <a href="{{ route('home') }}">← Kembali</a>
    </header>

    @php
        $defaultVarian = $produk->varians->first();
        $defaultGambar = $defaultVarian?->gambar->first();
    @endphp

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
                        <img src="{{ asset('storage/' . $g->path_gambar) }}"
                            onclick="document.getElementById('mainImage').src=this.src">
                    @endforeach
                </div>
            </div>

            {{-- INFO --}}
            <div>
                <h2>{{ $produk->nama_produk }}</h2>

                <div class="price" id="price">
                    @if ($defaultVarian && $defaultVarian->is_diskon)
                        <del>Rp {{ number_format($defaultVarian->harga, 0, ',', '.') }}</del><br>
                        <span>Rp {{ number_format($defaultVarian->harga_final, 0, ',', '.') }}</span>
                    @else
                        Rp {{ number_format($defaultVarian->harga ?? 0, 0, ',', '.') }}
                    @endif
                </div>

                <p>{{ $produk->deskripsi }}</p>

                <strong>Varian:</strong><br><br>

                @foreach ($produk->varians as $i => $v)
                    <button class="variant-btn {{ $i == 0 ? 'active' : '' }}" onclick="changeVarian(this)"
                        data-harga="{{ $v->harga }}" data-harga-final="{{ $v->harga_final }}"
                        data-diskon="{{ $v->is_diskon }}" data-gambar='@json($v->gambar)'>
                        {{ $v->nama_varian }}
                    </button>
                @endforeach

                <br><br>
                <button class="btn-cart">Tambah ke Keranjang</button>
            </div>

        </div>
    </div>

    <script>
        function changeVarian(el) {
            document.querySelectorAll('.variant-btn').forEach(b => b.classList.remove('active'));
            el.classList.add('active');

            const harga = el.dataset.harga;
            const hargaFinal = el.dataset.hargaFinal;
            const diskon = el.dataset.diskon == 1;

            const price = document.getElementById('price');
            if (diskon) {
                price.innerHTML =
                    `<del>Rp ${Number(harga).toLocaleString('id-ID')}</del><br>
             <span>Rp ${Number(hargaFinal).toLocaleString('id-ID')}</span>`;
            } else {
                price.innerText = 'Rp ' + Number(harga).toLocaleString('id-ID');
            }

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
        }
    </script>

</body>

</html>
