<?php
if (isset($_POST['proveedorId'])) {
    $proveedorId = $_POST['proveedorId'];

    require_once "conexion.php";

    $sql = "DELETE FROM proveedores WHERE Nip = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("s", $proveedorId);

    if ($stmt->execute()) {
        echo "Proveedor eliminado correctamente";
    } else {
        echo "Error al eliminar el proveedor";
    }

    $stmt->close();
    $conn->close();
} else {
  
    echo "ID de proveedor no válido";
}

