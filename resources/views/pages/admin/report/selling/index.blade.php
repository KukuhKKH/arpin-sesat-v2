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
                    </div>
                </div>
                <div class="panel-body" id="table_data">
                    <form action="{{ route('report.selling.print') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <div class="col">
                                <input type="text" class="form-control" id="date_start" name="date_start" placeholder="Tanggal Awal" data-date-format="mm/dd/yyyy">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" id="date_end" name="date_end" placeholder="Tanggal Akhir" data-date-format="mm/dd/yyyy">
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-primary">Cetak</button>
                            </div>
                        </div>
                    </form>
                </div>
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
    $(document).ready(() => {
        $('#date_start,#date_end').datepicker()
    })
</script>
@endsection
