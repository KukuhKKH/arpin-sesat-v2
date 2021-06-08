<table class="table table-bordered table-hovered">
    <thead>
        <tr class="text-center">
            <th rowspan="2">Tanggal</th>
            <th colspan="3">Masuk</th>
            <th colspan="3">Keluar</th>
            <th colspan="3">Total Saldo</th>
        </tr>
        <tr>
            <td>Qty</td>
            <td>Harga</td>
            <td>Total</td>
            <td>Qty</td>
            <td>Harga</td>
            <td>Total</td>
            <td>Qty</td>
            <td>Harga</td>
            <td>Total</td>
        </tr>
    </thead>
    <tbody>
        @foreach ($material as $value)
            <tr>
                <td>{{ date('d F Y', strtotime(isset($value['date_in']) ? $value['date_in'] : $value['date_out'])) }}</td>
                @if (isset($value['qty_in']))
                    <td>{{ $value['qty_in'] }}</td>
                    <td>Rp. {{ number_format($value['price_in']) }}</td>
                    <td>Rp. {{ number_format($value['qty_in'] * $value['price_in']) }}</td>
                @else
                    <td></td><td></td><td></td>
                @endif
                @if (isset($value['qty_out']))
                    <td>{{ $value['qty_out'] }}</td>
                    <td>Rp. {{ number_format($value['price_out']) }}</td>
                    <td>Rp. {{ number_format($value['qty_out'] * $value['price_out']) }}</td>
                @else
                    <td></td><td></td><td></td>
                @endif
                @php
                    $total_amount = (isset($value['qty_in']) ? $value['qty_in'] : 0) - (isset($value['qty_out']) ? $value['qty_out'] : 0);
                    $total_price = (isset($value['price_in']) ? $value['price_in'] : 0) - (isset($value['price_out']) ? $value['price_out'] : 0);
                    $subtotal = $total_amount * $total_price;
                @endphp
                <td>{{ $total_amount }}</td>
                <td>Rp. {{ number_format($total_price) }}</td>
                <td>Rp. {{ number_format($subtotal) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
