<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $company_id = $_POST['compania'];
    $sql = "{CALL sp_GetVentasPorCompania(?)}";
    $params = array(
        array($company_id, SQLSRV_PARAM_IN)
    );
    $stmt = sqlsrv_query($conn, $sql, $params);
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    $resultados = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $resultados[] = $row;
    }
    sqlsrv_free_stmt($stmt);
    echo "<form method='post' action='ex.php'>";
    echo "<table class='table table-striped table-bordered'>";
    echo "<thead class='thead-dark'><tr><th>Order ID</th><th>Usuario</th><th>Fecha Pedido</th><th>Total</th><th>Product ID</th><th>Product Name</th><th>Quantity</th><th>Unit Price</th><th>Discount</th><th>Subtotal</th><th>IVA</th><th>Total Order</th></tr></thead>";
    echo "<tbody>";
    foreach ($resultados as $row) {
        echo "<tr>";
        echo "<td>" . $row['order_id'] . "</td>";
        echo "<td>" . $row['usuario_nombre'] . "</td>";
        echo "<td>" . $row['fecha_pedido']->format('Y-m-d H:i:s') . "</td>";
        echo "<td>" . $row['total'] . "</td>";
        echo "<td>" . $row['product_id'] . "</td>";
        echo "<td>" . $row['product_nombre'] . "</td>";
        echo "<td>" . $row['quantity'] . "</td>";
        echo "<td>" . $row['unit_price'] . "</td>";
        echo "<td>" . $row['discount'] . "</td>";
        echo "<td>" . $row['subtotal'] . "</td>";
        echo "<td>" . $row['iva'] . "</td>";
        echo "<td>" . $row['order_total'] . "</td>";
        echo "</tr>";
    }
    echo "</tbody></table>";
    echo "<input type='hidden' name='resultados' value='" . base64_encode(serialize($resultados)) . "'>";
    echo "<button type='submit' class='btn btn-outline-info'>Exportar a PDF</button>";
    echo "</form>";
}
?>