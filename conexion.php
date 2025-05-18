<?php
$server = "sql101.infinityfree.com";
$username = "if0_38689300";
$password = "KH98mO5E9a";
$database = "if0_38689300_DB_viralize";

$conexion = new mysqli($server, $username, $password, $database);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Elimina el echo de conexión exitosa para producción
// echo "Conexión exitosa a la base de datos";
?>