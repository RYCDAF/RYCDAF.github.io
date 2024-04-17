<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script type="text/javascript" src="MVC/vista/js/funciones.js"></script>
    <link rel="stylesheet" type="text/css" href="REG.css">
    <link rel="shortcut icon" href="MVC/vista/img2/logo.png"> 
    <title>Registro y Consulta de Activos Fijos</title>
    <style>
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <nav class="menu"> 
        <div class="hamburguesa" onclick="mostrar()">
            <span></span><span></span><span></span>
        </div>
        
        <label class="logo">Registro y Consulta de Activos Fijos</label>
        <ul id="menu-desplegable">
            <li><a href="registro.php">Inicio</a></li>
            <li><a href="Admin.php">Administrador</a></li>
            <li><a href="registro.php">Registro</a></li>
            <li><a href="login.php">Inicio Sesión</a></li>
        </ul>
    </nav>
    
    <header>
        <h1></h1>
    </header>
        
    <div class="wrapper">
        <div class="form-box login">
            <h2>Iniciar Sesión</h2>
            <form id="login-form" action="login_usuario.php" method="POST">
                <div class="input-box">
                   <span class="icon"><ion-icon name="mail-outline"></ion-icon></span>
                   <input id="email" type="email" name="email" required>
                   <label>Email</label>
                   <small class="error" id="error-email" style="display: none;">Por favor, introduce un correo electrónico válido.</small>
                   <small class="error" id="error-email-registrado" style="display: none;">Este correo electrónico no está registrado.</small>
                </div>
                <div class="input-box">
                   <span class="icon"><ion-icon name="key-outline"></ion-icon></span>
                   <input id="contraseña" type="password" name="contrasena" required minlength="8">
                   <label>Contraseña</label>
                   <small class="error" id="error-contraseña" style="display: none;">La contraseña debe tener al menos 8 caracteres.</small>
                </div>
                <button type="submit" class="btnInicioS">Ingresar</button>
                <div class="login-register">
                    <p>¿No tienes una cuenta? <a href="Registro.php" class="register-link">Registráte!</a></p>
                </div>
            </form>
        </div>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script>
        document.getElementById('login-form').addEventListener('submit', function(event) {
            event.preventDefault(); // Evitar enviar el formulario automáticamente
            
            var email = document.getElementById("email").value;
            var contraseña = document.getElementById("contraseña").value;
            var emailValido = /\S+@\S+\.\S+/;

            if (!emailValido.test(email)) {
                document.getElementById("error-email").style.display = "block";
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        document.getElementById("error-email-registrado").style.display = "none";
                        document.getElementById("error-contraseña").style.display = "none";
                        document.getElementById("login-form").submit(); // Envía el formulario si el correo electrónico está registrado
                    } else {
                        document.getElementById("error-email-registrado").style.display = "block";
                    }
                }
            };
            xhr.send("email=" + email);
        });
    </script>
</body>
</html>
