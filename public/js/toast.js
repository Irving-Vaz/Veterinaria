/* =============================================================
   TOAST NOTIFICATIONS — Inicialización Bootstrap 4
   Archivo: public/js/toast.js
   ============================================================= */

$(document).ready(function () {
    $('.app-toast').each(function () {
        var $toast = $(this);

        // Inicializar y mostrar el toast con Bootstrap 4
        $toast.toast({ delay: 4500, autohide: true });
        $toast.toast('show');

        // Eliminar del DOM al ocultarse para no acumular toasts
        $toast.on('hidden.bs.toast', function () {
            $toast.remove();
        });
    });
});
