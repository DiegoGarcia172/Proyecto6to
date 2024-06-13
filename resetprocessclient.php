<?php
include 'conexion.php';
$correo = $_POST['correo'];
$nueva_contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

if (isset($_POST['contrasena'])) {
  
    $updateSql = "UPDATE Usuarios SET contrasena = ? WHERE correo = ?";
    $updateParams = array($nueva_contrasena, $correo);
    $updateStmt = sqlsrv_query($conn, $updateSql, $updateParams);
    if ($updateStmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        header('Location: login.php');
    }
}
?>