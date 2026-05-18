@extends('layouts.main')

@section('hide_sidebar', true)

@section('titulo_pagina', 'Expedientes Médicos')

@section('page_heading', 'Gestión de Expedientes')

@section('contenido')
    <div class="row justify-content-center mt-5">
        <div class="col-lg-8 col-md-10">
            <div class="card shadow mb-4">
                <div class="card-body text-center py-5 px-4">
                    
                    <i class="fas fa-search-plus fa-4x text-gray-300 mb-4"></i>
                    <h1 class="h4 text-gray-800 font-weight-bold mb-4">Búsqueda de Expedientes</h1>
                    <p class="text-muted mb-4">Ingresa el nombre del dueño, el nombre de la mascota o el número de registro para localizar su expediente.</p>

                    {{-- Buscador Principal --}}
                    <form action="#" method="GET" class="mb-5">
                        <div class="input-group input-group-lg shadow-sm">
                            <input type="text" class="form-control border-0 bg-light" placeholder="Ej. Firulais, Juan Pérez..." aria-label="Buscar expediente" name="search">
                            <div class="input-group-append">
                                <button class="btn btn-primary px-4" type="button">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <hr class="mb-4">

                    {{-- Botones de Acción --}}
                    <div class="d-flex justify-content-center flex-wrap">
                        <a href="#" class="btn btn-info btn-icon-split shadow-sm m-2">
                            <span class="icon text-white-50">
                                <i class="fas fa-notes-medical"></i>
                            </span>
                            <span class="text">Ver Historial de Consultas</span>
                        </a>

                        <a href="#" class="btn btn-success btn-icon-split shadow-sm m-2">
                            <span class="icon text-white-50">
                                <i class="fas fa-paw"></i>
                            </span>
                            <span class="text">Registrar Nuevo Paciente</span>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
