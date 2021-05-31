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
                            <a href="{{ route('transaction.product.create') }}" class="btn btn-outline-primary btn-sm mb-4"><i class="zwicon-plus"></i> Tambah Produksi</a>
                        </div>
                        <div>

                        </div>
                    </div>
                </div>
                <div class="panel-body" id="table_data">
                    @include('pages.admin.transaction.production.pagination')
                </div>
            </div>
        </div>
    </div>
@endsection
