<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Iniciar Sesion</title>
    <link href="bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center bg-body-tertiary py-5">
    <main class="border form-signin w-25 m-100 p-3 py-5 mw-100 position-absolute top-50 start-50 translate-middle">
        <form class="py-5 text-center" action="Lprocesar.php" method="POST">
            <h1 class="h3 mb-3 fw-normal">Inicia sesión</h1>
            <a href="rclientes.php">¿Aún no estás registrado?</a>
            
            <div class="form-floating py-4">
                <input type="email" class="form-control py-4" id="floatingInput" name="correo" placeholder="Correo" required>
                <label for="floatingInput" class="py-4">Correo</label>
            </div>
            <div class="form-floating py-4">
                <input name="contrasena" type="password" class="form-control py-4" id="floatingPassword" placeholder="Clave" required>
                <label for="floatingPassword" class="py-4">Clave</label>
            </div>
            <a href="rpassc.php">Olvide la contrasena</a>
            <div class="py-5">
                <button class="btn btn-outline-info w-100" type="submit">Entrar</button>
            </div>
        </form>
    </main>
</body>
</html>
