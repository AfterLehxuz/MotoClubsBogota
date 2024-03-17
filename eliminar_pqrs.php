<?php
session_start();

require_once "conexion.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['idPQRS']) && !empty($_POST['idPQRS'])) {

        $idPQRS = $_POST['idPQRS'];

      
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }


        $sql = "DELETE FROM pqrs WHERE idPqrs = $idPQRS";

        if ($conn->query($sql) === TRUE) {
    
            echo json_encode(array('success' => true));
        } else {

            echo json_encode(array('success' => false, 'error' => $conn->error));
        }

    
        $conn->close();
    } else {
    
        echo json_encode(array('success' => false, 'error' => 'ID de PQRS no proporcionado'));
    }
} else {  
  
    echo json_encode(array('success' => false, 'error' => 'Método de solicitud no válido'));
}

