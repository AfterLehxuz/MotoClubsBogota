<?php
session_start();
require_once "conexion.php";

if (isset($_POST["idReserva"])) {
    $idReserva = $_POST["idReserva"];

    // Realiza la lógica para eliminar la reserva en la base de datos
    $query = "DELETE FROM reserva WHERE idReserva = $idReserva";
    $result = $conn->query($query);

    if ($result) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $conn->error]);
    }

    $conn->close();
} else {
    echo json_encode(["success" => false, "error" => "No se proporcionó el ID de la reserva"]);
}

