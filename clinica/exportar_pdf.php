<?php
// exportar_pdf.php

require(__DIR__ . '/fpdf.php');
include(__DIR__ . '/db.php');

// Inicializar FPDF en tamaño Carta (Letter) y orientación Portrait
$pdf = new FPDF('P', 'mm', 'Letter');
$pdf->AddPage();
// Ajustar posición vertical: pegar título más arriba
$pdf->SetY(5);

// Título del reporte centrado
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0, 10, utf8_decode('Reporte de Pacientes'), 0, 1, 'C');
$pdf->Ln(5);

// Definir encabezados de la tabla
$pdf->SetFont('Arial', 'B', 12);
$headers = ['Código', 'Nombre', 'Apellido', 'DNI', 'Fecha Nacimiento', 'Sexo'];
$widths  = [30, 40, 40, 35, 40, 20];
foreach ($headers as $i => $h) {
    // Aquí aplicamos utf8_decode para manejar acentos correctamente
    $pdf->Cell($widths[$i], 8, utf8_decode($h), 1, 0, 'C');
}
$pdf->Ln();

// Imprimir datos de pacientes
$pdf->SetFont('Arial', '', 11);
$result = $conexion->query("SELECT * FROM pacientes");
while ($row = $result->fetch_assoc()) {
    $pdf->Cell($widths[0], 7, utf8_decode($row['codigo']), 1);
    $pdf->Cell($widths[1], 7, utf8_decode($row['nombre']), 1);
    $pdf->Cell($widths[2], 7, utf8_decode($row['apellido']), 1);
    $pdf->Cell($widths[3], 7, utf8_decode($row['dni']), 1);
    $pdf->Cell($widths[4], 7, utf8_decode($row['fecha_nacimiento']), 1);
    $pdf->Cell($widths[5], 7, utf8_decode($row['sexo']), 1);
    $pdf->Ln();
}

// Enviar el PDF al navegador
$pdf->Output('I', utf8_decode('Reporte_Pacientes.pdf'));
exit;
?>