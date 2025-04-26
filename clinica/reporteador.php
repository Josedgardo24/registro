<?php
include("db.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporteador de Pacientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7fa; font-family: Arial, sans-serif; }
        .container { margin-top: 30px; background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { color: #2d3e50; margin-bottom: 20px; }
        .table th, .table td { text-align: center; }
        .table thead { background-color: #0056b3; color: white; }
        .table tbody tr:hover { background-color: #f1f1f1; }
    </style>
</head>
<body>

<div class="container">
    <h2>Listado de Pacientes (Reporteado)</h2>

    <!-- Botón para exportar a PDF -->
    <a href="exportar_pdf.php" class="btn btn-success mb-3">Exportar a PDF</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>DNI</th>
                <th>F. de Nacimiento</th>
                <th>Sexo</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $res = $conexion->query("SELECT * FROM pacientes");
            if($res->num_rows > 0) {
                while($row = $res->fetch_assoc()) {
                    echo '<tr>'.
                         '<td>'.$row['codigo'].'</td>'.
                         '<td>'.$row['nombre'].'</td>'.
                         '<td>'.$row['apellido'].'</td>'.
                         '<td>'.$row['dni'].'</td>'.
                         '<td>'.$row['fecha_nacimiento'].'</td>'.
                         '<td>'.$row['sexo'].'</td>'.
                         '</tr>';
                }
            } else {
                echo '<tr><td colspan="6" class="text-center">No hay pacientes registrados.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
