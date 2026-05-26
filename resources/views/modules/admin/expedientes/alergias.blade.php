@extends('layouts.main')

@section('titulo_pagina', 'Alergias - ' . $mascota->nombre)

@section('page_heading', 'Alergias Conocidas')

@section('custom_sidebar')
    @include('modules.admin.expedientes.partials.consulta_sidebar')
@endsection

@section('contenido')
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4 border-left-danger">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-danger">
                        <i class="fas fa-allergies mr-2"></i> Registro de Alergias del Paciente
                    </h6>
                </div>
                <div class="card-body">
                    {{-- Información Básica --}}
                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                        <div class="mr-4 text-center">
                            <div class="text-danger bg-light rounded-circle p-3 d-inline-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px;">
                                <i class="fas fa-paw fa-lg"></i>
                            </div>
                        </div>
                        <div>
                            <h5 class="font-weight-bold mb-1 text-gray-800">Paciente: {{ $mascota->nombre }}</h5>
                            <p class="text-muted mb-0">
                                Las alergias registradas aquí se guardan de forma permanente en el perfil del paciente y estarán visibles en todas sus consultas.
                            </p>
                        </div>
                    </div>

                    {{-- Formulario de Alergias --}}
                    <form action="{{ route('admin.expedientes.consultas.alergias.store', [$mascota->id, $consulta->id]) }}" method="POST">
                        @csrf
                        
                        @php
                            $alergias = old('alergias', is_array($mascota->alergias) ? $mascota->alergias : []);
                        @endphp

                        <div class="row">
                            {{-- Insectos --}}
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 bg-light border-0">
                                    <div class="card-body">
                                        <h6 class="font-weight-bold text-gray-800 mb-3">
                                            <i class="fas fa-bug text-warning mr-2"></i> Insectos y Parásitos
                                        </h6>
                                        <div class="form-group mb-0">
                                            <textarea class="form-control" name="alergias[insectos]" rows="3" placeholder="Ej. Picadura de pulga, garrapatas, abejas...">{{ $alergias['insectos'] ?? '' }}</textarea>
                                            <small class="text-muted mt-1 d-block">Especifique si existe hipersensibilidad a picaduras.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Medicamentos --}}
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 bg-light border-0">
                                    <div class="card-body">
                                        <h6 class="font-weight-bold text-gray-800 mb-3">
                                            <i class="fas fa-pills text-info mr-2"></i> Medicamentos
                                        </h6>
                                        <div class="form-group mb-0">
                                            <textarea class="form-control" name="alergias[medicamentos]" rows="3" placeholder="Ej. Penicilina, ciertos antibióticos...">{{ $alergias['medicamentos'] ?? '' }}</textarea>
                                            <small class="text-muted mt-1 d-block">Indique fármacos que han causado reacciones adversas.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            {{-- Alimentos --}}
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 bg-light border-0">
                                    <div class="card-body">
                                        <h6 class="font-weight-bold text-gray-800 mb-3">
                                            <i class="fas fa-bone text-success mr-2"></i> Alimentos
                                        </h6>
                                        <div class="form-group mb-0">
                                            <textarea class="form-control" name="alergias[alimentos]" rows="3" placeholder="Ej. Pollo, res, gluten, lácteos...">{{ $alergias['alimentos'] ?? '' }}</textarea>
                                            <small class="text-muted mt-1 d-block">Detalle intolerancias alimentarias o alergias a ingredientes.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Ambientales --}}
                            <div class="col-md-6 mb-4">
                                <div class="card h-100 bg-light border-0">
                                    <div class="card-body">
                                        <h6 class="font-weight-bold text-gray-800 mb-3">
                                            <i class="fas fa-leaf text-secondary mr-2"></i> Ambientales u Otros
                                        </h6>
                                        <div class="form-group mb-0">
                                            <textarea class="form-control" name="alergias[ambientales]" rows="3" placeholder="Ej. Polen, ácaros del polvo, productos de limpieza...">{{ $alergias['ambientales'] ?? '' }}</textarea>
                                            <small class="text-muted mt-1 d-block">Cualquier otra alergia de contacto o respiratoria.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-right border-top pt-4">
                            <a href="{{ route('admin.expedientes.consultas.show', [$mascota->id, $consulta->id]) }}" class="btn btn-secondary shadow-sm mr-2">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-danger shadow-sm btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-save"></i>
                                </span>
                                <span class="text">Guardar Alergias</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
