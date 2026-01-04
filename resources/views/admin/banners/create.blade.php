<!DOCTYPE html>
<html>

<head>
    <title>Tambah Banner</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 900px;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
        }

        h1 {
            margin-bottom: 20px;
        }

        a.button {
            display: inline-block;
            padding: 8px 14px;
            background: #0d6efd;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        a.button:hover {
            background: #0b5ed7;
        }

        .banner-card {
            display: flex;
            gap: 15px;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .banner-card img {
            width: 200px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
        }

        .banner-info {
            flex: 1;
        }

        .actions a,
        .actions button {
            margin-right: 10px;
        }

        button {
            padding: 6px 12px;
            border: none;
            background: #dc3545;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background: #bb2d3b;
        }

        form label {
            display: block;
            margin-top: 12px;
            font-weight: bold;
        }

        form input,
        form textarea {
            width: 100%;
            padding: 8px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        form button.submit {
            background: #198754;
            margin-top: 15px;
        }

        form button.submit:hover {
            background: #157347;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Tambah Banner</h1>

        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label>Judul</label>
            <input type="text" name="judul" required>

            <label>Deskripsi</label>
            <textarea name="deskripsi"></textarea>

            <label>Gambar Banner</label>
            <input type="file" name="gambar" required>

            <label>Status</label>
            <select name="status" required>
                <option value="1">Aktif</option>
                <option value="0">Nonaktif</option>
            </select>
            <br><br>

            <button type="submit" class="submit">Simpan</button>
        </form>
    </div>

</body>

</html>
