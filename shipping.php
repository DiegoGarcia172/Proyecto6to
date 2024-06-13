<?php
include 'conexion.php';
include 'validacioncliente.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $metodo_pago = $_POST['metodo_pago'];
    $_SESSION['metodo_pago'] = $metodo_pago;
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información de Envío</title>
    <link href="bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Información de Envío</h2>
        <form action="confirm_order.php" method="post">
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" required>
            </div>
            <div class="mb-3">
                <label for="ciudad" class="form-label">Ciudad</label>
                <input type="text" class="form-control" id="ciudad" name="ciudad" required>
            </div>
            <div class="mb-3">
                <label for="pais" class="form-label">País</label>
                <input type="text" class="form-control" id="pais" name="pais" required>
            </div>
            <div class="mb-3">
                <label for="codigo_postal" class="form-label">Código Postal</label>
                <input type="text" class="form-control" id="codigo_postal" name="codigo_postal" required>
            </div>
            <div class="mb-3">
                <label for="company_id" class="form-label">Compañía</label>
                <select class="form-select" id="company_id" name="company_id" required>
                    <option value="">Seleccione una compañía</option>
                    <?php
                    $query = "SELECT * FROM Company";
                    $result = sqlsrv_query($conn, $query);
                    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                        echo "<option value='{$row['company_id']}'>{$row['nombre']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-outline-info">Confirmar Pedido</button>
        </form>
    </div>
    <script src="bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
</body>
</html>
