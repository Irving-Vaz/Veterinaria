function toggleVeterinarioFields() {
    const rolSelect = document.getElementById('rol');
    const vetFields = document.getElementById('veterinario_fields');
    
    if (rolSelect.value === 'veterinario') {
        vetFields.style.display = 'block';
    } else {
        vetFields.style.display = 'none';
    }
}

// Inicializar al cargar la página (útil cuando hay validación fallida y se recarga con 'old' values)
document.addEventListener('DOMContentLoaded', function() {
    toggleVeterinarioFields();
    
    // Actualizar el label del input file con el nombre del archivo seleccionado
    const fileInput = document.querySelector('.custom-file-input');
    if (fileInput) {
        fileInput.addEventListener('change', function(e) {
            var fileName = document.getElementById("foto_firma").files[0].name;
            var nextSibling = e.target.nextElementSibling;
            nextSibling.innerText = fileName;
        });
    }
});
