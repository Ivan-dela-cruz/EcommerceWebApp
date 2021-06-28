<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from ableproadmin.com/bootstrap/default/auth-signin.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 28 Oct 2020 08:08:57 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>

    <title>Aspralnues || Registro</title>
    <!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 11]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>

    <![endif]-->
    <!-- Meta -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta name="author" content="CodeMort" />
    <!-- Favicon icon -->
    <link rel="icon" href="{{asset('favicon.ico')}}" type="image/x-icon">

    <!-- vendor css -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">

    <style>

        .btn-facebook{
            background:#39579A;
        }
        .btn-facebook:hover{
            background:#073088 !important;
        }
        .btn-github{
            background:#444444;
            color:white;
        }
        .btn-github:hover{
            background:black !important;
        }
        .btn-google{
            background:#ea4335;
            color:white;
        }
        .btn-google:hover{
            background:rgb(243, 26, 26) !important;
        }
    </style>

    @livewireStyles


</head>
<body>

<!-- [ auth-signin ] start -->
<div class="auth-wrapper bg">
    <div class="auth-content">
        <div class="card">
            <div class="row align-items-center text-center">
                <div class="col-md-12">
                    <div class="card-body">
                        <img src="{{asset('images/logoverde.png')}}" alt="" class="img-fluid mb-4 w-50 h-50" >
                        {{--                    <h6 class="mb-3 f-w-400">Iniciar Sesión</h6>--}}

                        <form class="form" method="post" action="{{route('register.submit')}}">
                            @csrf
                            <div class="form-group mb-3">
                                <label class="floating-label" for="name">Nombre</label>
                                <input type="text" name="name" placeholder="" class="form-control @error('name ') is-invalid @enderror" required="required" value="{{old('name')}}">
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label class="floating-label" for="Email">Correo</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  required autocomplete="email" placeholder="">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label class="floating-label" for="Password">Contraseña</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mb-4">
                                <label class="floating-label" for="Password">Confirmar Contraseña</label>
                                <input  type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation" required  placeholder="">
                                @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-block btn-primary mb-2">Entrar</button>
                            <div class="align-content-center mb-2">
                                <a href="{{route('login.redirect','facebook')}}" data-toggle="tooltip" title="Facebook"  class="btn btn-sm btn-facebook"><i class="feather icon-facebook text-white"></i></a>
                                <a href="{{route('login.redirect','google')}}" data-toggle="tooltip" title="Google"  class="btn btn-sm btn-google"><i class="feather icon-plus text-white"></i></a>
                            </div>
                            <p class="mb-0 text-muted">¿Tiene una cuenta? <a href="{{route('login.form')}}" class="f-w-400">Entrar</a></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ auth-signin ] end -->

<!-- Required Js -->
<script src="{{asset('assets/js/vendor-all.min.js')}}"></script>
<script src="{{asset('assets/js/plugins/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/js/ripple.js')}}"></script>
<script src="{{asset('assets/js/pcoded.min.js')}}"></script>

@livewireScripts
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<x-livewire-alert::scripts/>


</body>


<!-- Mirrored from ableproadmin.com/bootstrap/default/auth-signin.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 28 Oct 2020 08:08:58 GMT -->
</html>

