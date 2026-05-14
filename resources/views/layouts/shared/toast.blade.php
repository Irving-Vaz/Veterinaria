{{-- ============================================================
     TOAST NOTIFICATIONS — Componente compartido
     Archivo: layouts/shared/toast.blade.php
     Uso: @include('layouts.shared.toast')
     ============================================================ --}}

@php
$toasts = [
    ['key' => 'toast_success', 'type' => 'success', 'icon' => 'fa-check-circle',       'title' => 'Éxito'],
    ['key' => 'toast_error',   'type' => 'error',   'icon' => 'fa-exclamation-circle',  'title' => 'Error'],
    ['key' => 'toast_warning', 'type' => 'warning', 'icon' => 'fa-exclamation-triangle','title' => 'Advertencia'],
    ['key' => 'toast_info',    'type' => 'info',    'icon' => 'fa-info-circle',         'title' => 'Información'],
];
@endphp

<div class="toast-container-fixed" aria-live="polite" aria-atomic="true">
    @foreach($toasts as $toast)
        @if(session($toast['key']))
        <div class="toast app-toast toast-{{ $toast['type'] }} mb-2"
             role="alert"
             aria-live="assertive"
             aria-atomic="true"
             data-autohide="true"
             data-delay="4500">

            <div class="toast-header">
                <i class="fas {{ $toast['icon'] }} mr-2"></i>
                <strong class="mr-auto">{{ $toast['title'] }}</strong>
                <small class="ml-2 opacity-75">ahora</small>
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Cerrar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="toast-body text-gray-700">
                {{ session($toast['key']) }}
            </div>

            {{-- Barra de progreso animada --}}
            <div class="toast-progress"></div>

        </div>
        @endif
    @endforeach
</div>
