<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.freepik.com/512/5608/5608597.png?ga=GA1.1.2115270469.1711143531">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
          integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
          crossorigin="anonymous"/>
    <!-- Styles -->
    @notifyCss
    <style>
        body {
            font-family: 'Nunito';
            color: white !important; 
            background-color: rgb(26, 32, 44) !important; 
        }
    </style>

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container-xl min-vh-100 align-content-center">
        <div class="row vh-100">
            <div class="col-12 col-sm-12 col-md-5 align-content-center">
                <div class="login-logo row ">
                    <div class="col-12">
                        <img src="https://cdn-icons-png.freepik.com/512/8324/8324499.png?ga=GA1.1.2115270469.1711143531" alt="AdminLTE Logo" class="w-25 ">
                    </div>
                    <div class="col-12">
                        <a><b>{{ config('app.name') }}</b></a>
                        <p class="h5"> <small>Bienvenido a la App que te ayudara a controlar todas tus gestiones de picking y la de tus equipo, ademas de unos extras que anunciaremos pronto</small> </p>
                    </div>
                </div>
                @if (Route::has('login'))
                <div class="col-12 text-center " >
                    @auth
                    <a href="{{ url('/home') }}" class="btn btn-primary">Incio</a>
                    @else
                    <a href="{{ route('login') }}" class="btn btn-outline-primary">Iniciar Sesion</a>
        
                    @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-outline-primary ">Crear Cuenta</a>
                    @endif
                    @endif
                </div>
                @endif
            </div>
            <div class="col-12 col-sm-12 col-md-7 embed-responsive embed-responsive-16by9">
                <iframe class="embed-responsive-item" src='https://my.spline.design/mymanageriphone14prosplash-be8a61112dceb2caba44678934b08eed/' frameborder='0' width='100%' height='100%'></iframe>
            </div>
        </div>
    
        @include('notify::components.notify')

        @notifyJs        
</body>
</html>