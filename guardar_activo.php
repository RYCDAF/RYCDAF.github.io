<?php
// Obtener los datos del formulario
$numeroActivo = $_POST['numeroActivo'];
$fecha = $_POST['fecha'];
$proveedor = $_POST['proveedor'];
$descripcion = $_POST['descripcion'];

// Realizar la conexión a la base de datos
$servername = "fdb1029.awardspace.net";
$username = "4329530_activosfijos";
$password = "activosfijos123";
$dbname = "4329530_activosfijos";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Insertar los datos en la tabla de activos_fijos
$sql = "INSERT INTO activos_fijos (numero_activo, fecha, proveedor, descripcion) VALUES ('$numeroActivo', '$fecha', '$proveedor', '$descripcion')";

if ($conn->query($sql) === TRUE) {
    echo "Registro exitoso";
} else {
    echo "Error al registrar el activo fijo: " . $conn->error;
}

$conn->close();
?>
