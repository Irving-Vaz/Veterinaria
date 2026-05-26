@extends('layouts.main')

@section('titulo_pagina', 'Lesiones Previas - ' . $mascota->nombre)

@section('page_heading', 'Historial de Lesiones')

@section('custom_sidebar')
    @include('modules.admin.expedientes.partials.consulta_sidebar')
@endsection

@section('contenido')
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4 border-left-warning">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-warning">
                        <i class="fas fa-band-aid mr-2"></i> Registro de Lesiones del Paciente
                    </h6>
                </div>
                <div class="card-body">
                    {{-- Información Básica --}}
                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                        <div class="mr-4 text-center">
                            <div class="text-warning bg-light rounded-circle p-3 d-inline-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px;">
                                <i class="fas fa-paw fa-lg"></i>
                            </div>
                        </div>
                        <div>
                            <h5 class="font-weight-bold mb-1 text-gray-800">Paciente: {{ $mascota->nombre }}</h5>
                            <p class="text-muted mb-0">
                                Gestione el historial de lesiones de la mascota. Las lesiones registradas se conservan de forma permanente.
                            </p>
                        </div>
                    </div>

                    {{-- Formulario de Lesiones --}}
                    <form action="{{ route('admin.expedientes.consultas.lesiones.store', [$mascota->id, $consulta->id]) }}" method="POST" id="formLesiones">
                        @csrf
                        
                        <div id="lesiones-container">
                            @php
                                $lesiones = old('lesiones', is_array($mascota->lesiones) ? $mascota->lesiones : []);
                                if (empty($lesiones)) {
                                    // Añadir un elemento vacío por defecto
                                    $lesiones = [['lugar' => '', 'procedimiento' => '', 'fecha' => '', 'consulta_id' => null]];
                                }
                            @endphp

                            @foreach($lesiones as $index => $lesion)
                                <div class="lesion-item border rounded p-4 mb-4 bg-light position-relative">
                                    <button type="button" class="close text-danger position-absolute btn-remove-lesion" style="top: 15px; right: 15px;" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    
                                    <h6 class="font-weight-bold text-gray-700 mb-3 border-bottom pb-2">
                                        <i class="fas fa-file-medical text-warning mr-1"></i> Lesión #<span class="lesion-number">{{ $index + 1 }}</span>
                                    </h6>
                                    
                                    {{-- Hidden input para mantener el consulta_id si ya existía --}}
                                    @if(isset($lesion['consulta_id']) && $lesion['consulta_id'])
                                        <input type="hidden" name="lesiones[{{ $index }}][consulta_id]" value="{{ $lesion['consulta_id'] }}">
                                    @endif

                                    <div class="row">
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="font-weight-bold text-gray-700">Lugar de la Lesión <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="lesiones[{{ $index }}][lugar]" value="{{ $lesion['lugar'] ?? '' }}" required placeholder="Ej. Pata trasera derecha">
                                        </div>
                                        <div class="col-md-6 form-group mb-3">
                                            <label class="font-weight-bold text-gray-700">Procedimiento <span class="text-danger">*</span></label>
                                            <select class="form-control" name="lesiones[{{ $index }}][procedimiento]" required>
                                                <option value="">Seleccionar...</option>
                                                <option value="Observación" {{ ($lesion['procedimiento'] ?? '') == 'Observación' ? 'selected' : '' }}>Observación</option>
                                                <option value="Limpieza / Curación" {{ ($lesion['procedimiento'] ?? '') == 'Limpieza / Curación' ? 'selected' : '' }}>Limpieza / Curación</option>
                                                <option value="Vendaje" {{ ($lesion['procedimiento'] ?? '') == 'Vendaje' ? 'selected' : '' }}>Vendaje</option>
                                                <option value="Inmovilización con Yeso" {{ ($lesion['procedimiento'] ?? '') == 'Inmovilización con Yeso' ? 'selected' : '' }}>Inmovilización con Yeso</option>
                                                <option value="Puntadas / Sutura" {{ ($lesion['procedimiento'] ?? '') == 'Puntadas / Sutura' ? 'selected' : '' }}>Puntadas / Sutura</option>
                                                <option value="Cirugía" {{ ($lesion['procedimiento'] ?? '') == 'Cirugía' ? 'selected' : '' }}>Cirugía Mayor/Menor</option>
                                                <option value="Otro" {{ ($lesion['procedimiento'] ?? '') == 'Otro' ? 'selected' : '' }}>Otro Procedimiento</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row align-items-center">
                                        <div class="col-md-6 form-group mb-0">
                                            <label class="font-weight-bold text-gray-700">Fecha del Suceso <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="lesiones[{{ $index }}][fecha]" value="{{ $lesion['fecha'] ?? '' }}" required>
                                        </div>
                                        <div class="col-md-6 form-group mb-0">
                                            <label class="font-weight-bold text-gray-700 d-block">Vinculación</label>
                                            @if(isset($lesion['consulta_id']) && $lesion['consulta_id'] && $lesion['consulta_id'] != $consulta->id)
                                                {{-- Esta lesión está vinculada a otra consulta pasada --}}
                                                <a href="{{ route('admin.expedientes.consultas.show', [$mascota->id, $lesion['consulta_id']]) }}" class="btn btn-sm btn-info shadow-sm" target="_blank">
                                                    <i class="fas fa-external-link-alt mr-1"></i> Ver consulta pasada #{{ $lesion['consulta_id'] }}
                                                </a>
                                            @else
                                                {{-- Checkbox para vincular a la consulta actual --}}
                                                <div class="custom-control custom-checkbox mt-2">
                                                    <input type="checkbox" class="custom-control-input" id="vincular_{{ $index }}" name="lesiones[{{ $index }}][vincular_consulta]" value="1" {{ (isset($lesion['consulta_id']) && $lesion['consulta_id'] == $consulta->id) ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="vincular_{{ $index }}">Vincular a la consulta actual</label>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="text-center mb-4">
                            <button type="button" class="btn btn-outline-warning btn-sm" id="btnAddLesion">
                                <i class="fas fa-plus mr-1"></i> Añadir otra lesión
                            </button>
                        </div>

                        <div class="text-right border-top pt-4">
                            <a href="{{ route('admin.expedientes.consultas.show', [$mascota->id, $consulta->id]) }}" class="btn btn-secondary shadow-sm mr-2">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-warning shadow-sm btn-icon-split text-dark">
                                <span class="icon text-dark-50">
                                    <i class="fas fa-save"></i>
                                </span>
                                <span class="text">Guardar Lesiones</span>
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
    let container = document.getElementById('lesiones-container');
    let btnAdd = document.getElementById('btnAddLesion');
    
    btnAdd.addEventListener('click', function() {
        let items = container.querySelectorAll('.lesion-item');
        let index = items.length; // index goes 0, 1, 2...
        
        let newHtml = `
            <div class="lesion-item border rounded p-4 mb-4 bg-light position-relative">
                <button type="button" class="close text-danger position-absolute btn-remove-lesion" style="top: 15px; right: 15px;" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h6 class="font-weight-bold text-gray-700 mb-3 border-bottom pb-2">
                    <i class="fas fa-file-medical text-warning mr-1"></i> Lesión #<span class="lesion-number">${index + 1}</span>
                </h6>
                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label class="font-weight-bold text-gray-700">Lugar de la Lesión <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="lesiones[${index}][lugar]" required placeholder="Ej. Pata trasera derecha">
                    </div>
                    <div class="col-md-6 form-group mb-3">
                        <label class="font-weight-bold text-gray-700">Procedimiento <span class="text-danger">*</span></label>
                        <select class="form-control" name="lesiones[${index}][procedimiento]" required>
                            <option value="">Seleccionar...</option>
                            <option value="Observación">Observación</option>
                            <option value="Limpieza / Curación">Limpieza / Curación</option>
                            <option value="Vendaje">Vendaje</option>
                            <option value="Inmovilización con Yeso">Inmovilización con Yeso</option>
                            <option value="Puntadas / Sutura">Puntadas / Sutura</option>
                            <option value="Cirugía">Cirugía Mayor/Menor</option>
                            <option value="Otro">Otro Procedimiento</option>
                        </select>
                    </div>
                </div>
                <div class="row align-items-center">
                    <div class="col-md-6 form-group mb-0">
                        <label class="font-weight-bold text-gray-700">Fecha del Suceso <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="lesiones[${index}][fecha]" required>
                    </div>
                    <div class="col-md-6 form-group mb-0">
                        <label class="font-weight-bold text-gray-700 d-block">Vinculación</label>
                        <div class="custom-control custom-checkbox mt-2">
                            <input type="checkbox" class="custom-control-input" id="vincular_${index}" name="lesiones[${index}][vincular_consulta]" value="1" checked>
                            <label class="custom-control-label" for="vincular_${index}">Vincular a la consulta actual</label>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', newHtml);
        updateLesionNumbers();
    });

    container.addEventListener('click', function(e) {
        if (e.target.closest('.btn-remove-lesion')) {
            // No permitir borrar si solo queda uno
            if (container.querySelectorAll('.lesion-item').length > 1) {
                e.target.closest('.lesion-item').remove();
                updateLesionNumbers();
            } else {
                alert('Debe existir al menos un registro de lesión (puede dejarlo vacío si no hay lesiones).');
            }
        }
    });

    function updateLesionNumbers() {
        let items = container.querySelectorAll('.lesion-item');
        items.forEach((item, index) => {
            item.querySelector('.lesion-number').textContent = index + 1;
            
            // Actualizar names e IDs para evitar conflictos
            let inputs = item.querySelectorAll('input[name^="lesiones"], select[name^="lesiones"]');
            inputs.forEach(input => {
                let name = input.getAttribute('name');
                if (name) {
                    input.setAttribute('name', name.replace(/\[\d+\]/, `[${index}]`));
                }
            });

            // Actualizar checkbox ids for labels
            let checkbox = item.querySelector('input[type="checkbox"]');
            let label = item.querySelector('label.custom-control-label');
            if (checkbox && label) {
                checkbox.id = `vincular_${index}`;
                label.setAttribute('for', `vincular_${index}`);
            }
        });
    }
});
</script>
@endpush
