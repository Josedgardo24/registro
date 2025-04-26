<?php
// Incluir la conexión a la base de datos
include 'db.php';

// Obtener el ID del paciente que se va a eliminar
$id = isset($_POST['id']) ? $_POST['id'] : '';

if (empty($id)) {
    echo json_encode(['status' => 'ERROR', 'error' => 'ID no proporcionado']);
    exit;
}

// Preparar la consulta SQL para eliminar el paciente
$stmt = $conexion->prepare("DELETE FROM pacientes WHERE id = ?");
$stmt->bind_param("i", $id);

// Ejecutar la consulta
if ($stmt->execute()) {
    // Si la eliminación es exitosa, devolver estado OK
    echo json_encode(['status' => 'OK']);
} else {
    // Si hubo un error, devolver estado ERROR y el mensaje de error
    echo json_encode(['status' => 'ERROR', 'error' => $stmt->error]);
}

// Cerrar la conexión
$stmt->close();
?>
