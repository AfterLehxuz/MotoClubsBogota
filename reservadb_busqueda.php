<?php
session_start();
require_once "conexion.php";

$term = $_GET["term"];

$query = "SELECT r.idReserva, r.descripcion, r.fecha, r.hora
          FROM reserva AS r
          LEFT JOIN servicios AS s ON r.idServicio = s.idServicio
          LEFT JOIN usuarios AS u ON r.cliente_idCliente = u.idUsuarios
          WHERE s.nombreServicio LIKE '%$term%' OR u.nombre LIKE '%$term%'";

$result = $conn->query($query);

$data = array();

while ($row = $result->fetch_assoc()) {
    $item = array(
        "idReserva" => $row["idReserva"],
        "descripcion" => $row["descripcion"],
        "fecha" => $row["fecha"],
        "hora" => $row["hora"]
    );
    $data[] = $item;
}

echo json_encode($data);

$conn->close();

