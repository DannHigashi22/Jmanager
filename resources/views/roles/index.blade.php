@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Roles</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right bg-transparent">
                    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                    <li class="breadcrumb-item active">Roles</li>
                </ol>
            </div>
        </div>
    </div>
</section>
    <div class="container-fluid">    
        <div class="row">
            <div class="col-12">
                <div class="card card-secondary">
                    <div class="card-header">
                        @can('create-rol')
                        <a class="btn btn-primary float-left" href="{{route('roles.create')}}"><i class="fas fa-tag"></i> Nuevo</a>
                        @endcan
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Rol</th>
                                <th>Creado</th>
                                @if(auth()->user()->can('edit-audit') && auth()->user()->can('delete-audit'))
                                <th>Acciones</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $rol)
                                <tr>
                                    <td><strong>{{$rol->name}}</strong></td>
                                    <td> {{$rol->created_at}}</td>
                                        @can('edit-rol')
                                        <td>
                                            <a class="btn btn-primary " href="{{route('roles.edit',$rol->id)}}" ><i class="fas fa-edit"></i></a>
                                        @endcan
                                        @can('delete-rol')
                                        <a class="btn btn-danger" href="{{route('roles.destroy',$rol->id)}}" data-confirm-delete="true"><i class="fas fa-trash-alt"></i></a>
                                        </td>    
                                        @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination justify-self-end">
                        {!! $roles->links() !!}
                    </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
@endsection