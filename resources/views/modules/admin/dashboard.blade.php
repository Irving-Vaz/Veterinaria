@extends('layouts.admin')

@section('titulo_pagina', 'Dashboard Administrador')

@section('page_heading', 'Panel de Administración')

@section('page_actions')
    <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">
        <i class="fas fa-file-export fa-sm text-white-50"></i> Exportar Reporte
    </a>
@endsection

@section('contenido')

    {{-- Tarjetas de resumen --}}
    <div class="row">

        {{-- Total Usuarios --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Usuarios</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Veterinarios --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Veterinarios</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-md fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Ingresos del Mes --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Ingresos del Mes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">$0.00</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Reportes Pendientes --}}
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Reportes Pendientes</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">0</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    {{-- Fin tarjetas --}}

    {{-- Fila de bienvenida + tabla de usuarios --}}
    <div class="row">

        {{-- Bienvenida --}}
        <div class="col-lg-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3 bg-gradient-danger">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-shield-alt mr-1"></i> Bienvenido, Administrador
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <img class="img-fluid rounded-circle mb-3"
                            src="/startbootstrap/img/undraw_profile.svg"
                            alt="Perfil" style="width: 80px;">
                        <h5 class="font-weight-bold text-gray-800">{{ Auth::user()->name }}</h5>
                        <span class="badge badge-danger px-3 py-1">Administrador</span>
                    </div>
                    <hr>
                    <p class="text-gray-600 small mb-0">
                        Tienes acceso completo al sistema. Usa el menú lateral para gestionar usuarios,
                        revisar reportes y configurar el sistema.
                    </p>
                </div>
            </div>
        </div>

        {{-- Tabla de usuarios registrados --}}
        <div class="col-lg-8 mb-4">
            <div class="card shadow">
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-danger">
                        <i class="fas fa-users mr-1"></i> Usuarios Registrados
                    </h6>
                    <a href="#" class="btn btn-sm btn-danger">
                        <i class="fas fa-plus fa-sm"></i> Nuevo
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="tablaUsuarios" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Rol</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" class="text-center text-gray-500 py-4">
                                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                        No hay usuarios registrados aún.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    {{-- Fin fila --}}

@endsection
