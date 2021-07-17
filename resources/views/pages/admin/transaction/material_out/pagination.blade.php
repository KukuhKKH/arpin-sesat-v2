<table class="table table-responsive-sm">
    <thead>
        <tr>
            <th>#</th>
            <th>Tanggal Permintaan</th>
            <th>Nama Bahan</th>
            <th>Harga</th>
            <th>Jumlah</th>
            <th>Total</th>
            <th>Status</th>
            @role('admin')
            <th>Aksi</th>
            @endrole
        </tr>
    </thead>
    <tbody>
        @forelse ($material_out as $value)
            <tr>
                <td>{{ ($material_out->currentpage()-1) * $material_out->perpage() + $loop->index + 1 }}</td>
                <td>{{ date('d F Y', strtotime($value->date)) }}</td>
                <td>{{ $value->material->name }}</td>
                <td>Rp {{ $value->price }}</td>
                <td>{{ $value->amount }}</td>
                <td>Rp {{ $value->price * $value->amount }}</td>
                <td>
                    @if ($value->status == 1)
                        <span class="btn btn-rounded btn-warning">Pending</span>
                    @elseif($value->status == 2)
                        <span class="btn btn-rounded btn-success">Diterima</span>
                    @elseif($value->status == 3)
                        <span class="btn btn-rounded btn-danger">Ditolak</span>
                    @endif
                </td>
                @role('admin')
                <td>
                    @if ($value->status == 1)
                        <button class="btn btn-success" onclick="approve({{ $value->id }})">Terima</button>
                        <button class="btn btn-danger" onclick="reject({{ $value->id }})">Tolak</button>
                    @endif
                </td>
                @endrole
            </tr>
        @empty
            <tr>
                @role('admin')
                @php $colspan = 8 @endphp
                @else
                @php $colspan = 7 @endphp
                @endrole
                <td colspan="{{ $colspan }}" class="text-center">Tidak ada data</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $material_out->appends($data)->links() }}
