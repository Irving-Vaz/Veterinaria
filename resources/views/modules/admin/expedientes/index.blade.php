@extends('layouts.main')

@section('hide_sidebar', true)

@section('titulo_pagina', 'Expedientes Médicos')

@section('page_heading', 'Gestión de Expedientes')

@section('contenido')
    <div class="card shadow mb-4">
        <div class="card-body text-center py-5">
            <i class="fas fa-folder-open fa-4x text-gray-300 mb-3"></i>
            <h5 class="text-gray-600 font-weight-bold">Módulo de Expedientes</h5>
            <p class="text-muted">Esta sección está lista para comenzar a registrar el historial clínico de los pacientes.</p>
            <button class="btn btn-primary mt-3">
                <i class="fas fa-plus mr-1"></i> Crear Nuevo Expediente
            </button>
        </div>
    </div>
@endsection
