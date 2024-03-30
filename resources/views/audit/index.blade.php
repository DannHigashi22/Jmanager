@extends('layouts.app')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>Auditorias</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right bg-transparent">
                    <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                    <li class="breadcrumb-item active">Auditorias</li>
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
                            @can('create-audit')
                                <a class="btn btn-primary float-left" href="{{route('audits.create')}}"><i class="fas fa-layer-group"></i> Nuevo</a>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>Pedido</th>
                                <th>shopper</th>
                                <th>Tipo</th>
                                <th>Auditor</th>
                                <th>Creado</th>
                                @if(auth()->user()->can('edit-audit') && auth()->user()->can('delete-audit'))
                                <th>Acciones</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($audits as $audit)
                                <tr>
                                    <td><strong>{{$audit->order}}</strong></td>
                                    <td>{{$audit->shopper}}</td>
                                    <td>
                                        @foreach ($audit->errors as $error)
                                            <small class="badge badge-warning">{{$error->type}}</small><br>
                                        @endforeach
                                    </td>
                                    <td>{{$audit->user->name.' '.$audit->user->surname}}</td>
                                    <td>{{$audit->created_at}}</td>
                                    @can('edit-audit')
                                    <td>
                                            <a class="btn btn-primary" href="{{route('audits.edit',$audit->id)}}"><i class="fas fa-user-edit"></i></a>
                                        @endcan
                                        @can('delete-audit')
                                            <form action="{{route('audits.destroy',$audit->id)}}" method="post" class="d-inline" >
                                                @csrf
                                                @method('DELETE')
                                                <button  class="btn btn-danger" type="submit"><i class="fas fa-trash-alt"></i></button>
                                            </form>
                                    </td>        
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination justify-center">
                        {!! $audits->links() !!}
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
