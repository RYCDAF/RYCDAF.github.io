// Registro de activos fijos
function guardarActivoFijo() {
    var numeroActivo = document.getElementById('numeroActivo').value;
    var fecha = document.getElementById('fecha').value;
    var proveedor = document.getElementById('proveedor').value;
    var descripcion = document.getElementById('descripcion').value;

    // Realizar la conexión a la base de datos y guardar los datos
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'guardar_activo.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            // Mostrar mensaje de registro exitoso en una ventana modal
            var modal = document.getElementById('modal');
            var mensaje = document.getElementById('mensaje');
            mensaje.innerText = "Registro exitoso";

            // Mostrar la ventana modal
            modal.style.display = "block";

            // Limpiar el formulario después de un retraso de 1 segundo
            setTimeout(function() {
                document.getElementById('numeroActivo').value = '';
                document.getElementById('fecha').value = '';
                document.getElementById('proveedor').value = '';
                document.getElementById('descripcion').value = '';

                // Cerrar la ventana modal después de limpiar el formulario
                modal.style.display = "none";
            }, 5000);
        }
    };
    xhr.send('numeroActivo=' + encodeURIComponent(numeroActivo) + '&fecha=' + encodeURIComponent(fecha) + '&proveedor=' + encodeURIComponent(proveedor) + '&descripcion=' + encodeURIComponent(descripcion));
    return false; // Evita el envío del formulario
}

// Cerrar la ventana modal
function cerrarModal() {
    var modal = document.getElementById('modal');
    modal.style.display = "none";
}

        function buscarActivosFijos() {
            var input = document.getElementById('buscar').value;
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'buscar_activos.php?query=' + encodeURIComponent(input), true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                    var resultadoDiv = document.getElementById('activosFijosContainer');
                    resultadoDiv.innerHTML = xhr.responseText;
                }
            };
            xhr.send();
        }