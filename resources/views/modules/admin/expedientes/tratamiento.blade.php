@extends('layouts.main')

@section('titulo_pagina', 'Tratamiento - ' . $mascota->nombre)

@section('page_heading', 'Tratamiento de la Consulta')

@section('custom_sidebar')
    @include('modules.admin.expedientes.partials.consulta_sidebar')
@endsection

@section('contenido')
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4 border-left-success">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="fas fa-pills mr-2"></i> Registro de Tratamiento
                    </h6>
                </div>
                <div class="card-body">
                    {{-- Información Básica --}}
                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                        <div class="mr-4 text-center">
                            <div class="text-success bg-light rounded-circle p-3 d-inline-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px;">
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

                    {{-- Mostrar Diagnóstico Vinculado --}}
                    <div class="mb-4">
                        <h6 class="font-weight-bold text-gray-700 border-bottom pb-2 mb-3">
                            <i class="fas fa-stethoscope text-warning mr-1"></i> Diagnóstico Identificado
                        </h6>
                        <div class="p-3 bg-light border-left-warning rounded">
                            {!! $consulta->diagnostico ?: '<span class="text-muted font-italic">Sin diagnóstico registrado aún.</span>' !!}
                        </div>
                    </div>

                    {{-- Formulario de Tratamiento --}}
                    <form action="{{ route('admin.expedientes.consultas.tratamiento.store', [$mascota->id, $consulta->id]) }}" method="POST" id="formTratamiento">
                        @csrf
                        
                        <div id="medicamentos-container">
                            @php
                                $tratamientos = old('medicamentos', is_array($consulta->tratamiento) ? $consulta->tratamiento : []);
                                if (empty($tratamientos)) {
                                    // Añadir un elemento vacío por defecto
                                    $tratamientos = [['nombre' => '', 'dosis' => '', 'via' => 'Vía Oral', 'frecuencia' => '', 'duracion' => '']];
                                }
                            @endphp

                            @foreach($tratamientos as $index => $med)
                                <div class="medicamento-item border rounded p-3 mb-3 bg-light position-relative">
                                    @if($index > 0)
                                        <button type="button" class="close text-danger position-absolute btn-remove-med" style="top: 10px; right: 15px;" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    @endif
                                    
                                    <h6 class="font-weight-bold text-gray-700 mb-3 border-bottom pb-2">Medicamento #<span class="med-number">{{ $index + 1 }}</span></h6>
                                    
                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="font-weight-bold text-gray-700">Nombre del Medicamento <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="medicamentos[{{ $index }}][nombre]" value="{{ $med['nombre'] ?? '' }}" required placeholder="Ej. Meloxicam">
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="font-weight-bold text-gray-700">Dosis <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="medicamentos[{{ $index }}][dosis]" value="{{ $med['dosis'] ?? '' }}" required placeholder="Ej. 0.5 ml">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 form-group mb-3">
                                            <label class="font-weight-bold text-gray-700">Vía de Adm. <span class="text-danger">*</span></label>
                                            <select class="form-control" name="medicamentos[{{ $index }}][via]" required>
                                                <option value="Vía Oral" {{ ($med['via'] ?? '') == 'Vía Oral' ? 'selected' : '' }}>Vía Oral</option>
                                                <option value="Intramuscular" {{ ($med['via'] ?? '') == 'Intramuscular' ? 'selected' : '' }}>Intramuscular</option>
                                                <option value="Intravenosa" {{ ($med['via'] ?? '') == 'Intravenosa' ? 'selected' : '' }}>Intravenosa</option>
                                                <option value="Subcutánea" {{ ($med['via'] ?? '') == 'Subcutánea' ? 'selected' : '' }}>Subcutánea</option>
                                                <option value="Tópica" {{ ($med['via'] ?? '') == 'Tópica' ? 'selected' : '' }}>Tópica</option>
                                                <option value="Oftálmica" {{ ($med['via'] ?? '') == 'Oftálmica' ? 'selected' : '' }}>Oftálmica</option>
                                                <option value="Ótica" {{ ($med['via'] ?? '') == 'Ótica' ? 'selected' : '' }}>Ótica</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-group mb-3">
                                            <label class="font-weight-bold text-gray-700">Frecuencia <span class="text-danger">*</span></label>
                                            <select class="form-control" name="medicamentos[{{ $index }}][frecuencia]" required>
                                                <option value="">Seleccionar...</option>
                                                <option value="8" {{ ($med['frecuencia'] ?? '') == '8' ? 'selected' : '' }}>Cada 8 horas</option>
                                                <option value="12" {{ ($med['frecuencia'] ?? '') == '12' ? 'selected' : '' }}>Cada 12 horas</option>
                                                <option value="24" {{ ($med['frecuencia'] ?? '') == '24' ? 'selected' : '' }}>Cada 24 horas (1 al día)</option>
                                                <option value="0" {{ ($med['frecuencia'] ?? '') == '0' ? 'selected' : '' }}>Una única dosis</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4 form-group mb-3">
                                            <label class="font-weight-bold text-gray-700">Duración (Días) <span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" name="medicamentos[{{ $index }}][duracion]" value="{{ $med['duracion'] ?? '' }}" min="1" required placeholder="Ej. 5">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="text-center mb-4">
                            <button type="button" class="btn btn-outline-primary btn-sm" id="btnAddMed">
                                <i class="fas fa-plus mr-1"></i> Añadir otro medicamento
                            </button>
                        </div>

                        <div class="text-right border-top pt-3">
                            <a href="{{ route('admin.expedientes.consultas.show', [$mascota->id, $consulta->id]) }}" class="btn btn-secondary shadow-sm mr-2">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-success shadow-sm btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-save"></i>
                                </span>
                                <span class="text">Guardar Tratamiento</span>
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
    let container = document.getElementById('medicamentos-container');
    let btnAdd = document.getElementById('btnAddMed');
    
    btnAdd.addEventListener('click', function() {
        let items = container.querySelectorAll('.medicamento-item');
        let index = items.length;
        
        let newHtml = `
            <div class="medicamento-item border rounded p-3 mb-3 bg-light position-relative">
                <button type="button" class="close text-danger position-absolute btn-remove-med" style="top: 10px; right: 15px;" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h6 class="font-weight-bold text-gray-700 mb-3 border-bottom pb-2">Medicamento #<span class="med-number">${index + 1}</span></h6>
                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label class="font-weight-bold text-gray-700">Nombre del Medicamento <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="medicamentos[${index}][nombre]" required placeholder="Ej. Meloxicam">
                    </div>
                    <div class="col-md-6 form-group mb-3">
                        <label class="font-weight-bold text-gray-700">Dosis <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="medicamentos[${index}][dosis]" required placeholder="Ej. 0.5 ml">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 form-group mb-3">
                        <label class="font-weight-bold text-gray-700">Vía de Adm. <span class="text-danger">*</span></label>
                        <select class="form-control" name="medicamentos[${index}][via]" required>
                            <option value="Vía Oral" selected>Vía Oral</option>
                            <option value="Intramuscular">Intramuscular</option>
                            <option value="Intravenosa">Intravenosa</option>
                            <option value="Subcutánea">Subcutánea</option>
                            <option value="Tópica">Tópica</option>
                            <option value="Oftálmica">Oftálmica</option>
                            <option value="Ótica">Ótica</option>
                        </select>
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label class="font-weight-bold text-gray-700">Frecuencia <span class="text-danger">*</span></label>
                        <select class="form-control" name="medicamentos[${index}][frecuencia]" required>
                            <option value="">Seleccionar...</option>
                            <option value="8">Cada 8 horas</option>
                            <option value="12">Cada 12 horas</option>
                            <option value="24">Cada 24 horas (1 al día)</option>
                            <option value="0">Una única dosis</option>
                        </select>
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label class="font-weight-bold text-gray-700">Duración (Días) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="medicamentos[${index}][duracion]" min="1" required placeholder="Ej. 5">
                    </div>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', newHtml);
        updateMedNumbers();
    });

    container.addEventListener('click', function(e) {
        if (e.target.closest('.btn-remove-med')) {
            e.target.closest('.medicamento-item').remove();
            updateMedNumbers();
        }
    });

    function updateMedNumbers() {
        let items = container.querySelectorAll('.medicamento-item');
        items.forEach((item, index) => {
            item.querySelector('.med-number').textContent = index + 1;
            // Update name attributes to ensure array indices are sequential (optional but good practice)
            let inputs = item.querySelectorAll('input, select');
            inputs.forEach(input => {
                let name = input.getAttribute('name');
                if (name) {
                    input.setAttribute('name', name.replace(/\[\d+\]/, `[${index}]`));
                }
            });
        });
    }
});
</script>
@endpush
