<?php
$conexion = new mysqli("localhost", "root", "", "clinica");
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>
