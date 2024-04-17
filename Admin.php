<?php
require_once 'conexion.php';
require_once 'cerrar_sesion.php'; // Agrega esta línea para incluir el código de cerrar_sesion.php

// No es necesario llamar a session_start() aquí si ya se ha iniciado en cerrar_sesion.php u otro lugar.

// Verificar si el usuario ha iniciado sesión y si las validaciones de ID y correo electrónico fueron exitosas
if (!isset($_SESSION['name']) || !isset($_SESSION['id']) || !isset($_SESSION['email'])) {
    echo '<script>alert("Inicie sesion primero"); window.location = "login.php";</script>';
    session_destroy();
    die();
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registro y Consulta de Activos Fijos</title>
  <link rel="stylesheet" type="text/css" href="REG.css">
</head>
<body>
<nav class="menu">
        <div class="hamburguesa" onclick="mostrar()">
            <span></span><span></span><span></span>
        </div>
        <label class="logo">Registro y Consulta de Activos Fijos</label>
        <ul id="menu-desplegable">
            <li><a href="login.php">Inicio</a></li>
            <li><a href="Admin.php">Administrador</a></li>
            <li><a href="Registro.php">Registrarme</a></li>
            <li><a href="login.php">Inicio Sesión</a></li>
        </ul>
    </nav>
<h1>Pagina para admins</h1>

<a href="#" onclick="cerrarSesion()">Cerrar sesion</a> <!-- Cambiado a un enlace que llama a la función cerrarSesion() -->

<script>
    // Función para cerrar sesión manualmente
    function cerrarSesion() {
        // Enviar una solicitud POST a cerrar_sesion.php
        fetch('cerrar_sesion.php', {
            method: 'POST',
            body: new URLSearchParams({ 'cerrar_sesion': 'true' }),
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            }
        })
        .then(response => {
            // Redirigir al usuario al formulario de inicio de sesión
            window.location.href = "login.php";
        })
        .catch(error => console.error('Error:', error));
    }

    // Establecer temporizador de sesión
    let temporizadorSesion;

    function reiniciarTemporizadorSesion() {
        clearTimeout(temporizadorSesion);
        temporizadorSesion = setTimeout(cerrarSesion, 900000); // 15 minutos en milisegundos
    }

    // Reiniciar temporizador cada vez que ocurra una acción del usuario
    document.addEventListener('mousemove', reiniciarTemporizadorSesion);
    document.addEventListener('keydown', reiniciarTemporizadorSesion);

    // Iniciar temporizador al cargar la página
    reiniciarTemporizadorSesion();
</script>
</body>
</html>
