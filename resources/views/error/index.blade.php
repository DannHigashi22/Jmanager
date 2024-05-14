@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Error - Auditorias</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right bg-transparent">
                    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                    <li class="breadcrumb-item active">Error-Auditorias</li>
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
                        <div class="input-group input-group-sm" style="width: 150px;">
                            @can('create-error')
                                <a class="btn btn-primary float-left" href="{{route('errors.create')}}"><i class="fas fa-feather-alt"></i> Nuevo</a>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Creado</th>
                                @if(auth()->user()->can('edit-error') || auth()->user()->can('delete-error'))
                                <th>Acciones</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($errors as $error)
                                <tr>
                                    <td><strong>{{$error->type}}</strong></td>
                                    <td>{{$error->created_at}}</td>
                                    @can('edit-error')
                                    <td>
                                        <a class="btn btn-primary" href="{{route('errors.edit',$error->id)}}"><i class="fas fa-user-edit"></i></a>
                                    @endcan
                                    @can('delete-error')
                                        <a class="btn btn-danger" href="{{route('errors.destroy',$error->id)}}" data-confirm-delete="true"><i class="fas fa-trash-alt"></i></a>
                                    </td>        
                                    @endcan
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination justify-center">
                        {!! $errors->links() !!}
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
