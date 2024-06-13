<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['metodo_pago']) || empty($_POST['metodo_pago'])) {
        header('Location: cart.php');
        exit();
    }
    $_SESSION['metodo_pago'] = $_POST['metodo_pago'];
}

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito']) || !isset($_SESSION['metodo_pago'])) {
    header('Location: cart.php');
    exit();
}

// Fetch payment method details
$metodo_pago_id = $_SESSION['metodo_pago'];
$query = "SELECT * FROM Pagos WHERE pago_id = ?";
$params = [$metodo_pago_id];
$result = sqlsrv_query($conn, $query, $params);
if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}
$metodo_pago = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revisión de Pedido</title>
    <link href="bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Revisión de Pedido</h2>
        <h3>Detalles del Carrito</h3>

        <table class="table table-bordered">
            <thead>
                <tr><th>Producto</th><th>Descripción</th><th>Stock</th><th>Cantidad</th></tr>
            </thead>
            <tbody>
                <?php
                foreach ($_SESSION['carrito'] as $producto_id => $producto) {
                    echo "<tr>
                            <td>{$producto['nombre']}</td>
                            <td>{$producto['descripcion']}</td>
                            <td>{$producto['stock']}</td>
                            <td>{$producto['cantidad']}</td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>

        <h3>Método de Pago</h3>
        <p><?php echo $metodo_pago['metodo']; ?></p>

        <form action="finalizar.php" method="post">
            <button type="submit" class="btn btn-outline-info">Confirmar Pedido</button>
        </form>
    </div>
    <script src="bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
</body>
</html>
