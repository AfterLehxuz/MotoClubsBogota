<?php
session_start();
require_once "conexion.php";
require_once 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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

error_log("Consulta SQL: $query"); // Registro de la consulta SQL

if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("i", $idVenta);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows > 0) {
        error_log("Número de filas encontradas: " . $result->num_rows); // Registro del número de filas encontradas

        // Crear un nuevo objeto Spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Encabezados de las columnas
        $sheet->setCellValue('A1', 'ID Venta');
        $sheet->setCellValue('B1', 'Fecha de Venta');
        $sheet->setCellValue('C1', 'Total');
        $sheet->setCellValue('D1', 'Dinero Recibido');
        $sheet->setCellValue('E1', 'Cambio');
        $sheet->setCellValue('F1', 'Nombre del Usuario');
        $sheet->setCellValue('G1', 'Nombre del Producto');
        $sheet->setCellValue('H1', 'Costo del Producto');
        $sheet->setCellValue('I1', 'Cantidad del Producto');
        $sheet->setCellValue('J1', 'Nombre del Servicio');
        $sheet->setCellValue('K1', 'Precio del Servicio');

        // Escribir datos de los usuarios en el archivo Excel
        $row = 2;
        while ($row_data = $result->fetch_assoc()) {
            error_log("Fila de datos: " . print_r($row_data, true)); // Registro de los datos de cada fila
            $sheet->setCellValue('A' . $row, $row_data['idVenta']);
            $sheet->setCellValue('B' . $row, $row_data['fechaVenta']);
            $sheet->setCellValue('C' . $row, $row_data['total']);
            $sheet->setCellValue('D' . $row, $row_data['dineroRecibido']);
            $sheet->setCellValue('E' . $row, $row_data['cambio']);
            $sheet->setCellValue('F' . $row, $row_data['nombreUsuario']);
            $sheet->setCellValue('G' . $row, $row_data['nombreProducto']);
            $sheet->setCellValue('H' . $row, $row_data['costoProducto']);
            $sheet->setCellValue('I' . $row, $row_data['cantidadProducto']);
            $sheet->setCellValue('J' . $row, $row_data['nombreServicio']);
            $sheet->setCellValue('K' . $row, $row_data['precioServicio']);
            $row++;
        }

        // Establecer el formato de salida para Xlsx (Excel 2007 y posteriores)
        $writer = new Xlsx($spreadsheet);
        $filename = "venta_" . $idVenta . ".xlsx";

        // Descargar el archivo Excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Escribir el archivo en la salida (output)
        $writer->save('php://output');

    } else {
        echo "No se encontraron detalles asociados a esta venta.";
    }
} else {
    echo "Error en la preparación de la consulta: " . $conn->error;
}

$conn->close();

