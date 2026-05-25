@extends('layouts.main')

@section('titulo_pagina', 'Diagnóstico - ' . $mascota->nombre)

@section('page_heading', 'Diagnóstico de la Consulta')

@push('styles')
    {{-- Quill Theme --}}
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <style>
        #editor-container {
            height: 300px;
            background-color: #f8f9fc;
            font-size: 1rem;
        }
    </style>
@endpush

@section('custom_sidebar')
    @include('modules.admin.expedientes.partials.consulta_sidebar')
@endsection

@section('contenido')
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4 border-left-warning">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-stethoscope mr-2"></i> Registro de Diagnóstico
                    </h6>
                </div>
                <div class="card-body">
                    {{-- Información Básica --}}
                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                        <div class="mr-4 text-center">
                            <div class="text-primary bg-light rounded-circle p-3 d-inline-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px;">
                                <i class="fas fa-paw fa-lg"></i>
                            </div>
                        </div>
                        <div>
                            <h5 class="font-weight-bold mb-1 text-gray-800">Paciente: {{ $mascota->nombre }}</h5>
                            <p class="text-muted mb-0">
                                <i class="far fa-calendar-alt mr-1"></i> 
                                Fecha de consulta: <strong>{{ $consulta->fecha_consulta->format('d/m/Y') }} a las {{ $consulta->fecha_consulta->format('H:i') }}</strong>
                            </p>
                        </div>
                    </div>

                    {{-- Formulario de Diagnóstico --}}
                    <form action="{{ route('admin.expedientes.consultas.diagnostico.store', [$mascota->id, $consulta->id]) }}" method="POST">
                        @csrf
                        {{-- Suponiendo que luego haya un endpoint PUT/PATCH, se colocaría @method('PUT') --}}
                        
                        <div class="form-group mb-4">
                            <label for="diagnostico" class="font-weight-bold text-gray-700">Detalle del Diagnóstico</label>
                            
                            {{-- Quill Editor Container --}}
                            <div id="editor-container">{!! old('diagnostico', $consulta->diagnostico ?: 'Aún sin diagnóstico') !!}</div>
                            
                            {{-- Hidden input to store Quill content on form submit --}}
                            <input type="hidden" name="diagnostico" id="diagnostico" value="{{ old('diagnostico', $consulta->diagnostico ?: 'Aún sin diagnóstico') }}">
                            @error('diagnostico')
                                <small class="text-danger mt-1 d-block">{{ $message }}</small>
                            @enderror
                            <small class="form-text text-muted mt-2">
                                Describe de manera detallada el estado clínico, síntomas evaluados y conclusiones del examen físico.
                            </small>
                        </div>

                        <div class="text-right mt-3">
                            <a href="{{ route('admin.expedientes.consultas.show', [$mascota->id, $consulta->id]) }}" class="btn btn-secondary shadow-sm mr-2">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary shadow-sm btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-save"></i>
                                </span>
                                <span class="text">Guardar Diagnóstico</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- Quill JS CDN --}}
    <script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var quill = new Quill('#editor-container', {
                theme: 'snow',
                placeholder: 'Escribe aquí el diagnóstico...',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['link', 'blockquote'],
                        ['clean']
                    ]
                }
            });

            var diagnosticoInput = document.querySelector('#diagnostico');
            
            // Set initial value just in case
            diagnosticoInput.value = quill.root.innerHTML;

            // Sincronizar el contenido de Quill con el input oculto en cada cambio
            quill.on('text-change', function() {
                diagnosticoInput.value = quill.root.innerHTML;
            });
            
            // También asegurar al enviar
            var form = document.querySelector('form');
            form.addEventListener('submit', function() {
                diagnosticoInput.value = quill.root.innerHTML;
            });
        });
    </script>
@endpush
