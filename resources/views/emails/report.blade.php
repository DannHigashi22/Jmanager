<!DOCTYPE html>
<html lang="es">
<head>
    <!---
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>-->

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css"
          integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog=="
          crossorigin="anonymous"/>
<<<<<<< HEAD
    
=======
>>>>>>> v2
</head>

<body class="">
<div class="wrapper">
    <div class="content-wrapper ml-0">
        <section class="content">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Reporte Dashboard GP | Jumbo costanera J511</h1>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="container-xl">
                    <!--info boxes -->
                    <div class="row">
                        <div class="col-12 col-sm-12">
                            <div class="info-box">
                                <span class="info-box-icon ">📎</span>
                                <div class="info-box-content">
                                    <span class="info-box-text text-wrap">Buen dia Correo generado automaticamente 🎉</span>
                                    <span class="info-box-text text-wrap">-Resumen de auditorias del dia de hoy </span>
                                </div> 
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="info-box">
                                <span class="info-box-icon bg-blue elevation-1"> 📅</span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Auditorias {{Request::get('dateRange') !== null ? '(Fecha)':'Hoy'}}</span>
                                    <span class="info-box-number">{{$auditsDay}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 ">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-info elevation-1"> 🗓</span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Auditorias Mes</span>
                                    <span class="info-box-number">{{$auditsMonth}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--info boxes end -->
            
                    <!--charts-->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-success">
                                <div class="card-header">
                                    <h5 class="card-title">Tipo error - Mala practica</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach ($chartErrors as $key => $error)
                                            <div class="col-sm-auto mx-auto callout callout-info">
                                                <h5>{{$key}}</h5>
                                                <p>{{$error}}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="card-footer">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title">Auditorias por Usuario</h3>
                                    <div class="card-tools">
                                        <span class="badge badge-danger">Fecha</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @foreach ($chartUsers as $key => $user)
                                            <div class="col-sm-auto callout callout-info mx-auto">
                                                <h5>{{$key}}</h5>
                                                <p>{{$user}}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="card-footer text-center">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card card-success">
                                <div class="card-header">
                                    <h3 class="card-title">Tipo de Entrega </h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        @if ($chartType == null)
                                            <h5 class="align-center">Sin datos</h5>
                                        @else
                                            @foreach ($chartType as $key => $type)
                                                <div class="col-sm-auto callout callout-info mx-auto">
                                                    <h5>{{$key}}</h5>
                                                    <p>{{$type}}</p>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="card-footer ">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--charts  error end -->
                </div>
            </section>
        </section>
    </div>
</div>
</body>
</html>
