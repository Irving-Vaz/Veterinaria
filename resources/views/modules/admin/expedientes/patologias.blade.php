@extends('layouts.main')

@section('titulo_pagina', 'Patologías - ' . $mascota->nombre)

@section('page_heading', 'Antecedentes Patológicos')

@section('custom_sidebar')
    @include('modules.admin.expedientes.partials.consulta_sidebar')
@endsection

@section('contenido')
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4 border-left-danger">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-danger">
                        <i class="fas fa-virus mr-2"></i> Registro de Enfermedades y Patologías
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
                                Gestione el historial de enfermedades diagnosticadas al paciente.
                            </p>
                        </div>
                    </div>

                    {{-- Formulario de Patologías --}}
                    <form action="{{ route('admin.expedientes.consultas.patologias.store', [$mascota->id, $consulta->id]) }}" method="POST" id="formPatologias">
                        @csrf
                        
                        <div id="patologias-container">
                            @php
                                $patologias = old('patologias', is_array($mascota->patologias) ? $mascota->patologias : []);
                                if (empty($patologias)) {
                                    // Añadir un elemento vacío por defecto
                                    $patologias = [['enfermedad' => '', 'es_cronica' => false]];
                                }
                            @endphp

                            @foreach($patologias as $index => $patologia)
                                <div class="patologia-item border rounded p-4 mb-4 bg-light position-relative">
                                    <button type="button" class="close text-danger position-absolute btn-remove-patologia" style="top: 15px; right: 15px;" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                                        <h6 class="font-weight-bold text-gray-700 m-0">
                                            <i class="fas fa-microscope text-danger mr-1"></i> Patología #<span class="patologia-number">{{ $index + 1 }}</span>
                                        </h6>
                                        @if(isset($patologia['es_cronica']) && $patologia['es_cronica'])
                                            <span class="badge badge-danger px-2 py-1"><i class="fas fa-exclamation-triangle mr-1"></i> Crónica</span>
                                        @endif
                                    </div>

                                    <div class="row align-items-center">
                                        <div class="col-md-8 form-group mb-0">
                                            <label class="font-weight-bold text-gray-700">Enfermedad Diagnosticada <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="patologias[{{ $index }}][enfermedad]" value="{{ $patologia['enfermedad'] ?? '' }}" required placeholder="Ej. Insuficiencia Cardíaca, Parvovirus, Gastroenteritis...">
                                        </div>
                                        <div class="col-md-4 form-group mb-0 d-flex justify-content-center">
                                            <div class="custom-control custom-switch mt-4">
                                                <input type="checkbox" class="custom-control-input cronica-checkbox" id="es_cronica_{{ $index }}" name="patologias[{{ $index }}][es_cronica]" value="1" {{ (isset($patologia['es_cronica']) && $patologia['es_cronica']) ? 'checked' : '' }}>
                                                <label class="custom-control-label font-weight-bold text-danger" for="es_cronica_{{ $index }}">Enfermedad Crónica</label>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @if(isset($patologia['consulta_id']))
                                        <div class="text-right mt-3 pt-2 border-top">
                                            <small class="text-muted"><i class="fas fa-link"></i> Registrado en Consulta #{{ $patologia['consulta_id'] }}</small>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div class="text-center mb-4">
                            <button type="button" class="btn btn-outline-danger btn-sm" id="btnAddPatologia">
                                <i class="fas fa-plus mr-1"></i> Añadir otra patología
                            </button>
                        </div>

                        <div class="text-right border-top pt-4">
                            <a href="{{ route('admin.expedientes.consultas.show', [$mascota->id, $consulta->id]) }}" class="btn btn-secondary shadow-sm mr-2">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-danger shadow-sm btn-icon-split text-white">
                                <span class="icon text-white-50">
                                    <i class="fas fa-save"></i>
                                </span>
                                <span class="text">Guardar Antecedentes Patológicos</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let container = document.getElementById('patologias-container');
    let btnAdd = document.getElementById('btnAddPatologia');
    
    btnAdd.addEventListener('click', function() {
        let items = container.querySelectorAll('.patologia-item');
        let index = items.length; 
        
        let newHtml = `
            <div class="patologia-item border rounded p-4 mb-4 bg-light position-relative">
                <button type="button" class="close text-danger position-absolute btn-remove-patologia" style="top: 15px; right: 15px;" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                    <h6 class="font-weight-bold text-gray-700 m-0">
                        <i class="fas fa-microscope text-danger mr-1"></i> Patología #<span class="patologia-number">${index + 1}</span>
                    </h6>
                    <span class="badge badge-warning px-2 py-1">Nueva</span>
                </div>
                <div class="row align-items-center">
                    <div class="col-md-8 form-group mb-0">
                        <label class="font-weight-bold text-gray-700">Enfermedad Diagnosticada <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="patologias[${index}][enfermedad]" required placeholder="Ej. Insuficiencia Cardíaca, Parvovirus, Gastroenteritis...">
                    </div>
                    <div class="col-md-4 form-group mb-0 d-flex justify-content-center">
                        <div class="custom-control custom-switch mt-4">
                            <input type="checkbox" class="custom-control-input cronica-checkbox" id="es_cronica_${index}" name="patologias[${index}][es_cronica]" value="1">
                            <label class="custom-control-label font-weight-bold text-danger" for="es_cronica_${index}">Enfermedad Crónica</label>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', newHtml);
        updatePatologiaNumbers();
    });

    container.addEventListener('click', function(e) {
        if (e.target.closest('.btn-remove-patologia')) {
            if (container.querySelectorAll('.patologia-item').length > 1) {
                e.target.closest('.patologia-item').remove();
                updatePatologiaNumbers();
            } else {
                alert('Debe existir al menos un registro (puede dejarlo vacío si no hay patologías).');
            }
        }
    });

    function updatePatologiaNumbers() {
        let items = container.querySelectorAll('.patologia-item');
        items.forEach((item, index) => {
            item.querySelector('.patologia-number').textContent = index + 1;
            
            let inputEnfermedad = item.querySelector('input[name^="patologias"][name$="[enfermedad]"]');
            if (inputEnfermedad) {
                inputEnfermedad.setAttribute('name', `patologias[${index}][enfermedad]`);
            }

            let checkboxCronica = item.querySelector('input[name^="patologias"][name$="[es_cronica]"]');
            let labelCronica = item.querySelector('label[for^="es_cronica_"]');
            if (checkboxCronica && labelCronica) {
                checkboxCronica.setAttribute('name', `patologias[${index}][es_cronica]`);
                checkboxCronica.id = `es_cronica_${index}`;
                labelCronica.setAttribute('for', `es_cronica_${index}`);
            }
        });
    }
});
</script>
@endpush
