<?php
session_start();
require_once "conexion.php";

if (isset($_POST["idUsuario"]) && isset($_POST["nuevoRol"])) {
   
    $idUsuario = $_POST["idUsuario"];
    $nuevoRol = $_POST["nuevoRol"];

   
    $queryRolAnterior = "SELECT rol_idRol FROM usuarios WHERE idUsuarios = ?";
    $stmtRolAnterior = $conn->prepare($queryRolAnterior);
    $stmtRolAnterior->bind_param("i", $idUsuario);
    $stmtRolAnterior->execute();
    $stmtRolAnterior->store_result();
    $stmtRolAnterior->bind_result($rolAnterior);
    $stmtRolAnterior->fetch();

    $queryActualizarRol = "UPDATE usuarios SET rol_idRol = ? WHERE idUsuarios = ?";
    $stmtActualizarRol = $conn->prepare($queryActualizarRol);
    $stmtActualizarRol->bind_param("ii", $nuevoRol, $idUsuario);

    if ($stmtActualizarRol->execute()) {
        if ($nuevoRol == 4) {
            $queryInsertarTecnico = "INSERT INTO tecnico (usuario_idUsuario, disponible) VALUES (?, 1)";
            $stmtInsertarTecnico = $conn->prepare($queryInsertarTecnico);
            $stmtInsertarTecnico->bind_param("i", $idUsuario);

            if ($stmtInsertarTecnico->execute()) {
                echo json_encode(array("success" => true));
            } else {
                echo json_encode(array("success" => false, "error" => "Error al insertar en la tabla de técnicos"));
            }

            $stmtInsertarTecnico->close();
        } else {
            
            if ($rolAnterior == 4) {
                $queryEliminarTecnico = "DELETE FROM tecnico WHERE usuario_idUsuario = ?";
                $stmtEliminarTecnico = $conn->prepare($queryEliminarTecnico);
                $stmtEliminarTecnico->bind_param("i", $idUsuario);

                if ($stmtEliminarTecnico->execute()) {
                    echo json_encode(array("success" => true));
                } else {
                    echo json_encode(array("success" => false, "error" => "Error al eliminar de la tabla de técnicos"));
                }

                $stmtEliminarTecnico->close();
            } else {
                echo json_encode(array("success" => true));
            }
        }
    } else {
        echo json_encode(array("success" => false, "error" => "Error al actualizar el rol del usuario"));
    }

    $stmtActualizarRol->close();
    $stmtRolAnterior->close();
    $conn->close();
} else {
    echo json_encode(array("success" => false, "error" => "Parámetros incompletos"));
}

