<?php
require_once "conexion.php";

$sql = "SELECT * FROM proveedores";
$resultado = $conn->query($sql);

$proveedores = array();
while ($row = $resultado->fetch_assoc()) {
    $proveedores[] = $row;
}

echo json_encode($proveedores);

