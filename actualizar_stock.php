<?php
require_once "conexion.php";

header('Content-Type: application/json'); // Establecer el tipo de contenido como JSON

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["codigo_producto"]) && isset($_POST["cantidadNueva"])) {
    $codigo_producto = $_POST["codigo_producto"];
    $cantidadNueva = $_POST["cantidadNueva"];

    $query = "UPDATE producto SET cantidad = cantidad + $cantidadNueva WHERE codigo_producto = '$codigo_producto'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "error", "message" => mysqli_error($conn)));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Invalid Request"));
}

