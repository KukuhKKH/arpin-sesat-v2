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
                        <div>
                            <button class="btn btn-outline-primary btn-sm mb-4" onclick="add()"><i class="zwicon-plus"></i> Tambah Tim</button>
                        </div>
                        <div>

                        </div>
                    </div>
                </div>
                <div class="panel-body" id="table_data">
                    @include('pages.admin.master.team.pagination')
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-data" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title"></h4>
                </div>
                <form action="" id="form-data">
                    @csrf
                    <input type="hidden" id="fieldId">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Nama Tim</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Nama Tim">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Bagian</label>
                                    <input type="text" class="form-control" id="part" name="part" placeholder="Bagian">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Gaji</label>
                                    <input type="text" class="form-control" id="salary" name="salary" placeholder="Gaji">
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
@section('js')
<script>
    let type
    $(document).ready(() => {
        $("#form-data").on('submit', e => {
            e.preventDefault()
            loading('show', $("#modal-data"))
            if(type == 'POST') {
                new Promise((resolve, reject) => {
                    $axios.post(`{{ route('master.team.store') }}`, $("#form-data").serialize())
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
            } else if(type == "PUT") {
                new Promise((resolve, reject) => {
                    let url = `{{ route('master.team.update', ['team' => ':id']) }}`
                    url = url.replace(':id', $("#fieldId").val())
                    $axios.put(`${url}`, $("#form-data").serialize())
                        .then(({data}) => {
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
            }
        })
    })

    const add = () => {
        type = `POST`
        $("#form-data")[0].reset()
        $("#btn-submit").html(`Simpan`)
        $(".modal-title").html(`Tambah Tim`)
        $("#modal-data").modal('show')
    }

    const editData = id => {
        new Promise((resolve, reject) => {
            let url = `{{ route('master.team.edit', ['team' => ':id']) }}`
            url = url.replace(':id', id)
            $axios.get(`${url}`)
                .then(({data}) => {
                    let team = data.data
                    type = `PUT`
                    $("#btn-submit").html(`Update`)
                    $(".modal-title").html(`Update Tim`)
                    $("#fieldId").val(team.id)
                    $("#name").val(team.name)
                    $("#part").val(team.part)
                    $("#salary").val(team.salary)
                    $("#modal-data").modal('show')
                })
        })
    }

    const deleteData = id => {
        $swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        })
        .then(res => {
            if(res.isConfirmed) {
                new Promise((resolve, reject) => {
                    let url = `{{ route('master.team.destroy', ['team' => ':id']) }}`
                    url = url.replace(':id', id)
                    $axios.delete(`${url}`)
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
