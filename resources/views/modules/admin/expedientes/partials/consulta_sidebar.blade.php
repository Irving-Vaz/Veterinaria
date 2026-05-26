<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    {{-- Sidebar Brand --}}
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.expedientes.index') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-paw"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Expediente</div>
    </a>

    {{-- Divider --}}
    <hr class="sidebar-divider my-0">

    {{-- Volver --}}
    <li class="nav-item">
        <a class="nav-link" href="{{ route('admin.expedientes.consultas', $mascota->id) }}">
            <i class="fas fa-fw fa-arrow-left"></i>
            <span>Volver a Consultas</span>
        </a>
    </li>

    {{-- Divider --}}
    <hr class="sidebar-divider">

    {{-- Heading: Consulta Actual --}}
    <div class="sidebar-heading">
        Consulta Actual
    </div>

    <li class="nav-item {{ request()->routeIs('admin.expedientes.consultas.diagnostico') ? 'active' : '' }}">
        <a class="nav-link pb-1" href="{{ route('admin.expedientes.consultas.diagnostico', [$mascota->id, $consulta->id]) }}">
            <i class="fas fa-fw fa-stethoscope"></i>
            <span>Diagnóstico</span>
        </a>
    </li>
    <li class="nav-item {{ request()->routeIs('admin.expedientes.consultas.tratamiento') ? 'active' : '' }}">
        <a class="nav-link pt-1" href="{{ route('admin.expedientes.consultas.tratamiento', [$mascota->id, $consulta->id]) }}">
            <i class="fas fa-fw fa-pills"></i>
            <span>Tratamiento</span>
        </a>
    </li>

    {{-- Divider --}}
    <hr class="sidebar-divider">

    {{-- Heading: Historial Clínico --}}
    <div class="sidebar-heading">
        Historial Clínico
    </div>

    <li class="nav-item {{ request()->routeIs('admin.expedientes.consultas.alergias') ? 'active' : '' }}">
        <a class="nav-link pt-1" href="{{ route('admin.expedientes.consultas.alergias', [$mascota->id, $consulta->id]) }}">
            <i class="fas fa-fw fa-allergies"></i>
            <span>Alergias</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link py-1" href="#">
            <i class="fas fa-fw fa-band-aid"></i>
            <span>Lesiones Previas</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link py-1" href="#">
            <i class="fas fa-fw fa-virus"></i>
            <span>Patologías</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link pt-1" href="#">
            <i class="fas fa-fw fa-bone"></i>
            <span>Alimentación</span>
        </a>
    </li>

    {{-- Divider --}}
    <hr class="sidebar-divider d-none d-md-block">

    {{-- Sidebar Toggler --}}
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
