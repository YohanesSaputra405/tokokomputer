<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $produk->nama_produk }}</title>

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
        }

        header a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
        }

        .container {
            padding: 30px;
            max-width: 900px;
            margin: auto;
        }

        .card {
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 3px 6px rgba(0, 0, 0, .1);
            display: flex;
            gap: 30px;
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

        .variant-list {
            margin: 15px 0;
        }

        .variant-btn {
            padding: 6px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-right: 6px;
            cursor: pointer;
            background: #f8f9fa;
        }

        .variant-btn.active {
            background: #0d6efd;
            color: #fff;
            border-color: #0d6efd;
        }

        .price {
            font-size: 22px;
            color: #198754;
            font-weight: bold;
            margin: 10px 0;
        }

        .btn {
            padding: 10px 16px;
            background: #198754;
            color: #fff;
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
                        src="{{ $defaultGambar ? asset('storage/' . $defaultGambar->path_gambar) : 'https://via.placeholder.com/320' }}">
                </div>

                <div class="thumbs" id="thumbs">
                    @foreach ($defaultVarian?->gambar ?? [] as $g)
                        <img src="{{ asset('storage/' . $g->path_gambar) }}"
                            onclick="document.getElementById('mainImage').src=this.src">
                    @endforeach
                </div>
            </div>

            {{-- INFO --}}
            <div class="info">
                <h2>{{ $produk->nama_produk }}</h2>

                <div class="price" id="price">
                    Rp {{ number_format($defaultVarian->harga ?? 0, 0, ',', '.') }}
                </div>

                <p>{{ $produk->deskripsi }}</p>

                {{-- VARIAN --}}
                <div class="variant-list">
                    <strong>Varian:</strong><br><br>

                    @foreach ($produk->varians as $index => $v)
                        <button class="variant-btn {{ $index === 0 ? 'active' : '' }}" data-harga="{{ $v->harga }}"
                            data-gambar='@json($v->gambar)' onclick="changeVarian(this)">
                            {{ $v->nama_varian }}
                        </button>
                    @endforeach
                </div>

                <button class="btn">Tambah ke Keranjang</button>
            </div>
        </div>
    </div>

    <script>
        function changeVarian(el) {

            // aktifkan tombol
            document.querySelectorAll('.variant-btn')
                .forEach(b => b.classList.remove('active'));
            el.classList.add('active');

            // update harga
            const harga = el.dataset.harga;
            document.getElementById('price').innerText =
                'Rp ' + new Intl.NumberFormat('id-ID').format(harga);

            // update gambar
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
