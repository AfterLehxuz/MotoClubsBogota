<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION["nombre"]) || empty($_SESSION["nombre"])) {
    echo json_encode(array('success' => false, 'message' => 'No hay una sesión activa'));
    exit;
}

$nip = $_POST['idProveedor']; 
$codigoProveedor = $_POST['codigoProveedor'];
$nombre = $_POST['nombre'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$direccion = $_POST['direccion'];

$stmt = $conn->prepare("SELECT COUNT(*) AS count FROM proveedores WHERE Codigo_Proveedor = ? AND Nip != ?");
$stmt->bind_param("si", $codigoProveedor, $nip);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$countCodigo = $row['count'];
$stmt->close();

$stmt = $conn->prepare("SELECT COUNT(*) AS count FROM proveedores WHERE Email = ? AND Nip != ?");
$stmt->bind_param("si", $email, $nip);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$countEmail = $row['count'];
$stmt->close();

if ($countCodigo > 0) {
    echo json_encode(array('success' => false, 'message' => 'El código de proveedor ya está en uso'));
    exit;
}

if ($countEmail > 0) {
    echo json_encode(array('success' => false, 'message' => 'El correo electrónico ya está en uso'));
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(array('success' => false, 'message' => 'El formato de email es inválido'));
    exit;
}

if (strlen($telefono) !== 10) {
    echo json_encode(array('success' => false, 'message' => 'El número de teléfono debe tener 10 dígitos'));
    exit;
}

$stmt = $conn->prepare("UPDATE proveedores SET Codigo_Proveedor = ?, Nombre = ?, Email = ?, Telefono = ?, Direccion = ? WHERE Nip = ?");
$stmt->bind_param("sssssi", $codigoProveedor, $nombre, $email, $telefono, $direccion, $nip);
$stmt->execute();
$stmt->close();

echo json_encode(array('success' => true, 'message' => 'Proveedor actualizado exitosamente'));
exit;

