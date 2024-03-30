@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Crear Error - Tipo Auditorias</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right bg-transparent">
                    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                    <li class="breadcrumb-item"><a href="/errors">Error-Auditorias</a></li>
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
                        <form id="formAuthentication" class="mb-3" action="{{route('errors.store')}}" method="POST">
                            @csrf
                          <div class="mb-3">
                            <label for="type" class="form-label">Nombre de tipo</label>
                            <input type="text" class="form-control form-control-border @error('type') is-invalid @enderror" id="type" name="type" value="{{ old('type') }}" placeholder="Ingrese tipo" autofocus/>
                            @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                          </div>
                          <button class="btn btn-primary">Crear Error-Tipo</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection