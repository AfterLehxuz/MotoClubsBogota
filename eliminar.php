<?php
session_start();
require_once "conexion.php";

if (isset($_POST['idUsuario']) && !empty($_POST['idUsuario'])) {
    $idUsuario = $_POST['idUsuario'];

    $query = "DELETE FROM usuarios WHERE idUsuarios = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $idUsuario);

    if ($stmt->execute()) {
        $response = array('success' => true);
        echo json_encode($response);
    } else {
        $response = array('success' => false);
        echo json_encode($response);
    }
} else {
    $response = array('success' => false, 'message' => 'ID de usuario no proporcionado');
    echo json_encode($response);
}
?>
