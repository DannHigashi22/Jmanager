@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Editar Usuarios</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right bg-transparent">
                    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="/users">Usuarios</a></li>
                    <li class="breadcrumb-item active">Editar</li>
                </ol>
            </div>
        </div>
    </div>
</section>
    <div class="container-xl">        
        <div class="row">
            <div class="col-12">
                <div class="card card-primary">
                    <div class="card-header">
                    </div>
                    <div class="card-body ">
                        <form id="formAuthentication" class="mb-3" action="{{route('users.update',$user->id)}}" method="POST">
                           @method('PUT')
                            @csrf
                          <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input type="text" class="form-control form-control-border @error('name') is-invalid @enderror" id="name" name="name" value="{{ $user->name }}" placeholder="Ingrese nombre" autofocus/>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          </div>
                          <div class="mb-3">
                            <label for="surname" class="form-label">Apellido</label>
                            <input type="text" class="form-control form-control-border @error('surname') is-invalid @enderror" id="surname" name="surname" value="{{ $user->surname }}" placeholder="Ingrese apellido"/>
                            @error('surname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          </div>
                          <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control form-control-border @error('email') is-invalid @enderror" id="email" name="email" value="{{ $user->email }}" placeholder="Ingresa email" />
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          </div>
                          <div class="mb-3">
                            <label class="form-label" for="roles">Rol</label>
                            <select class="custom-select form-control-border @error('roles') is-invalid @enderror" name="roles">
                                <option value="" >Selecione Rol</option>
                                @foreach ($roles as $rol)
                                    <option value="{{$rol}}" {{in_array($rol,$userRole) ?'selected':''}}>{{$rol}}</option>
                                @endforeach
                            </select>
                            @error('roles')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          </div>
                          <div class="mb-3">
                            <label class="form-label" for="roles">Estado</label>
                            <select class="custom-select form-control-border @error('status') is-invalid @enderror" name="status">
                                <option value="" >Selecionar estado</option>
                                    <option value="1" {{$user->status == 1 ?'selected':''}}>Activo</option>
                                    <option value="0" {{$user->status == 0 ?'selected':''}} >Desactivo</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          </div>
                          <div class="mb-3">
                            <label class="form-label" for="password">Contraseña</label>
                            <div class="">
                              <input type="password" id="password" class="form-control form-control-border @error('password') is-invalid @enderror" name="password" placeholder="********" aria-describedby="password"/>
                              @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                              @enderror
                            </div>
                          </div>
                          <div class="mb-3">
                            <label for="password-confirm" class="form-label">Confirmar Contraseña</label>
                            <input id="password-confirm" type="password" class="form-control form-control-border" name="password_confirmation" autocomplete="new-password">
                          </div>
                          <button class="btn btn-primary ">Guardar Usuario</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
