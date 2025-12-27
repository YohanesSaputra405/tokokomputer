<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kelola Kategori</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f6fa;
            padding: 30px;
        }

        h1 {
            margin-bottom: 20px;
        }

        a {
            text-decoration: none;
            color: #3498db;
        }

        .card {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            max-width: 800px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        table th {
            background-color: #2c3e50;
            color: white;
        }

        .btn {
            padding: 6px 12px;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background-color: #3498db;
            color: white;
        }

        .btn-warning {
            background-color: #f39c12;
            color: white;
        }

        .btn-danger {
            background-color: #e74c3c;
            color: white;
        }

        .btn-secondary {
            background-color: #7f8c8d;
            color: white;
        }

        form {
            display: inline;
        }

        input[type="text"] {
            width: 100%;
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .form-group {
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <div class="card">
        <h1>Kelola Produk</h1>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
            Kembali
        </a>
        <br><br>

        <a href="{{ route('admin.produk.create') }}" class="btn btn-primary">
            + Tambah Produk
        </a>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($produk as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_produk }}</td>
                        <td>{{ $item->kategori ? $item->kategori->nama_kategori : '-' }}</td>
                        <td>{{ $item->deskripsi }}</td>


                        <td>
                            <a href="{{ route('admin.produk.varian.index', $item->id) }}" class="btn btn-info">
                                Varian
                            </a>
                            <a href="{{ route('admin.produk.edit', $item->id) }}" class="btn btn-warning">
                                Edit
                            </a>

                            <form action="{{ route('admin.produk.destroy', $item->id) }}" method="POST"
                                onsubmit="return confirm('Yakin mau hapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">Data Produk masih kosong</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</body>

</html>
