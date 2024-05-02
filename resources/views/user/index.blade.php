@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Usuarios</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right bg-transparent">
                    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                    <li class="breadcrumb-item active">Usuarios</li>
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
                            @can('create-rol')
                                <a class="btn btn-primary float-left" href="{{route('users.create')}}"><i class="fas fa-user-plus"></i> Nuevo</a>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Estatus</th>
                                @if(auth()->user()->can('edit-user') && auth()->user()->can('delete-user'))
                                <th>Acciones</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td><strong>{{$user->name}}</strong></td>
                                    <td>{{$user->surname}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>
                                        @empty(!$user->getRoleNames())
                                            @foreach ($user->getRoleNames() as $roleName)
                                                <small class="badge badge-warning">{{$roleName}}</small>
                                            @endforeach
                                        @endempty
                                    </td>
                                    <td>{!! ($user->status == 1 ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-danger">inactivo</span>')!!}</td>
                                        @can('edit-rol')
                                        <td>
                                            <a class="btn btn-primary" href="{{route('users.edit',$user->id)}}"><i class="fas fa-user-edit"></i></a>
                                        @endcan
                                        @can('delete-rol')
                                            <a class="btn btn-danger" href="{{route('users.destroy',$user->id)}}"><i class="fas fa-trash-alt"></i></a>
                                        </td>    
                                        @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination justify-center">
                        {!! $users->links() !!}
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
