<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" type="image/x-icon" href="https://cdn-icons-png.freepik.com/512/5608/5608597.png?ga=GA1.1.2115270469.1711143531">
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
          integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
          crossorigin="anonymous"/>
    @notifyCss
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    @yield('third_party_stylesheets')
    @stack('page_css')
    

</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Main Header -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <img src="https://cdn-icons-png.freepik.com/512/4122/4122901.png?ga=GA1.1.2115270469.1711143531&"
                         class="user-image img-circle elevation-2" alt="User Image">
                    <span class="d-none d-md-inline">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <!-- User image -->
                    <li class="user-header bg-success">
                        <img src="https://cdn-icons-png.freepik.com/512/4122/4122901.png?ga=GA1.1.2115270469.1711143531&"
                             class="img-circle elevation-2"
                             alt="User Image">
                        <p>
                            {{ Auth::user()->name .' '.Auth::user()->surname}}
                            <small>{{Auth::user()->getRoleNames()[0]}}</small>
                            <small>Miembro desde {{ Auth::user()->created_at->format('M. Y') }}</small>
                        </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <!--<a href="#" class="btn btn-default btn-flat">Perfil</a>-->
                        <a href="#" class="btn btn-default btn-flat float-right"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                           <i class="fas fa-sign-out-alt"></i> Salir
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>

    <!-- Left side column. contains the logo and sidebar -->
@include('layouts.sidebar')

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <section class="content">
            @yield('content')
        </section>
    </div>

    <!-- Main Footer -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-block">
            <b>Version</b> 1.0
        </div>
        <strong>Copyright &copy; 2024 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>Implements to DHsolutions, All rights
        reserved.
    </footer>
</div>

@include('sweetalert::alert')
@include('notify::components.notify')


@yield('third_party_scripts')
<script src="{{ mix('js/app.js') }}"></script>
@notifyJs

@yield('p_scripts')
@stack('page_scripts')
</body>
</html>
