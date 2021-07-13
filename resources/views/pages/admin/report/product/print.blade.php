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
        <center>Laporan Harga Pokok Produksi</center>
    </h3>

    <h3>
        <center>{{ $product->name }}</center>
    </h3>
    <p>
        <center> Maret {{ date('Y') }}</center>
    </p>
    <div class="container">
        <table class="table table-bordered table-hovered">
            <tbody>
                <tr>
                    <td>Biaya Bahan Baku</td>
                    <td></td>
                    <td>Rp {{ number_format($total_material) }}</td>
                </tr>
                <tr>
                    <td>Biaya Tenaga Kerja</td>
                    <td></td>
                    <td>Rp. {{ number_format($total_salary) }}</td>
                </tr>
                <tr>
                    <td>BOP</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td>Biaya Overhead Pabrik Tetap</td>
                    <td>Rp {{ number_format($total_overhead_fix) }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Biaya Overhead Pabrik Variabel</td>
                    <td>Rp {{ number_format($total_overhead_var) }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Biaya Bahan Penolong</td>
                    <td>Rp. {{ number_format($total_material_helper) }}</td>
                    <td></td>
                </tr>
                @php
                    $subtotal_bop = $total_material + $total_salary;
                    $subtotal = $total_overhead_fix + $total_overhead_var + $total_material_helper;
                @endphp
                <tr>
                    <td>Total BOP</td>
                    <td></td>
                    <td>Rp {{ number_format($subtotal) }}</td>
                </tr>
                <tr>
                    @php
                        $total = $subtotal + $subtotal_bop
                    @endphp
                    <td>Biaya Produksi</td>
                    <td></td>
                    <td>Rp {{ number_format($total) }}</td>
                </tr>
                <tr>
                    <td>Produk Dalam Proses Awal</td>
                    <td></td>
                    <td>Rp {{ number_format(0) }}</td>
                </tr>
                <tr>
                    <td>Produk Selesai</td>
                    <td></td>
                    <td>Rp {{ number_format($total) }}</td>
                </tr>
                <tr>
                    <td>Produk Dalam Proses Akhir</td>
                    <td></td>
                    <td>Rp {{ number_format(0) }}</td>
                </tr>
                <tr>
                    <td>Harga Pokok Produksi</td>
                    <td></td>
                    <td>Rp {{ number_format($total) }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    <script>
        window.print()
    </script>
</body>
</html>
