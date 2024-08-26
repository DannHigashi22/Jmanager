@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Csat Clientes</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right bg-transparent">
                    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                    <li class="breadcrumb-item active">Csat-Clientes</li>
                </ol>
            </div>
        </div>
    </div>
</section>
    <div class="container-fluid"> 
        <div class="row">
            <div class="col-12">
                <div class="card card-secondary ">
                    <div class="card-header">
                            @can('create-csat')
                                <button type="button" class="btn btn-primary float-left mr-1 " data-toggle="modal" data-target="#createModal"><i class="fas fa-plus-circle"></i> Añadir Cliente </button>
                            @endcan
                            @can('import-csat')
                            <button type="button" class="btn btn-primary float-right mr-1 " data-toggle="modal" data-target="#ImportCsatModal"><i class="fas fa-file-import"></i> Sacar Pedidos</button>
                            @endcan
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Rut</th>
                                <th>Nombre</th>
                                <th>Descripcion</th>
                                <th>Creado Por</th>
                                @if(auth()->user()->can('edit-csat') || auth()->user()->can('delete-csat'))
                                <th>Acciones</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                                <tr>
                                    <td><strong>{{$client->rut}}</strong></td>
                                    <td>{{$client->names}} {!!$client->vip_sala == 1  ? '<i class="far fa-gem"></i>' :'' !!} </td>
                                    <td>{{$client->description}}</td>
                                    <td>{{$client->created_by}}</td>
                                    @can('edit-csat')
                                    <td>
                                        <a class="btn btn-primary" href="{{route('csat.edit',$client->id)}}"><i class="fas fa-user-edit"></i></a>
                                    @endcan
                                    @can('delete-csat')
                                        <a class="btn btn-danger" href="{{route('csat.destroy',$client->id)}}" data-confirm-delete="true"><i class="fas fa-trash-alt"></i></a>
                                    </td>        
                                    @endcan
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                   
                    </div>
                </div>
            </div>
        </div>
    </div>
 <!-- Modal -->
<div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Anadir Cliente Csat</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{route('csat.store')}}" method="post" >
            @csrf
            <div class="modal-body">
            <h6>*Crear cliente asegura el seguimiento de sus pedidos y ver mejorar en calificacion*</h6>
            <br>
            <div class="mb-4">
                <label for="order" class="form-label">Rut</label>
                <input type="text" class="form-control form-control-border @error('rut') is-invalid @enderror" id="rut" name="rut" value="{{ old('rut') }}" placeholder="23.123.123-9" autofocus/>
                @error('rut')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="type" class="form-label">Nombre</label>
                <input type="text" class="form-control form-control-border @error('names') is-invalid @enderror" name="names" value="{{ old('names') }}" placeholder="Ingrese nombres cliente" />
                @error('names')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
              <div class="mb-4">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input @error('vip_sala') is-invalid @enderror" id="customSwitch1" name="vip_sala" role="switch" value="1" {{ old('vip_sala') ? 'checked': '' }} />
                    <label class="custom-control-label" for="customSwitch1">Vip Sala</label>
                    @error('vip_sala')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
                </div>
              </div>
              <div class="mb-4">
                <label for="name" class="form-label">Descripcion</label>
                <textarea class="form-control form-control-border @error('description') is-invalid @enderror" name="description" id="" rows="3" >{{ old('description') }}</textarea>
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
              </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary" >Añadir</button>
            </div>
        </form>
      </div>
    </div>
    </div>
</div>
<div class="modal fade" id="ImportCsatModal" data-backdrop="static" tabindex="-1" aria-labelledby="ImportCsatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Pedidos realizados CSAT</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <h5>En detalle pedidos de cliente csat realiazado el dia de hoy</h5>
            <h6>Solo importar archivos de 2MB, alrededor de 4300 filas</h6>
            <form  action="{{route('importCsat')}}"  method="post" enctype="multipart/form-data" id="formCsat">
                @csrf
                <div class="form-group row">
                    <div class="col-9">
                        <label class="form-label" for="excel">Archivo</label>
                        <input class="form-control @error('excel') is-invalid @enderror {{session('failures')?'is-invalid':''}}"  type="file" name="excel" id="" placeholder="archivo.xlsx">
                        @error('excel')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="col-3 align-text-bottom">
                        <button type="submit" class="btn btn-primary" id="btnformCsat">Importar</button>
                    </div>
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
                </form>
                <div class="table-responsive">
                  @if(session('orderCsat'))
                  <table class="table">
                    <thead class="thead-dark">
                        <tr>
                          <th scope="col">OP</th>
                          <th scope="col">Cliente</th>
                          <th scope="col">Ventana</th>
                          <th scope="col">Prime</th>
                          <th scope="col">Estado</th>
                          <th scope="col">Shopper</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach(session('orderCsat') as $csat)
                        <tr>
                            <td><a href="https://backoffice.jumbo.cl/orders/{{$csat['nro_pedido']}}" target="_blank" ><strong>{{$csat['nro_pedido']}}</strong></a></td>
                            <td>{{$csat['cliente']}}</td>
                            <td>{{$csat['hora_inicio_entrega']}}</td>
                            <td>{{$csat['prime']}}</td>
                            <td>{{$csat['estado']}}</td>
                            <td>{{ Str::limit($csat['shopper'],25)}}</td>
                          </tr>
                        @endforeach
                      </tbody>
                  </table>
                  @endif
                  </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </div>
      </div>
    </div>
</div>

@endsection
@if($errors->all() && !$errors->has('excel'))
    @section('p_scripts')
    <script>
        $(document).ready(function(){
             $('#createModal').modal({show: true});
         });
         </script>
    @endsection
@elseif($errors->has('excel') | session('orderCsat') )
  @section('p_scripts')
  <script>
      $(document).ready(function(){
          $('#ImportCsatModal').modal({show: true});
      });
      </script>
  @endsection
@endif