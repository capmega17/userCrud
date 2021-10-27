
<li class="{{ Request::is('user*') || Request::is('client*') ? 'has-sub highlight active' : '' }}">
    <a href='#'>
        <i class="fa fa-users"></i>
        <span>Usuarios</span>
    </a>
    <ul>
        <li>
            <a href="/user/create" class="{{ Request::is('user/create') ? 'select' : '' }}">
                <i class="fa fa-plus"></i>
                <span>Crear Usuario</span>
            </a>
        </li>
        <li>
            <a href="/user" class="{{ Request::is('user') || Request::is('user/*') ? 'select' : '' }}">
                <i class="fa fa-book"></i>
                <span>Listado de usuarios</span>
            </a>
        </li>
    </ul>
</li>
