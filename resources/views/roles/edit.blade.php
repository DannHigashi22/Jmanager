@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Editar Roles</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right bg-transparent">
                    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="/roles">Roles</a></li>
                    <li class="breadcrumb-item active">Editar</li>
                </ol>
            </div>
        </div>
    </div>
</section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                    </div>
                    <div class="card-body ">
                        <form id="formAuthentication" class="mb-3" action="{{route('roles.update',$role->id)}}" method="POST">
                            @method('PUT')
                            @csrf
                          <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control form-control-border @error('name') is-invalid @enderror" id="name" name="name" value="{{ $role->name }}" placeholder="Ingrese nombre" autofocus/>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          </div>
                          <div class="mb-3">
                            <label for="">Permisos para este rol:</label>
                            <div class="form-group ">
                                @foreach ($permission as $value)
                                <input type="checkbox" name="permission[]" id="{{$value->id}}" value="{{$value->id}}" class="form-check-input ml-0 @error('permission') is-invalid @enderror" {{in_array($value->id,$rolePermissions) ?'checked':''}}>
                                <label class="form-check-label ml-3" for="{{$value->id}}">{{$value->name}}</label>
                                <br>
                            @endforeach
                            @error('permission')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                               
                            </div>
                          </div>
                          <button class="btn btn-primary">Guardar Rol</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection