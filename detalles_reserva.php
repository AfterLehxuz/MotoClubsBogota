<?php

require_once "conexion.php";



if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

$idReserva = $_GET['idReserva'];


$sql = "SELECT r.*, s.* FROM reserva r 
        LEFT JOIN servicios s ON r.idServicio = s.idServicio 
        WHERE r.idReserva = $idReserva";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
   
    $data = $result->fetch_assoc();


    echo json_encode(array('success' => true, 'data' => $data));
} else {
    echo json_encode(array('success' => false));
}

$conn->close();
