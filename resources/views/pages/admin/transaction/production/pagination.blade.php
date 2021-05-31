<table class="table table-responsive-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>Tanggal Produksi</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Total Harga</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($production as $value)
            <tr>
                <td>{{ ($production->currentpage()-1) * $production->perpage() + $loop->index + 1 }}</td>
                <td>{{ date('d F Y', strtotime($value->date)) }}</td>
                <td>{{ $value->product->name }}</td>
                <td>{{ $value->product->price }}</td>
                <td>{{ $value->amount }}</td>
                <td>{{ $value->product->price * $value->amount }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $production->appends($data)->links() }}
