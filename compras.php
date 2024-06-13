<?php 
    include 'validaciontrab.php';
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compras</title>
    <link href="bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
      <li class="nav-item">
          <a class="btn btn-outline-secondary" href="trabajador_dashboard.php" aria-label="Inicio">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
              <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5"/>
            </svg>
          </a>
        </li>
        <li class="nav-item px-2">
          <a class="btn btn-outline-secondary" href="compras.php" aria-label="Historial de compras">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bag-plus-fill" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M10.5 3.5a2.5 2.5 0 0 0-5 0V4h5zm1 0V4H15v10a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V4h3.5v-.5a3.5 3.5 0 1 1 7 0M8.5 8a.5.5 0 0 0-1 0v1.5H6a.5.5 0 0 0 0 1h1.5V12a.5.5 0 0 0 1 0v-1.5H10a.5.5 0 0 0 0-1H8.5z"/>
          </svg>
          </a>
        </li>
        <li class="nav-item">
            <a class="btn btn-outline-secondary" href="pro.php" aria-label="Productos">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-checklist" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M15.528 2.973a.75.75 0 0 1 .472.696v8.662a.75.75 0 0 1-.472.696l-7.25 2.9a.75.75 0 0 1-.557 0l-7.25-2.9A.75.75 0 0 1 0 12.331V3.669a.75.75 0 0 1 .471-.696L7.443.184l.01-.003.268-.108a.75.75 0 0 1 .558 0l.269.108.01.003zM10.404 2 4.25 4.461 1.846 3.5 1 3.839v.4l6.5 2.6v7.922l.5.2.5-.2V6.84l6.5-2.6v-.4l-.846-.339L8 5.961 5.596 5l6.154-2.461z"/>
         </svg>
            </a>
        </li>
      </ul>
    </div>
    <div class="nav-item">
           <a class="btn btn-outline-secondary" href="logout.php" aria-label="Salir">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-door-open" viewBox="0 0 16 16">
              <path d="M8.5 10c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1"/>
              <path d="M10.828.122A.5.5 0 0 1 11 .5V1h.5A1.5 1.5 0 0 1 13 2.5V15h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V1.5a.5.5 0 0 1 .43-.495l7-1a.5.5 0 0 1 .398.117M11.5 2H11v13h1V2.5a.5.5 0 0 0-.5-.5M4 1.934V15h6V1.077z"/>
            </svg>
          </a>
        </div>
  </div>
</nav>
<script src="bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
<?php
// Incluir archivo de conexión
include 'conexion.php';

// Crear la conexión
$conn = sqlsrv_connect($serverName, $connectionInfo);

// Verificar si la conexión fue exitosa
if ($conn === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Preparar y ejecutar la consulta
$sql = "{CALL sp_GetAllOrderDetailsWithRelations}";
$stmt = sqlsrv_query($conn, $sql);

// Verificar si la consulta fue exitosa
if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// HTML y CSS para tarjetas bonitas
echo '<style>
        .card-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin: 20px;
        }
        .card {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: calc(33% - 40px);
            box-sizing: border-box;
        }
        .card h3 {
            margin-top: 0;
            font-size: 1.2em;
            margin-bottom: 10px;
        }
        .card p {
            margin: 5px 0;
        }
    </style>';

echo '<div class="card-container">';

while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    echo '<div class="card">';
    echo '<h3>Order: ' . $row['order_id'] . '</h3>';
    echo '<p><strong>Item:</strong> ' . $row['item_id'] . '</p>';
    echo '<p><strong>Comapañia:</strong> ' . $row['company_nombre'] . ' (' . $row['company_id'] . ')</p>';
    echo '<p><strong>Producto:</strong> ' . $row['producto_nombre'] . ' (' . $row['product_id'] . ')</p>';
    echo '<p><strong>Descripcion:</strong> ' . $row['producto_descripcion'] . '</p>';
    echo '<p><strong>Cantidad:</strong> ' . $row['quantity'] . '</p>';
    echo '<p><strong>Precio Unitario:</strong> $' . $row['unit_price'] . '</p>';
    echo '<p><strong>Descuento:</strong> $' . $row['discount'] . '</p>';
    echo '<p><strong>IVA:</strong> $' . $row['iva'] . '</p>';
    echo '<p><strong>Total con Iva:</strong> $' . $row['total'] . '</p>';
    echo '<p><strong>Metodo de Pago:</strong> ' . $row['pago_metodo'] . '</p>';
    echo '<p><strong>Status del pago:</strong> ' . $row['pago_estado'] . '</p>';
    echo '<p><strong>Envio:</strong> ' . $row['envio_direccion'] . ', ' . $row['envio_ciudad'] . ', ' . $row['envio_pais'] . ' (' . $row['envio_codigo_postal'] . ')</p>';
    echo '<p><strong>Estatus del envio:</strong> ' . $row['envio_estado'] . '</p>';
    echo '<p><strong>Usuario:</strong> ' . $row['usuario_nombre'] . ' (' . $row['usuario_correo'] . ')</p>';
    echo '<p><strong>Fecha de la orden:</strong> ' . $row['fecha_creacion']->format('Y-m-d H:i:s') . '</p>';
    echo '<a href="gn.php?order_id=' . $row['order_id'] . '&company_id='  . $row['company_id'] . '" class="btn btn-outline-info">Descargar PDF</a>';
    echo '</div>';
}

echo '</div>';

// Liberar los recursos
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>
