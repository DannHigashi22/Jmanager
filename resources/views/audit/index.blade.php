@extends('layouts.app')
@section('third_party_stylesheets')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"  />
@endsection

@section('third_party_scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>
@endsection
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Auditorias</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right bg-transparent">
                    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                    <li class="breadcrumb-item active">Auditorias</li>
                </ol>
            </div>
        </div>
    </div>
</section>
    <div class="container-fluid"> 
        <div class="row">
            <div class="col-12">
                <div class="card card-primary collapsed-card">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-filter"></i> Opciones</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" style="display: none;">
                        <form action="" method="" id="auditsForm">
                            <div class="row">
                                <div class="col-12 col-md-6 col-lg-4">
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
                                <div class="col-6 col-md-3 col-lg-3">
                                    <div class="form-group mb-1">
                                        <label>Colaborador:</label>
                                        <select class="form-control" name="user">
                                            <option value="">Selecione</option>
                                            @foreach($users as $user)
                                            <option value="{{$user->email}}" {{Request::get('user') == $user->email ? 'selected':''}} >{{$user->name.' '.$user->surname}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endif
                                <div class="col-6 col-md-3 col-lg-2">
                                    <div class="form-group mb-1">
                                        <label>Tipo Entrega</label>
                                        <select class="form-control" name="type">
                                            <option value="">Selecione</option>
                                            <option value="Click auto"  {{Request::get('type') == 'Click auto' ? 'selected':''}} >Click Auto</option>
                                            <option value="Despacho" {{Request::get('type') == 'Despacho' ? 'selected':''}}>Despacho</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-12 col-lg-3 d-flex justify-content-center align-items-end">
                                    <div class="form-group mb-1 ">
                                        <button class="btn btn-primary px-3"><i class="fas fa-filter"></i> Filtar</button>
                                        <a class="btn btn-secondary px-3" id="reset-filter-audits"><i class="fas fa-redo-alt"></i> Limpiar</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                
                </div>
                <div class="card card-secondary ">
                    <div class="card-header">
                            @can('create-audit')
                                <a class="btn btn-primary float-left" href="{{route('audits.create')}}"><i class="fas fa-layer-group"></i> Nuevo</a>
                            @endcan
                            @can('exportShpr-audit')
                            <a class="btn btn-primary float-right ml-1"  id="exportAudits"><i class="fas fa-file-export"></i> Export</a>
                            @endcan
                            @can('importShpr-audit')
                            <button type="button" class="btn btn-primary float-right mr-1 " data-toggle="modal" data-target="#ImportModal"><i class="fas fa-file-import"></i> Import</button>
                            @endcan
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Pedido</th>
                                <th>Tipo</th>
                                <th>Shopper</th>
                                <th>Error</th>
                                <th>Auditor</th>
                                <th>Creado</th>
                                @if(auth()->user()->can('edit-audit') | auth()->user()->can('delete-audit'))
                                <th>Acciones</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($audits as $audit)
                                <tr>
                                    <td><a href="https://backoffice.jumbo.cl/orders/{{$audit->order}}" target="_blank" ><strong>{{$audit->order}}</strong></a></td>
                                    <td>{{$audit->type}}</td>
                                    <td>{!! $audit->shopper ? $audit->shopper: '<small class="badge badge-info">Sin Datos</small>' !!}</td>
                                    <td>
                                        @foreach ($audit->errors as $error)
                                            <small class="badge badge-warning">{{$error->type}}</small><br>
                                        @endforeach
                                    </td>
                                    <td>{{$audit->user->name.' '.$audit->user->surname}}</td>
                                    <td>{{date_format($audit->created_at,'m/d/Y')}}</td>
                                    @can('edit-audit')
                                    <td>
                                            <a class="btn btn-primary" href="{{route('audits.edit',$audit->id)}}"><i class="fas fa-user-edit"></i></a>
                                    @endcan
                                    @can('delete-audit')
                                            <form action="{{route('audits.destroy',$audit->id)}}" method="post" class="d-inline" >
                                                @csrf
                                                @method('DELETE')
                                                <button  class="btn btn-danger" type="submit"><i class="fas fa-trash-alt"></i></button>
                                            </form>
                                    </td>        
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                        </table>
                    <div class="pagination d-flex justify-content-center">
                        {{--!! $audits->links() ---}}
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
<div class="modal fade" id="ImportModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Importar datos Shopper</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('importShoppers')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="modal-body">
            <h5>Solo importar archivos de 2MB, alrededor de 4300 filas</h5>
            <h6>Asegurese de que el numero de orden este corrrecto; si un dato no se actualiza, revisar numero de orden</h6>
            
                <div class="form-group">
                <label class="form-label" for="excel">Archivo</label>
                <input class="form-control @error('excel') is-invalid @enderror {{session('failures')?'is-invalid':''}}"  type="file" name="excel" id="" placeholder="archivo.xlsx">
                @error('excel')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                @if (Session::has('failures'))
                    <span class="invalid-feedback" role="alert">
                        <strong>Error archivo ingresado:</strong><br>
                            @foreach (session('failures') as $failure)
                                @foreach ($failure->errors() as $error)
                                <strong>{{ $error }}</strong><br>
                                @endforeach
                            @endforeach
                    </span>
                @endif
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary" >Importar</button>
            </div>
        </form>
      </div>
    </div>
</div>
@endsection
@if($errors->has('excel') | (bool)session('failures'))
    @section('p_scripts')
        <script>
       $(document).ready(function(){
            $('#ImportModal').modal({show: true});
        });
        </script>
    @endsection
@endif