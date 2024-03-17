<?php
session_start();

if (isset($_POST["idProducto"]) && isset($_SESSION["idUsuarios"])) {
    // Obtener el ID del producto y el ID del cliente desde el formulario
    $idProducto = $_POST["idProducto"];
    $idCliente = $_SESSION["idUsuarios"];

    // Realizar la inserción en la tabla "carrito"
    require "conexion.php";
    
    // Verificar la cantidad disponible del producto
    $queryCantidadProducto = "SELECT cantidad FROM producto WHERE idProducto = $idProducto";
    $resultCantidadProducto = $conn->query($queryCantidadProducto);

    if ($resultCantidadProducto !== false && $resultCantidadProducto->num_rows > 0) {
        $rowCantidadProducto = $resultCantidadProducto->fetch_assoc();
        $cantidadDisponible = $rowCantidadProducto["cantidad"];

        if ($cantidadDisponible > 0) {
            // La cantidad del producto es mayor que 0, podemos agregarlo al carrito
            $fecha = date("Y-m-d"); // Obtiene la fecha actual en formato YYYY-MM-DD

            // Insertar en la tabla "carrito"
            $insertCarrito = "INSERT INTO carrito (cliente_idCliente, fecha, cantidad) VALUES ($idCliente, '$fecha', 1)";
            if ($conn->query($insertCarrito) === TRUE) {
                $carritoID = $conn->insert_id; // Obtiene el ID del carrito recién insertado

                // Insertar en la tabla "detalle_compra"
                $insertDetalleCompra = "INSERT INTO detalle_compra (carritoID, productoID) VALUES ($carritoID, $idProducto)";
                if ($conn->query($insertDetalleCompra) === TRUE) {
                    // Actualizar la cantidad del producto en la tabla "producto"
                    $nuevaCantidad = $cantidadDisponible - 1;
                    $updateCantidadProducto = "UPDATE producto SET cantidad = $nuevaCantidad WHERE idProducto = $idProducto";
                    if ($conn->query($updateCantidadProducto) === TRUE) {
                        $_SESSION["mensaje"][$idProducto] = "El producto se agregó al carrito con éxito.";

                        // Redirigir de nuevo a la página de productos
                        header("Location: repuestos.php");
                        exit;
                    } else {
                        echo "Error al actualizar la cantidad del producto: " . $conn->error;
                    }
                } else {
                    echo "Error al insertar en detalle_compra: " . $conn->error;
                }
            } else {
                echo "Error al insertar en carrito: " . $conn->error;
            }
        } else {
            // La cantidad del producto es 0, no se puede agregar al carrito
            $_SESSION["mensaje"][$idProducto] = "El producto no está disponible en stock.";
            header("Location: repuestos.php");
            exit;
        }
    } else {
        echo "Error al obtener la cantidad del producto: " . $conn->error;
    }
} else {
    // Si no se proporcionó el ID del producto o el usuario no ha iniciado sesión, puedes redirigir al usuario o mostrar un mensaje de error
    header("Location: error.php"); // Cambia "error.php" por la página de error apropiada
    exit;
}
?>
