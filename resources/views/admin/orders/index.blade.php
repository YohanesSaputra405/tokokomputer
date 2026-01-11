<h2>Kelola Order</h2>
<a href="{{ route('admin.dashboard') }}">kembali</a>

<table border="1" cellpadding="10">
    <tr>
        <th>Kode Order</th>
        <th>User</th>
        <th>Total</th>
        <th>Status</th>
        <th>Tanggal</th>
        <th>Aksi</th>
    </tr>

    @foreach ($orders as $order)
        <tr>
            <td>{{ $order->kode_order }}</td>
            <td>{{ $order->user->name }}</td>
            <td>Rp {{ number_format($order->total_harga) }}</td>
            <td>{{ ucfirst($order->status) }}</td>
            <td>{{ $order->created_at->format('d-m-Y') }}</td>
            <td>
                <a href="{{ route('admin.orders.show', $order->id) }}">Detail</a>
            </td>
        </tr>
    @endforeach
</table>
