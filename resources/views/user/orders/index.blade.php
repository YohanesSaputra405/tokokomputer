<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>My Orders</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f6f9;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background: #0d6efd;
            color: white;
        }

        a {
            color: #0d6efd;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="container">
        @if (session('success'))
            <div style="background: #d1e7dd; padding:10px; margin-bottom:15px; border-radius:5px">
                {{ session('success') }}
            </div>
        @endif

        <h2>My Orders</h2>

        @if ($orders->isEmpty())
            <p>Belum ada pesanan.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Kode Order</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td>{{ $order->kode_order }}</td>
                            <td>Rp {{ number_format($order->total_harga) }}</td>
                            <td>{{ ucfirst($order->status) }}</td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('orders.show', $order->id) }}">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

</body>

</html>
