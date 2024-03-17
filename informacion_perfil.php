<?php
session_start(); 

require_once "conexion.php";

if (!isset($_SESSION["nombre"]) || empty($_SESSION["nombre"])) {
   
    header("Location: login.php");
    exit;
}

$nombreUsuario = $_SESSION["nombre"];

$query = "SELECT * FROM usuarios WHERE nombre = '$nombreUsuario'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
  
    $documentoID = $row["documentoID"];
    $nombre = $row["nombre"];
    $email = $row["email"];
    $numero = $row["numero"];
    $dirreccion = $row["dirreccion"];

    // Devolver datos en formato JSON
    $response = array(
        'documentoID' => $documentoID,
        'nombre' => $nombre,
        'email' => $email,
        'numero' => $numero,
        'dirreccion' => $dirreccion
    );

    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // El usuario no fue encontrado en la base de datos
    exit("Error: Usuario no encontrado");
}

