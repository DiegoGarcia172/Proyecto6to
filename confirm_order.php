<?php
include 'conexion.php';
session_start();  // Asegúrate de iniciar la sesión

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Asegúrate de que las variables de sesión están establecidas
    if (!isset($_SESSION['metodo_pago']) || !isset($_SESSION['usuarioid']) || !isset($_SESSION['carrito'])) {
        die('Error: Faltan datos en la sesión.');
    }

    $direccion = $_POST['direccion'];
    $ciudad = $_POST['ciudad'];
    $pais = $_POST['pais'];
    $codigo_postal = $_POST['codigo_postal'];
    $company_id = $_POST['company_id'];
    $metodo_pago = $_SESSION['metodo_pago'];
    $usuarioid = $_SESSION['usuarioid'];

    // Inicia una transacción
    sqlsrv_begin_transaction($conn);

    try {
        // Inserta en la tabla Envios
        $sql_envio = "INSERT INTO Envios (direccion, ciudad, pais, codigo_postal, estado) 
                      VALUES (?, ?, ?, ?, 'pendiente')";
        $params_envio = [$direccion, $ciudad, $pais, $codigo_postal];
        $stmt_envio = sqlsrv_query($conn, $sql_envio, $params_envio);

        if ($stmt_envio === false) {
            throw new Exception(print_r(sqlsrv_errors(), true));
        }

        // Obtén el ID del envío recién insertado
        $envio_id_query = sqlsrv_query($conn, "SELECT @@IDENTITY AS envio_id");
        if ($envio_id_query === false) {
            throw new Exception(print_r(sqlsrv_errors(), true));
        }
        $row = sqlsrv_fetch_array($envio_id_query, SQLSRV_FETCH_ASSOC);
        $envio_id = $row['envio_id'];

        // Inserta en la tabla Pagos
        $sql_pago = "INSERT INTO Pagos (metodo, estado) VALUES (?, 'pendiente')";
        $params_pago = [$metodo_pago];
        $stmt_pago = sqlsrv_query($conn, $sql_pago, $params_pago);

        if ($stmt_pago === false) {
            throw new Exception(print_r(sqlsrv_errors(), true));
        }

        // Obtén el ID del pago recién insertado
        $pago_id_query = sqlsrv_query($conn, "SELECT @@IDENTITY AS pago_id");
        if ($pago_id_query === false) {
            throw new Exception(print_r(sqlsrv_errors(), true));
        }
        $row = sqlsrv_fetch_array($pago_id_query, SQLSRV_FETCH_ASSOC);
        $pago_id = $row['pago_id'];

        // Obtén el siguiente order_id secuencial para la empresa
        $sql_max_order_id = "SELECT ISNULL(MAX(order_id), 0) + 1 AS next_order_id FROM Orders WHERE company_id = ?";
        $params_max_order_id = [$company_id];
        $stmt_max_order_id = sqlsrv_query($conn, $sql_max_order_id, $params_max_order_id);
        if ($stmt_max_order_id === false) {
            throw new Exception(print_r(sqlsrv_errors(), true));
        }
        $row = sqlsrv_fetch_array($stmt_max_order_id, SQLSRV_FETCH_ASSOC);
        $order_id = $row['next_order_id'];

        // Calcula el total del pedido
        $total = 0;
        foreach ($_SESSION['carrito'] as $producto_id => $producto) {
            $total += $producto['cantidad'] * $producto['precio'];
        }

        // Inserta el pedido en la tabla Orders
        $sql_pedido = "INSERT INTO Orders (order_id, usuarioid, company_id, total) VALUES (?, ?, ?, ?)";
        $params_pedido = [$order_id, $usuarioid, $company_id, $total];
        $stmt_pedido = sqlsrv_query($conn, $sql_pedido, $params_pedido);

        if ($stmt_pedido === false) {
            throw new Exception(print_r(sqlsrv_errors(), true));
        }

        // Inserta los productos del pedido en la tabla OrderDetails y actualiza el stock en Productos
        foreach ($_SESSION['carrito'] as $producto_id => $producto) {
            $quantity = $producto['cantidad'];
            $unit_price = $producto['precio'];
            $iva = $unit_price * $quantity * 0.16;  // Assuming a 16% tax rate

            // Inserta en OrderDetails
            $sql_producto = "INSERT INTO OrderDetails (order_id, company_id, pago_id, envio_id, usuarioid, product_id, quantity, unit_price, discount, iva)
                             VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0, ?)";
            $params_producto = [$order_id, $company_id, $pago_id, $envio_id, $usuarioid, $producto_id, $quantity, $unit_price, $iva];
            $stmt_producto = sqlsrv_query($conn, $sql_producto, $params_producto);

            if ($stmt_producto === false) {
                throw new Exception(print_r(sqlsrv_errors(), true));
            }

            // Actualiza el stock en Productos
            $sql_update_stock = "UPDATE Productos SET stock = stock - ? WHERE product_id = ?";
            $params_update_stock = [$quantity, $producto_id];
            $stmt_update_stock = sqlsrv_query($conn, $sql_update_stock, $params_update_stock);

            if ($stmt_update_stock === false) {
                throw new Exception(print_r(sqlsrv_errors(), true));
            }
        }

        // Confirma la transacción
        sqlsrv_commit($conn);

        // Limpia las variables de sesión relacionadas con el carrito y el método de pago
        unset($_SESSION['carrito']);
        unset($_SESSION['metodo_pago']);

        // Redirige a la página de confirmación
        header('Location: confirmacion.php');
        exit();

    } catch (Exception $e) {
        // Si hay un error, revierte la transacción
        sqlsrv_rollback($conn);
        die("Error al crear el pedido: " . $e->getMessage());
    }
}
?>