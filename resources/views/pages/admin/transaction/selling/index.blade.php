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
                            <button class="btn btn-outline-primary btn-sm mb-4" onclick="add()"><i class="zwicon-plus"></i> Tambah Penjualan Produk</button>
                        </div>
                        <div>

                        </div>
                    </div>
                </div>
                <div class="panel-body" id="table_data">
                    @include('pages.admin.transaction.selling.pagination')
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
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="">Pelanggan</label>
                                    <select name="customer_id" id="customer_id" class="form-control">
                                        <option value="" selected disabled>== Pilih Pelanggan ==</option>
                                        @foreach ($customer as $value)
                                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Produk</label>
                                    <select name="product_id" id="product_id" class="form-control">
                                        <option value="" selected disabled>== Pilih Produk ==</option>
                                        @foreach ($product as $value)
                                            <option value="{{ $value->id }}" data-price="{{ $value->price }}">{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Tanggal</label>
                                    <input type="text" class="form-control" id="date" name="date" placeholder="Tanggal" data-date-format="mm/dd/yyyy">
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
                                    <input type="number" class="form-control" id="amount" name="amount" placeholder="Total" readonly>
                                </div>
                            </div>
                            <div class="mx-auto">
                                <p id="fieldTotalPrice"></p>
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
    $(document).ready(() => {
        $('#date').datepicker()
        $("#form-data").on('submit', e => {
            e.preventDefault()
            loading('show', $("#modal-data"))
            if(type == 'POST') {
                new Promise((resolve, reject) => {
                    $axios.post(`{{ route('transaction.selling.store') }}`, $("#form-data").serialize())
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
            }
        })

        $("#product_id").on('change', () => {
            $("#amount").attr('readonly', false)
            $("#price").val($("#product_id").find(':selected').data('price'))
        })

        $("#amount").on('change', () => {
            let price = $("#product_id").find(':selected').data('price')
            let amount = $("#amount").val()
            let subtotal = (parseInt(price) * parseInt(amount)).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,')
            $("#fieldTotalPrice").html(`Rp. ${subtotal}`)
        })
    })

    const add = () => {
        type = `POST`
        $("#form-data")[0].reset()
        $("#btn-submit").html(`Simpan`)
        $(".modal-title").html(`Tambah Penjualan`)
        $("#modal-data").modal('show')
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
                    let url = `{{ route('transaction.selling.destroy', ['id' => ':id']) }}`
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
