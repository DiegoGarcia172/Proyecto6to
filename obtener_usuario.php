<?php
include 'conexion.php';

$usuarioid = $_GET['usuarioid'];

$sql = "SELECT usuarioid, nombre, correo, contrasena, rol_id FROM Usuarios WHERE usuarioid = ?";
$params = array($usuarioid);
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

$userData = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);

echo json_encode($userData);
?>