<?php
session_start();
require_once "conexion.php";
require_once 'vendor/autoload.php';

use Dompdf\Dompdf;

$rolUsuario = isset($_SESSION['rol_idRol']) ? $_SESSION['rol_idRol'] : '';

$periodo = $_GET['periodo'];

$fechaInicio = '';
$fechaFin = '';

switch ($periodo) {
    case 'semanal':
        $fechaInicio = date('Y-m-d', strtotime('last Sunday'));
        $fechaFin = date('Y-m-d', strtotime('next Saturday'));
        break;
    case 'mensual':
        $fechaInicio = date('Y-m-01');
        $fechaFin = date('Y-m-t');
        break;
    case 'anual':
        $fechaInicio = date('Y-01-01');
        $fechaFin = date('Y-12-31');
        break;
    default:
        echo "Período no válido.";
        exit; // Terminar la ejecución si el período no es válido
}

// Modificar la consulta para seleccionar las ventas asociadas con el usuario si no es un administrador
if ($rolUsuario != 1) {
    $idUsuario = $_SESSION["rol"];
    $query = "SELECT v.idVenta, v.fechaVenta, v.total, v.dineroRecibido, v.cambio, u.nombre AS nombreUsuario
     FROM ventas v
     JOIN usuarios u ON v.idUsuario = u.idUsuarios
     WHERE v.idUsuario =  $idUsuario AND v.fechaVenta BETWEEN ? AND ?";
} else {
    // Si el usuario es un administrador
    $query = "SELECT v.idVenta, v.fechaVenta, v.total, v.dineroRecibido, v.cambio, u.nombre AS nombreUsuario
     FROM ventas v
     JOIN usuarios u ON v.idUsuario = u.idUsuarios
     WHERE v.fechaVenta BETWEEN ? AND ?";
}

if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("ss", $fechaInicio, $fechaFin);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows > 0) {
        $dompdf = new Dompdf();

        $html = "<html>
        <head>
            <style>
                table {
                    border-collapse: collapse;
                    width: 100%;
                }
                th, td {
                    border: 1px solid black;
                    padding: 8px;
                    text-align: left;
                    font-size: 12px; 
                }
                th {
                    background-color: #f2f2f2; 
                }
                .header {
                    text-align: left; /* Alinear el texto del encabezado a la izquierda */
                    margin-bottom: 20px; /* Agregar espacio inferior para separar el logo del título */
                }
                .logo img {
                    max-width: 200px; /* Ajustar el tamaño máximo del logo */
                }
            </style>
        </head>
        <body>
            <div class='header'> 
                <div class='logo'>
                    <img src='Imagenes/Logo.png' alt='Logo de la empresa'>
                </div>
                <h2>Reporte de Ventas moto clubs</h2>
            </div>";

        while ($row = $result->fetch_assoc()) {
            $html .= "<h3>ID Venta: {$row['idVenta']}</h3>
                      <p>Fecha Venta: {$row['fechaVenta']}</p>
                      <p>Total: {$row['total']}</p>
                      <p>Dinero Recibido: {$row['dineroRecibido']}</p>
                      <p>Cambio: {$row['cambio']}</p>
                      <p>Nombre Usuario: {$row['nombreUsuario']}</p>";

            
            $html .= "<h4>Productos:</h4>
                      <table>
                        <tr>
                            <th>Nombre Producto</th>
                            <th>Precio Producto</th>
                            <th>Cantidad Producto</th>
                        </tr>";

            $queryProductos = "SELECT p.nombre AS nombreProducto, p.costo AS precioProducto, dp.cantidad AS cantidadProducto
                              FROM detalles_ventas_productos dp
                              LEFT JOIN producto p ON dp.idProducto = p.idProducto
                              WHERE dp.idVenta = {$row['idVenta']}";

            $resultProductos = $conn->query($queryProductos);

            if ($resultProductos->num_rows > 0) {
                while ($producto = $resultProductos->fetch_assoc()) {
                    $html .= "<tr>
                                <td>{$producto['nombreProducto']}</td>
                                <td>{$producto['precioProducto']}</td>
                                <td>{$producto['cantidadProducto']}</td>
                            </tr>";
                }
            } else {
                $html .= "<tr>
                            <td colspan='3'>No se encontraron productos para esta venta.</td>
                        </tr>";
            }

            $html .= "</table>";

            
            $html .= "<h4>Servicios:</h4>
                      <table>
                        <tr>
                            <th>Nombre Servicio</th>
                            <th>Precio Servicio</th>
                        </tr>";

            $queryServicios = "SELECT s.nombreServicio AS nombreServicio, ds.precioServicio AS precioServicio
                              FROM detalles_ventas_servicios ds
                              LEFT JOIN servicios s ON ds.idServicio = s.idServicio
                              WHERE ds.idVenta = {$row['idVenta']}";

            $resultServicios = $conn->query($queryServicios);

            if ($resultServicios->num_rows > 0) {
                while ($servicio = $resultServicios->fetch_assoc()) {
                    $html .= "<tr>
                                <td>{$servicio['nombreServicio']}</td>
                                <td>{$servicio['precioServicio']}</td>
                            </tr>";
                }
            } else {
                $html .= "<tr>
                            <td colspan='2'>No se encontraron servicios para esta venta.</td>
                        </tr>";
            }

            $html .= "</table>";
        }

        $html .= "</body></html>";

        $dompdf->loadHtml($html);
        $dompdf->render();
        $pdfContent = $dompdf->output();

      
        if ($rolUsuario == 1) {
         
            header('Content-Type: application/pdf');
            header('Content-Disposition: inline; filename="reporte_ventas_completo.pdf"');
            echo $pdfContent;
        } else {
         
            echo '<iframe src="data:application/pdf;base64,'.base64_encode($pdfContent).'" width="100%" height="100%"></iframe>';
        }

    } else {
        echo "No se encontraron detalles asociados a esta venta.";
    }
} else {
    echo "Error en la preparación de la consulta: " . $conn->error;
}

$conn->close();

