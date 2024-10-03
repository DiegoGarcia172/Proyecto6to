<?php
if(isset($_GET['order_id']) && isset($_GET['company_id'])) {
    $orderId = $_GET['order_id'];
    $companyId = $_GET['company_id'];

    // Incluir archivo de conexión
    include 'conexion.php';

    // Crear la conexión
    $conn = sqlsrv_connect($serverName, $connectionInfo);

    // Verificar si la conexión fue exitosa
    if ($conn === false) {
        die("Error en la conexión a la base de datos: " . print_r(sqlsrv_errors(), true));
    }

    // Preparar la consulta con la cláusula WHERE para filtrar por order_id y company_id
    $sql = "{CALL sp_GetOrderDetailsByOrderId(?, ?)}";
    $params = array($orderId, $companyId);
    $stmt = sqlsrv_query($conn, $sql, $params);

    // Verificar si la consulta fue exitosa
    if ($stmt === false) {
        die("Error al ejecutar la consulta SQL: " . print_r(sqlsrv_errors(), true));
    }

    // Crear una instancia de FPDF
    require('fpdf/fpdf.php');
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16); // Establecer una fuente en negrita de tamaño 16

    // Agregar encabezado con el nombre de la empresa
    $pdf->Cell(0, 10, 'Nombre de tu Empresa', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12); // Cambiar la fuente a tamaño 12 y sin negrita

    // Agregar línea decorativa
    $pdf->SetLineWidth(0.5);
    $pdf->Line(10, 30, 200, 30); // Línea horizontal desde (10,30) hasta (200,30)
    $pdf->Ln(10); // Agrega un espacio después de la línea

    // Agregar contenido al PDF
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        // Agregar los detalles de la orden de manera ordenada
        $pdf->Cell(60, 10, 'Orden:', 0, 0, 'R');
        $pdf->Cell(0, 10, $row['order_id'], 0, 1, 'L');
        $pdf->Cell(60, 10, 'company:', 0, 0, 'R');
        $pdf->Cell(0, 10, $row['company_nombre'] . ' (' . $row['company_id'] . ')', 0, 1, 'L');
        // Agregar otros datos de la orden aquí...
        $pdf->Cell(60, 10, 'Producto:', 0, 0, 'R');
        $pdf->Cell(0, 10, $row['producto_nombre'] . ' (' . $row['product_id'] . ')', 0, 1, 'L');
        $pdf->Cell(60, 10, 'Descripcion:', 0, 0, 'R');
        $pdf->Cell(0, 10, $row['producto_descripcion'], 0, 1, 'L');
        $pdf->Cell(60, 10, 'Cantidad:', 0, 0, 'R');
        $pdf->Cell(0, 10, $row['quantity'], 0, 1, 'L');
        $pdf->Cell(60, 10, 'Precio Unitario:', 0, 0, 'R');
        $pdf->Cell(0, 10, '$' . $row['unit_price'], 0, 1, 'L');
        $pdf->Cell(60, 10, 'Descuento:', 0, 0, 'R');
        $pdf->Cell(0, 10, '$' . $row['discount'], 0, 1, 'L');
        $pdf->Cell(60, 10, 'IVA:', 0, 0, 'R');
        $pdf->Cell(0, 10, '$' . $row['iva'], 0, 1, 'L');
        $pdf->Cell(60, 10, 'Total con IVA:', 0, 0, 'R');
        $pdf->Cell(0, 10, '$' . $row['total'], 0, 1, 'L');
        $pdf->Cell(60, 10, 'Metodo de Pago:', 0, 0, 'R');
        $pdf->Cell(0, 10, $row['pago_metodo'], 0, 1, 'L');
        $pdf->Cell(60, 10, 'Estado del Pago:', 0, 0, 'R');
        $pdf->Cell(0, 10, $row['pago_estado'], 0, 1, 'L');
        $pdf->Cell(60, 10, 'Envio:', 0, 0, 'R');
        $pdf->Cell(0, 10, $row['envio_direccion'] . ', ' . $row['envio_ciudad'] . ', ' . $row['envio_pais'] . ' (' . $row['envio_codigo_postal'] . ')', 0, 1, 'L');
        $pdf->Cell(60, 10, 'Estado del Envío:', 0, 0, 'R');
        $pdf->Cell(0, 10, $row['envio_estado'], 0, 1, 'L');
        $pdf->Cell(60, 10, 'Usuario:', 0, 0, 'R');
        $pdf->Cell(0, 10, $row['usuario_nombre'] . ' (' . $row['usuario_correo'] . ')', 0, 1, 'L');
        $pdf->Cell(60, 10, 'Fecha de la Orden:', 0, 0, 'R');
        $pdf->Cell(0, 10, $row['fecha_creacion']->format('Y-m-d H:i:s'), 0, 1, 'L');
        $pdf->Ln(10); // Agrega un espacio después de cada conjunto de datos
        
        
    }
    
    // Salida del PDF
    $pdf->Output();
} else {
    echo "Error: Falta order_id o company_id";
}
?>
