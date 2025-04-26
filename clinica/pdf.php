<?php
require_once("libs/dompdf/autoload.inc.php");
use Dompdf\Dompdf;

include("db.php");

$html = "<h1>Listado de Pacientes</h1><table border='1'><tr>
<th>Código</th><th>Nombre</th><th>Apellido</th><th>DNI</th><th>Fecha Nac.</th><th>Sexo</th></tr>";

$result = $conexion->query("SELECT * FROM pacientes");
while ($row = $result->fetch_assoc()) {
    $html .= "<tr>
    <td>{$row['codigo']}</td>
    <td>{$row['nombre']}</td>
    <td>{$row['apellido']}</td>
    <td>{$row['dni']}</td>
    <td>{$row['fecha_nacimiento']}</td>
    <td>{$row['sexo']}</td></tr>";
}
$html .= "</table>";

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper("A4", "portrait");
$dompdf->render();
$dompdf->stream("pacientes.pdf");
?>
