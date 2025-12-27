<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Varian Produk</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
        }

        .card {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        th {
            background: #eee;
        }

        .btn {
            padding: 6px 12px;
            text-decoration: none;
            border-radius: 4px;
        }

        .btn-primary {
            background: #0d6efd;
            color: #fff;
        }

        .btn-warning {
            background: #ffc107;
            color: #000;
        }

        .btn-danger {
            background: #dc3545;
            color: #fff;
        }

        .img-varian {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 6px;
            border: 1px solid #ddd;
            margin: 5px;
        }
    </style>
</head>

<body>

    <div class="card">
        <h2>Varian Produk: {{ $produk->nama_produk }}</h2>

        <div class="top-bar">
            <a href="{{ route('admin.produk.index') }}" class="btn btn-back">
                ← Kembali ke Produk
            </a>

            <a href="{{ route('admin.produk.varian.create', $produk->id) }}" class="btn btn-primary">
                + Tambah Varian
            </a>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Varian</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Gambar Varian</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($varians as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_varian }}</td>
                            <td>Rp {{ number_format($item->harga) }}</td>
                            <td>{{ $item->stok }}</td>
                            <td>
                                @foreach ($item->gambar as $img)
                                    <img src="{{ asset('storage/' . $img->path_gambar) }}" width="120"
                                        class="img-varian">
                                @endforeach
                            </td>
                            <td>
                                <a href="{{ route('admin.produk.varian.edit', [$produk->id, $item->id]) }}"
                                    class="btn btn-warning">Edit</a>

                                <form action="{{ route('admin.produk.varian.destroy', [$produk->id, $item->id]) }}"
                                    method="POST" style="display:inline"
                                    onsubmit="return confirm('Yakin hapus varian?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Belum ada varian</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

</body>

</html>
