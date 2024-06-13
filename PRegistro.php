<?php
include 'conexion.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];

    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
    
    $rol_id = $_POST['rol_id'];
    $checkSql = "SELECT COUNT(*) AS count FROM Usuarios WHERE correo = ?";
    $params = array($correo);
    $checkStmt = sqlsrv_query($conn, $checkSql, $params);
    if ($checkStmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    $row = sqlsrv_fetch_array($checkStmt, SQLSRV_FETCH_ASSOC);
    if ($row['count'] > 0) {
        die("El correo ya está registrado.");
    }
    $sql = "INSERT INTO Usuarios (nombre, correo, contrasena, rol_id) VALUES (?, ?, ?, ?)";
    $params = array($nombre, $correo, $contrasena, $rol_id);
    $stmt = sqlsrv_query($conn, $sql, $params);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo "Registro exitoso.";
        header('Location: login.php');
    }
}
?>