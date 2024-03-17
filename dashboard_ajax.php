<?php
require_once "conexion.php";

function obtenerTotalUsuarios($conn) {
    $sql = "SELECT COUNT(*) AS total FROM usuarios";
    $resultado = $conn->query($sql);
    $fila = $resultado->fetch_assoc();
    return $fila['total'];
}

function obtenerTotalReservas($conn) {
    $sql = "SELECT COUNT(*) AS total FROM Reserva";
    $resultado = $conn->query($sql);
    $fila = $resultado->fetch_assoc();
    return $fila['total'];
}

function obtenerTotalVentas($conn) {
    $sql = "SELECT COUNT(*) AS total FROM ventas";
    $resultado = $conn->query($sql);
    $fila = $resultado->fetch_assoc();
    return $fila['total'];
}

function obtenerTotalPQRS($conn) {
    $sql = "SELECT COUNT(*) AS total FROM pqrs";
    $resultado = $conn->query($sql);
    $fila = $resultado->fetch_assoc();
    return $fila['total'];
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    
    header('Content-Type: application/json');

    
    $totalUsuarios = obtenerTotalUsuarios($conn);
    $totalReservas = obtenerTotalReservas($conn);
    $totalVentas = obtenerTotalVentas($conn);
    $totalPQRS = obtenerTotalPQRS($conn);

    $conn->close();

    $totales = array(
        'usuarios' => $totalUsuarios,
        'reservas' => $totalReservas,
        'ventas' => $totalVentas,
        'pqrs' => $totalPQRS
    );

 
    echo json_encode($totales);
} else {
   
    http_response_code(405);
    echo json_encode(array("message" => "Método no permitido"));
}
