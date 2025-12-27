<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Produk</title>
    <style>
        body {
            font-family: Arial;
            background: #f5f5f5;
            padding: 20px
        }

        .card {
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            max-width: 600px;
            margin: auto
        }

        label {
            display: block;
            margin-top: 12px;
            font-weight: bold
        }

        input,
        textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px
        }

        button {
            margin-top: 15px;
            padding: 8px 16px;
            background: #0d6efd;
            color: #fff;
            border: none
        }

        a {
            margin-left: 10px;
            text-decoration: none
        }
    </style>
</head>

<body>

    <div class="card">
        <h2>Edit Produk</h2>

        <form action="{{ route('admin.produk.update', $produk->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label>Nama Produk</label>
            <input type="text" name="nama_produk" value="{{ old('nama_produk', $produk->nama_produk) }}" required>

            <label>Kategori</label>
            <select name="id_kategori" required>
                @foreach ($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" {{ $produk->id_kategori == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>

            <label>Deskripsi</label>
            <textarea name="deskripsi" rows="4" required>{{ old('deskripsi', $produk->deskripsi) }}</textarea>

            <button type="submit">Update Produk</button>
            <a href="{{ route('admin.produk.index') }}">Kembali</a>
        </form>

    </div>

</body>

</html>
