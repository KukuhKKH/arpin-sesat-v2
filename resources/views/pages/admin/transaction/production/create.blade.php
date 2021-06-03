@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-filled">
            <div class="panel-heading">
            </div>
            <div class="panel-body">
                <form action="{{ route('transaction.product.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="">Tanggal Produksi</label>
                        <input type="text" class="form-control" id="date" name="date" placeholder="Tanggal" data-date-format="mm/dd/yyyy" required>
                    </div>
                    <div class="form-group">
                        <label for="">Produk</label>
                        <select name="product_id" id="product" class="form-control" required>
                            <option value="" selected disabled>== Pilih Produk ==</option>
                            @foreach ($product as $value)
                                <option value="{{ $value->id }}" data-price="{{ $value->price }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Harga</label>
                        <input type="text" class="form-control" id="price" readonly>
                    </div>
                    <div class="form-group">
                        <label for="">Total Produksi</label>
                        <input type="number" class="form-control" id="amount" name="amount" placeholder="Total Produksi" required>
                    </div>
                    <div class="form-group">
                        <div class="d-flex justify-content-between">
                            <div>
                                <label for="">Bahan Baku</label>
                            </div>
                            <div>
                                <button type="button" class="btn btn-sm btn-secondary" id="btnAddMaterialRaw"><i class="pe-7s-plus"></i> Tambah Bahan Baku</button>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <select name="material_raw[]" id="material_raw_1" data-id="1" class="form-control select-material-raw" autocomplete="off" required>
                                    <option value="" selected disabled>== Pilih Bahan Baku ==</option>
                                    @foreach ($material_raw as $value)
                                        <option value="{{ $value->id }}" data-price="{{ $value->price }}">{{ $value->code . " - " . $value->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="number" name="material_raw_amount[]" id="material_raw_amount_1" class="form-control type" data-id="1" placeholder="Total" readonly required>
                            </div>
                            <div class="col-md-4">
                                <input type="number" name="material_raw_total[]" class="form-control" id="material_raw_total_1" placeholder="Harga Total" readonly>
                            </div>
                        </div>
                        <div id="fieldMateialRaw"></div>
                    </div>
                    <div class="form-group">
                        <div class="d-flex justify-content-between">
                            <div>
                                <label for="">Bahan Penolong</label>
                            </div>
                            <div>
                                <button type="button" class="btn btn-sm btn-secondary" id="btnAddMaterialHelp"><i class="pe-7s-plus"></i> Tambah Bahan Penolong</button>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-4">
                                <select name="material_help[]" id="material_help_1" data-id="1" class="form-control select-material-help" autocomplete="off" required>
                                    <option value="" selected disabled>== Pilih Bahan Penolong ==</option>
                                        @foreach ($material_help as $value)
                                            <option value="{{ $value->id }}" data-price="{{ $value->price }}">{{ $value->code . " - " . $value->name }}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="number" name="material_help_amount[]" id="material_help_amount_1" class="form-control type_help" data-id="1" placeholder="Total" readonly required>
                            </div>
                            <div class="col-md-4">
                                <input type="number" name="material_help_total[]" class="form-control" id="material_help_total_1" placeholder="Harga Total"readonly>
                            </div>
                        </div>
                        <div id="fieldMateialHelp"></div>
                    </div>
                    <div class="form-group">
                        <div class="d-flex justify-content-between">
                            <div>
                                <label for="">Overhead Tetap</label>
                            </div>
                            <div>
                                <button type="button" class="btn btn-sm btn-secondary" id="btnAddOverheadFix"><i class="pe-7s-plus"></i> Tambah Overhead Tetap</button>
                            </div>
                        </div>
                        <select name="overhead_fix[]" class="form-control mt-1" required>
                            <option value="" selected disabled>== Pilih Overhead Tetap ==</option>
                            @foreach ($overhead_fix as $value)
                                <option value="{{ $value->id }}">{{ $value->name }} - {{ $value->price }}</option>
                            @endforeach
                        </select>
                        <div id="fieldOverheadFix"></div>
                    </div>
                    <div class="form-group">
                        <div class="d-flex justify-content-between">
                            <div>
                                <label for="">Overhead Variabel</label>
                            </div>
                            <div>
                                <button type="button" class="btn btn-sm btn-secondary" id="btnAddOverheadVar"><i class="pe-7s-plus"></i> Tambah Overhead Variabel</button>
                            </div>
                        </div>
                        <select name="overhead_var[]" class="form-control mt-1" required>
                            <option value="" selected disabled>== Pilih Overhead Variabel ==</option>
                            @foreach ($overhead_var as $value)
                                <option value="{{ $value->id }}">{{ $value->name }} - {{ $value->price }}</option>
                            @endforeach
                        </select>
                        <div id="fieldOverheadVar"></div>
                    </div>
                    <div class="form-group">
                        <label for="">Tim</label>
                        <select name="team_id" id="team" class="form-control" required>
                            <option value="" disabled selected>== Pilih Tenaga Kerja ==</option>
                            @foreach ($team as $value)
                                <option value="{{ $value->id }}">{{ $value->name }} - {{ $value->salary }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Produksi</button>
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
    let material_raw = `{!! json_encode($material_raw) !!}`
    let material_raw_count = 1
    let material_help_count = 1
    let material_help = `{!! json_encode($material_help) !!}`
    let overhead_fix = `{!! json_encode($overhead_fix) !!}`
    let overhead_var = `{!! json_encode($overhead_var) !!}`
    $(document).ready(() => {
        $('#date').datepicker()

        $("#product").on('change', e => {
            let price = $("#product").find(":selected").data('price')
            $("#price").val(price)
        })

        $("#btnAddMaterialRaw").on('click', () => {
            let data = JSON.parse(material_raw)
            material_raw_count++
            let html = `<div class="row mt-2"> <div class="col-md-4"> <select name="material_raw[]" id="material_raw_${material_raw_count}" class="form-control select-material-raw" data-id="${material_raw_count}"> <option value="" selected disabled>== Pilih Bahan Baku ==</option>`
            data.forEach(el => {
                html += `<option value="${el.id}" data-price="${el.price}">${el.code} - ${el.name}</option>`
            })
            html += `</select> </div> <div class="col-md-4"> <input type="number" name="material_raw_amount[]" class="form-control type" data-id="${material_raw_count}" id="material_raw_amount_${material_raw_count}" placeholder="Total" readonly> </div> <div class="col-md-4"> <input type="number" name="material_raw_total[]" class="form-control" id="material_raw_total_${material_raw_count}" placeholder="Harga Total"readonly> </div> </div>`
            $("#fieldMateialRaw").append(html)
        })

        $("#btnAddMaterialHelp").on('click', () => {
            let data = JSON.parse(material_help)
            material_help_count++
            let html = `<div class="row mt-2"> <div class="col-md-4"> <select name="material_help[]" id="material_help_${material_help_count}" class="form-control select-material-help" data-id="${material_help_count}"> <option value="" selected disabled>== Pilih Bahan Penolong ==</option>`
            data.forEach(el => {
                html += `<option value="${el.id}" data-price="${el.price}">${el.code} - ${el.name}</option>`
            })
            html += `</select> </div> <div class="col-md-4"> <input type="number" name="material_help_amount[]" class="form-control type_help" data-id="${material_help_count}" id="material_help_amount_${material_help_count}" placeholder="Total" readonly> </div> <div class="col-md-4"> <input type="number" name="material_help_total[]" class="form-control" id="material_help_total_${material_help_count}" placeholder="Harga Total"readonly> </div> </div>`
            $("#fieldMateialHelp").append(html)
        })

        $("#btnAddOverheadFix").on('click', () => {
            let data = JSON.parse(overhead_fix)
            let html = `<select name="overhead_fix[]" id="overhead_fix" class="form-control mt-1"><option value="" selected disabled>== Pilih Overhead Tetap ==</option>`
            data.forEach(el => {
                html += `<option value="${el.id}">${el.name}</option>`
            })
            html += `</select>`
            $("#fieldOverheadFix").append(html)
        })

        $("#btnAddOverheadVar").on('click', () => {
            let data = JSON.parse(overhead_var)
            let html = `<select name="overhead_var[]" id="overhead_var" class="form-control mt-1"><option value="" selected disabled>== Pilih Overhead Variabel ==</option>`
            data.forEach(el => {
                html += `<option value="${el.id}">${el.name}</option>`
            })
            html += `</select>`
            $("#fieldOverheadVar").append(html)
        })

    })

    $(document).on('change', '.select-material-raw', e => {
        let comp = $(e.currentTarget).val()
        let id = $(e.currentTarget).data('id')
        $(`#material_raw_amount_${id}`).attr("readonly", false)
    })

    $(document).on('change', '.select-material-help', e => {
        let comp = $(e.currentTarget).val()
        let id = $(e.currentTarget).data('id')
        $(`#material_help_amount_${id}`).attr("readonly", false)
    })

    $(document).on('change', '.type', e => {
        let comp = $(e.currentTarget).val()
        let id = $(e.currentTarget).data('id')
        let price = $(`#material_raw_${id}`).find(':selected').data('price')
        let total = parseInt(comp) * parseInt(price)
        $(`#material_raw_total_${id}`).val(parseInt(total))
    })

    $(document).on('change', '.type_help', e => {
        let comp = $(e.currentTarget).val()
        let id = $(e.currentTarget).data('id')
        let price = $(`#material_help_${id}`).find(':selected').data('price')
        let total = parseInt(comp) * parseInt(price)
        $(`#material_help_total_${id}`).val(parseInt(total))
    })
</script>
@endsection
