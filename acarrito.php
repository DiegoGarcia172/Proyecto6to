<?php
session_start();
include 'conexion.php';

if (!isset($_SESSION['carrito'])) {
    $_SESSION['carrito'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['producto_id']) && isset($_POST['accion'])) {
        $producto_id = $_POST['producto_id'];
        $accion = $_POST['accion'];

        if ($accion === 'agregar') {
            $producto = obtenerDetalleProducto($producto_id);

            if ($producto) {
                if (isset($_SESSION['carrito'][$producto_id])) {
                    $_SESSION['carrito'][$producto_id]['cantidad'] += 1;
                } else {
                    $_SESSION['carrito'][$producto_id] = [
                        'nombre' => $producto['nombre'],
                        'cantidad' => 1,
                        'descripcion' => $producto['descripcion'],
                        'precio' => $producto['precio'],  // Agregar el precio
                        'stock' => $producto['stock'],
                    ];
                }
            }
        } elseif ($accion === 'eliminar') {
            unset($_SESSION['carrito'][$producto_id]);
        } elseif ($accion === 'vender') {
            foreach ($_SESSION['carrito'] as $producto_id => $producto) {
                $cantidad_vendida = $producto['cantidad'];
                $queryUpdateStock = "UPDATE Productos SET stock = stock - ? WHERE product_id = ?";
                $params = array($cantidad_vendida, $producto_id);
                $stmt = sqlsrv_query($conn, $queryUpdateStock, $params);

                if ($stmt === false) {
                    die(print_r(sqlsrv_errors(), true));
                }
            }
            
            // Limpiar carrito después de vender
            $_SESSION['carrito'] = [];
        }
    } elseif (isset($_POST['accion']) && $_POST['accion'] === 'limpiar') {
        $_SESSION['carrito'] = [];
    }
}

header('Location: cart.php');
exit();

function obtenerDetalleProducto($producto_id) {
    global $conn;
    $query = "SELECT * FROM Productos WHERE product_id = ?";
    $params = [$producto_id];
    $result = sqlsrv_query($conn, $query, $params);
    if ($result === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    return sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
}
?>
