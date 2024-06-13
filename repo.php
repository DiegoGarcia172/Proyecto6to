<?php
// Configuración de la conexión a la base de datos
include 'conexion.php';
// Intentar establecer la conexión
$conn = sqlsrv_connect($serverName, $connectionInfo);

if ($conn === false) {
    // Si hay un error en la conexión, muestra un mensaje y termina el script
    die(print_r(sqlsrv_errors(), true));
}

// Llamar al procedimiento almacenado
$sql = "{CALL ObtenerDatos}";

// Ejecutar la consulta
$stmt = sqlsrv_query($conn, $sql);

if ($stmt === false) {
    // Si hay un error en la ejecución de la consulta, muestra un mensaje y termina el script
    die(print_r(sqlsrv_errors(), true));
}

// Imprimir resultados
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    print_r($row);
}

// Cerrar la conexión
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>