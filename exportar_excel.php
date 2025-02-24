<?php
require 'vendor/autoload.php';
include 'db.php'; // Conectar con MySQL

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Encabezados de la tabla
$sheet->setCellValue('A1', 'Nombre');
$sheet->setCellValue('B1', 'Apellido');
$sheet->setCellValue('C1', 'Tipo de Documento');
$sheet->setCellValue('D1', 'Número de Documento');
$sheet->setCellValue('E1', 'Ciudad');
$sheet->setCellValue('F1', 'Dirección');
$sheet->setCellValue('G1', 'Teléfono');
$sheet->setCellValue('H1', 'Email');

// Obtener datos de la base de datos
$sql = "SELECT * FROM clientes";
$result = $conn->query($sql);

$fila = 2; // Inicia en la fila 2 para los datos
while ($row = $result->fetch_assoc()) {
    $sheet->setCellValue("A$fila", $row['nombre']);
    $sheet->setCellValue("B$fila", $row['apellido']);
    $sheet->setCellValue("C$fila", $row['tipo_documento']);
    $sheet->setCellValue("D$fila", $row['numero_documento']);
    $sheet->setCellValue("E$fila", $row['ciudad']);
    $sheet->setCellValue("F$fila", $row['direccion']);
    $sheet->setCellValue("G$fila", $row['telefono']);
    $sheet->setCellValue("H$fila", $row['email']);
    $fila++;
}

$writer = new Xlsx($spreadsheet);
$filename = "clientes.xlsx";

// Descargar archivo
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
$writer->save("php://output");
exit;
?>
