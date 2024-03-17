<?php
session_start();
require_once "conexion.php";

if (isset($_SESSION["nombre"]) && !empty($_SESSION["nombre"])) {
    
    $rolUsuario = $_SESSION["rol_idRol"];

    $allowedRoles = [1, 4];

    if (in_array($rolUsuario, $allowedRoles) ){
        $query = "SELECT r.idReserva, r.descripcion, r.fecha, r.hora, s.nombreServicio, u.nombre AS nombreUsuario
                  FROM reserva AS r
                  INNER JOIN servicios AS s ON r.idServicio = s.idServicio
                  LEFT JOIN usuarios AS u ON r.cliente_idCliente = u.idUsuarios";
    } else {
       
        $idUsuario = $_SESSION["rol"];
        
        $query = "SELECT r.idReserva, r.descripcion, r.fecha, r.hora, s.nombreServicio, u.nombre AS nombreUsuario
                  FROM reserva AS r
                  INNER JOIN servicios AS s ON r.idServicio = s.idServicio
                  LEFT JOIN usuarios AS u ON r.cliente_idCliente = u.idUsuarios
                  WHERE u.idUsuarios = $idUsuario";
    }

    $result = $conn->query($query);

    $data = array();

    while ($row = $result->fetch_assoc()) {
        $reserva = array(
            "idReserva" => $row["idReserva"],
            "descripcion" => $row["descripcion"],
            "fecha" => $row["fecha"],
            "hora" => $row["hora"],
            "nombreServicio" => $row["nombreServicio"],
            "nombreUsuario" => $row["nombreUsuario"]
        );

        $data[] = $reserva;
    }

    echo json_encode($data);
} else {
    echo json_encode(array('error' => 'No ha iniciado sesión.'));
}

$conn->close();

