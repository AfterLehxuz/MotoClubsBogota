<?php
session_start();
require_once "conexion.php";
require_once 'vendor/autoload.php';

use Dompdf\Dompdf;

$idVenta = $_GET['idVenta'];

$query = "SELECT v.idVenta, v.fechaVenta, v.total, v.dineroRecibido, v.cambio, u.nombre AS nombreUsuario,
         p.nombre AS nombreProducto, p.costo AS costoProducto, dp.cantidad AS cantidadProducto,
         s.nombreServicio AS nombreServicio, ds.precioServicio
     FROM ventas v
     JOIN usuarios u ON v.idUsuario = u.idUsuarios
     LEFT JOIN detalles_ventas_productos dp ON v.idVenta = dp.idVenta
     LEFT JOIN producto p ON dp.idProducto = p.idProducto
     LEFT JOIN detalles_ventas_servicios ds ON v.idVenta = ds.idVenta
     LEFT JOIN servicios s ON ds.idServicio = s.idServicio
     WHERE v.idVenta = ?";

if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("i", $idVenta);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows > 0) {

        $dompdf = new Dompdf();

        $html = '<html>
                    <head>
                        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                        <style>
                            body {
                                font-family: Arial, sans-serif;
                                background-color: #f8f9fa;
                                padding: 20px;
                            }
                            .receipt-container {
                                background-color: #fff;
                                border-radius: 10px;
                                padding: 30px;
                                box-shadow: 0 0 10px rgba(0,0,0,0.1);
                            }
                            .receipt-header {
                                text-align: center;
                                margin-bottom: 30px;
                            }
                            .receipt-header h1 {
                                color: #007bff;
                            }
                            .receipt-info {
                                margin-bottom: 20px;
                            }
                            .detail-row {
                                border-top: 1px solid #dee2e6;
                                padding: 10px 0;
                            }
                            .detail-row:last-child {
                                border-bottom: 1px solid #dee2e6;
                            }
                            .subtotal {
                                font-weight: bold;
                            }
                        </style>
                    </head>
                    <body>
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-md-8">
                                    <div class="receipt-container">
                                        <div class="receipt-header">
                                            <h1>Moto Clubs Bogota</h1>
                                        </div>';

        // Obtener una vez la información del encabezado y del pie de página
        $row = $result->fetch_assoc();
        $html .= '<div class="receipt-info">';
        $html .= '<p><strong>Fecha de Venta:</strong> ' . $row['fechaVenta'] . '</p>';
        $html .= '<p><strong>Total:</strong> $' . $row['total'] . '</p>';
        $html .= '<p><strong>Dinero Recibido:</strong> $' . $row['dineroRecibido'] . '</p>';
        $html .= '<p><strong>Cambio:</strong> $' . $row['cambio'] . '</p>';
        $html .= '<p><strong>Nombre del Usuario:</strong> ' . $row['nombreUsuario'] . '</p>';

        $productos = array();
        $servicios = array();
        $productos_vendidos = array(); // Array para rastrear los productos vendidos
        $servicios_agregados = array(); // Array para rastrear los servicios agregados

        do {
            if (!is_null($row['nombreProducto']) && !in_array($row['nombreProducto'], $productos_vendidos)) {
                $subtotalProducto = $row['cantidadProducto'] * $row['costoProducto'];
                $productos[] = '<div class="detail-row">
                            <strong>Producto:</strong> ' . $row['nombreProducto'] . ' - 
                            <strong>Cantidad:</strong> ' . $row['cantidadProducto'] . ' - 
                            <strong>Precio:</strong> $' . $row['costoProducto'] . ' - 
                            <strong>Subtotal:</strong> $' . $subtotalProducto . '
                        </div>';
                $productos_vendidos[] = $row['nombreProducto']; // Agregar el producto al array de productos vendidos
            }

            if (!is_null($row['nombreServicio']) && !in_array($row['nombreServicio'], $servicios_agregados)) {
                $servicios[] = '<div class="detail-row">
                            <strong>Servicio:</strong> ' . $row['nombreServicio'] . ' - 
                            <strong>Precio:</strong> $' . $row['precioServicio'] . '
                        </div>';
                $servicios_agregados[] = $row['nombreServicio']; // Agregar el servicio al array de servicios agregados
            }
        } while ($row = $result->fetch_assoc());

        // Imprimir detalles de productos
        foreach ($productos as $producto) {
            $html .= $producto;
        }

        // Imprimir detalles de servicios
        foreach ($servicios as $servicio) {
            $html .= $servicio;
        }

        $html .= '</div>'; // Cierre de receipt-info
        $html .= '</div>'; // Cierre de receipt-container
        $html .= '</div>'; // Cierre de col-md-8
        $html .= '</div>'; // Cierre de row
        $html .= '</div>'; // Cierre de container
        $html .= '</body>'; // Cierre de body
        $html .= '</html>'; // Cierre de html

        $dompdf->loadHtml($html);
        $dompdf->render();

        $pdfContent = $dompdf->output();

        header("Content-Type: application/pdf");
        header("Content-Length: " . strlen($pdfContent));
        header("Content-Disposition: inline; filename='recibo_venta_" . $idVenta . ".pdf'");

        echo $pdfContent;

    } else {
        echo "No se encontraron detalles asociados a esta venta.";
    }
} else {
    echo "Error en la preparación de la consulta: " . $conn->error;
}

$conn->close();
