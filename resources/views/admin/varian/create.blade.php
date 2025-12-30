<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Tambah Varian</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }

        .card {
            background: #fff;
            padding: 24px;
            border-radius: 8px;
            max-width: 500px;
            margin: 40px auto;
        }

        h2 {
            margin-bottom: 5px;
        }

        .info {
            background: #eef5ff;
            padding: 10px;
            border-left: 4px solid #0d6efd;
            margin-bottom: 15px;
            font-size: 14px;
        }

        label {
            display: block;
            margin-top: 12px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
        }

        .actions {
            margin-top: 20px;
        }

        button {
            padding: 8px 16px;
            background: #0d6efd;
            color: #fff;
            border: none;
            border-radius: 4px;
        }

        a {
            margin-left: 10px;
            text-decoration: none;
            color: #555;
        }
    </style>
</head>

<body>

    <div class="card">
        <h2>Tambah Varian</h2>
        <p>Produk: <strong>{{ $produk->nama_produk }}</strong></p>

        <div class="info">
            Setelah varian disimpan, kamu bisa mengupload
            <strong>banyak gambar</strong> di halaman berikutnya.
        </div>

        <form action="{{ route('admin.produk.varian.store', $produk->id) }}" method="POST">
            @csrf

            <label>Nama Varian</label>
            <input type="text" name="nama_varian" placeholder="Contoh: RAM 16GB DDR4" required>

            <label>Harga</label>
            <input type="number" name="harga" placeholder="Contoh: 750000" required>

            <label>Stok</label>
            <input type="number" name="stok" placeholder="Contoh: 10" required>

            <div class="actions">
                <button type="submit"
                    onclick="this.disabled=true; this.innerText='Menyimpan...'; this.form.submit();">Simpan & Lanjut
                    Upload Gambar</button>
                <a href="{{ route('admin.produk.varian.index', $produk->id) }}">Batal</a>
            </div>
        </form>
    </div>

</body>

</html>
