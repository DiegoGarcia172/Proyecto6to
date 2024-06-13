<?php
include 'conexion.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombreProducto = $_POST['nombre_producto'];
    $nuevoNombre = $_POST['nuevo_nombre'];
    $nuevaDescripcion = $_POST['nueva_descripcion'];
    $nuevoPrecio = $_POST['nuevo_precio'];
    $nuevoStock = $_POST['nuevo_stock'];

    // Llamar al procedimiento almacenado
    $sql = "{CALL UpdateProductDetails(?, ?, ?, ?, ?)}";
    $params = array(
        array($nombreProducto, SQLSRV_PARAM_IN),
        array($nuevoNombre, SQLSRV_PARAM_IN),
        array($nuevaDescripcion, SQLSRV_PARAM_IN),
        array($nuevoPrecio, SQLSRV_PARAM_IN),
        array($nuevoStock, SQLSRV_PARAM_IN)
    );

    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        header('Location: actualizarproducto.php');
    }

    sqlsrv_free_stmt($stmt);
}

sqlsrv_close($conn);
?>
