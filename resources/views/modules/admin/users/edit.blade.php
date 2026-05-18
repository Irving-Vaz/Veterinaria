@extends('layouts.admin')

@section('titulo_pagina', 'Editar Usuario')

@section('page_heading', 'Editar Usuario: ' . $usuario->name)

@section('page_actions')
    <a href="{{ route('admin.users.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Volver a la Lista
    </a>
@endsection

@section('contenido')
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-danger">Modificar Datos del Usuario</h6>
        </div>
        <div class="card-body">
            
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><i class="fas fa-exclamation-triangle"></i> ¡Por favor corrige los siguientes errores!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <form action="{{ route('admin.users.update', $usuario->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Información Básica de la Cuenta --}}
                <h5 class="font-weight-bold text-gray-800 mb-3"><i class="fas fa-user-circle"></i> Información de la Cuenta</h5>
                
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="name">Nombre de Usuario (Login)</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $usuario->name) }}" required>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $usuario->email) }}" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="password">Nueva Contraseña <small class="text-muted">(Dejar en blanco para mantener la actual)</small></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Mínimo 8 caracteres">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="password_confirmation">Confirmar Nueva Contraseña</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="rol">Rol del Sistema</label>
                        <select class="form-control @error('rol') is-invalid @enderror" id="rol" name="rol" required onchange="toggleVeterinarioFields()">
                            <option value="administrador" {{ old('rol', $usuario->rol) == 'administrador' ? 'selected' : '' }}>Administrador</option>
                            <option value="veterinario" {{ old('rol', $usuario->rol) == 'veterinario' ? 'selected' : '' }}>Veterinario</option>
                        </select>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="is_active">Estado de la Cuenta</label>
                        <div class="custom-control custom-switch mt-2">
                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', $usuario->is_active) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_active">Activo / Inactivo</label>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                {{-- Información Perfil Veterinario --}}
                <div id="veterinario_fields" style="display: none;">
                    <h5 class="font-weight-bold text-gray-800 mb-3"><i class="fas fa-user-md"></i> Perfil del Veterinario</h5>
                    
                    <div class="form-group">
                        <label for="nombre_completo">Nombre Completo del Médico</label>
                        <input type="text" class="form-control @error('nombre_completo') is-invalid @enderror" id="nombre_completo" name="nombre_completo" value="{{ old('nombre_completo', optional($usuario->veterinario)->nombre_completo) }}" placeholder="Ej. Dr. Juan Pérez Gómez">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="especialidad">Especialidad</label>
                            <input type="text" class="form-control @error('especialidad') is-invalid @enderror" id="especialidad" name="especialidad" value="{{ old('especialidad', optional($usuario->veterinario)->especialidad) }}" placeholder="Ej. Cirugía General">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="cedula_profesional">Cédula Profesional</label>
                            <input type="text" class="form-control @error('cedula_profesional') is-invalid @enderror" id="cedula_profesional" name="cedula_profesional" value="{{ old('cedula_profesional', optional($usuario->veterinario)->cedula_profesional) }}" placeholder="Número de cédula">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="foto_firma">Actualizar Firma Digital</label>
                        @if(optional($usuario->veterinario)->foto_firma)
                            <div class="mb-3">
                                <span class="badge badge-info">Ya tiene una firma guardada</span>
                                <p class="small text-muted mt-1">Sube un archivo nuevo solo si deseas cambiarla.</p>
                            </div>
                        @endif
                        <div class="custom-file">
                            <input type="file" class="custom-file-input @error('foto_firma') is-invalid @enderror" id="foto_firma" name="foto_firma" accept="image/*">
                            <label class="custom-file-label" for="foto_firma" data-browse="Buscar">Seleccionar nueva imagen...</label>
                        </div>
                        <small class="form-text text-muted">Formatos aceptados: JPEG, PNG, JPG, GIF. Tamaño máximo: 2MB.</small>
                    </div>
                </div>

                <div class="text-right mt-4">
                    <button type="submit" class="btn btn-danger btn-icon-split shadow-sm">
                        <span class="icon text-white-50">
                            <i class="fas fa-save"></i>
                        </span>
                        <span class="text">Guardar Cambios</span>
                    </button>
                </div>

            </form>
        </div>
    </div>

@endsection

@push('scripts')
<script src="/js/admin/usuarios/create.js"></script>
@endpush
