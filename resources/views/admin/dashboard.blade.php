<!DOCTYPE html>
<html>

<head>
    <title>Admin Dashboard</title>
</head>

<body>
    <a href="{{ route('admin.kategori.index') }}">Kelola Kategori</a>
    <br>
    <br>
    <a href="{{ route('admin.produk.index') }}">Kelola Produk</a>
    <h1>Admin Dashboard</h1>
    <p>Login sebagai admin</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Logout</button>
    </form>

</body>

</html>
