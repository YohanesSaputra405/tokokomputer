<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Order</title>
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
            margin-top: 15px;
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

        .info p {
            margin: 5px 0;
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

        <h2>Invoice Order</h2>

        <div class="info">
            <p><strong>Kode Order:</strong> {{ $order->kode_order }}</p>
            <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
            <p><strong>Metode Pembayaran:</strong> {{ $order->metode_pembayaran }}</p>
            <p><strong>Alamat Pengiriman:</strong> {{ $order->alamat_pengiriman }}</p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                    <tr>
                        <td>{{ $item->produk->nama_produk }}</td>
                        <td>Rp {{ number_format($item->harga) }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>Rp {{ number_format($item->harga * $item->qty) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3 style="text-align:right; margin-top:15px;">
            Total: Rp {{ number_format($order->total_harga) }}
        </h3>
    </div>

</body>

</html>
