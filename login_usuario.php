<?php
function conectarBD() {
    $servername = "db"; 
    $username = "mariadb"; 
    $password_db = "mariadb"; 
    $dbname = "mariadb"; 

    $conn = new mysqli($servername, $username, $password_db, $dbname);

    if ($conn->connect_error) {
        die("Error en la conexión a la bd:" . $conn->connect_error);
    }

    return $conn;
}


function validarFormularioLogin($email, $contrasena) {

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Error: Formato de correo inválido.";
    }

    if (strlen($contrasena) < 8) {
        return "Error: La contraseña debe tener al menos 8 caracteres.";
    }

    return "";
}


function iniciarSesion($email, $contrasena) {
    $conn = conectarBD();


    $sql = "SELECT id, name, password, email FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();


    if ($stmt->num_rows == 0) {
        return "Error: No se encontró ningún usuario con ese correo electrónico.";
    }

    $stmt->bind_result($id, $name, $password_bd, $email_bd);
    $stmt->fetch();

    if (!password_verify($contrasena, $password_bd)) {
        return "Error: La contraseña proporcionada es incorrecta.";
    }

    session_start();
    $_SESSION["id"] = $id;
    $_SESSION["name"] = $name;
    $_SESSION["email"] = $email_bd;

    return "Inicio de sesión exitoso.";
}


function validarSesion() {

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }


    if (!isset($_SESSION["id"]) || !isset($_SESSION["email"])) {

        header("Location: index.html");
        exit;
    }

    

    // Conexión a la base de datos
    $conn = conectarBD();

    // Consulta a la base de datos para validar que el ID y el correo existen
    $sql = "SELECT role_id FROM users WHERE id = ? AND email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $_SESSION["id"], $_SESSION["email"]);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        header("Location: login.php");
        exit();
    } else {
        $row = $result->fetch_assoc();
        if (isset($row['role_id'])) {
            $rol = $row['role_id'];
        } else {
            $rol = 0; 
        }
    }

    // Verificar si se encontraron resultados en la consulta
    if ($result->num_rows == 0) {
        // Si no se encuentran en la base de datos, redirigir al formulario de inicio de sesión
        header("Location: login.php");
        exit;
    }

    // Si se encuentran en la base de datos, cargar en la sesión el rol del usuario
    $row = $result->fetch_assoc();
    $_SESSION["role_id"] = $row["role_id"];
}

// Validación del lado del servidor para el formulario de inicio de sesión
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $contrasena = $_POST["contrasena"];

    // Validar el formulario de inicio de sesión
    $error = validarFormularioLogin($email, $contrasena);
    if ($error !== "") {
        echo "<script>alert('$error'); window.location.href = 'login.php';</script>";
        exit;
    }

    // Iniciar sesión del usuario después de las validaciones del formulario
    $mensaje = iniciarSesion($email, $contrasena);
    if ($mensaje === "Inicio de sesión exitoso.") {
        echo "<script>alert('$mensaje'); window.location.href = 'index.html';</script>";
        exit;
    } else {
        echo "<script>alert('$mensaje'); window.location.href = 'login.php';</script>";
        exit;
    }
}

// Validar que el usuario ha iniciado sesión en la aplicación
validarSesion();

?>
