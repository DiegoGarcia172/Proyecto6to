<?php
session_start();
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito']) || !isset($_SESSION['metodo_pago'])) {
        header('Location: cart.php');
        exit();
    }

    // Collect shipping details
    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    $pais = $_POST['pais'];
    $codigo_postal = $_POST['codigo_postal'];
    $usuarioid = 1; // Assume a logged-in user id (this should be managed through your session management system)

    // Begin transaction
    sqlsrv_begin_transaction($conn);

    try {
        // Insert into Envios
        $envioQuery = "INSERT INTO Envios (direccion, ciudad, pais, codigo_postal, estado) VALUES (?, ?, ?, ?, 'Pendiente')";
        $envioParams = [$direccion, $ciudad, $pais, $codigo_postal];
        $envioResult = sqlsrv_query($conn, $envioQuery, $envioParams);
        if ($envioResult === false) {
            throw new Exception(print_r(sqlsrv_errors(), true));
        }
        sqlsrv_next_result($envioResult); // Move to next result set

        // Get the last inserted envio_id
        $envioIdQuery = "SELECT SCOPE_IDENTITY() AS envio_id";
        $envioIdResult = sqlsrv_query($conn, $envioIdQuery);
        $envioRow = sqlsrv_fetch_array($envioIdResult, SQLSRV_FETCH_ASSOC);
        $envio_id = $envioRow['envio_id'];

        // Insert into Orders
        $company_id = 1; // Assume a default company id (this should be managed through your system)
        $total = array_sum(array_map(function($producto) {
            return $producto['cantidad'] * $producto['stock']; // Assuming stock is the price (correct this if necessary)
        }, $_SESSION['carrito']));
        $orderQuery = "INSERT INTO Orders (usuarioid, company_id, total) VALUES (?, ?, ?)";
        $orderParams = [$usuarioid, $company_id, $total];
        $orderResult = sqlsrv_query($conn, $orderQuery, $orderParams);
        if ($orderResult === false) {
            throw new Exception(print_r(sqlsrv_errors(), true));
        }
        sqlsrv_next_result($orderResult);

        // Get the last inserted order_id
        $orderIdQuery = "SELECT SCOPE_IDENTITY() AS order_id";
        $orderIdResult = sqlsrv_query($conn, $orderIdQuery);
        $orderRow = sqlsrv_fetch_array($orderIdResult, SQLSRV_FETCH_ASSOC);
        $order_id = $orderRow['order_id'];

        // Insert into OrderDetails
        foreach ($_SESSION['carrito'] as $producto_id => $producto) {
            $quantity = $producto['cantidad'];
            $unit_price = $producto['stock']; // Assuming stock is the price (correct this if necessary)
            $discount = 0; // Assume no discount
            $iva = 0; // Assume no tax
            $orderDetailsQuery = "INSERT INTO OrderDetails (order_id, company_id, pago_id, envio_id, usuarioid, product_id, quantity, unit_price, discount, iva) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $orderDetailsParams = [$order_id, $company_id, $_SESSION['metodo_pago'], $envio_id, $usuarioid, $producto_id, $quantity, $unit_price, $discount, $iva];
            $orderDetailsResult = sqlsrv_query($conn, $orderDetailsQuery, $orderDetailsParams);
            if ($orderDetailsResult === false) {
                throw new Exception(print_r(sqlsrv_errors(), true));
            }
        }

        // Commit transaction
        sqlsrv_commit($conn);

        // Clear cart
        $_SESSION['carrito'] = [];
        unset($_SESSION['metodo_pago']);

        echo "<p>Pedido realizado con éxito</p>";

    } catch (Exception $e) {
        // Rollback transaction
        sqlsrv_rollback($conn);
        echo "<p>Error al realizar el pedido: " . $e->getMessage() . "</p>";
    }
} else {
    header('Location: cart.php');
    exit();
}
?>
