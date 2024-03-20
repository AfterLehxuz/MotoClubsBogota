<?php
session_start();

require_once "conexion.php";

if (isset($_SESSION["rol_idRol"]) && $_SESSION["rol_idRol"] == 1) {
    if (isset($_POST["idProducto"])) {
        $idProducto = $_POST["idProducto"];

        $sql = "DELETE FROM producto WHERE idProducto = $idProducto";
        $result = $conn->query($sql);

        if ($result) {
            echo json_encode(array("status" => "success"));
        } else {
            echo json_encode(array("status" => "error", "message" => $conn->error));
        }
    } else {
        echo json_encode(array("status" => "error", "message" => "ID de producto no proporcionado"));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Acceso denegado"));
}

$conn->close();

