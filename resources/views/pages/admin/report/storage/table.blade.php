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
        @php
            $saldo_qty = 0;
            $saldo_price = 0;
            $saldo_total = 0;
        @endphp
        @foreach ($product as $key => $value)
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
                $total_price = isset($value['price_in']) ? $value['price_in'] : $value['price_out'];
                $subtotal = $total_amount * $total_price;

                $saldo_total += $subtotal;
                $saldo_qty += $total_amount;
                $saldo_price = $total_price;
            @endphp
            <td>{{ $total_amount }}</td>
            <td>Rp. {{ number_format($total_price) }}</td>
            <td>Rp. {{ number_format($subtotal) }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="7" class="text-right">Saldo</td>
            <td>{{ $saldo_qty }}</td>
            <td>Rp. {{ number_format($saldo_price) }}</td>
            <td>Rp. {{ number_format($saldo_total) }}</td>
        </tr>
    </tbody>
</table>
