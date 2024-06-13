<?php
include 'conexion.php';
function obtenerProductos($filtroNombre = null) {
    global $conn;
    $query = "SELECT * FROM Productos";
    if ($filtroNombre !== null) {
        $query .= " WHERE nombre LIKE ?";
    }
    $params = $filtroNombre !== null ? ["%$filtroNombre%"] : [];
    $result = sqlsrv_query($conn, $query, $params);
    if ($result === false) {
        die(print_r(sqlsrv_errors(), true));
    }
    $productos = '';
    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        $productos .= '<div class="col-md-3 mb-4 d-flex align-items-stretch">
                <div class="card w-100 d-flex flex-column mx-2 my-2">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">' . $row['nombre'] . '</h5>
                        <p class="card-text">' . $row['descripcion'] . '</p>
                        <p class="card-text">Precio: ' . $row['precio'] . '</p>
                        <p class="card-text">Stock: ' . $row['stock'] . '</p>

                        <div class="mt-auto">
                            <form action="acarrito.php" method="post">
                                <input type="hidden" name="producto_id" value="' . $row['product_id'] . '">
                                <input type="hidden" name="accion" value="agregar">
                            </form>
                        </div>
                    </div>
                </div>
            </div>';
    }
    return $productos;
}
$filtroNombre = isset($_GET['filtroNombre']) ? $_GET['filtroNombre'] : null;
$productos = obtenerProductos($filtroNombre);
?>