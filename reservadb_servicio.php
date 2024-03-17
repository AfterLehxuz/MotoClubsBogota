<?php
session_start();
require_once "conexion.php";

$term = $_GET["term"];

if (isset($_SESSION["nombre"]) && !empty($_SESSION["nombre"])) {
    $rolUsuario = $_SESSION["rol_idRol"];
    $idUsuario = ($rolUsuario != 1) ? $_SESSION["rol"] : null;

    if ($rolUsuario == 1 || $rolUsuario == 4) {
        $query = "SELECT s.nombreServicio, u.nombre AS nombreUsuario
                  FROM servicios AS s
                  LEFT JOIN reserva AS r ON s.idServicio = r.idServicio
                  LEFT JOIN usuarios AS u ON r.cliente_idCliente = u.idUsuarios
                  WHERE s.nombreServicio LIKE '%$term%'
                  GROUP BY s.nombreServicio";
    } else {
        $query = "SELECT s.nombreServicio, u.nombre AS nombreUsuario
                  FROM servicios AS s
                  LEFT JOIN reserva AS r ON s.idServicio = r.idServicio
                  LEFT JOIN usuarios AS u ON r.cliente_idCliente = u.idUsuarios
                  WHERE s.nombreServicio LIKE '%$term%' AND u.idUsuarios = $idUsuario
                  GROUP BY s.nombreServicio";
    }

    $result = $conn->query($query);

    $data = array();

    while ($row = $result->fetch_assoc()) {
        $itemServicio = array(
            "label" => $row["nombreServicio"] . " (Servicio)",
            "value" => $row["nombreServicio"],
            "type" => "servicio",
            "reservas" => obtenerReservas($row["nombreServicio"], $idUsuario, $rolUsuario, $conn)
        );
        $data[] = $itemServicio;
    }

    echo json_encode($data);
} else {
    echo json_encode(array('error' => 'No ha iniciado sesión.'));
}

$conn->close();

function obtenerReservas($nombreServicio, $idUsuario, $rolUsuario, $conn)
{
    $query = "SELECT r.idReserva, r.descripcion, r.fecha, r.hora
              FROM reserva AS r
              INNER JOIN servicios AS s ON r.idServicio = s.idServicio";

    if ($rolUsuario == 1 || $rolUsuario == 4) {
        $query .= " WHERE s.nombreServicio = '$nombreServicio'";
    } else {
        $query .= " INNER JOIN usuarios AS u ON r.cliente_idCliente = u.idUsuarios
                    WHERE s.nombreServicio = '$nombreServicio' AND u.idUsuarios = $idUsuario";
    }

    $result = $conn->query($query);

    $reservas = array();

    while ($row = $result->fetch_assoc()) {
        $reserva = array(
            "idReserva" => $row["idReserva"],
            "descripcion" => $row["descripcion"],
            "fecha" => $row["fecha"],
            "hora" => $row["hora"]
        );
        $reservas[] = $reserva;
    }

    return $reservas;
}
?>

