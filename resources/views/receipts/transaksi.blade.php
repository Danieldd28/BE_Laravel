<!DOCTYPE html>
<html>
<head>
    <title>Transaksi Receipt</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total { text-align: right; }
    </style>
</head>
<body>
    <h2>Receipt</h2>
    <p><strong>Transaksi ID:</strong> {{ $transaksi->id_transaksi }}</p>
    <p><strong>Nama Pelanggan:</strong> {{ $transaksi->nama_pelanggan }}</p>
    <p><strong>Meja:</strong> {{ $transaksi->meja->nomor_meja }}</p>
    <p><strong>Kasir:</strong> {{ $transaksi->user->nama_user }}</p>
    <p><strong>Status:</strong> {{ ucfirst($transaksi->status) }}</p>
    <p><strong>Tanggal:</strong> {{ $transaksi->tgl_transaksi->format('d-m-Y H:i') }}</p>

    <h3>Items</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Menu</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; $grandTotal = 0; @endphp
            @foreach($transaksi->detailTransaksis as $item)
                @php
                    $total = $item->jumlah * $item->harga;
                    $grandTotal += $total;
                @endphp
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->menu->nama_menu }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                </tr>
            @endforeach
            <tr>
                <td colspan="4" class="total"><strong>Grand Total</strong></td>
                <td><strong>Rp {{ number_format($grandTotal, 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>

    <p>Thank you for your business!</p>
</body>
</html>
