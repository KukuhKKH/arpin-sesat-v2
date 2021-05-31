<table class="table table-responsive-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>Pemasok</th>
            <th>Tanggal Masuk</th>
            <th>Nama Bahan</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($materialTransaction as $value)
            <tr>
                <td>{{ ($materialTransaction->currentpage()-1) * $materialTransaction->perpage() + $loop->index + 1 }}</td>
                <td>{{ $value->supplier->name }}</td>
                <td>{{ date('d F Y', strtotime($value->date)) }}</td>
                <td>{{ $value->material->name }}</td>
                <td>{{ $value->price }}</td>
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

{{ $materialTransaction->appends($data)->links() }}
