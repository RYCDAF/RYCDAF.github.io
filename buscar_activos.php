<?php
// Obtener el valor del parámetro de búsqueda
$query = $_GET['query'];

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

// Consultar los activos fijos que coincidan con el número de activo ingresado
$sql = "SELECT * FROM activos_fijos WHERE numero_activo LIKE '%$query%'";
$result = $conn->query($sql);

// Generar el HTML con los resultados de la búsqueda
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='activo-fijo'>";
        echo "<h3>Número de Activo: " . $row['numero_activo'] . "</h3>";
        echo "<p>Fecha: " . $row['fecha'] . "</p>";
        echo "<p>Proveedor: " . $row['proveedor'] . "</p>";
        echo "<p>Descripción: " . $row['descripcion'] . "</p>";
        echo "</div>";
    }
} else {
    echo "<p>No se encontraron resultados</p>";
}

$conn->close();
?>
