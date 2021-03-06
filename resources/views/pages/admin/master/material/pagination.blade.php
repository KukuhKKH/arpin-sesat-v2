<table class="table table-responsive-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>Kode</th>
            <th>Nama Bahan</th>
            <th>Persediaan</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($material as $value)
            <tr>
                <td>{{ ($material->currentpage()-1) * $material->perpage() + $loop->index + 1 }}</td>
                <td>{{ $value->code }}</td>
                <td>{{ $value->name }}</td>
                <td>{{ $value->total }}</td>
                <td>
                    <button type="button" class="btn-sm btn btn-success" onclick="editData({{ $value->id }})"><i class="pe-7s-pen"></i></button>
                    <button class="btn-sm btn btn-danger hapus" onclick="deleteData({{ $value->id }})" type="button"><i class="pe-7s-trash"></i></button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">Tidak ada data</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $material->appends($data)->links() }}
