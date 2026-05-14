{{-- ============================================================
     SIDEBAR - Sistema Veterinaria
     Archivo: layouts/partials/sidebar.blade.php
     ============================================================ --}}

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    {{-- Sidebar Brand --}}
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon">
            <i class="fas fa-paw"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Veterinaria</div>
    </a>

    {{-- Divider --}}
    <hr class="sidebar-divider my-0">

    {{-- Dashboard --}}
    <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>

    {{-- Divider --}}
    <hr class="sidebar-divider">

    {{-- Heading: Gestión --}}
    <div class="sidebar-heading">
        Gestión
    </div>

    {{-- Pacientes --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePacientes"
            aria-expanded="true" aria-controls="collapsePacientes">
            <i class="fas fa-fw fa-dog"></i>
            <span>Pacientes</span>
        </a>
        <div id="collapsePacientes" class="collapse" aria-labelledby="headingPacientes"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Mascotas:</h6>
                <a class="collapse-item" href="#">Ver Todos</a>
                <a class="collapse-item" href="#">Nuevo Paciente</a>
            </div>
        </div>
    </li>

    {{-- Citas --}}
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCitas"
            aria-expanded="true" aria-controls="collapseCitas">
            <i class="fas fa-fw fa-calendar-check"></i>
            <span>Citas</span>
        </a>
        <div id="collapseCitas" class="collapse" aria-labelledby="headingCitas"
            data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Agenda:</h6>
                <a class="collapse-item" href="#">Ver Citas</a>
                <a class="collapse-item" href="#">Nueva Cita</a>
            </div>
        </div>
    </li>

    {{-- Divider --}}
    <hr class="sidebar-divider">

    {{-- Heading: Catálogos --}}
    <div class="sidebar-heading">
        Catálogos
    </div>

    {{-- Propietarios --}}
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-users"></i>
            <span>Propietarios</span>
        </a>
    </li>

    {{-- Servicios --}}
    <li class="nav-item">
        <a class="nav-link" href="#">
            <i class="fas fa-fw fa-stethoscope"></i>
            <span>Servicios</span>
        </a>
    </li>

    {{-- Divider --}}
    <hr class="sidebar-divider d-none d-md-block">

    {{-- Sidebar Toggler --}}
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
