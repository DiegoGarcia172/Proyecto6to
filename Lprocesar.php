<?php
session_start();
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    // Verificar si el usuario existe y obtener la contraseña hash
    $sql = "SELECT usuarioid, nombre, contrasena, rol_id FROM Usuarios WHERE correo = ?";
    $params = array($correo);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    if ($row && password_verify($contrasena, $row['contrasena'])) {
        // Las credenciales son correctas, iniciar la sesión
        $_SESSION['usuarioid'] = $row['usuarioid'];
        $_SESSION['user_nombre'] = $row['nombre'];
        $_SESSION['rol_id'] = $row['rol_id'];

        // Redirigir según el tipo de usuario
        switch ($row['rol_id']) {
            case 1: // Admin
                header('Location: admin_dashboard.php');
                break;
            case 2: // Usuario estándar
                header('Location: trabajador_dashboard.php');
                break;
            case 3: // Otro tipo de usuario
                header('Location: client_dashboard.php');
                break;
        }
        exit();
    } else {
        // Credenciales incorrectas
        echo "Correo o contraseña incorrectos.";
    }
}
?>
