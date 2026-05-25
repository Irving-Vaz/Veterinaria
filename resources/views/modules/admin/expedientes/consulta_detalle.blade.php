@extends('layouts.main')

@section('titulo_pagina', 'Detalle de Consulta')

@section('page_heading', 'Detalle de Consulta - ' . $mascota->nombre)

@section('contenido')
    <div class="row">
        {{-- Información Principal de la Consulta --}}
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4 border-left-primary">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-stethoscope mr-2"></i> Detalles Médicos
                    </h6>
                    <span class="badge badge-info px-3 py-2">
                        <i class="far fa-calendar-alt mr-1"></i> 
                        {{ $consulta->fecha_consulta->format('d/m/Y') }} a las {{ $consulta->fecha_consulta->format('H:i') }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6 mb-3">
                            <div class="small text-gray-500 font-weight-bold text-uppercase mb-1">Veterinario Tratante</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <i class="fas fa-user-md mr-2 text-primary"></i>
                                {{ $consulta->veterinario ? $consulta->veterinario->nombre_completo : 'No asignado' }}
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="small text-gray-500 font-weight-bold text-uppercase mb-1">Peso</div>
                            <div class="h5 mb-0 text-gray-800">
                                <i class="fas fa-weight mr-2 text-info"></i>
                                {{ $consulta->peso ? $consulta->peso . ' kg' : 'N/A' }}
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="small text-gray-500 font-weight-bold text-uppercase mb-1">Talla</div>
                            <div class="h5 mb-0 text-gray-800">
                                <i class="fas fa-ruler-vertical mr-2 text-info"></i>
                                {{ $consulta->talla ? $consulta->talla . ' cm' : 'N/A' }}
                            </div>
                        </div>
                    </div>

                    <hr>

                    

                    <div class="mt-4 text-center">
                        <a href="{{ route('admin.expedientes.consultas', $mascota->id) }}" class="btn btn-secondary btn-icon-split shadow-sm">
                            <span class="icon text-white-50">
                                <i class="fas fa-arrow-left"></i>
                            </span>
                            <span class="text">Volver al Historial</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Información del Paciente y Antecedentes --}}
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-paw mr-2"></i> Paciente
                    </h6>
                </div>
                <div class="card-body text-center">
                    <div class="text-primary bg-light rounded-circle p-3 d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="fas fa-paw fa-2x"></i>
                    </div>
                    <h5 class="font-weight-bold mb-1">{{ $mascota->nombre }}</h5>
                    <p class="text-muted small mb-3">Dueño: {{ $mascota->dueno ? $mascota->dueno->nombre_completo : 'N/A' }}</p>

                    <ul class="list-group list-group-flush text-left mb-0">
                        <li class="list-group-item px-0">
                            <strong>Especie/Raza:</strong> 
                            <span class="float-right">{{ $mascota->especie }} {{ $mascota->raza ? '/ '.$mascota->raza : '' }}</span>
                        </li>
                        <li class="list-group-item px-0">
                            <strong>Edad:</strong> 
                            <span class="float-right">{{ $mascota->fecha_nacimiento ? $mascota->fecha_nacimiento->diffInYears(now()) . ' años' : 'N/A' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-file-medical mr-2"></i> Antecedentes
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush text-left mb-0">
                        <li class="list-group-item px-0 py-2">
                            <strong class="text-gray-700">Tipo de Sangre:</strong> 
                            <span class="float-right text-muted">{{ $mascota->tipo_sangre ?: 'No especificado' }}</span>
                        </li>
                        <li class="list-group-item px-0 py-2">
                            <strong class="text-gray-700">Comportamiento:</strong> 
                            <span class="float-right text-muted">{{ $mascota->comportamiento ?: 'No especificado' }}</span>
                        </li>
                        <li class="list-group-item px-0 py-2">
                            <strong class="text-gray-700">Condición:</strong> 
                            <span class="float-right text-muted">
                                @if($mascota->es_adoptado)
                                    <span class="badge badge-success">Adoptado</span>
                                @else
                                    <span class="badge badge-secondary">No Especificado</span>
                                @endif
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_sidebar')
    @include('modules.admin.expedientes.partials.consulta_sidebar')
@endsection
