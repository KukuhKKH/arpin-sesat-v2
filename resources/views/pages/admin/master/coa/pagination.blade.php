<table class="table table-responsive-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>Kode</th>
            <th>Nama Akun</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($coa as $value)
            <tr>
                <td>{{ ($coa->currentpage()-1) * $coa->perpage() + $loop->index + 1 }}</td>
                <td>{{ $value->code }}</td>
                <td>{{ $value->name }}</td>
                <td>
                    <button type="button" class="btn-sm btn btn-success" onclick="editData({{ $value->id }})"><i class="pe-7s-pen"></i></button>
                    <button class="btn-sm btn btn-danger hapus" onclick="deleteData({{ $value->id }})" type="button"><i class="pe-7s-trash"></i></button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">Tidak ada data</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $coa->appends($data)->links() }}
