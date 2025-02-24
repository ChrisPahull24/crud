<?php
require 'vendor/autoload.php';
include 'db.php'; // Conectar con MySQL

use TCPDF;

// Crear PDF
$pdf = new TCPDF();
$pdf->SetTitle('Lista de Clientes');
$pdf->AddPage();
$pdf->SetFont('Helvetica', '', 12);

// Encabezado de la tabla
$html = '<h2>Lista de Clientes</h2>
<table border="1" cellpadding="5">
<tr>
    <th>Nombre</th>
    <th>Apellido</th>
    <th>Tipo de Documento</th>
    <th>Número de Documento</th>
    <th>Ciudad</th>
    <th>Dirección</th>
    <th>Teléfono</th>
    <th>Email</th>
</tr>';

// Obtener datos de la base de datos
$sql = "SELECT * FROM clientes";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $html .= "<tr>
        <td>{$row['nombre']}</td>
        <td>{$row['apellido']}</td>
        <td>{$row['tipo_documento']}</td>
        <td>{$row['numero_documento']}</td>
        <td>{$row['ciudad']}</td>
        <td>{$row['direccion']}</td>
        <td>{$row['telefono']}</td>
        <td>{$row['email']}</td>
    </tr>";
}

$html .= '</table>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('clientes.pdf', 'D');

exit;
?>
