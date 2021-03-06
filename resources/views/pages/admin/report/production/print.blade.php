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
    <p>
        <center> per 31 Maret {{ date('Y') }}</center>
    </p>
    <div class="container">
        <table class="table table-bordered table-hovered">
            <tbody>
                <tr>
                    <td>Persediaan Bahan Baku Awal</td>
                    <td>Rp {{ number_format($total_stock_material) }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Pembelian Bahan Baku</td>
                    <td>Rp. {{ number_format($total_buying_material) }}</td>
                    <td></td>
                </tr>
                <tr>
                    @php
                    $subtotal_material = $total_stock_material + $total_buying_material
                    @endphp
                    <td></td>
                    <td>Rp {{ number_format($subtotal_material) }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Persediaan Bahan Baku Akhir</td>
                    <td>Rp {{ number_format($total_stock_material_end) }}</td>
                    <td></td>
                </tr>
                <tr>
                    @php
                    $subtotal_used_meterial = $subtotal_material - $total_stock_material_end
                    @endphp
                    <td>Pemakaian Bahan Baku</td>
                    <td></td>
                    <td>Rp {{ number_format($subtotal_used_meterial) }}</td>
                </tr>
                <tr>
                    <td>Biaya Tenaga Kerja</td>
                    <td></td>
                    <td>Rp {{ number_format($total_salary) }}</td>
                </tr>
                @php
                $subtotal = $subtotal_used_meterial + $total_salary
                @endphp
                <tr>
                    <td>BOP :</td>
                    <td></td>
                    <td></td>
                </tr>
                @php
                $subtotal_bop = $total_overhead_fix + $total_overhead_var + $total_help_material
                @endphp
                <tr>
                    <td>Overhead Tetap</td>
                    <td>Rp {{ number_format($total_overhead_fix) }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Overhead Variabel</td>
                    <td>Rp {{ number_format($total_overhead_var) }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Biaya Penolong</td>
                    <td>Rp {{ number_format($total_help_material) }}</td>
                    <td></td>
                </tr>
                <tr>
                    <td>Total BOP</td>
                    <td></td>
                    <td>Rp {{ number_format($subtotal_bop) }}</td>
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
                    <td>Rp {{ number_format($total_dalamproses_awal) }}</td>
                </tr>
                <tr>
                    @php
                        $total = $subtotal + $subtotal_bop
                    @endphp
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
                    @php
                        $total = $subtotal + $subtotal_bop
                    @endphp
                    <td>Harga Pokok Produksi</td>
                    <td></td>
                    <td>Rp {{ number_format($total) }}</td>
            </tbody>
        </table>
    </div>
    <script>
        window.print()
    </script>
</body>
</html>
