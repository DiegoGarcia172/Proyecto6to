<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito']) || !isset($_SESSION['metodo_pago'])) {
    header('Location: cart.php');
    exit();
}

$usuarioid = 1; // Replace this with the actual user ID from your session or authentication system
$company_id = 1; // Replace this with the actual company ID
$pago_id = $_SESSION['metodo_pago'];
$fecha_pedido = date('Y-m-d H:i:s');

// Insert the order
$query = "INSERT INTO Orders (usuarioid, company_id, fecha_pedido, total) VALUES (?, ?, ?, ?)";
$params = [$usuarioid, $company_id, $fecha_pedido, 0]; // Initial total as 0, we'll update it later
$result = sqlsrv_query($conn, $query, $params);
if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Get the last inserted order ID
$query = "SELECT SCOPE_IDENTITY() AS order_id";
$result = sqlsrv_query($conn, $query);
$order = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
$order_id = $order['order_id'];

// Insert order details
$total = 0;
foreach ($_SESSION['carrito'] as $producto_id => $producto) {
    $quantity = $producto['cantidad'];
    $unit_price = 10; // Replace with actual product price from the database
    $discount = 0; // Replace with actual discount logic
    $iva = 0; // Replace with actual IVA calculation

    $subtotal = $quantity * $unit_price * (1 - $discount);
    $total += $subtotal + $iva;

    $query = "INSERT INTO Order_Details (order_id, product_id, quantity, unit_price, discount, iva) VALUES (?, ?, ?, ?, ?, ?)";
    $params = [$order_id, $producto_id, $quantity, $unit_price, $discount, $iva];
    $result = sqlsrv_query($conn, $query, $params);
    if ($result === false) {
        die(print_r(sqlsrv_errors(), true));
    }
}

// Update the order total
$query = "UPDATE Orders SET total = ? WHERE order_id = ?";
$params = [$total, $order_id];
$result = sqlsrv_query($conn, $query, $params);
if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Clear the cart
unset($_SESSION['carrito']);
unset($_SESSION['metodo_pago']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedido Confirmado</title>
    <link href="bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Pedido Confirmado</h2>
        <p>Tu pedido ha sido confirmado exitosamente.</p>
        <a href="cp.php" class="btn btn-outline-info">Volver a la tienda</a>
    </div>
    <script src="bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
</body>
</html>
