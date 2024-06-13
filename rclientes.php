<!DOCTYPE html>
<html>
<head>
    <title>Registro de Clientes</title>
    <link href="bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center bg-body-tertiary py-5 ">
      <main class="border form-signin w-25 m-100 p-3 py-2 mw-100 position-absolute top-50 start-50 translate-middle">
        <form class="py-5 text-center" action="PLC.php" method="post">
          <h1 class="h3 mb-3 fw-normal">Registro</h1>
          <div class="form-floating py-4">
            <input type="text" class="form-control py-4" id="nombre" name="nombre" id="floatingInput">
            <label for="floatingInput" class="py-4">Nombre</label>
          </div>
          <div class="form-floating py-4">
            <input type="email" class="form-control py-4" id="floatingInput" id="correo" name="correo">
            <label for="floatingInput" class="py-4">Correo</label>
          </div>

          <div class="form-floating py-4">
            <input  type="password" class="form-control py-4" id="floatingPassword" id="contrasena" name="contrasena"> 
            <label for="floatingPassword" class="py-4">Clave</label>
          </div>
          <div class="py-2">
          <button type="submit" class="btn btn-outline-info  btn-block">Registrar</button>
          <a href="login.php"><button type="button" class="btn btn-outline-info">Volver</button></a>          
          </div>
        </form>
      </main>
</body>
</html>
