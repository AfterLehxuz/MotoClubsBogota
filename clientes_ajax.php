<?php
require_once "conexion.php";

$query = "SELECT * FROM usuarios";
$result = mysqli_query($conn, $query);

$usuarios = array();

while ($row = mysqli_fetch_assoc($result)) {
    $usuarios[] = $row;
}

echo json_encode($usuarios);

