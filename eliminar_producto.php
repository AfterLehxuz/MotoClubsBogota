<?php
session_start();

require_once "conexion.php";

// Verificar la existencia de la sesión y el rol
if (isset($_SESSION["rol_idRol"]) && $_SESSION["rol_idRol"] == 1) {
    if (isset($_POST["idProducto"])) {
        $idProducto = $_POST["idProducto"];

        // Realizar la lógica para eliminar el producto con el id proporcionado
        $sql = "DELETE FROM producto WHERE idProducto = $idProducto";
        $result = $conn->query($sql);

        if ($result) {
            // Enviar una respuesta de éxito si la eliminación fue exitosa
            echo json_encode(array("status" => "success"));
        } else {
            // Enviar una respuesta de error si hubo un problema al eliminar
            echo json_encode(array("status" => "error", "message" => $conn->error));
        }
    } else {
        // Enviar una respuesta de error si no se proporcionó el id del producto
        echo json_encode(array("status" => "error", "message" => "ID de producto no proporcionado"));
    }
} else {
    // Enviar una respuesta de error si el usuario no tiene los permisos adecuados
    echo json_encode(array("status" => "error", "message" => "Acceso denegado"));
}

$conn->close();

