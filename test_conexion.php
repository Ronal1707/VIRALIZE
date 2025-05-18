<?php
require 'conexion.php';
$result = $conexion->query("SHOW TABLES LIKE 'usuario123'");
echo $result->num_rows > 0 ? "✅ Tabla encontrada" : "❌ Tabla no existe";
$conexion->close();
?>