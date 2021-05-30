<table class="table table-responsive-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Username</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($user as $value)
            <tr>
                <td>{{ ($user->currentpage()-1) * $user->perpage() + $loop->index + 1 }}</td>
                <td>{{ $value->getRoleNames()->first() }}</td>
                <td>{{ $value->name }}</td>
                <td>{{ $value->email }}</td>
                <td>{{ $value->username }}</td>
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

{{ $user->appends($data)->links() }}
