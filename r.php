<?php
include 'conexion.php';
$sql = "SELECT rol_id, rol_nombre FROM Roles";
$stmt = sqlsrv_query($conn, $sql);
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>