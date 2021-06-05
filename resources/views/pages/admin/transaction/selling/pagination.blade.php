<table class="table table-responsive-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>Pelanggan</th>
            <th>Tanggal Masuk</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($selling as $value)
            <tr>
                <td>{{ ($selling->currentpage()-1) * $selling->perpage() + $loop->index + 1 }}</td>
                <td>{{ $value->customer->name }}</td>
                <td>{{ date('d F Y', strtotime($value->date)) }}</td>
                <td>{{ $value->product->name }}</td>
                <td>Rp. {{ number_format($value->product->price) }}</td>
                <td>{{ $value->amount }}</td>
                <td>
                    <button class="btn-sm btn btn-danger hapus" onclick="deleteData({{ $value->id }})" type="button"><i class="pe-7s-trash"></i></button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">Tidak ada data</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $selling->appends($data)->links() }}
