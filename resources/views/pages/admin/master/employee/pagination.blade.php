<table class="table table-responsive-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Tim</th>
            <th>Nama Pegawai</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($employee as $value)
            <tr>
                <td>{{ ($employee->currentpage()-1) * $employee->perpage() + $loop->index + 1 }}</td>
                <td>{{ $value->team->name }}</td>
                <td>{{ $value->name }}</td>
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

{{ $employee->appends($data)->links() }}
