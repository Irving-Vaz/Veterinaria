@extends('layouts.main')

@section('titulo_pagina', 'Alimentación - ' . $mascota->nombre)

@section('page_heading', 'Historial de Alimentación')

@push('styles')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endpush

@section('custom_sidebar')
    @include('modules.admin.expedientes.partials.consulta_sidebar')
@endsection

@section('contenido')
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4 border-left-info">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="fas fa-bone mr-2"></i> Perfil Nutricional y Dietas
                    </h6>
                </div>
                <div class="card-body">
                    {{-- Información Básica --}}
                    <div class="d-flex align-items-center mb-4 pb-3 border-bottom">
                        <div class="mr-4 text-center">
                            <div class="text-info bg-light rounded-circle p-3 d-inline-flex align-items-center justify-content-center mb-2" style="width: 60px; height: 60px;">
                                <i class="fas fa-paw fa-lg"></i>
                            </div>
                        </div>
                        <div>
                            <h5 class="font-weight-bold mb-1 text-gray-800">Paciente: {{ $mascota->nombre }}</h5>
                            <p class="text-muted mb-0">
                                Gestione el historial de dietas terapéuticas y alimentación del paciente.
                            </p>
                        </div>
                    </div>

                    {{-- Formulario de Alimentación --}}
                    <form action="{{ route('admin.expedientes.consultas.alimentacion.store', [$mascota->id, $consulta->id]) }}" method="POST" id="formAlimentacion">
                        @csrf
                        
                        <div id="dietas-container">
                            @php
                                $dietas = old('dietas', is_array($mascota->alimentacion) ? $mascota->alimentacion : []);
                                if (empty($dietas)) {
                                    // Añadir un elemento vacío por defecto
                                    $dietas = [['dieta_especial' => false, 'motivo_dieta' => '', 'dieta_terapeutica' => '', 'fecha_inicio' => date('Y-m-d'), 'fecha_fin' => '', 'permanente' => false, 'veterinario_responsable' => $consulta->veterinario ? $consulta->veterinario->nombre_completo : '', 'restricciones' => '', 'observaciones_nutricionales' => '']];
                                }
                            @endphp

                            @foreach($dietas as $index => $dieta)
                                <div class="dieta-item border rounded p-4 mb-4 bg-light position-relative">
                                    <button type="button" class="close text-danger position-absolute btn-remove-dieta" style="top: 15px; right: 15px;" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    
                                    <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                                        <h6 class="font-weight-bold text-gray-700 m-0">
                                            <i class="fas fa-utensils text-info mr-1"></i> Dieta Registrada #<span class="dieta-number">{{ $index + 1 }}</span>
                                        </h6>
                                        @if(isset($dieta['permanente']) && $dieta['permanente'])
                                            <span class="badge badge-success px-2 py-1"><i class="fas fa-check-circle mr-1"></i> Permanente</span>
                                        @elseif(!empty($dieta['fecha_fin']) && $dieta['fecha_fin'] >= date('Y-m-d'))
                                            <span class="badge badge-primary px-2 py-1">Activa hasta {{ date('d/m/Y', strtotime($dieta['fecha_fin'])) }}</span>
                                        @elseif(!empty($dieta['fecha_fin']) && $dieta['fecha_fin'] < date('Y-m-d'))
                                            <span class="badge badge-secondary px-2 py-1">Finalizada</span>
                                        @endif
                                    </div>

                                    <div class="row">
                                        <div class="col-md-3 form-group mb-3 d-flex align-items-center">
                                            <div class="custom-control custom-switch mt-4">
                                                <input type="checkbox" class="custom-control-input" id="dieta_especial_{{ $index }}" name="dietas[{{ $index }}][dieta_especial]" value="1" {{ (isset($dieta['dieta_especial']) && $dieta['dieta_especial']) ? 'checked' : '' }}>
                                                <label class="custom-control-label font-weight-bold text-info" for="dieta_especial_{{ $index }}">Dieta Especial</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-group mb-3">
                                            <label class="font-weight-bold text-gray-700">Motivo de la Dieta <span class="text-danger">*</span></label>
                                            <select class="form-control" name="dietas[{{ $index }}][motivo_dieta]" required>
                                                <option value="">Seleccionar...</option>
                                                <option value="Edad" {{ ($dieta['motivo_dieta'] ?? '') == 'Edad' ? 'selected' : '' }}>Edad</option>
                                                <option value="Obesidad" {{ ($dieta['motivo_dieta'] ?? '') == 'Obesidad' ? 'selected' : '' }}>Obesidad</option>
                                                <option value="Diabetes" {{ ($dieta['motivo_dieta'] ?? '') == 'Diabetes' ? 'selected' : '' }}>Diabetes</option>
                                                <option value="Problema renal" {{ ($dieta['motivo_dieta'] ?? '') == 'Problema renal' ? 'selected' : '' }}>Problema renal</option>
                                                <option value="Hepático" {{ ($dieta['motivo_dieta'] ?? '') == 'Hepático' ? 'selected' : '' }}>Hepático</option>
                                                <option value="Gastrointestinal" {{ ($dieta['motivo_dieta'] ?? '') == 'Gastrointestinal' ? 'selected' : '' }}>Gastrointestinal</option>
                                                <option value="Alergia" {{ ($dieta['motivo_dieta'] ?? '') == 'Alergia' ? 'selected' : '' }}>Alergia</option>
                                                <option value="Recuperación postoperatoria" {{ ($dieta['motivo_dieta'] ?? '') == 'Recuperación postoperatoria' ? 'selected' : '' }}>Recuperación postoperatoria</option>
                                                <option value="Embarazo/lactancia" {{ ($dieta['motivo_dieta'] ?? '') == 'Embarazo/lactancia' ? 'selected' : '' }}>Embarazo / lactancia</option>
                                                <option value="Tratamiento médico" {{ ($dieta['motivo_dieta'] ?? '') == 'Tratamiento médico' ? 'selected' : '' }}>Tratamiento médico general</option>
                                            </select>
                                        </div>
                                        <div class="col-md-5 form-group mb-3">
                                            <label class="font-weight-bold text-gray-700">Dieta Terapéutica (Detalle) <span class="text-danger">*</span></label>
                                            <input type="hidden" name="dietas[{{ $index }}][dieta_terapeutica]" id="dieta_terapeutica_{{ $index }}" value="{{ $dieta['dieta_terapeutica'] ?? '' }}">
                                            <div class="quill-editor bg-white" data-target="dieta_terapeutica_{{ $index }}" style="height: 120px;">{!! $dieta['dieta_terapeutica'] ?? '' !!}</div>
                                        </div>
                                    </div>

                                    <div class="row align-items-center border-bottom pb-3 mb-3">
                                        <div class="col-md-3 form-group mb-0">
                                            <label class="font-weight-bold text-gray-700">Fecha de Inicio <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" name="dietas[{{ $index }}][fecha_inicio]" value="{{ $dieta['fecha_inicio'] ?? '' }}" required>
                                        </div>
                                        <div class="col-md-3 form-group mb-0">
                                            <label class="font-weight-bold text-gray-700">Fecha Fin</label>
                                            <input type="date" class="form-control fecha-fin-input" name="dietas[{{ $index }}][fecha_fin]" value="{{ $dieta['fecha_fin'] ?? '' }}" {{ (isset($dieta['permanente']) && $dieta['permanente']) ? 'disabled' : '' }}>
                                        </div>
                                        <div class="col-md-2 form-group mb-0">
                                            <div class="custom-control custom-checkbox mt-4">
                                                <input type="checkbox" class="custom-control-input permanente-checkbox" id="permanente_{{ $index }}" name="dietas[{{ $index }}][permanente]" value="1" {{ (isset($dieta['permanente']) && $dieta['permanente']) ? 'checked' : '' }}>
                                                <label class="custom-control-label font-weight-bold text-success" for="permanente_{{ $index }}">Permanente</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-group mb-0">
                                            <label class="font-weight-bold text-gray-700">Vet. Responsable <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="dietas[{{ $index }}][veterinario_responsable]" value="{{ $dieta['veterinario_responsable'] ?? '' }}" required placeholder="Nombre del Veterinario">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 form-group mb-0">
                                            <label class="font-weight-bold text-gray-700">Restricciones</label>
                                            <textarea class="form-control" name="dietas[{{ $index }}][restricciones]" rows="2" placeholder="Ej. Prohibido lácteos, no dar premios grasosos...">{{ $dieta['restricciones'] ?? '' }}</textarea>
                                        </div>
                                        <div class="col-md-6 form-group mb-0">
                                            <label class="font-weight-bold text-gray-700">Observaciones Nutricionales</label>
                                            <textarea class="form-control" name="dietas[{{ $index }}][observaciones_nutricionales]" rows="2" placeholder="Ej. Dividir la ración en 3 tomas diarias...">{{ $dieta['observaciones_nutricionales'] ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    
                                    @if(isset($dieta['consulta_id']))
                                        <div class="text-right mt-2">
                                            <small class="text-muted"><i class="fas fa-link"></i> Registrado en Consulta #{{ $dieta['consulta_id'] }}</small>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        <div class="text-center mb-4">
                            <button type="button" class="btn btn-outline-info btn-sm" id="btnAddDieta">
                                <i class="fas fa-plus mr-1"></i> Añadir otra dieta / Actualizar dieta
                            </button>
                        </div>

                        <div class="text-right border-top pt-4">
                            <a href="{{ route('admin.expedientes.consultas.show', [$mascota->id, $consulta->id]) }}" class="btn btn-secondary shadow-sm mr-2">
                                Cancelar
                            </a>
                            <button type="submit" class="btn btn-info shadow-sm btn-icon-split text-white">
                                <span class="icon text-white-50">
                                    <i class="fas fa-save"></i>
                                </span>
                                <span class="text">Guardar Historial de Alimentación</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let container = document.getElementById('dietas-container');
    let btnAdd = document.getElementById('btnAddDieta');
    
    // Función para manejar el checkbox permanente
    function handlePermanenteToggle(checkbox) {
        let container = checkbox.closest('.row');
        let fechaFinInput = container.querySelector('.fecha-fin-input');
        if (checkbox.checked) {
            fechaFinInput.value = '';
            fechaFinInput.disabled = true;
        } else {
            fechaFinInput.disabled = false;
        }
    }

    // Inicializar listeners existentes
    container.querySelectorAll('.permanente-checkbox').forEach(cb => {
        cb.addEventListener('change', function() {
            handlePermanenteToggle(this);
        });
    });

    function initQuill(element) {
        new Quill(element, {
            theme: 'snow',
            placeholder: 'Explique a detalle la dieta terapéutica...',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }]
                ]
            }
        });
    }

    // Inicializar Quill para los elementos existentes
    container.querySelectorAll('.quill-editor').forEach(el => initQuill(el));

    // Sincronizar Quill antes de enviar el formulario
    document.getElementById('formAlimentacion').addEventListener('submit', function() {
        document.querySelectorAll('.quill-editor').forEach(el => {
            let targetId = el.getAttribute('data-target');
            let target = document.getElementById(targetId);
            let qlEditor = el.querySelector('.ql-editor');
            if (target && qlEditor) {
                // Remove empty p tags if empty
                target.value = qlEditor.innerHTML === '<p><br></p>' ? '' : qlEditor.innerHTML;
            }
        });
    });

    btnAdd.addEventListener('click', function() {
        let items = container.querySelectorAll('.dieta-item');
        let index = items.length; 
        
        let currentDate = new Date().toISOString().split('T')[0];
        let defaultVet = "{{ $consulta->veterinario ? $consulta->veterinario->nombre_completo : '' }}";
        
        let newHtml = `
            <div class="dieta-item border rounded p-4 mb-4 bg-light position-relative">
                <button type="button" class="close text-danger position-absolute btn-remove-dieta" style="top: 15px; right: 15px;" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2">
                    <h6 class="font-weight-bold text-gray-700 m-0">
                        <i class="fas fa-utensils text-info mr-1"></i> Dieta Registrada #<span class="dieta-number">${index + 1}</span>
                    </h6>
                    <span class="badge badge-warning px-2 py-1">Nueva</span>
                </div>
                <div class="row">
                    <div class="col-md-3 form-group mb-3 d-flex align-items-center">
                        <div class="custom-control custom-switch mt-4">
                            <input type="checkbox" class="custom-control-input" id="dieta_especial_${index}" name="dietas[${index}][dieta_especial]" value="1">
                            <label class="custom-control-label font-weight-bold text-info" for="dieta_especial_${index}">Dieta Especial</label>
                        </div>
                    </div>
                    <div class="col-md-4 form-group mb-3">
                        <label class="font-weight-bold text-gray-700">Motivo de la Dieta <span class="text-danger">*</span></label>
                        <select class="form-control" name="dietas[${index}][motivo_dieta]" required>
                            <option value="">Seleccionar...</option>
                            <option value="Edad">Edad</option>
                            <option value="Obesidad">Obesidad</option>
                            <option value="Diabetes">Diabetes</option>
                            <option value="Problema renal">Problema renal</option>
                            <option value="Hepático">Hepático</option>
                            <option value="Gastrointestinal">Gastrointestinal</option>
                            <option value="Alergia">Alergia</option>
                            <option value="Recuperación postoperatoria">Recuperación postoperatoria</option>
                            <option value="Embarazo/lactancia">Embarazo / lactancia</option>
                            <option value="Tratamiento médico">Tratamiento médico general</option>
                        </select>
                    </div>
                    <div class="col-md-5 form-group mb-3">
                        <label class="font-weight-bold text-gray-700">Dieta Terapéutica (Detalle) <span class="text-danger">*</span></label>
                        <input type="hidden" name="dietas[${index}][dieta_terapeutica]" id="dieta_terapeutica_${index}">
                        <div class="quill-editor bg-white" data-target="dieta_terapeutica_${index}" style="height: 120px;"></div>
                    </div>
                </div>
                <div class="row align-items-center border-bottom pb-3 mb-3">
                    <div class="col-md-3 form-group mb-0">
                        <label class="font-weight-bold text-gray-700">Fecha de Inicio <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="dietas[${index}][fecha_inicio]" value="${currentDate}" required>
                    </div>
                    <div class="col-md-3 form-group mb-0">
                        <label class="font-weight-bold text-gray-700">Fecha Fin</label>
                        <input type="date" class="form-control fecha-fin-input" name="dietas[${index}][fecha_fin]">
                    </div>
                    <div class="col-md-2 form-group mb-0">
                        <div class="custom-control custom-checkbox mt-4">
                            <input type="checkbox" class="custom-control-input permanente-checkbox" id="permanente_${index}" name="dietas[${index}][permanente]" value="1">
                            <label class="custom-control-label font-weight-bold text-success" for="permanente_${index}">Permanente</label>
                        </div>
                    </div>
                    <div class="col-md-4 form-group mb-0">
                        <label class="font-weight-bold text-gray-700">Vet. Responsable <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="dietas[${index}][veterinario_responsable]" value="${defaultVet}" required placeholder="Nombre del Veterinario">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 form-group mb-0">
                        <label class="font-weight-bold text-gray-700">Restricciones</label>
                        <textarea class="form-control" name="dietas[${index}][restricciones]" rows="2" placeholder="Ej. Prohibido lácteos, no dar premios grasosos..."></textarea>
                    </div>
                    <div class="col-md-6 form-group mb-0">
                        <label class="font-weight-bold text-gray-700">Observaciones Nutricionales</label>
                        <textarea class="form-control" name="dietas[${index}][observaciones_nutricionales]" rows="2" placeholder="Ej. Dividir la ración en 3 tomas diarias..."></textarea>
                    </div>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', newHtml);
        
        let newItems = container.querySelectorAll('.dieta-item');
        let newestItem = newItems[newItems.length - 1];
        let newCheckbox = newestItem.querySelector('.permanente-checkbox');
        newCheckbox.addEventListener('change', function() {
            handlePermanenteToggle(this);
        });

        // Init Quill for the new element
        let newQuillEl = newestItem.querySelector('.quill-editor');
        if (newQuillEl) {
            initQuill(newQuillEl);
        }

        updateDietaNumbers();
    });

    container.addEventListener('click', function(e) {
        if (e.target.closest('.btn-remove-dieta')) {
            if (container.querySelectorAll('.dieta-item').length > 1) {
                e.target.closest('.dieta-item').remove();
                updateDietaNumbers();
            } else {
                alert('Debe existir al menos un registro de dieta (puede dejarlo vacío si no aplica).');
            }
        }
    });

    function updateDietaNumbers() {
        let items = container.querySelectorAll('.dieta-item');
        items.forEach((item, index) => {
            item.querySelector('.dieta-number').textContent = index + 1;
            
            let inputs = item.querySelectorAll('input[name^="dietas"], select[name^="dietas"], textarea[name^="dietas"]');
            inputs.forEach(input => {
                let name = input.getAttribute('name');
                if (name) {
                    input.setAttribute('name', name.replace(/\[\d+\]/, `[${index}]`));
                }
            });

            let checkboxEspecial = item.querySelector('input[id^="dieta_especial_"]');
            let labelEspecial = item.querySelector('label[for^="dieta_especial_"]');
            if (checkboxEspecial && labelEspecial) {
                checkboxEspecial.id = `dieta_especial_${index}`;
                labelEspecial.setAttribute('for', `dieta_especial_${index}`);
            }

            let checkboxPerm = item.querySelector('input[id^="permanente_"]');
            let labelPerm = item.querySelector('label[for^="permanente_"]');
            if (checkboxPerm && labelPerm) {
                checkboxPerm.id = `permanente_${index}`;
                labelPerm.setAttribute('for', `permanente_${index}`);
            }

            let hiddenQuill = item.querySelector('input[id^="dieta_terapeutica_"]');
            let divQuill = item.querySelector('.quill-editor');
            if (hiddenQuill && divQuill) {
                hiddenQuill.id = `dieta_terapeutica_${index}`;
                divQuill.setAttribute('data-target', `dieta_terapeutica_${index}`);
            }
        });
    }
});
</script>
@endpush
