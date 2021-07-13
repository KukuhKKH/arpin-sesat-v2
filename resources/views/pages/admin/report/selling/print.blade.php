<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print</title>
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.css') }}">
</head>

<body>
    <h1>
        <center>UD Langgeng Gypsum Ponorogo</center>
    </h1>
    <h3>
        <center>Laporan Penjualan Produk</center>
    </h3>
    <p>
        <center>{{ date('D d F Y') }}</center>
    </p>

    <div class="container">
        <table class="table table-bordered">
            <thead style="background-color: grey">
                <tr>
                    <th>Tanggal</th>
                    {{-- <th>No Pesanan</th> --}}
                    <th>Nama Pelanggan</th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php $subtotal = 0 ?>
                @forelse ($selling as $value)
                <tr>
                    <td>{{ date('d F Y', strtotime($value->date)) }}</td>
                    {{-- <td>{{ $value->invoice }}</td> --}}
                    <td>{{ $value->customer->name }}</td>
                    <td>{{ $value->product->name }}</td>
                    <td>{{ $value->amount }}</td>
                    <td>{{ $value->product->price }}</td>
                    <td>Rp. {{ number_format(($value->amount * $value->product->price)) }}</td>
                    <?php $subtotal += ($value->amount * $value->product->price) ?>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <center>Tidak ada data</center>
                    </td>
                </tr>
                @endforelse
            </tbody>
            <tfoot style="background-color: grey">
                <tr>
                    <th colspan="5" class="text-right">Total</th>
                    <th>Rp. {{ number_format($subtotal) }}</th>
                </tr>
            </tfoot>

        </table>
    </div>

</body>

</html>
