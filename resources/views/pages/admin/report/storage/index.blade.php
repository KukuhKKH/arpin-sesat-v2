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
                    <select name="material" id="material" class="form-control">
                        <option value="" selected disabled>== Pilih Produk ==</option>
                        @foreach ($product as $value)
                            <option value="{{ $value->id }}">{{ $value->code . ' | ' . $value->name }}</option>
                        @endforeach
                    </select>
                    <button class="btn btn-success mt-1" id="btn-cari">Cari</button>
                    <div class="mt-3" id="fieldHTML">
                        {{-- @include('pages.admin.report.stock.table') --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $("#btn-cari").on('click', () => {
            let material = $("#material").val()
            loading('show', '.panel.panel-filled')
            new Promise((resolve, reject) => {
                let url = `{{ route('report.storage.post', ['id' => ':id']) }}`
                url = url.replace(':id', $('#material').val())
                $axios.post(`${url}`)
                    .then(({data}) => {
                        loading('hide', '.panel.panel-filled')
                        $('#fieldHTML').html(data)
                    })
                    .catch(err => {
                        loading('hide', '.panel.panel-filled')
                        console.log(err)
                        throwErr(err)
                    })
            })
        })
    </script>
@endsection
