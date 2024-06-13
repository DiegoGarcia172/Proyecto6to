<?php
// Aquí podrías incluir tus archivos de conexión y validación de cliente si es necesario
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

        <!-- Aquí podrías mostrar los detalles del pedido -->
        <?php
        // Por ejemplo, podrías mostrar el número de pedido, dirección de envío, método de pago, productos comprados, total, etc.
        // Simplemente puedes recuperar esta información de la sesión o de la base de datos, dependiendo de cómo esté estructurado tu sistema.

        // Por ejemplo, podrías mostrar el número de pedido, dirección de envío, método de pago, productos comprados, total, etc.
        // Simplemente puedes recuperar esta información de la sesión o de la base de datos, dependiendo de cómo esté estructurado tu sistema.
        ?>

        <a href="client_dashboard.php" class="btn btn-outline-info">Volver al Panel de Cliente</a>
    </div>
    <script src="bootstrap-5.3.3-dist/js/bootstrap.min.js"></script>
</body>
</html>
