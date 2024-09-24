<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Transaksi</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        h1 {
            margin-bottom: 20px;
        }
        .table {
            margin-top: 20px;
        }
        .detail-list {
            list-style-type: none;
            padding-left: 0;
        }
        .detail-list li {
            background: #e9ecef;
            margin: 5px 0;
            padding: 10px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">History Transaksi</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered ">
            <thead class="thead-dark">
                <tr>
                    <th>No Transaksi</th>
                    <th>Tanggal Transaksi</th>
                    <th>Total</th>
                    <th>Keterangan</th>
                    <th>Detail</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->no_transaksi }}</td>
                        <td>{{ $transaction->tgl_transaksi->format('Y-m-d') }}</td>
                        <td>{{ number_format($transaction->total, 2) }}</td>
                        <td>{{ $transaction->keterangan ?: '-' }}</td>
                        <td>
                            <ul class="detail-list">
                                @foreach ($transaction->details as $detail)
                                    <li>
                                        {{ $detail->item->nama_barang }} - Qty: {{ $detail->qty }} - Harga: {{ number_format($detail->harga, 2) }} - Subtotal: {{ number_format($detail->subtotal, 2) }}
                                    </li>
                                @endforeach
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
