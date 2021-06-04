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
        @foreach ($material->transaction as $value)
            <tr>
                <td>{{ date('d F Y', strtotime($value->date)) }}</td>
                <td>{{ $value->amount }}</td>
                <td>Rp. {{ number_format($value->price) }}</td>
                <td>Rp. {{ number_format($value->amount * $value->price) }}</td>
                <td></td><td></td><td></td>
                <td>{{ $value->amount }}</td>
                <td>Rp. {{ number_format($value->price) }}</td>
                <td>Rp. {{ number_format($value->amount * $value->price) }}</td>
            </tr>
        @endforeach
        @foreach ($material->out as $value)
        <tr>
            <td>{{ date('d F Y', strtotime($value->date)) }}</td>
            <td></td><td></td><td></td>
            <td>{{ $value->amount }}</td>
            <td>Rp. {{ number_format($value->price) }}</td>
            <td>Rp. {{ number_format($value->amount * $value->price) }}</td>
            <td>{{ $value->amount }}</td>
            <td>Rp. {{ number_format($value->price) }}</td>
            <td>Rp. {{ number_format($value->amount * $value->price) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>