<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Checkout</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, .1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }

        table th {
            background: #0d6efd;
            color: white;
        }

        .total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .btn {
            margin-top: 20px;
            padding: 12px 20px;
            background: #0d6efd;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .error {
            background: #f8d7da;
            color: #842029;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Checkout</h2>

        @if ($errors->any())
            <div class="error">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf

            {{-- 🔥 WAJIB: KIRIM CART IDS --}}
            @foreach ($cartItems as $item)
                <input type="hidden" name="cart_ids[]" value="{{ $item->id }}">
            @endforeach

            <h4>Daftar Produk</h4>

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
                    @foreach ($cartItems as $item)
                        <tr>
                            <td>
                                {{ $item->produk->nama_produk }}
                                @if ($item->varian)
                                    <br><small>({{ $item->varian->nama_varian }})</small>
                                @endif
                            </td>
                            <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td>{{ $item->qty }}</td>
                            <td>
                                Rp {{ number_format($item->harga * $item->qty, 0, ',', '.') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="total">
                Total: Rp {{ number_format($total, 0, ',', '.') }}
            </div>

            <label>Alamat Pengiriman</label>
            <textarea name="alamat_pengiriman" rows="4" required></textarea>

            <label style="margin-top:15px; display:block;">Metode Pembayaran</label>
            <select name="metode_pembayaran" required>
                <option value="">-- Pilih Metode --</option>
                <option value="transfer_bank">Transfer Bank</option>
                <option value="cod">COD</option>
            </select>

            <button type="submit" class="btn">
                Buat Pesanan
            </button>
        </form>
    </div>

</body>

</html>
