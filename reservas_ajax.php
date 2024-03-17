<?php
require "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servicioSeleccionado = $_POST["servicioSeleccionado"];

    // Obtener la información del servicio seleccionado
    $queryInfoServicio = "SELECT idServicio, nombreServicio, descripcionServicio, precio FROM servicios WHERE nombreServicio = '$servicioSeleccionado'";
    $resultInfoServicio = mysqli_query($conn, $queryInfoServicio);

    if ($resultInfoServicio) {
        $rowInfoServicio = mysqli_fetch_assoc($resultInfoServicio);
        $response = array('success' => true, 'data' => $rowInfoServicio);
        echo json_encode($response);
    } else {
        $response = array('success' => false, 'mensaje' => "Error al obtener información del servicio: " . mysqli_error($conn));
        echo json_encode($response);
    }
}

mysqli_close($conn);
?>
