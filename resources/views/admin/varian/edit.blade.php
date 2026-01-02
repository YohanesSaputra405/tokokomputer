<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Varian</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }

        .card {
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            max-width: 900px;
            margin: auto;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
        }

        h2,
        h3,
        h4 {
            margin-bottom: 10px;
        }

        label {
            display: block;
            margin-top: 12px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }

        button {
            margin-top: 15px;
            padding: 8px 16px;
            cursor: pointer;
            border: none;
            background: #0d6efd;
            color: #fff;
            border-radius: 4px;
        }

        .btn-back {
            margin-left: 10px;
            color: #0d6efd;
            text-decoration: none;
        }

        hr {
            margin: 30px 0;
        }

        .hint {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }

        .gallery {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
            gap: 15px;
            margin-top: 15px;
        }

        .gallery img {
            width: 100%;
            height: 130px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #ddd;
        }

        .empty {
            color: #888;
            font-style: italic;
        }

        .img-varian {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid #ddd;
            margin: 6px;
        }
    </style>
</head>

<body>

    <!-- ================= EDIT VARIAN + DISKON ================= -->
    <h2>Edit Varian</h2>
    <p>Produk: <strong>{{ $produk->nama_produk }}</strong></p>

    <form action="{{ route('admin.produk.varian.update', [$produk->id, $varian->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nama Varian</label>
        <input type="text" name="nama_varian" value="{{ $varian->nama_varian }}" required>

        <label>Harga</label>
        <input type="number" name="harga" value="{{ $varian->harga }}" required>

        <label>Stok</label>
        <input type="number" name="stok" value="{{ $varian->stok }}" required>

        <hr>

        <!-- ================= DISKON VARIAN ================= -->
        <h3>Diskon Varian</h3>

        <label>
            <input type="checkbox" name="is_diskon" value="1" {{ $varian->is_diskon ? 'checked' : '' }}>
            Aktifkan Diskon
        </label>

        <br><br>

        <select name="diskon_tipe">
            <option value="">-- Pilih Tipe --</option>
            <option value="persen" {{ $varian->diskon_tipe == 'persen' ? 'selected' : '' }}>
                Persen (%)
            </option>
            <option value="nominal" {{ $varian->diskon_tipe == 'nominal' ? 'selected' : '' }}>
                Nominal (Rp)
            </option>
        </select>

        <br><br>

        <input type="number" name="diskon_nilai" value="{{ $varian->diskon_nilai }}" placeholder="Nilai Diskon">

        <br><br>

        <input type="datetime-local" name="diskon_mulai"
            value="{{ optional($varian->diskon_mulai)->format('Y-m-d\TH:i') }}">

        <input type="datetime-local" name="diskon_selesai"
            value="{{ optional($varian->diskon_selesai)->format('Y-m-d\TH:i') }}">

        <br><br>

        <button type="submit">Update Varian</button>
        <a href="{{ route('admin.produk.varian.index', $produk->id) }}">Kembali</a>
    </form>

    <!-- ================= UPLOAD GAMBAR ================= -->
    <h3>Upload Gambar Varian</h3>

    <form action="{{ route('admin.produk.varian.gambar.store', [$produk->id, $varian->id]) }}" method="POST"
        enctype="multipart/form-data">

        @csrf

        <label>Pilih Gambar</label>
        <input type="file" name="gambar[]" multiple onchange="previewGambar(this)" required>
        <div id="preview"></div>

        <div class="hint">
            • Bisa upload <strong>lebih dari satu gambar</strong><br>
            • Format: JPG, PNG, WEBP<br>
            • Maksimal 2MB per gambar
        </div>

        <button type="submit">Upload Gambar</button>
    </form>

    <hr>

    <!-- ================= GALERI GAMBAR ================= -->
    <h4>Gambar Saat Ini</h4>

    <div class="gallery">
        @forelse ($varian->gambar as $img)
            <div style="text-align:center">

                <img src="{{ asset('storage/' . $img->path_gambar) }}" class="img-varian">

                @if ($img->is_primary)
                    <div style="color:green;font-weight:bold">⭐ Gambar Utama</div>
                @else
                    <form method="POST" action="{{ route('admin.gambar-varian.primary', $img->id) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit">Jadikan Utama</button>
                    </form>
                @endif

                <form method="POST" action="{{ route('admin.gambar-varian.destroy', $img->id) }}"
                    onsubmit="return confirm('Hapus gambar ini?')">
                    @csrf
                    @method('DELETE')
                    <button style="background:#dc3545;margin-top:5px">Hapus</button>
                </form>

            </div>
        @empty
            <p class="empty">Belum ada gambar.</p>
        @endforelse
    </div>

    </div>

</body>
<script>
    function previewGambar(input) {
        const preview = document.getElementById('preview');
        preview.innerHTML = '';

        Array.from(input.files).forEach(file => {
            const reader = new FileReader();

            reader.onload = e => {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'img-varian';
                preview.appendChild(img);
            };

            reader.readAsDataURL(file);
        });
    }
</script>

</html>
