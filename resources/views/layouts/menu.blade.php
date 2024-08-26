<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link  {{(Request::path() == 'home') ? 'active' : ''}}">
        <i class="nav-icon fas fa-chart-line"></i>
        <p>Dashboard</p>
    </a>
</li>
@if(auth()->user()->can('show-audit'))
    <li class="nav-item">
        <a href="/audits" class="nav-link  {{(Request::path() == 'audits'|| Request::is('audits*')) ? 'active' : ''}}">
            <i class="nav-icon fas fa-feather "></i>
            <p>Auditorias</p>
        </a>
    </li>
@endif
@if(auth()->user()->can('show-error') )
    <li class="nav-item">
        <a href="/errors" class="nav-link {{(Request::path() == 'errors'|| Request::is('errors*')) ? 'active' : ''}} ">
        <i class="nav-icon fas fa-scroll"></i>
        <p>Error Tipo</p></a>
    </li>
@endif
@if(auth()->user()->can('show-csat') )
    <li class="nav-item">
        <a href="/csat" class="nav-link {{(Request::path() == 'cliCsat'|| Request::is('cliCsat*')) ? 'active' : ''}} ">
        <i class=" nav-icon fas fa-poll-h"></i>
        <p>Csat Clientes</p></a>
    </li>
@endif
@if(auth()->user()->can('show-user'))
    <li class="nav-item">
        <a href="/users" class="nav-link {{(Request::path() == 'users' || Request::is('users*')) ? 'active' : ''}} ">
            <i class="nav-icon fas fa-users"></i>
            <p>Usuarios</p>
        </a>
    </li>
@endif
@if(auth()->user()->can('show-rol'))
    <li class="nav-item">
        <a href="/roles" class="nav-link {{(Request::path() == 'roles') || Request::is('roles*') ? 'active' : ''}} ">
            <i class="nav-icon fas fa-user-tag"></i>
            <p>Roles</p>
        </a>
    </li>
@endif
