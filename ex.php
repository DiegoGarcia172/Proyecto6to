<?php
require('fpdf/fpdf.php');

// Obtener los resultados del formulario
$resultados = unserialize(base64_decode($_POST['resultados']));

// Crear una nueva instancia de FPDF en modo horizontal
$pdf = new FPDF('L', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

// Título del PDF
$pdf->Cell(0, 10, 'Ventas de la compania seleccionada', 0, 1, 'C');

// Encabezados de la tabla
$header = array('ID', 'User', 'Fecha', 'Producto', 'Nombre', 'Cant.', 'P. Unit', 'Desc.', 'SubTotal', 'IVA', 'Total');

// Anchos de las columnas ajustados
$widths = array(10, 20, 40, 20, 40, 20, 20, 20, 30, 20, 30);

// Imprimir encabezados
foreach ($header as $i => $col) {
    $pdf->Cell($widths[$i], 7, $col, 1);
}
$pdf->Ln();

// Datos de la tabla
$pdf->SetFont('Arial', '', 10);
foreach ($resultados as $row) {
    $pdf->Cell($widths[0], 6, $row['order_id'], 1);
    $pdf->Cell($widths[1], 6, $row['usuario_nombre'], 1);
    // Convertir el objeto DateTime a cadena de texto
    $fecha = $row['fecha_pedido']->format('Y-m-d H:i:s');
    $pdf->Cell($widths[2], 6, $fecha, 1);
    $pdf->Cell($widths[3], 6, $row['product_id'], 1);
    $pdf->Cell($widths[4], 6, $row['product_nombre'], 1);
    $pdf->Cell($widths[5], 6, $row['quantity'], 1);
    $pdf->Cell($widths[6], 6, $row['unit_price'], 1);
    $pdf->Cell($widths[7], 6, $row['discount'], 1);
    $pdf->Cell($widths[8], 6, $row['subtotal'], 1);
    $pdf->Cell($widths[9], 6, $row['iva'], 1);
    $pdf->Cell($widths[10], 6, $row['order_total'], 1);
    $pdf->Ln();
}

// Salida del PDF
$pdf->Output('D', 'ventas_compania.pdf');
?>

