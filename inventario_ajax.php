<?php
// inventario_ajax.php
require_once "conexion.php";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["buscarProducto"])) {
    $buscarProducto = $_POST["buscarProducto"];

    $query = "SELECT * FROM producto WHERE nombre LIKE '%$buscarProducto%' OR codigo_producto = '$buscarProducto'";
    $result = mysqli_query($conn, $query);

    $productos = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $productos[] = $row;
    }

    echo json_encode($productos);
} else {
    echo json_encode(array("error" => "Invalid Request"));
}
