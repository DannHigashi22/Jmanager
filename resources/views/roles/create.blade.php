@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Crear Roles</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right bg-transparent">
                    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="/roles">Roles</a></li>
                    <li class="breadcrumb-item active">Crear</li>
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
                        <form id="formAuthentication" class="mb-3" action="{{route('roles.store')}}" method="POST">
                            @csrf
                          <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control form-control-border @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Ingrese nombre" autofocus/>
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
                                <input type="checkbox" name="permission[]" id="{{$value->name}}" class="form-check-input ml-0 @error('permission') is-invalid @enderror" 
                                value="{{$value->id}}" {{(old('permission'))?(in_array($value->id,old('permission'))?'checked':''):''}} >
                                <label class="form-check-label ml-3  mb-1" for="{{$value->name}}">{{$value->name}}</label>
                                <br>
                            @endforeach
                            @error('permission')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror  
                            </div>
                          </div>
                          <button class="btn btn-primary">Crear Rol</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection