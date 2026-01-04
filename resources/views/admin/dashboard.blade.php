<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        header {
            background: #343a40;
            color: #fff;
            padding: 15px 30px;
        }

        header h1 {
            margin: 0;
            font-size: 20px;
        }

        .container {
            padding: 30px;
        }

        .card {
            background: #fff;
            padding: 20px;
            border-radius: 6px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .1);
            margin-bottom: 20px;
        }

        .menu a {
            display: inline-block;
            margin-right: 15px;
            padding: 10px 15px;
            background: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }

        .menu a:hover {
            background: #0056b3;
        }

        .logout {
            margin-top: 20px;
        }

        button {
            padding: 8px 14px;
            border: none;
            background: #dc3545;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background: #b52a37;
        }

        .menu a.banner {
            background: #198754;
        }

        .menu a.banner:hover {
            background: #157347;
        }
    </style>
</head>

<body>

    <header>
        <h1>Admin Panel</h1>
    </header>

    <div class="container">

        <div class="card">
            <h2>Dashboard</h2>
            <p>Halo, <b>{{ auth()->user()->name }}</b></p>
        </div>

        <div class="card menu">
            <a href="{{ route('admin.kategori.index') }}">Kelola Kategori</a>
            <a href="{{ route('admin.produk.index') }}">Kelola Produk</a>
            <a href="{{ route('admin.banners.index') }}" class="banner">Kelola Banner</a>
        </div>


        <div class="logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>

    </div>

</body>

</html>
