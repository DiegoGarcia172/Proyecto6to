<?php
session_start();
include 'conexion.php';
include 'validacioncliente.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Pedido</title>
    <link href="bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Confirmación de Pedido</h2>
        <p>Su pedido se ha realizado con éxito. A continuación se muestran los detalles:</p>
        <a href="client_dashboard.php" class="btn btn-outline-info">Volver al Panel de Cliente</a>
    </div>
    <script src="bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
</body>
</html>
