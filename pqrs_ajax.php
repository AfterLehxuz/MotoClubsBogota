<?php
session_start();
$mensaje = "";
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION["nombre"]) && $_SESSION["nombre"] != '') {
        require "conexion.php";

        // Evitar inyección de SQL utilizando declaraciones preparadas
        $estado = "Activa";

        $query = $conn->prepare("INSERT INTO pqrs (tipo, descripcion, estado, cliente_idCliente) VALUES (?, ?, ?, ?)");
        $query->bind_param("sssi", $tipo, $descripcion, $estado, $cliente_idCliente);

        $tipo = $_POST["servicio"];
        $descripcion = $_POST["descripcion"];
        $cliente_idCliente = $_SESSION["rol"];

        if ($query->execute()) {
            $mensaje = "PQR enviada correctamente";
            $success = true; // Indicamos el éxito
        } else {
            $mensaje = "Error al enviar la PQR: " . $query->error;
        }

        $query->close();
        mysqli_close($conn);
    } else {
        $mensaje = "Debes iniciar sesión para poder enviar una PQR.";
    }
}

echo json_encode(array("success" => $success, "mensaje" => $mensaje));
