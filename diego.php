<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Hash de Contraseña</title>
</head>
<body>
    <h2>Generar Password Hash</h2>
    <form action="generar_hash.php" method="POST">
        <label for="password">Nueva Contraseña:</label>
        <input type="password" id="password" name="password" required>
        <br><br>
        <input type="submit" value="Generar Hash">
    </form>
</body>
</html>
