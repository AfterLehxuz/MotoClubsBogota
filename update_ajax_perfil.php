<?php
session_start();
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_SESSION["nombre"]) || empty($_SESSION["nombre"])) {
        exit(json_encode(array("success" => false, "message" => "Usuario no autenticado")));
    }

    $idUsuarios = $_POST["idUsuarios"];
    $documentoID = $_POST["documentoID"];
    $nombre = $_POST["nombre"];
    $numero = $_POST["numero"];
    $email = $_POST["email"];
    $dirreccion = $_POST["dirreccion"];

    
    $queryOriginalDocumento = "SELECT documentoID FROM usuarios WHERE idUsuarios = $idUsuarios";
    $resultOriginalDocumento = $conn->query($queryOriginalDocumento);

    if (!$resultOriginalDocumento || $resultOriginalDocumento->num_rows !== 1) {
        exit(json_encode(array("success" => false, "message" => "Error al obtener el documento original")));
    }

    $row = $resultOriginalDocumento->fetch_assoc();
    $originalDocumento = $row["documentoID"];

    // Verificar si el nuevo documento ya existe para otro usuario
    $queryDocumento = "SELECT idUsuarios FROM usuarios WHERE documentoID = '$documentoID' AND idUsuarios != $idUsuarios";
    $resultDocumento = $conn->query($queryDocumento);

    if ($resultDocumento && $resultDocumento->num_rows > 0) {
        exit(json_encode(array("success" => false, "message" => "El documento ya está registrado para otro usuario")));
    }

    // Verificar si el nuevo correo electrónico ya existe para otro usuario
    $queryEmail = "SELECT idUsuarios FROM usuarios WHERE email = '$email' AND idUsuarios != $idUsuarios";
    $resultEmail = $conn->query($queryEmail);

    if ($resultEmail && $resultEmail->num_rows > 0) {
        exit(json_encode(array("success" => false, "message" => "El correo electrónico ya está registrado para otro usuario")));
    }

    // Actualizar los datos en la base de datos
    $queryUpdate = "UPDATE usuarios SET documentoID='$documentoID', nombre='$nombre', numero='$numero', email='$email', dirreccion='$dirreccion' WHERE idUsuarios = '$idUsuarios'";
    $resultUpdate = $conn->query($queryUpdate);

    if ($resultUpdate) {
        $_SESSION["nombre"] = $nombre;
        exit(json_encode(array("success" => true, "message" => "Datos actualizados correctamente")));
    } else {
        // Revertir el cambio del documento en caso de error
        $queryRevertDocumento = "UPDATE usuarios SET documentoID='$originalDocumento' WHERE idUsuarios = '$idUsuarios'";
        $conn->query($queryRevertDocumento);

        exit(json_encode(array("success" => false, "message" => "Error al actualizar datos")));
    }
} else {
    exit(json_encode(array("success" => false, "message" => "Solicitud no válida")));
}
?>
