<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener la contraseña ingresada
    $password = $_POST['password'];

    // Generar el hash de la contraseña
    $hash = password_hash($password, PASSWORD_DEFAULT);

    // Mostrar el hash generado
    echo "<h3>Contraseña Hasheada:</h3>";
    echo "<p>$hash</p>";
} else {
    echo "Método no permitido";
}
?>
