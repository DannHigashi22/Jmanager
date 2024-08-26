@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Editar Cliente Csat</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right bg-transparent">
                    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                    <li class="breadcrumb-item">Csat-Clientes</li>
                    <li class="breadcrumb-item active">Editar</li>
                </ol>
            </div>
        </div>
    </div>
</section>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                    </div>
                    <div class="card-body ">
                        <form action="{{ route('csat.update', ['csat' => $client->id])}}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                            <h5>Añadir cliente asegura el seguimiento de sus pedidos</h5>
                            <h6>Con esto mejorar el servicio</h6>
                                
                            <div class="mb-4">
                                <label for="order" class="form-label">Rut</label>
                                <input type="text" class="form-control form-control-border @error('rut') is-invalid @enderror" name="rut" value="{{ $client->rut }}" placeholder="23.123.123-9" autofocus/>
                                @error('rut')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <label for="type" class="form-label">Nombre</label>
                                <input type="text" class="form-control form-control-border @error('names') is-invalid @enderror" name="names" value="{{ $client->names }}" placeholder="Ingrese nombres cliente" />
                                @error('names')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                              <div class="mb-4">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input @error('vip_sala') is-invalid @enderror" id="customSwitch1" name="vip_sala" role="switch" value="1" {{$client->vip_sala == 1 ? 'checked' :''}} />
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
                                <textarea class="form-control form-control-border @error('description') is-invalid @enderror" name="description" id="" rows="3" >{{ $client->description }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                              </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary">Cancelar</button>
                            <button type="submit" class="btn btn-primary" >Guardar</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection