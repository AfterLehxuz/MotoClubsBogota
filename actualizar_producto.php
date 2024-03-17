<?php
session_start();
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idProducto = mysqli_real_escape_string($conn, $_POST["idProducto"]);
    $nombre = mysqli_real_escape_string($conn, $_POST["nombreProducto"]);
    $descripcion = mysqli_real_escape_string($conn, $_POST["descripcion"]);
    $costo = mysqli_real_escape_string($conn, $_POST["costo"]);
    $cantidad = mysqli_real_escape_string($conn, $_POST["cantidad"]);
    $codigo_producto = mysqli_real_escape_string($conn, $_POST["codigo_producto"]);
    $proveedor = mysqli_real_escape_string($conn, $_POST["proveedor"]);
    $rutaImagen = "";


    $queryVerificarCodigo = "SELECT COUNT(*) as total FROM producto WHERE codigo_producto = '$codigo_producto' AND idProducto != $idProducto";
    $resultadoCodigo = mysqli_query($conn, $queryVerificarCodigo);
    $filaCodigo = mysqli_fetch_assoc($resultadoCodigo);

    if ($filaCodigo['total'] > 0) {
        echo json_encode(array("status" => "error", "mensaje" => "El código del producto ya existe"));
        exit;
    }

    
    $queryVerificarNombre = "SELECT COUNT(*) as total FROM producto WHERE nombre = '$nombre' AND idProducto != $idProducto";
    $resultadoNombre = mysqli_query($conn, $queryVerificarNombre);
    $filaNombre = mysqli_fetch_assoc($resultadoNombre);

    if ($filaNombre['total'] > 0) {
        echo json_encode(array("status" => "error", "mensaje" => "El nombre del producto ya existe"));
        exit;
    }

   
    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] == 0) {
        $directorioImagenes = "Estilos/Inventario/";
        $nombreArchivo = basename($_FILES["imagen"]["name"]);
        $rutaImagen = $directorioImagenes . str_replace(' ', '_', $nombreArchivo);

        if (move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaImagen)) {
            // Eliminar imagen anterior si existe
            $sqlImagenAnterior = "SELECT rutaImagen FROM producto WHERE idProducto = $idProducto";
            $resultadoImagenAnterior = mysqli_query($conn, $sqlImagenAnterior);

            if ($resultadoImagenAnterior) {
                $filaImagenAnterior = mysqli_fetch_assoc($resultadoImagenAnterior);
                $imagenAnterior = $filaImagenAnterior['rutaImagen'];

                if (!empty($imagenAnterior) && file_exists($imagenAnterior)) {
                    unlink($imagenAnterior);
                }
            }
        } else {
            echo json_encode(array("status" => "error", "mensaje" => "Error al subir la nueva imagen."));
            exit;
        }
    }

    $queryActualizarProducto = "UPDATE producto 
                                SET nombre = '$nombre', descripcion = '$descripcion', costo = $costo, 
                                    cantidad = $cantidad, codigo_producto = '$codigo_producto', 
                                    proveedor_idProveedor = '$proveedor', rutaImagen = '$rutaImagen'
                                WHERE idProducto = $idProducto";

    if (mysqli_query($conn, $queryActualizarProducto)) {
        echo json_encode(array("status" => "success", "mensaje" => "Producto actualizado correctamente."));
    } else {
        echo json_encode(array("status" => "error", "mensaje" => "Error al actualizar el producto: " . mysqli_error($conn)));
    }

    // Cerrar la conexión
    $conn->close();
} else {
    echo json_encode(array("status" => "error", "mensaje" => "Método de solicitud no válido."));
}

