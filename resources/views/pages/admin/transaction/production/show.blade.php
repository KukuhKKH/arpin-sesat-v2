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
            </div>
            <div class="panel-body">
                <h1>Nama Produk : {{ $productTransaction->product->name }}</h1>
                <h3>Nama TIM : {{ $productTransaction->team->name }} - Rp. {{ number_format($productTransaction->team->salary) }}</h3>
                <p>Bahan Baku</p>
                <table class="table table-bordered table-hovered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Total</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($productTransaction->transaction_material as $key => $value)
                            @if ($value->material->type == 1)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ $value->material->name }}</td>
                                    <td>Rp. {{ number_format($value->material->price) }}</td>
                                    <td>{{ $value->amount }}</td>
                                    <td>Rp. {{ number_format(($value->material->price * $value->amount)) }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                <p>Bahan Penolong</p>
                <table class="table table-bordered table-hovered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Total</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 0;
                        @endphp
                        @foreach ($productTransaction->transaction_material as $key => $value)
                            @if ($value->material->type == 2)
                                <tr>
                                    <td>{{ ++$no }}</td>
                                    <td>{{ $value->material->name }}</td>
                                    <td>Rp. {{ number_format($value->material->price) }}</td>
                                    <td>{{ $value->amount }}</td>
                                    <td>Rp. {{ number_format(($value->material->price * $value->amount)) }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>

                <p>Overhead Tetap</p>
                <table class="table table-bordered table-hovered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 0;
                        @endphp
                        @foreach ($productTransaction->transaction_overhead as $key => $value)
                            @if ($value->overhead->type == 1)
                                <tr>
                                    <td>{{ ++$no }}</td>
                                    <td>{{ $value->overhead->name }}</td>
                                    <td>Rp. {{ number_format($value->overhead->price) }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>

                <p>Overhead Variabel</p>
                <table class="table table-bordered table-hovered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 0;
                        @endphp
                        @foreach ($productTransaction->transaction_overhead as $key => $value)
                            @if ($value->overhead->type == 2)
                                <tr>
                                    <td>{{ ++$no }}</td>
                                    <td>{{ $value->overhead->name }}</td>
                                    <td>Rp. {{ number_format($value->overhead->price) }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
                <p>Biaya Produksi</p>
                <table class="table table-bordered table-hovered">
                    <thead>    
                    </thead>
                    <tbody>
                        @php
                            $total = 0;
                            $bahanbaku = 0;
                            $bahanpenolong = 0;
                            $overheadTetap = 0;
                            $overheadVariable = 0;
                            
                            foreach($productTransaction->transaction_material as $baku){
                                if($baku->material->type ==1){
                                    $bahanbaku += ($baku->material->price * $baku->amount); 
                                }
                            }
                            foreach($productTransaction->transaction_material as $penolong){
                                if($penolong->material->type ==2){
                                    $bahanpenolong += $penolong->material->price * $penolong->amount; 
                                }
                            }
                            foreach($productTransaction->transaction_overhead as $ovTetap){
                                if($ovTetap->overhead->type ==1){
                                    $overheadTetap += $ovTetap->overhead->price; 
                                }
                            }
                            foreach($productTransaction->transaction_overhead as $ovVar){
                                if($ovVar->overhead->type ==2){
                                    $overheadVariable += $ovVar->overhead->price; 
                                }
                            }  
                            $total =$bahanbaku + $bahanpenolong + $overheadTetap + $overheadVariable;
                            @endphp
                                <tr>
                                    <td>Rp. {{ number_format($total + $productTransaction->team->salary) }}</td>
                                </tr>
                           
                    </tbody>
                </table>
        </div>
    </div>
</div>
@endsection
