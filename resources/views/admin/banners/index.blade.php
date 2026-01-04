<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Kelola Banner</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
        }

        h1 {
            margin-bottom: 20px;
        }

        .top-actions {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        a.button {
            padding: 8px 14px;
            background: #0d6efd;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
        }

        a.button.back {
            background: #6c757d;
        }

        a.button:hover {
            opacity: .9;
        }

        .alert {
            padding: 12px;
            background: #d1e7dd;
            color: #0f5132;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .banner-card {
            display: flex;
            gap: 15px;
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 15px;
            align-items: center;
        }

        .banner-card img {
            width: 220px;
            height: 90px;
            object-fit: cover;
            border-radius: 4px;
            flex-shrink: 0;
        }

        .banner-info {
            flex: 1;
        }

        .banner-info h3 {
            margin: 0 0 6px;
        }

        .banner-info p {
            margin: 0 0 8px;
            color: #555;
        }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 12px;
            color: #fff;
        }

        .badge.active {
            background: #198754;
        }

        .badge.inactive {
            background: #dc3545;
        }

        .actions {
            display: flex;
            gap: 8px;
        }

        .actions a {
            padding: 6px 12px;
            background: #ffc107;
            color: #000;
            border-radius: 4px;
            font-size: 13px;
            text-decoration: none;
        }

        .actions a:hover {
            background: #e0a800;
        }

        .actions button {
            padding: 6px 12px;
            border: none;
            background: #dc3545;
            color: #fff;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
        }

        .actions button:hover {
            background: #bb2d3b;
        }

        .empty {
            text-align: center;
            padding: 40px;
            color: #777;
        }
    </style>
</head>

<body>

    <div class="container">

        <h1>Kelola Banner</h1>

        <div class="top-actions">
            <a href="{{ route('admin.banners.create') }}" class="button">+ Tambah Banner</a>
            <a href="{{ route('admin.dashboard') }}" class="button back">← Dashboard</a>
        </div>

        @if (session('success'))
            <div class="alert">
                {{ session('success') }}
            </div>
        @endif

        @forelse ($banners as $banner)
            <div class="banner-card">

                <img src="{{ asset('storage/' . $banner->gambar) }}" alt="Banner">

                <div class="banner-info">
                    <h3>{{ $banner->judul }}</h3>
                    <p>{{ $banner->deskripsi }}</p>

                    <span class="badge {{ $banner->status ? 'active' : 'inactive' }}">
                        {{ $banner->status ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>

                <div class="actions">
                    <a href="{{ route('admin.banners.edit', $banner->id) }}">Edit</a>

                    <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST"
                        onsubmit="return confirm('Yakin hapus banner ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Hapus</button>
                    </form>
                </div>

            </div>
        @empty
            <div class="empty">
                Belum ada banner.
            </div>
        @endforelse

    </div>

</body>

</html>
