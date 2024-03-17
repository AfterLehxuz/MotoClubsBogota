<?php
require_once "conexion.php";

if (isset($_GET["term"])) {
    $term = $_GET["term"];

    $results = array();

    $query = "SELECT idServicio, nombreServicio, precio FROM servicios WHERE nombreServicio LIKE ?";
    $term = '%' . $term . '%';
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $term);
    $stmt->execute();
    $result = $stmt->get_result();
    $results = $result->fetch_all(MYSQLI_ASSOC);

    header("Content-type: application/json");
    echo json_encode($results);
    exit;
} else {
    header("HTTP/1.1 400 Bad Request");
    echo "Parámetros incorrectos";
    exit; 
}
?>
