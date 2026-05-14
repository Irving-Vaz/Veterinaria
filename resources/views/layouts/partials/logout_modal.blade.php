{{-- ============================================================
     MODAL DE LOGOUT - Sistema Veterinaria
     Archivo: layouts/partials/logout_modal.blade.php
     ============================================================ --}}

<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="logoutModalLabel">¿Cerrar Sesión?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Cerrar">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                Selecciona "Salir" si deseas terminar tu sesión actual.
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                <a class="btn btn-primary" href="{{ route('logout') }}">Salir</a>
            </div>
        </div>
    </div>
</div>
