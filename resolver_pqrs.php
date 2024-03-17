<?php
session_start();
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["idPQRS"]) && isset($_POST["respuesta"])) {
    $idPQRS = $_POST["idPQRS"];
    $respuesta = $_POST["respuesta"];

    // Lógica para resolver la PQRS
    $resuelta = true;
    $estadoInactivo = 'Inactiva';

    // Actualizar la PQRS con respuesta, marcándola como resuelta e inactiva
    $query = "UPDATE pqrs SET respuesta = ?, resuelta = ?, estado = ? WHERE idPqrs = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $respuesta, $resuelta, $estadoInactivo, $idPQRS);

    $success = $stmt->execute();
    $stmt->close();

    if ($success) {
        echo json_encode(array('success' => true, 'message' => 'La PQRS ha sido resuelta e inactiva.'));
    } else {
        echo json_encode(array('success' => false, 'message' => 'Hubo un error al resolver la PQRS.'));
    }
} else {
    echo json_encode(array('error' => 'Solicitud no válida.'));
}

$conn->close();

