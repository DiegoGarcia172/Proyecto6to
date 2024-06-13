<?php
include 'conexion.php';
$roles = ['cliente', 'administrador', 'trabajador'];
foreach ($roles as $rol_nombre) {
    $checkSql = "SELECT COUNT(*) AS count FROM Roles WHERE rol_nombre = ?";
    $params = array($rol_nombre);
    $checkStmt = sqlsrv_query($conn, $checkSql, $params);
    if ($checkStmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    $row = sqlsrv_fetch_array($checkStmt, SQLSRV_FETCH_ASSOC);
    if ($row['count'] == 0) {
        $insertSql = "INSERT INTO Roles (rol_nombre) VALUES (?)";
        $insertStmt = sqlsrv_query($conn, $insertSql, $params);

        if ($insertStmt === false) {
            die(print_r(sqlsrv_errors(), true));
        }
    } else {
        echo "El rol '$rol_nombre' ya existe. No se insertará nuevamente.<br>";
    }
}
echo "Proceso de inserción de roles completado.";
?>