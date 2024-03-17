<?php
require "conexion.php";

$productos = array();

$query = "SELECT * FROM producto ORDER BY idProducto";
$result = $conn->query($query);

if ($result !== false) {
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
}

header('Content-Type: application/json');
echo json_encode($productos);

