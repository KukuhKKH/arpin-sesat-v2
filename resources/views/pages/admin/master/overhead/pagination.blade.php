<table class="table table-responsive-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Harga</th>
            <th>Deskripsi</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($overhead as $value)
            <tr>
                <td>{{ ($overhead->currentpage()-1) * $overhead->perpage() + $loop->index + 1 }}</td>
                <td>{{ $value->name }}</td>
                <td>Rp. {{ number_format($value->price) }}</td>
                <td>{{ $value->description }}</td>
                <td>
                    <button type="button" class="btn-sm btn btn-success" onclick="editData({{ $value->id }})"><i class="pe-7s-pen"></i></button>
                    <button class="btn-sm btn btn-danger hapus" onclick="deleteData({{ $value->id }})" type="button"><i class="pe-7s-trash"></i></button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada data</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $overhead->appends($data)->links() }}
