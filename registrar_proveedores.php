<?php
session_start();
require_once "conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
    $codigoProveedor = $_POST['Codigo_Proveedor'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $numero = $_POST['numero'];
    $dirreccion = $_POST['dirreccion'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response = array('success' => false, 'message' => 'El formato de email es inválido');
        echo json_encode($response);
        exit;
    }

    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM proveedores WHERE Codigo_Proveedor = ?");
    $stmt->bind_param("s", $codigoProveedor);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $countCodigoProveedor = $row['count'];
    $stmt->close();

    if ($countCodigoProveedor > 0) {
        $response = array('success' => false, 'message' => 'El código del proveedor ya está en uso');
        echo json_encode($response);
        exit;
    }

    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM proveedores WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $countEmail = $row['count'];
    $stmt->close();

    if ($countEmail > 0) {
        $response = array('success' => false, 'message' => 'El correo electrónico ya está en uso');
        echo json_encode($response);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO proveedores (Codigo_Proveedor, Nombre, Email, Telefono, Direccion) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $codigoProveedor, $nombre, $email, $numero, $dirreccion);
    $stmt->execute();
    $stmt->close();

    $response = array('success' => true, 'message' => 'Proveedor registrado exitosamente');
    echo json_encode($response);
    exit;
}

