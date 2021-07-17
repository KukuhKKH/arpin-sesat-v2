<table class="table table-responsive-sm">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal Produksi</th>
            <th>Nama Produk</th>
            <th>Harga Jual</th>
            <th>Jumlah Produksi</th>
            <th>Total Harga Jual</th>
            <th>Status</th>
            <th>Biaya Produksi</th>
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
                <td>
                    <div class="badge badge-success">{{ ucwords($value->status) }}</div>
                </td>
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
                    <div class="d-flex items-center justify-content-between m-2">
                        <form action="{{ route('transaction.product.selesai', $value->id) }}" method="POST" class="d-block" id="selesai-{{ $value->id }}">
                            @csrf
                            @method('put')
                            <button type="button" onclick="selesai({{ $value->id }})" class="btn btn-outline-success">Selesaikan</div>
                        </form>
                        <form action="{{ route('transaction.product.destroy', $value->id) }}" method="POST" id="form-{{ $value->id }}" class="d-inline">
                            @csrf
                            @method("DELETE")
                            <a href="{{ route('transaction.product.show', $value->id) }}" class="btn btn-sm btn-success">Detail</a>
                            <button type="button" onclick="destroy({{ $value->id }})" class="btn btn-sm btn-danger">DELETE</button>
                        </form>

                    </div>
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
