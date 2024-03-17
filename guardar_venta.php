<?php
session_start();
require_once "conexion.php";

if (!isset($_SESSION["nombre"]) || empty($_SESSION["nombre"])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $idUsuario = $_POST["idUsuario"];
    $idProductos = isset($_POST["idProductos"]) ? json_decode($_POST["idProductos"], true) : [];
    $cantidades = isset($_POST["cantidades"]) ? json_decode($_POST["cantidades"], true) : [];
    $cambio = $_POST["cambio"];
    $total = $_POST["total"];
    $dineroRecibido = $_POST["dineroRecibido"];
    $idServicios = isset($_POST["idServicios"]) ? json_decode($_POST["idServicios"], true) : [];
    $precioServicio = isset($_POST["precioServicio"]) ? json_decode($_POST["precioServicio"], true) : [];
    
    
    $verificarUsuario = "SELECT COUNT(*) AS count FROM usuarios WHERE idUsuarios = ?";

    if ($stmtVerificar = $conn->prepare($verificarUsuario)) {
        $stmtVerificar->bind_param("i", $idUsuario);
        $stmtVerificar->execute();
        $stmtVerificar->bind_result($count);
        $stmtVerificar->fetch();
        $stmtVerificar->close();

        if ($count > 0) {

            $sql = "INSERT INTO ventas (fechaVenta, idUsuario, total, dineroRecibido, cambio) VALUES (NOW(), ?, ?, ?, ?)";

            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("iddd", $idUsuario, $total, $dineroRecibido, $cambio);

                if ($stmt->execute()) {

                    $idVenta = $conn->insert_id;

                    if ($idVenta > 0) {
                        
                        if (!empty($idProductos)) {
                            $queryDetallesProductos = "INSERT INTO detalles_ventas_productos (idVenta, idProducto, cantidad) VALUES (?, ?, ?)";
                            $stmtDetallesProductos = $conn->prepare($queryDetallesProductos);

                            foreach ($idProductos as $key => $idProducto) {
                                $cantidad = $cantidades[$key];
                                $stmtDetallesProductos->bind_param("iii", $idVenta, $idProducto, $cantidad);
                                $stmtDetallesProductos->execute();
                            }

                       
                            if ($stmtDetallesProductos->errno) {
                                echo "Error al insertar detalles de venta de productos: " . $stmtDetallesProductos->error;
                            }

                            $stmtDetallesProductos->close();

                       
                            foreach ($idProductos as $key => $idProducto) {
                                $cantidad = $cantidades[$key];
                                $sqlActualizarStock = "UPDATE producto SET cantidad = cantidad - ? WHERE idProducto = ?";
                                $stmtActualizarStock = $conn->prepare($sqlActualizarStock);
                                $stmtActualizarStock->bind_param("ii", $cantidad, $idProducto);
                                $stmtActualizarStock->execute();
                                $stmtActualizarStock->close();
                            }
                        }

                     
                        if (!empty($idServicios)) {
                            $queryDetallesServicios = "INSERT INTO detalles_ventas_servicios (idVenta, idServicio, precioServicio) VALUES (?, ?, ?)";
                            $stmtDetallesServicios = $conn->prepare($queryDetallesServicios);

                            foreach ($idServicios as $key => $idServicio) {
                                $precio = $precioServicio[$key];
                                $stmtDetallesServicios->bind_param("idd", $idVenta, $idServicio, $precio);
                                $stmtDetallesServicios->execute();
                            }

                       
                            if ($stmtDetallesServicios->errno) {
                                echo "Error al insertar detalles de venta de servicios: " . $stmtDetallesServicios->error;
                            }

                            $stmtDetallesServicios->close();
                        }

                        echo json_encode(["idVenta" => $idVenta]);
                    } else {
                        echo "Error al obtener el ID de la venta";
                    }
                } else {
                    echo "Error al registrar la venta: " . $stmt->error;
                }

                $stmt->close();
            } else {
                echo "Error en la preparación de la consulta para insertar venta: " . $conn->error;
            }
        } else {
       
        }
    } else {
        echo "Error en la preparación de la consulta para verificar usuario: " . $conn->error;
    }

    $conn->close();
} else {
    echo "Acceso no autorizado.";
}

