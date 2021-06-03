<table class="table table-responsive-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>Tanggal Produksi</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Total Harga</th>
            <th>Total Produksi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($production as $value)
            <tr>
                <td>{{ ($production->currentpage()-1) * $production->perpage() + $loop->index + 1 }}</td>
                <td>{{ date('d F Y', strtotime($value->date)) }}</td>
                <td>{{ $value->product->name }}</td>
                <td>Rp. {{ number_format($value->product->price) }}</td>
                <td>{{ $value->amount }}</td>
                <td>Rp. {{ number_format(($value->product->price * $value->amount)) }}</td>
                @php
                    $price_team = $value->team->salary;
                    $price_material = 0;
                    $price_overhead = 0;
                    foreach ($value->transaction_material as $key => $v) {
                        $total = $v->material->price * $v->amount;
                        $price_material += $total;
                    }

                    foreach ($value->transaction_overhead as $key => $v) {
                        $price_overhead += $v->overhead->price;
                    }
                    $subtotal = $price_team + $price_material + $price_overhead;
                @endphp
                <td>Rp. {{ number_format($subtotal) }}</td>
                <td>
                    <form action="{{ route('transaction.product.destroy', $value->id) }}" method="POST">
                        @csrf
                        @method("DELETE")
                        <a href="{{ route('transaction.product.show', $value->id) }}" class="btn btn-sm btn-success">Detail</a>
                        <button type="submit" class="btn btn-sm btn-danger">DELETE</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">Tidak ada data</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $production->appends($data)->links() }}
