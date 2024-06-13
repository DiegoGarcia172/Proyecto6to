<?php
include 'conexion.php';

$usuarioid = $_POST['usuarioid'];
$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$contrasena = $_POST['contrasena'];
$rol_id = $_POST['rol_id'];

// Encriptar la contraseña usando password_hash
$hashed_contrasena = password_hash($contrasena, PASSWORD_DEFAULT);

$sql = "EXEC actualizar_usuario @usuarioid = ?, @nombre = ?, @correo = ?, @contrasena = ?, @rol_id = ?";
$params = array($usuarioid, $nombre, $correo, $hashed_contrasena, $rol_id);

$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);

header('Location: admin_dashboard.php');
?>
