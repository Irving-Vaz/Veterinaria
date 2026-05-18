@extends('layouts.admin')

@section('titulo_pagina', 'Ver Usuario')

@section('page_heading', 'Detalles del Usuario')

@section('page_actions')
    <a href="{{ route('admin.users.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver a la Lista
    </a>
@endsection

@section('contenido')
    <div class="row">
        {{-- Resumen del Usuario --}}
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-user mr-2"></i> Información de la Cuenta</h6>
                    @if($usuario->is_active)
                        <span class="badge badge-success px-3 py-2">Estado: Activo</span>
                    @else
                        <span class="badge badge-secondary px-3 py-2">Estado: Inactivo</span>
                    @endif
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted font-weight-bold">Nombre (Login):</div>
                        <div class="col-sm-8">{{ $usuario->name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted font-weight-bold">Correo Electrónico:</div>
                        <div class="col-sm-8">{{ $usuario->email }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted font-weight-bold">Rol:</div>
                        <div class="col-sm-8">
                            @if($usuario->rol === 'administrador')
                                <span class="badge badge-danger">Administrador</span>
                            @else
                                <span class="badge badge-warning">Veterinario</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted font-weight-bold">Miembro desde:</div>
                        <div class="col-sm-8">{{ $usuario->created_at->format('d de M, Y h:i A') }}</div>
                    </div>

                    @if($usuario->rol === 'veterinario' && $usuario->veterinario)
                        <hr>
                        <h6 class="font-weight-bold text-gray-800 mb-3"><i class="fas fa-user-md mr-2"></i> Perfil Médico</h6>
                        
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted font-weight-bold">Nombre Completo:</div>
                            <div class="col-sm-8">{{ $usuario->veterinario->nombre_completo ?? 'No registrado' }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted font-weight-bold">Especialidad:</div>
                            <div class="col-sm-8">{{ $usuario->veterinario->especialidad ?? 'No registrado' }}</div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted font-weight-bold">Cédula Profesional:</div>
                            <div class="col-sm-8">{{ $usuario->veterinario->cedula_profesional ?? 'No registrado' }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Zona de Peligro (Eliminar) --}}
        <div class="col-lg-4">
            <div class="card shadow mb-4 border-left-danger">
                <div class="card-header py-3 bg-danger">
                    <h6 class="m-0 font-weight-bold text-white"><i class="fas fa-exclamation-triangle mr-2"></i> Zona de Peligro</h6>
                </div>
                <div class="card-body">
                    <p class="text-gray-800 font-weight-bold">Atención: Estás a punto de eliminar este usuario.</p>
                    <p class="small text-muted mb-4">
                        Esta acción es <strong>irreversible</strong>. Una vez eliminado, todos los datos personales, accesos, y perfiles (incluyendo la firma si la hay) se borrarán permanentemente del sistema. Si el usuario cuenta con registros importantes asociados (como reportes o consultas), el sistema bloqueará la eliminación por seguridad.
                    </p>
                    
                    @if(Auth::id() === $usuario->id)
                        <div class="alert alert-warning text-sm">
                            <i class="fas fa-info-circle"></i> No puedes eliminar tu propia cuenta.
                        </div>
                    @else
                        <form action="{{ route('admin.users.destroy', $usuario->id) }}" method="POST" onsubmit="return confirm('¿Estás absolutamente seguro de querer ELIMINAR este usuario de forma permanente?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-block btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-trash"></i>
                                </span>
                                <span class="text">Eliminar Usuario Definitivamente</span>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
