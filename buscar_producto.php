<?php
require_once "conexion.php"; 

if (isset($_GET['term'])) {
    $term = $_GET['term'];

    // Modificar la consulta para incluir un filtro por cantidad mayor que cero
    $query = "SELECT idProducto, nombre, costo, cantidad, descripcion, codigo_producto FROM producto WHERE (nombre LIKE '%$term%' OR codigo_producto LIKE '%$term%') AND cantidad > 0";
    $result = mysqli_query($conn, $query);

    $productos = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $producto = array(
            'idProducto' => $row['idProducto'],
            'codigo_producto' => $row['codigo_producto'],
            'nombre' => $row['nombre'],
            'costo' => $row['costo'],
            'cantidad' => $row['cantidad'],
            'descripcion' => $row['descripcion']

        );
        $productos[] = $producto;
    }

    echo json_encode($productos);
}


