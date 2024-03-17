<?php
session_start();
require_once "conexion.php";

if (isset($_SESSION["nombre"]) && !empty($_SESSION["nombre"])) {
    $rolUsuario = $_SESSION["rol_idRol"];

    if ($rolUsuario == 1) {
        $query = "SELECT p.idPqrs, p.tipo, p.descripcion, p.fecha, p.estado, p.respuesta, p.resuelta, u.nombre AS nombre_usuario
                  FROM pqrs AS p
                  INNER JOIN usuarios AS u ON p.cliente_idCliente = u.idUsuarios";
    } else {
        $idUsuario = $_SESSION["rol"];

        $query = "SELECT p.idPqrs, p.tipo, p.descripcion, p.fecha, p.estado, p.respuesta, p.resuelta, u.nombre AS nombre_usuario
                  FROM pqrs AS p
                  INNER JOIN usuarios AS u ON p.cliente_idCliente = u.idUsuarios
                  WHERE u.idUsuarios = $idUsuario";
    }

    $result = $conn->query($query);

    $data = array();

    while ($row = $result->fetch_assoc()) {
        $pqrs = array(
            "idPQRS" => $row["idPqrs"],
            "tipo" => $row["tipo"],
            "descripcion" => $row["descripcion"],
            "fecha" => $row["fecha"],
            "estado" => $row["estado"],
            "nombre_usuario" => $row["nombre_usuario"],
            "rolUsuario" => $rolUsuario,
        );

        if ($rolUsuario != 1) {
            $pqrs["respuesta"] = $row["respuesta"];
            $pqrs["resuelta"] = $row["resuelta"];
        }else{
            $pqrs["respuesta"] = $row["respuesta"];
            $pqrs["resuelta"] = $row["resuelta"];
        }

        $data[] = $pqrs;
    }

    echo json_encode($data);
} else {
    echo json_encode(array('error' => 'No ha iniciado sesión.'));
}

$conn->close();

