<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }}</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
          integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
          crossorigin="anonymous"/>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            
            background-color: rgb(26, 32, 44) !important; 
        }
    </style>

</head>
<body class="login-page">
    <div class="login-box w-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-7" style="margin-top: 2%">
                    <div class="card">
                        <div class="login-logo row pt-3">
                            <div class="col-12">
                                <img src="https://cdn-icons-png.freepik.com/512/8324/8324499.png?ga=GA1.1.2115270469.1711143531" alt="AdminLTE Logo" class="w-25 ">
                            </div>
                            <div class="col-12">
                                <a href="{{ url('/') }}"><b>{{ config('app.name') }}</b></a>
                            </div>
                        </div>
                        <div class="card-body ">
                            <div class="box">
                                <h3 class="box-title" style="padding: 2%">Confirmacion de correo Electronico</h3>
            
                                <div class="box-body">
                                    @if (session('resent'))
                                        <div class="alert alert-success" role="alert">Un nuevo link de verificacion ha sido enviado a su Correo Electronico
                                        </div>
                                    @endif
                                    <p>Antes de proceder revisa tu correo con un link de confirmacion. Si no has recibido el correo,</p>
                                    <div class="inline">
                                        <a href="#" class="btn btn-primary"
                                        onclick="event.preventDefault(); document.getElementById('resend-form').submit();">
                                            Click aqui para renvio.
                                        </a>
                                        <form id="resend-form" action="{{ route('verification.send') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>

                                        <a href="#" class="align-middle text-right"onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="fas fa-sign-out-alt"></i> Sign out
                                                </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                            @csrf
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="{{ mix('js/app.js') }}" defer></script>

</body>
</html>
