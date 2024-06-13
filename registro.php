<?php
include 'r.php';
?>
<!DOCTYPE html>
<html>
<head>
    <link href="bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Registro de Usuarios</title>
</head>
<body class="d-flex align-items-center bg-body-tertiary py-5 ">
      <main class="border form-signin w-25 m-100 p-3 py-2 mw-50 position-absolute top-50 start-50 translate-middle">
        <form class="py-5 text-center" action="PRegistro.php" method="post">
          <h1 class="h3 mb-3 fw-normal">Registro de Usuarios para administradores</h1>
          <div class="form-floating py-4">
            <input type="text" class="form-control py-4" name="nombre" id="floatingInput" placeholder="">
            <label for="floatingInput" class="py-4">Nombre</label>
          </div>
          <div class="form-floating py-4">
            <input type="email" class="form-control py-4"  name="correo" id="floatingInput" placeholder="">
            <label for="floatingInput" class="py-4">Correo</label>
          </div>
          <div class="form-floating py-4">
            <input  type="password" name="contrasena" class="form-control py-4" id="floatingPassword" placeholder="">
            <label for="floatingPassword" class="py-4">Clave</label>
          </div>
          <div class="form-floating py-4">
            <select name="rol_id" class="form-select" id="floatingRol" required>
                <option value="">Seleccione un rol</option>
                     <?php
                    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
                     echo "<option value='" . $row['rol_id'] . "'>" . $row['rol_nombre'] . "</option>";
                     }
                    ?>
                     </select>
            </div>
            <button type="submit" class="btn btn-outline-info" >Enviar</button>
            <a href="admin_dashboard.php"><button type="button" class="btn btn-outline-info">Volver</button></a>          
        </form>
      </main>
</body>
</html>
