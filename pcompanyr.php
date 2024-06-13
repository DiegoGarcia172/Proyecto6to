<?php
include 'conexion.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $sql = "INSERT INTO Company (nombre, direccion, telefono) VALUES (?, ?, ?)";
    $params = array($nombre, $direccion, $telefono);
    $stmt = sqlsrv_query($conn, $sql, $params);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo "Registro de compañía exitoso.";
        header("Location: rcompany.php");
    }
}
?>