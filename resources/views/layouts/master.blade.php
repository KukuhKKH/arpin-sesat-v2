<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900' rel='stylesheet' type='text/css'>

    <!-- Page title -->
    <title>@yield('title', 'UD Langgeng Gypsum')</title>

    <!-- Vendor styles -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/font-awesome.css') }}"/>
    <link rel="stylesheet" href="{{ asset('vendor/animate.css/animate.css') }}"/>
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.css') }}"/>
    <link rel="stylesheet" href="{{ asset('vendor/toastr/toastr.min.css') }}"/>

    <!-- App styles -->
    <link rel="stylesheet" href="{{ asset('assets/styles/pe-icons/pe-icon-7-stroke.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/styles/pe-icons/helper.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/styles/stroke-icons/style.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/styles/style.css') }}">
    @yield('css')
</head>
<body>

<!-- Wrapper-->
<div class="wrapper">

    <!-- Header-->
    @include('partials.header')
    <!-- End header-->

    <!-- Navigation-->
    @include('partials.navbar')
    <!-- End navigation-->


    <!-- Main content-->
    <section class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-12">
                    <div class="view-header">
                        <div class="pull-right text-right" style="line-height: 14px">
                            <small>UD Langgeng Gypsum <br><span class="c-white">2021</span></small>
                        </div>
                        <div class="header-icon">
                            <i class="pe page-header-icon pe-7s-shield"></i>
                        </div>
                        <div class="header-title">
                            <h3 class="m-b-xs">{{ $title['page_name'] ?? '' }}</h3>
                            <small>
                                {{ $title['page_description'] ?? '' }}
                            </small>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>

            @yield('content')

        </div>
    </section>
    <!-- End main content-->

</div>
<!-- End wrapper-->

<!-- Vendor scripts -->
<script>
    paceOptions = {
        ajax: false,
        document: true,
        eventLag: false,
    }
</script>
<script src="{{ asset('vendor/pacejs/pace.min.js') }}"></script>
<script src="{{ mix('js/app.js') }}"></script>
<script src="{{ asset('vendor/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('vendor/loadingoverlay.min.js') }}"></script>
<!-- App scripts -->
<script src="{{ asset('assets/scripts/luna.js') }}"></script>

<script>
    const BASE_URL = `{{ url('/') }}`
    const URL_NOW = `{{ request()->url() }}`
    const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content")
    $(document).ready(function () {
        // Run toastr notification with Welcome message
        @if (request()->url() == url('/'))
        setTimeout(function () {
            toastr.options = {
                "positionClass": "toast-top-right",
                "closeButton": true,
                "progressBar": true,
                "showEasing": "swing",
                "timeOut": "6000"
            };
            toastr.success('<strong>Welcome to mobile legend</small>');
        }, 1600)
        @endif

        // Ajax Paginate
        $(document).on('click', '.pagination a', function(event) {
            event.preventDefault()
            // Jika di url terdapat "page=" maka di pisah
            let page = $(this).attr('href').split('page=')[1]
            let l = window.location.href
            let url = ''
            // Jika tidak ada keyword / kata kunci yang sedang dicari
            if(l.includes('?')) {
                url = l + "&page=" + page
            } else {
                url = l + "?page=" + page
            }

            refresh_table(url)
        })
    })

    const refresh_table = url => {
        new Promise((resolve, reject) => {
            $("#table_data").LoadingOverlay('show')
            $axios.get(url)
                .then(({data}) => {
                    $("#table_data").LoadingOverlay('hide')
                    $('#table_data').html(data)
                })
                .catch(err => {
                    console.log(err)
                    $("#table_data").LoadingOverlay('hide')
                    toastr.error("Oops...", "Something went wrong!")
                })
        })
    }

    // Perlu library loadingoverlay
    const loading = (type , selector = null, options = null) => {
        if(selector) {
            $(selector).LoadingOverlay(type, options)
        } else {
            $.LoadingOverlay(type, options)
        }
    }

    const throwErr = err => {
        if(err.response.status == 422) {
            let message = err.response.data.errors
            let teks_error = ''
            $.each(message, (i, e) => {
                if(e.length > 1) {
                    $.each(e, (id, el) => {
                        teks_error += `<p>${el}</p>`
                    })
                } else {
                    teks_error += `<p>${e}</>`
                }
            })
            toastr.error(teks_error)
        } else {
            toastr.error(err.response.data.message.body, err.response.data.message.head)
        }
    }
</script>
@yield('js')
</body>
</html>
