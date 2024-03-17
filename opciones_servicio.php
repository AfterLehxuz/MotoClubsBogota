<?php
require "conexion.php";

$query = "SELECT nombreServicio FROM servicios";
$result = mysqli_query($conn, $query);

if ($result) {
    $opciones = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $opciones[] = $row['nombreServicio'];
    }

    $response = array('success' => true, 'data' => $opciones);
    echo json_encode($response);
} else {
    $response = array('success' => false, 'mensaje' => "Error al obtener opciones de servicio: " . mysqli_error($conn));
    echo json_encode($response);
}

mysqli_close($conn);

