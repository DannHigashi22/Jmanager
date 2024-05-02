@extends('layouts.app')

@section('content')
    <section class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-6">
                    <h1>Crear Usuarios</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right bg-transparent">
                            <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="/users">Usuarios</a></li>
                            <li class="breadcrumb-item active">Crear</li>
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
                        <form id="formAuthentication" class="mb-3" action="{{route('users.store')}}" method="POST">
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
                            <label for="surname" class="form-label">Apellido</label>
                            <input type="text" class="form-control form-control-border @error('surname') is-invalid @enderror" id="surname" name="surname" value="{{ old('surname') }}" placeholder="Ingrese apellido"/>
                            @error('surname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          </div>
                          <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="text" class="form-control form-control-border @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Ingresa email" />
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          </div>
                          <div class="mb-3">
                            <label class="form-label" for="roles">Rol</label>
                            <select class="custom-select form-control-border @error('roles') is-invalid @enderror" name="roles">
                                <option></option>
                                @foreach ($roles as $rol)
                                    <option value="{{$rol}}" {{old('roles')== $rol?'selected':''}} >{{$rol}}</option>
                                @endforeach
                            </select>
                            @error('roles')
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
                          <button class="btn btn-primary ">Registrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
