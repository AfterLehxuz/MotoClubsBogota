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

if ($stmt = $conn->prepare($query)) {
    $stmt->bind_param("i", $idVenta);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows > 0) {
       
        $spreadsheet = new Spreadsheet();

        // Obtener la hoja activa
        $sheet = $spreadsheet->getActiveSheet();

        // Añadir encabezados de columna
        $sheet->setCellValue('A1', 'ID Venta');
        $sheet->setCellValue('B1', 'Fecha Venta');
        $sheet->setCellValue('C1', 'Total');
        $sheet->setCellValue('D1', 'Dinero Recibido');
        $sheet->setCellValue('E1', 'Cambio');
        $sheet->setCellValue('F1', 'Nombre Usuario');
        $sheet->setCellValue('G1', 'Nombre Producto');
        $sheet->setCellValue('H1', 'Costo Producto');
        $sheet->setCellValue('I1', 'Cantidad Producto');
        $sheet->setCellValue('J1', 'Nombre Servicio');
        $sheet->setCellValue('K1', 'Precio Servicio');

        // Fila actual
        $row = 2;

        while ($row = $result->fetch_assoc()) {
            $sheet->setCellValue('A' . $row, $row['idVenta']);
            $sheet->setCellValue('B' . $row, $row['fechaVenta']);
            $sheet->setCellValue('C' . $row, $row['total']);
            $sheet->setCellValue('D' . $row, $row['dineroRecibido']);
            $sheet->setCellValue('E' . $row, $row['cambio']);
            $sheet->setCellValue('F' . $row, $row['nombreUsuario']);
            $sheet->setCellValue('G' . $row, $row['nombreProducto']);
            $sheet->setCellValue('H' . $row, $row['costoProducto']);
            $sheet->setCellValue('I' . $row, $row['cantidadProducto']);
            $sheet->setCellValue('J' . $row, $row['nombreServicio']);
            $sheet->setCellValue('K' . $row, $row['precioServicio']);
        }

        // Crear un objeto de escritura para guardar el archivo
        $writer = new Xlsx($spreadsheet);

        // Guardar el archivo Excel en el directorio deseado
        $excelFilePath = 'ventas_' . $idVenta . '.xlsx';
        $writer->save($excelFilePath);

        // Descargar el archivo Excel generado
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $excelFilePath . '"');
        header('Cache-Control: max-age=0');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($excelFilePath));
        readfile($excelFilePath);
        exit;

    } else {
        echo "No se encontraron detalles asociados a esta venta.";
    }
} else {
    echo "Error en la preparación de la consulta: " . $conn->error;
}

$conn->close();

