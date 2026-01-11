<h2>Detail Order Admin</h2>

<a href="{{ route('admin.orders.index') }}">Kembali</a>

<p><b>User:</b> {{ $order->user->name }}</p>
<p><b>Kode Order:</b> {{ $order->kode_order }}</p>
<p><b>Alamat:</b>{{ $order->alamat_pengiriman }}</p>
<p><b>Metode Bayar:</b>{{ $order->metode_pembayaran }}</p>
<p><b>Status:</b> {{ ucfirst($order->status) }}</p>

@php
    $allowedStatus = match ($order->status) {
        'pending' => ['paid', 'canceled'],
        'paid' => ['shipped'],
        'shipped' => ['completed'],
        default => [],
    };
@endphp

@if (count($allowedStatus))
    <form method="POST" action="{{ route('admin.orders.updateStatus', $order->id) }}">
        @csrf
        @method('PATCH')

        <select name="status" required>
            @foreach ($allowedStatus as $status)
                <option value="{{ $status }}">
                    {{ ucfirst($status) }}
                </option>
            @endforeach
        </select>

        <button type="submit">Update Status</button>
    </form>
@else
    <p><i>Status sudah final</i></p>
@endif


<hr>

<table border="1" cellpadding="10">
    <tr>
        <th>Produk</th>
        <th>Harga</th>
        <th>Qty</th>
        <th>Subtotal</th>
    </tr>

    @foreach ($order->items as $item)
        <tr>
            <td>{{ $item->produk->nama_produk }}</td>
            <td>Rp {{ number_format($item->harga) }}</td>
            <td>{{ $item->qty }}</td>
            <td>Rp {{ number_format($item->harga * $item->qty) }}</td>
        </tr>
    @endforeach
</table>
