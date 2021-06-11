@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-md-12">
        {{-- <div class="panel panel-filled" id="panel-loader"> --}}
            {{-- <div class="container"> --}}
                <h2>Selamat Datang</h2>
                <div class="row">
                    <div class="col-md-6">
                        <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/Lvz0xk2IWxY?controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <div class="col-md-6">
                        <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/R4xqPngPsrw?controls=0"
                        title="YouTube video player" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                    </div>
                    <div class="col-md-6">
                        <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/tSlJDGQKAMA?controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                    <div class="col-md-6">
                        <iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/18TXgQ5dgoA?controls=0" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                    </div>
                </div>
                <div id="fieldHtmlData" class="mt-2"></div>
            {{-- </div> --}}
        {{-- </div> --}}
    </div>
</div>
@endsection
@section('js')
    <script>
        $axios.post(`{{ route('dashboard.data') }}`).then(res => $('#fieldHtmlData').html(res.data)).catch(err => console.log(err))
    </script>
@endsection
