{{-- ============================================================
     SIDEBAR - Panel Administrador
     Archivo: layouts/admin_partials/sidebar.blade.php
     ============================================================ --}}

<ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">

    {{-- Sidebar Brand --}}
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-shield-alt"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin Panel</div>
    </a>

    {{-- Divider --}}
    <hr class="sidebar-divider my-0">

    {{-- Dashboard --}}
    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    {{-- Divider --}}
    <hr class="sidebar-divider">

    {{-- Heading: Gestión de Usuarios --}}
    <div class="sidebar-heading">
        Gestión
    </div>

    {{-- Usuarios --}}
    <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
        <a class="nav-link {{ request()->routeIs('admin.users.*') ? '' : 'collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseUsuarios"
            aria-expanded="{{ request()->routeIs('admin.users.*') ? 'true' : 'false' }}" aria-controls="collapseUsuarios">
            <i class="fas fa-fw fa-users-cog"></i>
            <span>Usuarios</span>
        </a>
        <div id="collapseUsuarios" class="collapse {{ request()->routeIs('admin.users.*') ? 'show' : '' }}" aria-labelledby="headingUsuarios"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Cuentas:</h6>
                <a class="collapse-item {{ request()->routeIs('admin.users.index') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">Ver Todos</a>
                <a class="collapse-item" href="#">Nuevo Usuario</a>
            </div>
        </div>
    </li>

    {{-- Reportes --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReportes"
            aria-expanded="true" aria-controls="collapseReportes">
            <i class="fas fa-fw fa-chart-bar"></i>
            <span>Reportes</span>
        </a>
        <div id="collapseReportes" class="collapse" aria-labelledby="headingReportes"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Estadísticas:</h6>
                <a class="collapse-item" href="#">Reporte General</a>
                <a class="collapse-item" href="#">Ingresos</a>
            </div>
        </div>
    </li>

    {{-- Divider --}}
    <hr class="sidebar-divider">

    {{-- Heading: Sistema --}}
    <div class="sidebar-heading">
        Sistema
    </div>

    {{-- Configuración --}}
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-cogs"></i>
            <span>Configuración</span>
        </a>
    </li>

    {{-- Divider --}}
    <hr class="sidebar-divider d-none d-md-block">

    {{-- Sidebar Toggler --}}
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
