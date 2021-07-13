@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-filled" id="panel-loader">
            <div class="panel-heading">
                <div class="panel-tools">
                    <a class="panel-toggle"><i class="fa fa-chevron-up"></i></a>
                    <a class="panel-close"><i class="fa fa-times"></i></a>
                </div>
                <div class="d-flex justify-content-between">
                </div>
            </div>
            <div class="row">
                <div class="col-12 mb-2">
                    <select name="product" id="product" class="form-control" autocomplete="off">
                        <option value="" selected disabled>== Pilih Produk ==</option>
                        @foreach ($product as $value)
                            <option value="{{ $value->id }}">{{ $value->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12">
                    <a href="#" class="btn btn-lg btn-primary btn-block" id="btn-print">Print</a>
                </div>
            </div>
            <div class="panel-body" id="table_data">
                <div style="height: 100vh"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>

    $("#product").on('change', e => {
        sum_loading('show')
        let product = $("#product").val()
        let url = `{{ route('report.product.print', ":id") }}`
        url = url.replace(':id', product)
        $("#btn-print").attr('href', url)
        new Promise((resolve, reject) => {
            $axios.post(`{{ route('report.product.post') }}`, {product})
                .then(res => {
                    sum_loading('hide')
                    $("#table_data").html(res.data)
                })
        })
    })
</script>
@endsection
