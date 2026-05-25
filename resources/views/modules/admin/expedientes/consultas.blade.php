@extends('layouts.main')

@section('hide_sidebar', true)

@section('titulo_pagina', 'Consultas de ' . $mascota->nombre)

@section('page_heading', 'Historial de Consultas')

@section('contenido')
    <div class="row">
        {{-- Información de la Mascota --}}
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Información del Paciente</h6>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="text-primary bg-light rounded-circle p-4 d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                            <i class="fas fa-paw fa-3x"></i>
                        </div>
                        <h4 class="font-weight-bold mb-1">{{ $mascota->nombre }}</h4>
                        <span class="badge badge-primary px-3 py-2 mb-3">Folio #{{ $mascota->id }}</span>
                    </div>

                    <ul class="list-group list-group-flush text-left mt-4">
                        <li class="list-group-item px-0">
                            <strong><i class="fas fa-user mr-2 text-gray-500"></i> Dueño:</strong> 
                            <span class="float-right text-muted">{{ $mascota->dueno ? $mascota->dueno->nombre_completo : 'Desconocido' }}</span>
                        </li>
                        <li class="list-group-item px-0">
                            <strong><i class="fas fa-paw mr-2 text-gray-500"></i> Especie / Raza:</strong> 
                            <span class="float-right text-muted">{{ $mascota->especie }} {{ $mascota->raza ? '/ '.$mascota->raza : '' }}</span>
                        </li>
                        <li class="list-group-item px-0">
                            <strong><i class="fas fa-calendar-alt mr-2 text-gray-500"></i> F. Nacimiento:</strong> 
                            <span class="float-right text-muted">{{ $mascota->fecha_nacimiento ? $mascota->fecha_nacimiento->format('d/m/Y') : 'N/A' }}</span>
                        </li>
                    </ul>

                    <div class="mt-4">
                        <a href="{{ route('admin.expedientes.index') }}" class="btn btn-secondary btn-icon-split btn-sm w-100 mb-2">
                            <span class="icon text-white-50">
                                <i class="fas fa-arrow-left"></i>
                            </span>
                            <span class="text">Volver a Búsqueda</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Historial de Consultas --}}
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Consultas Registradas ({{ $mascota->consultas->count() }})</h6>
                    <a href="#" class="btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Nueva Consulta</a>
                </div>
                <div class="card-body">
                    @if($mascota->consultas->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Fecha y Hora</th>
                                        <th>Veterinario</th>
                                        <th>Peso</th>
                                        <th>Diagnóstico</th>
                                        <th>Tratamiento</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($mascota->consultas as $consulta)
                                        <tr>
                                            <td class="align-middle">
                                                <div class="font-weight-bold text-gray-800">{{ $consulta->fecha_consulta->format('d/m/Y') }}</div>
                                                <small class="text-muted"><i class="far fa-clock mr-1"></i>{{ $consulta->fecha_consulta->format('H:i') }}</small>
                                            </td>
                                            <td class="align-middle">
                                                <div class="text-gray-800">{{ $consulta->veterinario ? $consulta->veterinario->nombre_completo : 'No asignado' }}</div>
                                            </td>
                                            <td class="align-middle">
                                                <div class="text-gray-800">{{ $consulta->peso ? $consulta->peso . ' kg' : 'N/A' }}</div>
                                            </td>
                                            <td class="align-middle">{{ Str::limit(strip_tags($consulta->diagnostico), 50) }}</td>
                                            <td class="align-middle">{{ Str::limit(strip_tags($consulta->tratamiento), 50) }}</td>
                                            <td class="align-middle text-center">
                                                <a href="{{ route('admin.expedientes.consultas.show', ['mascota' => $mascota->id, 'consulta' => $consulta->id]) }}" class="btn btn-info btn-circle btn-sm shadow-sm" title="Ver Detalle">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-file-medical-alt fa-3x text-gray-300 mb-3"></i>
                            <p class="text-muted mb-0">No hay consultas registradas para este paciente.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
