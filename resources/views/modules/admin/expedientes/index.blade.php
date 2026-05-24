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
                    <div class="position-relative mb-5 text-left">
                        <form action="#" method="GET" id="searchForm">
                            <div class="input-group input-group-lg shadow-sm">
                                <input type="text" id="searchInput" class="form-control border-0 bg-light" placeholder="Ej. Firulais, Juan Pérez..." autocomplete="off">
                            </div>
                        </form>
                        
                        {{-- Contenedor de Resultados --}}
                        <div id="searchResults" class="position-absolute w-100 shadow rounded bg-white mt-1 border" style="z-index: 1000; display: none; max-height: 350px; overflow-y: auto;">
                            <!-- Resultados inyectados por JS -->
                        </div>
                    </div>

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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');
        let timeout = null;

        searchInput.addEventListener('input', function (e) {
            clearTimeout(timeout);
            const query = e.target.value.trim();

            if (query.length < 2) {
                searchResults.style.display = 'none';
                return;
            }

            // Debounce de 300ms
            timeout = setTimeout(() => {
                fetch(`{{ route('admin.expedientes.search') }}?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        searchResults.innerHTML = '';
                        
                        if (data.length === 0) {
                            searchResults.innerHTML = '<div class="p-3 text-muted text-center"><i class="fas fa-search-minus fa-2x mb-2 text-gray-300"></i><br>No se encontraron resultados para "'+query+'".</div>';
                        } else {
                            const list = document.createElement('div');
                            list.className = 'list-group list-group-flush text-left';

                            data.forEach(mascota => {
                                const a = document.createElement('a');
                                a.href = '#'; // TODO: Cambiar por ruta show
                                a.className = 'list-group-item list-group-item-action d-flex align-items-center py-3';
                                a.innerHTML = `
                                    <div class="mr-3 text-primary bg-light rounded-circle p-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                        <i class="fas fa-paw fa-lg"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0 font-weight-bold text-gray-800">${mascota.nombre} <span class="badge badge-primary ml-1">Folio #${mascota.id}</span></h6>
                                        <small class="text-muted d-block mt-1"><i class="fas fa-user fa-sm text-gray-400 mr-1"></i> Dueño: ${mascota.dueno ? mascota.dueno.nombre_completo : 'Desconocido'}</small>
                                    </div>
                                    <div class="text-gray-400">
                                        <i class="fas fa-chevron-right"></i>
                                    </div>
                                `;
                                list.appendChild(a);
                            });

                            searchResults.appendChild(list);
                        }
                        
                        searchResults.style.display = 'block';
                    })
                    .catch(error => console.error('Error buscando expedientes:', error));
            }, 300);
        });

        // Ocultar resultados si se hace click fuera
        document.addEventListener('click', function (e) {
            if (!searchInput.contains(e.target) && !searchResults.contains(e.target)) {
                searchResults.style.display = 'none';
            }
        });
        
        // Mostrar resultados al volver a enfocar si ya hay búsqueda
        searchInput.addEventListener('focus', function () {
            if (searchInput.value.trim().length >= 2 && searchResults.innerHTML !== '') {
                searchResults.style.display = 'block';
            }
        });
    });
</script>
@endpush
