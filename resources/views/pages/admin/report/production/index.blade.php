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
                <div class="col">
                    <a href="{{ route('report.production.print') }}" class="btn btn-lg btn-primary btn-block">Print</a>
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
    sum_loading('show')
    new Promise((resolve, reject) => {
        $axios.post(`{{ route('report.production.post') }}`)
            .then(res => {
                sum_loading('hide')
                $("#table_data").html(res.data)
            })
    })
</script>
@endsection
