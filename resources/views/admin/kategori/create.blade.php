<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tambah Kategori</title>
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
        <h1>Tambah Kategori</h1>

        <form action="{{ route('admin.kategori.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}" autofocus>
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>

</body>

</html>
