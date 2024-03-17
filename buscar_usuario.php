<?php
require_once "conexion.php"; 

if (isset($_GET['term'])) {
    $term = $_GET['term'];

    $query = "SELECT idUsuarios, documentoID, nombre, numero, dirreccion FROM usuarios WHERE documentoID LIKE '%$term%'";
    $result = mysqli_query($conn, $query);

    $usuarios = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $usuario = array(
            'idUsuarios' => $row['idUsuarios'],
            'documentoID' => $row['documentoID'],
            'nombre' => $row['nombre'],
            'numero' => $row['numero'],
            'dirreccion' => $row['dirreccion']

        );
        $usuarios[] = $usuario;
    }

    echo json_encode($usuarios);
}


