@extends('layouts.app')

@section('third_party_stylesheets')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"  />
@endsection

@section('third_party_scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"
    integrity="sha512-CQBWl4fJHWbryGE+Pc7UAxWMUMNMWzWxF4SQo9CgkJIN1kx6djDQZjh3Y8SZ1d+6I+1zze6Z7kHXO7q3UyZAWw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    

@endsection

@section('content')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Dashboard GP | Jumbo costanera J511</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                    <li class="breadcrumb-item active">Dashboard </li>
                </ol>
            </div>
        </div>
    </div>
</div>


<section class="content">
    <div class="container-fluid">
        <!--info boxes -->
        <div class="row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box">
                    <span class="info-box-icon bg-blue elevation-1"><i class="fas fa-calendar-day"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Auditorias</span>
                        <span class="info-box-number">{{$auditsDay}}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-info elevation-1"><i class="far fa-calendar-alt"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Auditorias del mes</span>
                        <span class="info-box-number">{{$auditsMonth}}</span>
                    </div>
                </div>
            </div>
            <div class="clearfix hidden-md-up"></div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-shopping-cart"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Auditorias Totales</span>
                        <span class="info-box-number">{{$audits}}</span>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="info-box mb-3">
                    <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Usuarios / Miembros</span>
                        <span class="info-box-number">{{$users->count()}}</span>
                    </div>
                </div>
            </div>
        </div>
        <!--info boxes end -->

        <!--charts-->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="">
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <div class="form-group mb-1">
                                        <label>Fecha:</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">
                                                    <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            <input type="text" class="form-control form-control-solid" placeholder="Todas las fechas" id="filter-date" name="dateRange" autocomplete="off" value="{{request('dateRange')? request('dateRange'):null}}">
                                        </div>
                                    </div>
                                </div>
                                @if(auth()->user()->getRoleNames()[0] == 'Super Administrador' |  auth()->user()->getRoleNames()[0] == 'Administrador' )
                                <div class="col-6 col-md-3">
                                    <div class="form-group mb-1">
                                        <label>Colaborador:</label>
                                        <select class="form-control" name="user">
                                            <option value="">Selecione</option>
                                            @foreach($users as $user)
                                            <option value="{{$user->email}}" >{{$user->name.' '.$user->surname}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endif
                                <div class="col-6 col-md-3">
                                    <div class="form-group mb-1">
                                        <label>Tipo Entrega</label>
                                        <select class="form-control" name="type">
                                            <option value="">Selecione</option>
                                            <option value="Click auto"  {{Request::get('type') == 'Click auto' ? 'selected':''}} >Click Auto</option>
                                            <option value="Despacho" {{Request::get('type') == 'Despacho' ? 'selected':''}}>Despacho</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-2 d-flex justify-content-center align-items-end">
                                    <div class="form-group mb-1 ">
                                        <button class="btn btn-primary px-3"><i class="fas fa-filter"></i> Filtar</button>
                                        <a class="btn btn-secondary px-3" id="reset-filter"><i class="fas fa-redo-alt"></i> Limpiar</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Tipo error - Mala practica</h5>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button><!--
                            <div class="btn-group">
                                <button type="button" class="btn btn-tool dropdown-toggle" data-toggle="dropdown">
                                    <i class="fas fa-wrench"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" role="menu">
                                    <a href="#" class="dropdown-item">Action</a>
                                    <a href="#" class="dropdown-item">Another action</a>
                                    <a href="#" class="dropdown-item">Something else here</a>
                                    <a class="dropdown-divider"></a>
                                    <a href="#" class="dropdown-item">Separated link</a>
                                </div>
                            </div>*/--->
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="chart box-chart">
                                    <div class="chartjs-size-monitor">
                                        <div class="chartjs-size-monitor-expand">
                                            <div class=""></div>
                                        </div>
                                        <div class="chartjs-size-monitor-shrink">
                                            <div class=""></div>
                                        </div>
                                    </div>
                                    <canvas id="errorChart"></canvas>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-8">
                <div class="card card-cyan">
                    <div class="card-header">
                        <h3 class="card-title">Auditorias por Usuario</h3>
                        <div class="card-tools">
                            <span class="badge badge-danger">Fecha</span>
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="chart box-chart">
                            <div class="chartjs-size-monitor">
                                <div class="chartjs-size-monitor-expand">
                                    <div class=""></div>
                                </div>
                                <div class="chartjs-size-monitor-shrink">
                                    <div class=""></div>
                                </div>
                            </div>
                            <canvas id="auditUserChart"></canvas>
                           
                        </div>
                    </div>
                    <div class="card-footer text-center">
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Tipo de Entrega </h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="chart box-chart">
                                <div class="chartjs-size-monitor">
                                    <div class="chartjs-size-monitor-expand">
                                        <div class=""></div>
                                    </div>
                                    <div class="chartjs-size-monitor-shrink">
                                        <div class=""></div>
                                    </div>
                                </div>
                                <canvas id="typeChart"></canvas>
                                
                            </div>
                        </div>
                    </div>
                    <div class="card-footer ">
                    </div>
                </div>
            </div>
        </div>
        <!--charts  error end -->

        <!--lastest-->
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Ultimas Auditorias</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <ul class="products-list product-list-in-card pl-2 pr-2">
                            @foreach ($lastAudits as $audit)
                            <li class="item">
                                <div class="product-img">
                                    <img src="https://cdn-icons-png.freepik.com/512/4308/4308078.png?ga=GA1.1.2115270469.1711143531&"
                                        alt="Product Image" class="img-size-50">
                                </div>
                                <div class="product-info">
                                    <a href="javascript:void(0)" class="product-title">{{$audit->order}}
                                        <span class="badge badge-info float-right">{{($audit->user->name)}}
                                            {{$audit->user->surname}}</span></a>
                                    <span class="product-description">{{$audit->description}}</span>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-footer text-center">
                        <a href="javascript:void(0)" class="uppercase">Ver Auditorias</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Ultimos Usuarios</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <ul class="products-list product-list-in-card pl-2 pr-2">
                            @foreach ($lastUsers as $user)
                            <li class="item">
                                <div class="product-img">
                                    <img src="https://cdn-icons-png.freepik.com/512/8647/8647311.png?ga=GA1.1.2115270469.1711143531&"
                                        alt="Product Image" class="img-size-50">
                                </div>
                                <div class="product-info ">
                                    <a href="javascript:void(0)" class="product-title">{{($user->name)}}
                                        {{$user->surname}}
                                        @empty(!$user->getRoleNames())
                                        @foreach ($user->getRoleNames() as $roleName)
                                        <span class="badge badge-warning float-right">{{$roleName}}</span></a>
                                    @endforeach
                                    @endempty

                                    <span class="product-description">{{($user->created_at)}}</span>
                                </div>
                            </li>
                            @endforeach

                        </ul>
                    </div>
                    <div class="card-footer text-center">
                        <a href="/" class="uppercase">Ver todos los Usuarios</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Ultimos Error-tipo</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <ul class="products-list product-list-in-card pl-2 pr-2">
                            @foreach ($lastErrors as $error)
                            <li class="item">
                                <div class="product-img">
                                    <img src="https://cdn-icons-png.freepik.com/512/1183/1183866.png?ga=GA1.1.2115270469.1711143531&"
                                        alt="Product Image" class="img-size-50">
                                </div>
                                <div class="product-info">
                                    <a href="javascript:void(0)" class="product-title">{{$error->type}}
                                        <span class="badge badge-warning float-right">{{$error->audits->count()}}
                                            Auditorias</span></a>
                                    <span class="product-description">{{$error->created_at}}</span>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="card-footer text-center">
                        <a href="/errors" class="uppercase">Ver todos Error-tipo</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection