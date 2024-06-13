<?php
require('fpdf/fpdf.php');
include 'conexion.php';

$company_id = $_GET['compania'];
$usuarioid = $_GET['usuario'];

$sql = "EXEC ObtenerVentasPorFiltros @company_id = $company_id, @usuarioid = $usuarioid";
$result = sqlsrv_query($conn, $sql);

if ($result === false) {
    die("Error al ejecutar la consulta: " . print_r(sqlsrv_errors(), true));
}

$data = array();

while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $data[] = $row;
}

$pdf = new FPDF('L'); // Establece la orientación horizontal (Landscape)
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, 'Ventas por Usuario y Compania', 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 10);

// Primera tabla: Meses 1 a 6
$pdf->Cell(280, 10, 'Meses 1 al 6', 1, 1, 'C');
$pdf->Cell(60, 10, 'Usuario', 1, 0, 'C');
$pdf->Cell(60, 10, 'Compania', 1, 0, 'C');
for ($i = 1; $i <= 6; $i++) {
    $pdf->Cell(20, 10, $i, 1, 0, 'C');
}
$pdf->Cell(40, 10, 'Total Ventas', 1, 1, 'C');

$pdf->SetFont('Arial', '', 10);
foreach ($data as $row) {
    $pdf->Cell(60, 10, $row["Usuario"], 1, 0, 'C');
    $pdf->Cell(60, 10, $row["Compania"], 1, 0, 'C');
    for ($i = 1; $i <= 6; $i++) {
        $pdf->Cell(20, 10, $row["$i"], 1, 0, 'C');
    }
    $pdf->Cell(40, 10, $row["Total"], 1, 1, 'C');
}

// Salto de página
$pdf->AddPage();

$pdf->SetFont('Arial', 'B', 10);

// Segunda tabla: Meses 7 a 12
$pdf->Cell(280, 10, 'Meses 7 al 12', 1, 1, 'C');
$pdf->Cell(60, 10, 'Usuario', 1, 0, 'C');
$pdf->Cell(60, 10, 'Compania', 1, 0, 'C');
for ($i = 7; $i <= 12; $i++) {
    $pdf->Cell(20, 10, $i, 1, 0, 'C');
}
$pdf->Cell(40, 10, 'Total Ventas', 1, 1, 'C');

$pdf->SetFont('Arial', '', 10);
foreach ($data as $row) {
    $pdf->Cell(60, 10, $row["Usuario"], 1, 0, 'C');
    $pdf->Cell(60, 10, $row["Compania"], 1, 0, 'C');
    for ($i = 7; $i <= 12; $i++) {
        $pdf->Cell(20, 10, $row["$i"], 1, 0, 'C');
    }
    $pdf->Cell(40, 10, $row["Total"], 1, 1, 'C');
}

// Liberar recursos
sqlsrv_free_stmt($result);
sqlsrv_close($conn);

$pdf->Output('D', 'Ventas.pdf');
?>
