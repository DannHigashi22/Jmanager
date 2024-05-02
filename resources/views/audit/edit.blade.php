@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Editar Auditoria</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right bg-transparent">
                    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="/audits">Auditorias</a></li>
                    <li class="breadcrumb-item active">Editar</li>
                </ol>
            </div>
        </div>
    </div>
</section>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card card-success">
                    <div class="card-header ">
                        <span class="small">Formulario creado para gestionar errores o malas prácticas de nuestro personal pickeador</span>
                    </div>
                    <div class="card-body ">
                        <form id="formAuthentication" class="mb-3" action="{{route('audits.update',$audit->id)}}" method="POST">
                            @method('PUT')
                            @csrf
                          <div class="mb-4">
                            <label for="order" class="form-label">1. Pedido</label>
                            <input type="text" class="form-control form-control-border @error('order') is-invalid @enderror" id="order" name="order" value="{{ $audit->order }}" />
                            @error('order')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          </div>
                          <div class="mb-4">
                            <label for="name" class="form-label">2. Tipo de entrega</label>
                            <div class="form-check">
                                <input class="form-check-input @error('type') is-invalid @enderror" type="radio" name="type" id="type1" value="Despacho" {{$audit->type =='Despacho' ? 'checked':''}}>
                                <label class="form-check-label mb-2" for="type1">Despacho</label> <br>
                           
                                <input class="form-check-input @error('type') is-invalid @enderror" type="radio" name="type" id="type2" value="Click auto" {{$audit->type =='Click auto' ? 'checked':''}}>
                                <label class="form-check-label" for="type2">Click Auto</label>
                                @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                           
                          </div>
                          <div class="mb-4">
                            <label for="">3. Tipo error - auditoria:</label>
                            <div class="form-check ">
                                @foreach ($error_type as $id => $error)
                                <input type="checkbox" name="error_type[]" id="{{$error}}" class="form-check-input @error('error_type') is-invalid @enderror" value="{{$id}}" {{in_array($id,$errorAudit) ?'checked':''}}>
                                <label class="form-check-label mb-3" for="{{$error}}">{{$error}}</label>
                                <br>
                            @endforeach
                            @error('error_type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            </div>
                          </div>
                          <div class="mb-4">
                            <label for="name" class="form-label">4. Descripcion</label>
                            <textarea class="form-control form-control-border @error('description') is-invalid @enderror" name="description" id="" rows="3" >{{ $audit->description }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          </div>
                          <button class="btn btn-primary">Guardar cambios</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection