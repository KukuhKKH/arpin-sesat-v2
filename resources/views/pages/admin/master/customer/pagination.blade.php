<table class="table table-responsive-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Alamat</th>
            <th>Nomer HP</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($customer as $value)
            <tr>
                <td>{{ ($customer->currentpage()-1) * $customer->perpage() + $loop->index + 1 }}</td>
                <td>{{ $value->name }}</td>
                <td>{{ $value->email }}</td>
                <td>{{ $value->address }}</td>
                <td>{{ $value->phone_number }}</td>
                <td>
                    <button type="button" class="btn-sm btn btn-success" onclick="editData({{ $value->id }})"><i class="pe-7s-pen"></i></button>
                    <button class="btn-sm btn btn-danger hapus" onclick="deleteData({{ $value->id }})" type="button"><i class="pe-7s-trash"></i></button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada data</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $customer->appends($data)->links() }}
