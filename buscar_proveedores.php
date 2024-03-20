<?php
require_once "conexion.php"; 

if (isset($_GET['term'])) {
    $term = '%' . $_GET['term'] . '%';

    $query = "SELECT Nip, Codigo_Proveedor, Nombre, Telefono, Direccion, Email FROM proveedores WHERE Codigo_Proveedor LIKE ? OR Nombre LIKE ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $term, $term);
    $stmt->execute();
    $result = $stmt->get_result();

    $proveedores = array();

    while ($row = $result->fetch_assoc()) {
        $proveedor = array(
            'Nip' => $row['Nip'],
            'Codigo_Proveedor' => $row['Codigo_Proveedor'],
            'Nombre' => $row['Nombre'],
            'Telefono' => $row['Telefono'],
            'Direccion' => $row['Direccion'],
            'Email' => $row['Email']
        );
        $proveedores[] = $proveedor;
    }

    echo json_encode($proveedores);
}

