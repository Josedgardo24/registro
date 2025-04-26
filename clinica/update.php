<?php
// Asegúrate de enviar la respuesta en formato JSON
header('Content-Type: application/json');

// Incluir la conexión a la base de datos
include 'db.php';

// Recibir los datos enviados por AJAX
$id     = isset($_POST['id'])     ? $_POST['id']     : '';
$column = isset($_POST['column']) ? $_POST['column'] : '';
$value  = isset($_POST['value'])  ? $_POST['value']  : '';

// Verificar que los parámetros necesarios estén presentes
if (empty($id) || empty($column) || empty($value)) {
    echo json_encode(['status' => 'ERROR', 'error' => 'Faltan parámetros']);
    exit;
}

// Preparar la consulta SQL para actualizar el valor
$stmt = $conexion->prepare("UPDATE pacientes SET `$column` = ? WHERE id = ?");
$stmt->bind_param("si", $value, $id);

// Ejecutar la consulta y verificar si tuvo éxito
if ($stmt->execute()) {
    echo json_encode(['status' => 'OK']);
} else {
    echo json_encode(['status' => 'ERROR', 'error' => $stmt->error]);
}

// Cerrar la conexión
$stmt->close();
?>
