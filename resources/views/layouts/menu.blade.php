<!-- need to remove -->
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link  {{(Request::path() == 'home') ? 'active' : ''}}">
        <i class="nav-icon fas fa-chart-line"></i>
        <p>Dashboard</p>
    </a>
</li>
<li class="nav-item">
    <a href="/audits" class="nav-link  {{(Request::path() == 'audits') ? 'active' : ''}}">
        <i class="nav-icon fas fa-feather "></i>
        <p>Auditorias</p>
    </a>
</li>
<li class="nav-item">
    <a href="/errors" class="nav-link {{(Request::path() == 'errors') ? 'active' : ''}} ">
    <i class="nav-icon fas fa-scroll"></i>
    <p>Error Tipo</p>
</a></li>
<li class="nav-item">
    <a href="/users" class="nav-link {{(Request::path() == 'users' ) ? 'active' : ''}} ">
        <i class="nav-icon fas fa-users"></i>
        <p>Usuarios</p>
    </a>
</li>
<li class="nav-item">
    <a href="/roles" class="nav-link {{(Request::path() == 'roles') ? 'active' : ''}} ">
        <i class="nav-icon fas fa-user-tag"></i>
        <p>Roles</p>
    </a>
</li>