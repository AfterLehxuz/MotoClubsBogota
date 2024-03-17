<?php
session_start();


function obtenerTecnicoDisponible($conn, $hora)
{
  
    $query = "SELECT t.idTecnico 
                FROM tecnico t
                LEFT JOIN disponibilidad_tecnico d ON t.idTecnico = d.tecnico_idTecnico AND d.hora = '$hora'
                LEFT JOIN reserva r ON t.idTecnico = r.tecnico_idTecnico AND r.hora = '$hora'
                WHERE t.disponible = true AND d.tecnico_idTecnico IS NULL AND r.idReserva IS NULL
                ORDER BY RAND() LIMIT 1";

    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row !== null && isset($row['idTecnico'])) {
            $tecnico_id = $row['idTecnico'];


            marcarTecnicoNoDisponible($conn, $tecnico_id, $hora);

            return $tecnico_id;
        } else {
            
            return false;
        }
    } else {
        // Error en la consulta
        echo "Error en la consulta: " . mysqli_error($conn);
        return false;
    }
}

function marcarTecnicoNoDisponible($conn, $tecnico_id, $hora)
{
    $query = "UPDATE disponibilidad_tecnico 
                SET disponible = 0 
                WHERE tecnico_idTecnico = '$tecnico_id' AND hora = '$hora'";

    if (!mysqli_query($conn, $query)) {
     
        echo "Error al marcar al técnico como no disponible: " . mysqli_error($conn);
    }
}


function asignarTecnicoReserva($conn, $reserva_id, $tecnico_id)
{
    $query = "UPDATE reserva SET tecnico_idTecnico = '$tecnico_id' WHERE idReserva = '$reserva_id'";

    if (mysqli_query($conn, $query)) {
        return true;
    } else {
        // Error al asignar técnico a la reserva
        echo "Error al asignar técnico: " . mysqli_error($conn);
        return false;
    }
}


function verificarDisponibilidadTecnico($conn, $tecnico_id)
{
    $query = "SELECT disponible FROM tecnico WHERE idTecnico = '$tecnico_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['disponible'] == true;
    } else {
        // Error en la consulta
        echo "Error en la consulta: " . mysqli_error($conn);
        return false;
    }
}

function validarFechaYHora($fecha, $hora)
{
   
    date_default_timezone_set('America/Bogota');

    $fechaActual = date('Y-m-d');
    $horaActual = date('h:i A'); 
    if ($fecha < $fechaActual) {
        return array('success' => false, 'mensaje' => "La fecha seleccionada es anterior a la fecha actual. Por favor, elige otra fecha.");
    }

   
    $minutos = date('i', strtotime($hora));
    if ($minutos != '00') {
        return array('success' => false, 'mensaje' => "Solo se permiten reservas en intervalos de horas completas. Por favor, selecciona una hora completa (por ejemplo, 6:00 AM, 7:00 AM, 8:00 AM).");
    }

    return array('success' => true, 'mensaje' => '');  
}




require "conexion.php";


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $descripcion = $_POST["descripcion"];
    $fecha = $_POST["fecha"];
    $hora = $_POST["hora"];
    $idServicio = $_POST["idServicio"];


    $validacionResult = validarFechaYHora($fecha, $hora);

    if (!$validacionResult['success']) {
 
        $mensaje = $validacionResult['mensaje'];
        $response = array('success' => false, 'mensaje' => $mensaje);
        echo json_encode($response);
        exit;
    } else {
     
        $tecnico_id = obtenerTecnicoDisponible($conn, $hora);

        if ($tecnico_id !== false && verificarDisponibilidadTecnico($conn, $tecnico_id)) {
          
            $cliente_idCliente = $_SESSION["rol"];
            $query = "INSERT INTO reserva (idServicio, descripcion, fecha, hora, cliente_idCliente) VALUES ('$idServicio', '$descripcion', '$fecha', '$hora', '$cliente_idCliente')";

            if (mysqli_query($conn, $query)) {
            
                $reserva_id = mysqli_insert_id($conn);

                if (asignarTecnicoReserva($conn, $reserva_id, $tecnico_id)) {
                    $mensaje = "Reserva realizada correctamente. Técnico asignado.";
                    $response = array('success' => true, 'mensaje' => $mensaje);
                    echo json_encode($response);
                    exit;
                } else {
                    $mensaje = "Reserva realizada correctamente, pero no se pudo asignar un técnico.";
                    $response = array('success' => false, 'mensaje' => $mensaje);
                    echo json_encode($response);
                    exit;
                }

            } else {    $mensaje = "Error al realizar la reserva: " . mysqli_error($conn);
                $response = array('success' => false, 'mensaje' => $mensaje);
                echo json_encode($response);
                exit;
            }
        } else {

            $mensaje = "No se encontraron técnicos disponibles en la hora seleccionada.";
            $response = array('success' => false, 'mensaje' => $mensaje);
            echo json_encode($response);
            exit;
        }
    }
}


mysqli_close($conn);