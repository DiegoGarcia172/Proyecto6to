<?php
include 'conexion.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $stock = $_POST['stock'];
    $sql = "INSERT INTO Productos (product_id, nombre, descripcion, precio, stock) VALUES (?, ?, ?, ?, ?)";
    $params = array($product_id, $nombre, $descripcion, $precio, $stock);
    $stmt = sqlsrv_query($conn, $sql, $params);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo "Registro de producto exitoso.";
        header('Location: rproductos.php');
    }
}
?>