    <table class="table table-hover text-nowrap">
        <thead>
            <tr>
                <th>Id</th>
                <th>Pedido</th>
                <th>Tipo</th>
                <th>Shopper</th>
                <th>Error</th>
                <th>Auditor</th>
                <th>Creado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($audits as $audit)
                <tr>
                    <td>{{$audit->id}}</td>
                    <td>{{$audit->order}}</td>
                    <td>{{$audit->type}}</td>
                    <td>{!! $audit->shopper ? $audit->shopper: 'Sin Datos' !!}</td>
                    <td>
                        @foreach ($audit->errors as $error)
                           {{$error->type}};
                        @endforeach
                    </td>
                    <td>{{$audit->user->name.' '.$audit->user->surname}}</td>
                    <td>{{date_format($audit->created_at,'d/m/Y')}} </td>
                </tr>
            @endforeach
        </tbody>
        </table>