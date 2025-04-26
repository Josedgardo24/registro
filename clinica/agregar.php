<?php
include("db.php");

$codigo = $_POST['codigo'];
$nombre = $_POST['nombre'];
$apellido = $_POST['apellido'];
$dni = $_POST['dni'];
$fecha_nacimiento = $_POST['fecha_nacimiento'];
$sexo = $_POST['sexo'];

$query = "INSERT INTO pacientes (codigo, nombre, apellido, dni, fecha_nacimiento, sexo) 
          VALUES ('$codigo', '$nombre', '$apellido', '$dni', '$fecha_nacimiento', '$sexo')";

if ($conexion->query($query)) {
    header("Location: index.php");
} else {
    echo "Error: " . $conexion->error;
}
?>
