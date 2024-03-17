<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION["nombre"]) || empty($_SESSION["nombre"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = mysqli_real_escape_string($conn, $_POST["nombre"]);
    $descripcion = mysqli_real_escape_string($conn, $_POST["descripcion"]);
    $costo = mysqli_real_escape_string($conn, $_POST["costo"]);
    $cantidad = mysqli_real_escape_string($conn, $_POST["cantidad"]);
    $codigo_producto = mysqli_real_escape_string($conn, $_POST["codigo_producto"]);
    $proveedor = mysqli_real_escape_string($conn, $_POST["proveedor"]);
    $rutaImagen = "";

    $queryVerificarCodigo = "SELECT COUNT(*) as total FROM producto WHERE codigo_producto = '$codigo_producto'";
    $resultadoCodigo = mysqli_query($conn, $queryVerificarCodigo);
    $filaCodigo = mysqli_fetch_assoc($resultadoCodigo);

    if ($filaCodigo['total'] > 0) {
        echo json_encode(array("error" => true, "mensaje" => "Error: El código de producto ya existe. Introduce un código único."));
        exit;
    }

    $queryVerificarNombre = "SELECT COUNT(*) as total FROM producto WHERE nombre = '$nombre'";
    $resultadoNombre = mysqli_query($conn, $queryVerificarNombre);
    $filaNombre = mysqli_fetch_assoc($resultadoNombre);

    if ($filaNombre['total'] > 0) {
        echo json_encode(array("error" => true, "mensaje" => "Error: El nombre de producto ya existe. Introduce un nombre único."));
        exit;
    }

    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
        $directorioImagenes = "Estilos/Inventario/";
        $nombreArchivo = basename($_FILES["imagen"]["name"]);
        $rutaImagen = $directorioImagenes . str_replace(' ', '_', $nombreArchivo);

        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaImagen)) {
        } else {
            echo json_encode(array("error" => true, "mensaje" => "Error al subir la imagen."));
            exit;
        }
    }

    $queryInsertarProducto = "INSERT INTO producto (nombre, descripcion, costo, cantidad, codigo_producto, proveedor_idProveedor, rutaImagen) 
                              VALUES ('$nombre', '$descripcion', $costo, $cantidad, '$codigo_producto', '$proveedor', '$rutaImagen')";

    if (mysqli_query($conn, $queryInsertarProducto)) {
        echo json_encode(array("error" => false, "mensaje" => "Producto agregado correctamente."));
    } else {
        echo json_encode(array("error" => true, "mensaje" => "Error al agregar el producto: " . mysqli_error($conn)));
    }

    // Cerrar la conexión
    $conn->close();
} else {
    echo json_encode(array("error" => true, "mensaje" => "Método de solicitud no válido."));
}

