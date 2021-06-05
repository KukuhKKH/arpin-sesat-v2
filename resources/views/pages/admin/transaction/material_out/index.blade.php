@extends('layouts.master')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-filled">
                <div class="panel-heading">
                    <div class="panel-tools">
                        <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                        <a class="panel-close"><i class="fa fa-times"></i></a>
                    </div>
                    <div class="d-flex justify-content-between">
                        @role('produksi')
                        <div>
                            <button class="btn btn-outline-primary btn-sm mb-4" onclick="add()"><i class="zwicon-plus"></i> Tambah Permintaan Bahan {{ request()->segment(4) == 1 ? 'Baku' : 'Penolong' }}</button>
                        </div>
                        @endrole
                        <div>

                        </div>
                    </div>
                </div>
                <div class="panel-body" id="table_data">
                    @include('pages.admin.transaction.material_out.pagination')
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-data" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title"></h4>
                </div>
                <form action="" id="form-data">
                    @csrf
                    <input type="hidden" id="fieldId">
                    <input type="hidden" name="type" value="{{ request()->segment(4) == 1 ? 1 : 2 }}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Tanggal</label>
                                    <input type="text" class="form-control" id="date" name="date" placeholder="Tanggal" data-date-format="mm/dd/yyyy">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Bahan {{ request()->segment(4) == 1 ? 'Baku' : 'Penolong' }}</label>
                                    <select name="material_id" id="material_id" class="form-control">
                                        <option value="" selected disabled>== Pilih Bahan ==</option>
                                        @foreach ($material as $value)
                                            <option value="{{ $value->id }}" data-price="{{ $value->price }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Harga</label>
                                    <input type="text" class="form-control" id="price" name="price" placeholder="Harga" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Total</label>
                                    <input type="text" class="form-control" id="amount" name="amount" placeholder="Total">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-accent" id="btn-submit"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('vendor/datepicker/datepicker.min.css') }}">
    <style>
        .datepicker-container { z-index: 99999 !important; }
    </style>
@endsection
@section('js')
<script src="{{ asset('vendor/datepicker/datepicker.min.js') }}"></script>
<script>
    let type
    let jenis = `{{ request()->segment(4) == 1 ? 'Baku' : 'Penolong' }}`
    $(document).ready(() => {
        $('#date').datepicker()
        $("#form-data").on('submit', e => {
            e.preventDefault()
            loading('show', $("#modal-data"))
            new Promise((resolve, reject) => {
                $axios.post(`{{ route('transaction.material-out.store') }}`, $("#form-data").serialize())
                    .then(({data}) => {
                        if(data.status == false) {
                            loading('hide', $("#modal-data"))
                            return toastr.error(data.message.body, data.message.head)
                        }
                        loading('hide', $("#modal-data"))
                        refresh_table(URL_NOW)
                        toastr.success(data.message.body, data.message.head)
                        $("#modal-data").modal('hide')
                    })
                    .catch(err => {
                        console.log(err)
                        throwErr(err)
                        loading('hide', $("#modal-data"))
                    })
            })
        })

        $("#material_id").on('change', e => {
            $("#price").val($("#material_id").find(':selected').data('price'))
        })
    })

    const add = () => {
        type = `POST`
        $("#form-data")[0].reset()
        $("#btn-submit").html(`Simpan`)
        $(".modal-title").html(`Tambah Transaksi Bahan ${jenis}`)
        $("#modal-data").modal('show')
    }

    const reject = id => {
        $swal.fire({
            title: 'Tolak keluarkan bahan',
            text: "Anda yakin?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Tolak!'
        })
        .then(res => {
            if(res.isConfirmed) {
                new Promise((resolve, reject) => {
                    let url = `{{ route('transaction.material-out.update', ['material_out' => ':id']) }}`
                    url = url.replace(':id', id)
                    $axios.put(`${url}`, {type:3})
                        .then(({data}) => {
                            toastr.success(data.message.body, data.message.head)
                            refresh_table(URL_NOW)
                        })
                })
            }
        })
    }

    const approve = id => {
        $swal.fire({
            title: 'Keluarkan bahan',
            text: "Anda sudah yakin?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, keluarkan!'
        })
        .then(res => {
            if(res.isConfirmed) {
                new Promise((resolve, reject) => {
                    let url = `{{ route('transaction.material-out.update', ['material_out' => ':id']) }}`
                    url = url.replace(':id', id)
                    $axios.put(`${url}`, {type:2})
                        .then(({data}) => {
                            toastr.success(data.message.body, data.message.head)
                            refresh_table(URL_NOW)
                        })
                })
            }
        })
    }
</script>
@endsection
