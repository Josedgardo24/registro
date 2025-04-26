<?php include("db.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clínica - Gestión de Pacientes</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f7fa; font-family: Arial, sans-serif; }
        .container { margin-top: 30px; background-color: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { color: #2d3e50; margin-bottom: 20px; }
        .form-control, .btn { border-radius: 5px; }
        .btn-primary { background-color: #0056b3; border-color: #0056b3; }
        .btn-primary:hover { background-color: #004085; border-color: #004085; }
        .btn-success { background-color: #28a745; border-color: #28a745; }
        .btn-success:hover { background-color: #218838; border-color: #1e7e34; }
        .table th, .table td { text-align: center; }
        .table thead { background-color: #0056b3; color: white; }
        .table tbody tr:hover { background-color: #f1f1f1; }
        .search-input { width: 100%; padding: 10px; margin-bottom: 20px; border-radius: 5px; border: 1px solid #ccc; }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <h2>Registro de Pacientes</h2>
        <form action="agregar.php" method="POST" class="mb-4">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <input type="text" name="codigo" class="form-control" placeholder="Código del paciente" required>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre" required>
                </div>
                <div class="form-group col-md-4">
                    <input type="text" name="apellido" class="form-control" placeholder="Apellido" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <input type="text" name="dni" class="form-control" placeholder="DNI" required>
                </div>
                <div class="form-group col-md-4">
                    <input type="datetime-local" name="fecha_nacimiento" class="form-control" required>
                </div>
                <div class="form-group col-md-4 d-flex align-items-center">
                    <div class="form-check mr-3">
                        <input class="form-check-input" type="radio" name="sexo" id="sexoM" value="Masculino" required>
                        <label class="form-check-label" for="sexoM">Masculino</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="sexo" id="sexoF" value="Femenino" required>
                        <label class="form-check-label" for="sexoF">Femenino</label>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Paciente</button>
        </form>

        <h2>Listado de Pacientes</h2>
        <input type="text" id="filtro" class="search-input" placeholder="Buscar por nombre o apellido...">

        <table class="table table-bordered" id="tabla">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>DNI</th>
                    <th>Fecha Nacimiento</th>
                    <th>Sexo</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $res = $conexion->query("SELECT * FROM pacientes");
            if($res->num_rows > 0) {
                while($row = $res->fetch_assoc()) {
                    echo '<tr>' .
                            '<td class="codigo" data-id="'.$row['id'].'">'.$row['codigo'].'</td>' .
                            '<td class="editable" data-column="nombre" data-id="'.$row['id'].'">'.$row['nombre'].'</td>' .
                            '<td class="editable" data-column="apellido" data-id="'.$row['id'].'">'.$row['apellido'].'</td>' .
                            '<td class="editable" data-column="dni" data-id="'.$row['id'].'">'.$row['dni'].'</td>' .
                            '<td class="editable" data-column="fecha_nacimiento" data-id="'.$row['id'].'">'.$row['fecha_nacimiento'].'</td>' .
                            '<td class="editable" data-column="sexo" data-id="'.$row['id'].'">'.$row['sexo'].'</td>' .
                         '</tr>';
                }
            } else {
                echo '<tr><td colspan="6" class="text-center">No hay pacientes registrados.</td></tr>';
            }
            ?>
            </tbody>
        </table>

        <!-- Botón para reporteado -->
        <form action="reporteador.php" method="POST">
            <button type="submit" class="btn btn-success mt-3">Generar Reporte</button>
        </form>
    </div>

    <script>
        // Filtro en tiempo real
        $('#filtro').on('keyup', function(){
            var val = $(this).val().toLowerCase();
            $('#tabla tbody tr').filter(function(){
                $(this).toggle($(this).text().toLowerCase().indexOf(val) > -1);
            });
        });

        // Editar en tiempo real
        $(document).on('dblclick', '.editable', function(){
            var cell = $(this);
            var original = cell.text();
            var id = cell.data('id');
            var column = cell.data('column');
            var input = $('<input type="text" class="form-control"/>').val(original);
            cell.html(input);
            input.focus();

            input.blur(function(){
                var value = $(this).val();
                if(value !== original){
                    $.post('update.php', {id: id, column: column, value: value}, function(resp){
                        if(resp.status === 'OK'){
                            cell.text(value);
                        } else {
                            alert('Error al actualizar');
                            cell.text(original);
                        }
                    }, 'json');
                } else {
                    cell.text(original);
                }
            });
        });

        // Eliminar paciente al hacer doble clic en el código
        $(document).on('dblclick', '.codigo', function(){
            var cell = $(this);
            var id = cell.data('id');
            var codigo = cell.text();
            if(confirm('¿Eliminar paciente con código ' + codigo + '?')){
                $.post('delete.php', {id: id}, function(resp){
                    if(resp.status === 'OK'){
                        cell.closest('tr').remove();
                    } else {
                        alert('Error al eliminar');
                    }
                }, 'json');
            }
        });
    </script>
</body>
</html>
