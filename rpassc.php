<!DOCTYPE html>
<html>
<head>
    <title>Restablecer Contraseña</title>
    <link href="bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center bg-body-tertiary py-5 ">
    <main class="border form-signin w-50 m-100 p-3 py-2 mw-100 position-absolute top-50 start-50 translate-middle">
        <form class="py-5 text-center" action="resetprocessclient.php" method="post">
            <h1 class="h3 mb-3 fw-normal">Restablecer Contraseña</h1>
            <div class="row">
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo electrónico">
                        <label for="correo">Correo electrónico</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="nueva_contrasena" name="contrasena" placeholder="Nueva contraseña">
                        <label for="nueva_contrasena">Nueva contraseña</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <button type="submit" class="btn btn-outline-info btn-block">Cambiar</button>
                </div>
                <div class="col">
                    <a href="login.php" class="btn btn-outline-info btn-block">Volver</a>
                </div>
            </div>
        </form>
    </main>
</body>
</html>

