<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900' rel='stylesheet' type='text/css'>

    <!-- Page title -->
    <title>Login</title>

    <!-- Vendor styles -->
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/font-awesome.css') }}"/>
    <link rel="stylesheet" href="{{ asset('vendor/animate.css/animate.css') }}"/>
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.css') }}"/>

    <!-- App styles -->
    <link rel="stylesheet" href="{{ asset('assets/styles/pe-icons/pe-icon-7-stroke.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/styles/pe-icons/helper.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/styles/stroke-icons/style.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/styles/style.css') }}">
</head>
<body class="blank">

<!-- Wrapper-->
<div class="wrapper">


    <!-- Main content-->
    <section class="content">
        <div class="container-center animated slideInDown">

            <div class="view-header">
                <div class="header-icon">
                    <i class="pe page-header-icon pe-7s-unlock"></i>
                </div>
                <div class="header-title">
                    <h3>Login</h3>
                    <small>
                        Please enter your credentials to login.
                    </small>
                </div>
            </div>

            <div class="panel panel-filled">
                <div class="panel-body">
                    <form action="{{ route('login') }}" novalidate method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="col-form-label" for="username">Username</label>
                            <input type="text" placeholder="Username" title="Please enter you username" required="" value="{{ old('username') }}" name="username" id="username" class="form-control @error('username') is-invalid @enderror">
                            <span class="form-text small">Your unique username to app</span>
                            @error('username')
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="col-form-label" for="password">Password</label>
                            <input type="password" title="Please enter your password" placeholder="******" required="" value="" name="password" id="password" class="form-control @error('username') is-invalid @enderror">
                            <span class="form-text small">Your strong password</span>
                        </div>
                        <div>
                            <button class="btn btn-accent" type="submit">Login</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
    <!-- End main content-->

</div>
<!-- End wrapper-->

<!-- Vendor scripts -->
<script src="{{ asset('vendor/pacejs/pace.min.js') }}"></script>
<script src="{{ asset('vendor/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>

<!-- App scripts -->
<script src="{{ asset('assets/scripts/luna.js') }}"></script>

</body>
</html>
