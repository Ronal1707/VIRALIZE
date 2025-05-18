<?php
// Database connection configuration
$server = "localhost";
$user = "root";
$password = "";
$dbname = "ejemplo";

// Crear conexión
$conexion = new mysqli($server, $user, $password, $dbname);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
?>