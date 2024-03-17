<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION["nombre"]) || empty($_SESSION["nombre"])) {
    http_response_code(401); 
    exit("No autorizado");
}

$rolUsuario = $_SESSION["rol_idRol"];

if ($rolUsuario == 1) {
    $query = "SELECT ventas.idVenta, ventas.fechaVenta, ventas.total, ventas.dineroRecibido, ventas.cambio, usuarios.nombre AS nombreUsuario 
              FROM ventas 
              INNER JOIN usuarios ON ventas.idUsuario = usuarios.idUsuarios";
} else {
    $idUsuario = $_SESSION["rol"]; // Utiliza $_SESSION["idUsuarios"] en lugar de $_SESSION["idUsuario"]
    $query = "SELECT ventas.idVenta, ventas.fechaVenta, ventas.total, ventas.dineroRecibido, ventas.cambio, usuarios.nombre AS nombreUsuario 
              FROM ventas 
              INNER JOIN usuarios ON ventas.idUsuario = usuarios.idUsuarios 
              WHERE ventas.idUsuario = ?";
}

// Preparar la consulta
$stmt = $conn->prepare($query);

// Si el usuario no es administrador, bindear su ID a la consulta
if ($rolUsuario != 1) {
    $stmt->bind_param("i", $idUsuario); // Utiliza $idUsuario aquí
}

// Ejecutar la consulta
$stmt->execute();

// Obtener resultados
$result = $stmt->get_result();

// Crear un array para almacenar los reportes
$reportes = array();

// Iterar sobre los resultados y almacenarlos en el array
while ($row = $result->fetch_assoc()) {
    $reportes[] = $row;
}

// Cerrar la consulta
$stmt->close();

// Devolver los reportes en formato JSON
header("Content-type: application/json");
echo json_encode($reportes);
