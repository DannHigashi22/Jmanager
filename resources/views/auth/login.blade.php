<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.freepik.com/512/5608/5608597.png?ga=GA1.1.2115270469.1711143531">

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
          integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
          crossorigin="anonymous"/>

        @notifyCss
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            color: white !important; 
            background-color: rgb(26, 32, 44) !important; 
        }
    </style>

</head>
<body class="hold-transition login-page">
<div class="login-box">
    <!-- /.login-box-body -->
    <div class="card">
        <div class="login-logo row pt-3">
            <div class="col-12">
                <img src="https://cdn-icons-png.freepik.com/512/8324/8324499.png?ga=GA1.1.2115270469.1711143531" alt="AdminLTE Logo" class="w-25 ">
            </div>
            <div class="col-12">
                <a href="{{ url('/') }}"><b>{{ config('app.name') }}</b></a>
            </div>
        </div>
        <!-- /.login-logo -->
        <div class="card-body login-card-body pt-1">
            <p class="login-box-msg">Inicia sesión para comenzar</p>
            <form method="post" action="{{ url('/login') }}">
                @csrf

                <div class="input-group mb-3">
                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           placeholder="Email"
                           class="form-control @error('email') is-invalid @enderror">
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                    </div>
                    @error('email')
                    <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="input-group mb-3">
                    <input type="password"
                           name="password"
                           placeholder="Contraseña"
                           class="form-control @error('password') is-invalid @enderror">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                    @error('password')
                    <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror

                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember">
                            <label for="remember">Recordar</label>
                        </div>
                    </div>

                    <div class="col-6">
                        <button type="submit" class="btn btn-primary btn-block">Iniciar sesión</button>
                    </div>

                </div>
            </form>

            <p class="mb-1">
                <a href="{{ route('password.request') }}">Olvide contraseña</a>
            </p>
            <p class="mb-0">
                <a href="{{ route('register') }}" class="text-center">¿Todavía no tienes una cuenta? Regístrate</a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>

</div>
<!-- /.login-box -->

<script src="{{ mix('js/app.js') }}" defer></script>

@include('notify::components.notify')

@notifyJs

</body>
</html>
