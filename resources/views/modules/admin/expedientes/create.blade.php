@extends('layouts.main')

@section('hide_sidebar', true)

@section('titulo_pagina', 'Registrar Nuevo Paciente')

@section('page_heading', 'Registro de Paciente')

@section('contenido')
    <div class="row justify-content-center">
        <div class="col-xl-10">
            
            <form action="{{ route('admin.expedientes.store') }}" method="POST">
                @csrf
                <div class="row">
                    
                    {{-- Datos del Dueño --}}
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow border-left-info h-100">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-info"><i class="fas fa-user mr-2"></i>Datos del Dueño</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group mb-3">
                                    <label for="dueno_nombre" class="font-weight-bold">Nombre Completo <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('dueno_nombre') is-invalid @enderror" id="dueno_nombre" name="dueno_nombre" value="{{ old('dueno_nombre') }}" required placeholder="Ej. Juan Pérez">
                                    @error('dueno_nombre') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="dueno_telefono" class="font-weight-bold">Teléfono <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('dueno_telefono') is-invalid @enderror" id="dueno_telefono" name="dueno_telefono" value="{{ old('dueno_telefono') }}" required placeholder="Ej. 555-123-4567">
                                    @error('dueno_telefono') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                                <div class="form-group mb-3">
                                    <label for="dueno_direccion" class="font-weight-bold">Dirección</label>
                                    <textarea class="form-control @error('dueno_direccion') is-invalid @enderror" id="dueno_direccion" name="dueno_direccion" rows="3" placeholder="Domicilio completo">{{ old('dueno_direccion') }}</textarea>
                                    @error('dueno_direccion') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Datos del Paciente (Mascota) --}}
                    <div class="col-lg-6 mb-4">
                        <div class="card shadow border-left-primary h-100">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-paw mr-2"></i>Datos del Paciente</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-7 form-group mb-3">
                                        <label for="mascota_nombre" class="font-weight-bold">Nombre de la Mascota <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('mascota_nombre') is-invalid @enderror" id="mascota_nombre" name="mascota_nombre" value="{{ old('mascota_nombre') }}" required placeholder="Ej. Firulais">
                                        @error('mascota_nombre') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-md-5 form-group mb-3">
                                        <label for="especie" class="font-weight-bold">Especie <span class="text-danger">*</span></label>
                                        <select class="form-control @error('especie') is-invalid @enderror" id="especie" name="especie" required>
                                            <option value="">Seleccione...</option>
                                            <option value="Perro" {{ old('especie') == 'Perro' ? 'selected' : '' }}>Perro</option>
                                            <option value="Gato" {{ old('especie') == 'Gato' ? 'selected' : '' }}>Gato</option>
                                            <option value="Ave" {{ old('especie') == 'Ave' ? 'selected' : '' }}>Ave</option>
                                            <option value="Roedor" {{ old('especie') == 'Roedor' ? 'selected' : '' }}>Roedor</option>
                                            <option value="Reptil" {{ old('especie') == 'Reptil' ? 'selected' : '' }}>Reptil</option>
                                            <option value="Otro" {{ old('especie') == 'Otro' ? 'selected' : '' }}>Otro</option>
                                        </select>
                                        @error('especie') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="raza" class="font-weight-bold">Raza</label>
                                        <input type="text" class="form-control @error('raza') is-invalid @enderror" id="raza" name="raza" value="{{ old('raza') }}" placeholder="Ej. Labrador">
                                        @error('raza') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="fecha_nacimiento" class="font-weight-bold">Fecha de Nacimiento</label>
                                        <input type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror" id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}">
                                        @error('fecha_nacimiento') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="tipo_sangre" class="font-weight-bold">Tipo de Sangre</label>
                                        <input type="text" class="form-control @error('tipo_sangre') is-invalid @enderror" id="tipo_sangre" name="tipo_sangre" value="{{ old('tipo_sangre') }}" placeholder="Ej. DEA 1.1">
                                        @error('tipo_sangre') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                    <div class="col-md-6 form-group mb-3">
                                        <label for="comportamiento" class="font-weight-bold">Comportamiento</label>
                                        <select class="form-control @error('comportamiento') is-invalid @enderror" id="comportamiento" name="comportamiento">
                                            <option value="">Seleccione...</option>
                                            <option value="Dócil" {{ old('comportamiento') == 'Dócil' ? 'selected' : '' }}>Dócil</option>
                                            <option value="Nervioso" {{ old('comportamiento') == 'Nervioso' ? 'selected' : '' }}>Nervioso</option>
                                            <option value="Agresivo" {{ old('comportamiento') == 'Agresivo' ? 'selected' : '' }}>Agresivo</option>
                                            <option value="Miedoso" {{ old('comportamiento') == 'Miedoso' ? 'selected' : '' }}>Miedoso</option>
                                        </select>
                                        @error('comportamiento') <small class="text-danger">{{ $message }}</small> @enderror
                                    </div>
                                </div>

                                <div class="form-group mb-3 mt-2">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="es_adoptado" name="es_adoptado" value="1" {{ old('es_adoptado') ? 'checked' : '' }}>
                                        <label class="custom-control-label font-weight-bold" for="es_adoptado">¿El paciente es adoptado?</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Botones de Acción --}}
                <div class="text-center mt-3 mb-5">
                    <a href="{{ route('admin.expedientes.index') }}" class="btn btn-secondary shadow-sm px-4 mr-2">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-success shadow-sm px-5">
                        <i class="fas fa-save mr-2"></i> Registrar Paciente
                    </button>
                </div>
            </form>
            
        </div>
    </div>
@endsection
